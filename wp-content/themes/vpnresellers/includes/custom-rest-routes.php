<?


// Добавление REST API для получения данных товара WC 
add_action('rest_api_init', function () {
  register_rest_route('custom/v1', '/products', array(
    'methods' => 'GET',
    'callback' => 'get_woocommerce_products',
    'permission_callback' => '__return_true', // Доступ открыт для всех
  ));
});
function get_woocommerce_products($request){
  $category = sanitize_text_field($request->get_param('category'));
  $limit = intval($request->get_param('limit')) ?: -1;

  $args = array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => $limit,
  );

  if ($category) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => 'product_cat',
        'field' => 'slug',
        'terms' => $category,
      ),
    );
  }

  $products = get_posts($args);
  $data = array();

  foreach ($products as $product_post) {
    $product = wc_get_product($product_post->ID);

    $data[] = array(
      'id' => $product->get_id(),
      'name' => $product->get_name(),
      'price' => $product->get_price(),
      'categories' => wp_get_post_terms($product->get_id(), 'product_cat', array('fields' => 'names')),
      'image' => wp_get_attachment_url($product->get_image_id()),
      'sku' => $product->get_sku(),
    );
  }

  return rest_ensure_response($data);
}


//---------------------------
// Создание заказа REST API маршрут 
add_action('rest_api_init', function () {
  register_rest_route('custom/v1', '/create-order', array(
      'methods' => 'POST',
      'callback' => 'create_order_with_custom_meta',
      'permission_callback' => function () {
          return is_user_logged_in();
      }, // Только для авторизованных пользователей
  ));
});

/**
* Callback для создания заказа
*/
function create_order_with_custom_meta($request) {
  $user_id = get_current_user_id();

  if ($user_id === 0) {
      return new WP_Error('not_logged_in', 'Пользователь не авторизован.', array('status' => 401));
  }

  $params = $request->get_json_params();
  $sku = sanitize_text_field($params['sku']);
  $api_key = 'JaBasLQyxRLgv3h0RnXMLCZAXaShlynz'; // Ваш API ключ
  $domain = 'gmail.com'; // Ваш домен

  if (empty($sku)) {
      return new WP_Error('missing_params', 'Параметр sku обязателен.', array('status' => 400));
  }

  // Находим товар по SKU
  $product_id = wc_get_product_id_by_sku($sku);

  if (!$product_id) {
      return new WP_Error('product_not_found', 'Товар с указанным SKU не найден.', array('status' => 404));
  }

  // Запрос к внешнему API
  $selected_service = $sku;
  $external_api_url = "https://smsbower.online/api/mail/getActivation?api_key={$api_key}&service={$selected_service}&domain={$domain}";

  $response = wp_remote_get($external_api_url);

  if (is_wp_error($response)) {
      return new WP_Error('external_api_error', 'Ошибка при запросе к внешнему API.', array('status' => 500));
  }

  $response_body = wp_remote_retrieve_body($response);
  $api_data = json_decode($response_body, true);

  if (!$api_data || empty($api_data['mail']) || empty($api_data['mailId']) || empty($api_data['status'])) {
      return $api_data;
  }

  // Создание заказа
  $order = wc_create_order();

  // Добавление товара в заказ
  $product = wc_get_product($product_id);
  $order->add_product($product, 1); // Добавляем товар с количеством 1

  // Установка данных клиента
  $order->set_customer_id($user_id);
  $order->set_billing_email(get_userdata($user_id)->user_email);

  // Добавляем объект с метаданными в заказ
  $meta_data = array(
      'mail' => $api_data['mail'],
      'mailId' => $api_data['mailId'],
      'status' => $api_data['status'],
  );
  $order->update_meta_data('custom_data', $meta_data);

  // Сохраняем заказ
  $order->set_status('pending');
  $order->calculate_totals();
  $order->save();

  // Формируем данные для "order_data"
  $timestamp = $order->get_date_created() ? $order->get_date_created()->getTimestamp() : null;

  $order_data = array(
      'id' => $order->get_id(),
      'status' => $order->get_status(),
      'currency' => $order->get_currency(),
      'total' => $order->get_total(),
      'billing' => array(
          'email' => $order->get_billing_email(),
      ),
      'meta_data' => $meta_data,
      'timestamp' => $timestamp, // Добавлено время создания заказа
  );

  // Возвращаем результат
  return array(
      'status' => 'success',
      'message' => 'Заказ успешно создан.',
      'user_id' => $user_id,
      'order_id' => $order->get_id(),
      'product' => array(
          'id' => $product->get_id(),
          'name' => $product->get_name(),
          'sku' => $product->get_sku(),
          'image' => wp_get_attachment_image_url($product->get_image_id(), 'full'),
      ),
      'order_data' => $order_data, // Добавлено
  );
}


//---------------------------
// Получение заказов REST API маршрут 
add_action('rest_api_init', function () {
  register_rest_route('custom/v1', '/user-orders', array(
      'methods' => 'GET',
      'callback' => 'get_user_orders_with_custom_format',
      'permission_callback' => function () {
          return is_user_logged_in(); // Только для авторизованных пользователей
      },
  ));
});

/**
* Callback для получения всех заказов пользователя
*/
function get_user_orders_with_custom_format($request) {
  $user_id = get_current_user_id();

  if (!$user_id) {
      return new WP_Error('not_logged_in', 'Пользователь не авторизован.', array('status' => 401));
  }

  // Получаем все заказы пользователя
  $customer_orders = wc_get_orders(array(
      'customer_id' => $user_id,
      'status' => 'any', // Получить заказы с любым статусом
      'limit' => -1,     // Все заказы
  ));

  if (empty($customer_orders)) {
      return array(
          'status' => 'success',
          'message' => 'У пользователя нет заказов.',
          'orders' => array(),
      );
  }

  $orders_data = array();

  foreach ($customer_orders as $order) {
      // Получаем данные товара из заказа
      $items = $order->get_items();
      $product_data = array();
      foreach ($items as $item_id => $item) {
          $product = $item->get_product();
          if ($product) {
              $product_data = array(
                  'id' => $product->get_id(),
                  'name' => $product->get_name(),
                  'sku' => $product->get_sku(),
                  'image' => wp_get_attachment_image_url($product->get_image_id(), 'full'),
              );
              break; // Предполагаем, что в заказе один товар
          }
      }

      // Данные заказа
      $meta_data = $order->get_meta('custom_data', true);
      $timestamp = $order->get_date_created() ? $order->get_date_created()->getTimestamp() : null;

      $order_data = array(
          'id' => $order->get_id(),
          'status' => $order->get_status(),
          'currency' => $order->get_currency(),
          'total' => $order->get_total(),
          'billing' => array(
              'email' => $order->get_billing_email(),
          ),
          'meta_data' => array(
              'mail' => $meta_data['mail'] ?? '',
              'mailId' => $meta_data['mailId'] ?? '',
              'status' => $meta_data['status'] ?? '',
          ),
          'timestamp' => $timestamp, // Время создания заказа
      );

      $orders_data[] = array(
          'product' => $product_data,
          'order_data' => $order_data,
      );
  }

  return array(
      'status' => 'success',
      'orders' => $orders_data,
  );
}


//---------------------------
// Получение количества и стоимости товара REST API маршрут 
add_action('rest_api_init', function () {
  register_rest_route('custom/v1', '/get-product-data', array(
      'methods' => 'POST',
      'callback' => 'get_product_data_from_external_api',
      'permission_callback' => '__return_true', // Открытый доступ
  ));
});

/**
* Callback для получения данных товара
*/
function get_product_data_from_external_api($request) {
  // Извлекаем параметры из запроса
  $params = $request->get_json_params();
  $sku = sanitize_text_field($params['sku']);
  $api_key = 'JaBasLQyxRLgv3h0RnXMLCZAXaShlynz'; // Замените на ваш API ключ
  $domain = 'gmail.com'; // Замените на ваш домен

  if (empty($sku)) {
      return new WP_Error('missing_params', 'Параметр sku обязателен.', array('status' => 400));
  }

  // Формируем URL для запроса к внешнему API
  $external_api_url = "https://smsbower.online/api/mail/getPriceRests?api_key={$api_key}&service={$sku}&domain={$domain}";

  // Выполняем запрос к внешнему API
  $response = wp_remote_get($external_api_url);

  if (is_wp_error($response)) {
      return new WP_Error('external_api_error', 'Ошибка при запросе к внешнему API.', array('status' => 500));
  }

  $response_body = wp_remote_retrieve_body($response);
  $api_data = json_decode($response_body, true);

  if (!$api_data || $api_data['status'] !== 1 || empty($api_data['data'][$sku][$domain]['count'])) {
      return $api_data;
  }

  // Извлекаем количество из ответа API
  $count = intval($api_data['data'][$sku][$domain]['count']);

  // Получаем цену из WooCommerce
  $product_id = wc_get_product_id_by_sku($sku);
  if (!$product_id) {
      return new WP_Error('product_not_found', 'Товар с указанным SKU не найден.', array('status' => 404));
  }

  $product = wc_get_product($product_id);
  $price = $product->get_price();

  // Формируем объект для возврата
  return array(
      'status' => 'success',
      'data' => array(
          'count' => $count,
          'price' => $price,
      ),
  );
}
