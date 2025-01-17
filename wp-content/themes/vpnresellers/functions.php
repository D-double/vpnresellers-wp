<?php

add_action('wp_enqueue_scripts', "themeStyle");
add_action('wp_enqueue_scripts', "themeScript");
add_action('widgets_init', "themeSidebar");
add_theme_support('custom-logo');

// подключение стилей
function themeStyle()
{
  wp_enqueue_style("vue-multiselect", get_template_directory_uri() . "/assets/css/vue-multiselect.min.css");
  wp_enqueue_style("bootstrap", get_template_directory_uri() . "/assets/css/bootstrap.css");
  wp_enqueue_style("main", get_template_directory_uri() . "/assets/css/main.css");
  wp_enqueue_style("user-navigate", get_template_directory_uri() . "/assets/css/index-CScSokle.css");
  wp_enqueue_style("style", get_stylesheet_uri());
}
// подключение скриптов
function themeScript()
{
  wp_enqueue_script('bootstrap', get_template_directory_uri() . "/assets/js/bootstrap.min.js", [], null, true);
  wp_enqueue_script('main', get_template_directory_uri() . "/assets/js/main.js", [], null, true);
  wp_enqueue_script('user-navigate', get_template_directory_uri() . "/assets/js/index-B-pMSbFw.js", [], "1.0.4", true); // подключение sidebar
}

add_action('after_setup_theme', "themeMenu");
function themeMenu()
{
  register_nav_menu('top', 'Меню в шапке');
  register_nav_menu('bottom', 'Меню в подвале');
  register_nav_menu('sign', 'Меню регистрации');
  register_nav_menu('user', 'Меню пользователя');
}

// изменения классов у ссылко меню
add_filter('nav_menu_link_attributes', 'filter_nav_menu_link_attributes', 10, 4);
function filter_nav_menu_link_attributes($atts, $item, $args, $depth)
{
  if ($args->theme_location == "top") {
    $atts['class'] = "navigation-link";
  } elseif ($args->theme_location == "bottom") {
    $atts['class'] = "footer__menu-item";
  } elseif ($args->theme_location == "sign") {
    $atts['class'] = "button primary";
  } elseif ($args->theme_location == "user") {
    $atts['class'] = "menu__link__bot";
  }
  return $atts;
}


function themeSidebar()
{
  register_sidebar(array(
    'name'          => "Виджеты на главной",
    'id'            => "index_sidebar",
    'description'   => 'Сюда вставляй виджеты',
    'before_widget' => '<div class="main-earnings-monetize-item" itemprop="step" itemscope="" itemtype="https://schema.org/HowToStep">',
    'after_widget'  => "</div>\n",
    'before_title'  => '<div class="monetize-item-step" itemprop="position">',
    'after_title'   => "</div>\n",

  ));

  register_sidebar(array(
    'name'          => "Виджеты социальных иконок",
    'id'            => "footer_sidebar",
    'description'   => 'Сюда вставляй виджеты',
    'before_widget' => '<div>',
    'after_widget'  => "</div>\n",
  ));
  register_sidebar(array(
    'name'          => "Обратная связь в подвале",
    'id'            => "footer__buttons-link",
    'description'   => 'Сюда вставляй виджеты',
    'before_widget' => '<div>',
    'after_widget'  => "</div>\n",
  ));

  register_sidebar(array(
    'name'          => "Для кого - на главной",
    'id'            => "main_whom",
    'description'   => 'Сюда вставляй виджеты',
    'before_widget' => '',
    'after_widget'  => "",
  ));
  register_sidebar(array(
    'name'          => "Преимущества - на главной",
    'id'            => "main_advantages",
    'description'   => 'Сюда вставляй виджеты',
    'before_widget' => '',
    'after_widget'  => "",
  ));
}


// Создание nonce
add_action('wp_enqueue_scripts', 'action_function_name_7714', 99);

function action_function_name_7714()
{
  wp_localize_script('jquery', 'REST_API_data', array(
    'root'  => esc_url_raw(rest_url()),
    'nonce' => wp_create_nonce('wp_rest')
  ));
}
// //----------------------

//Переводы должны загружаться после инициализации WordPress, а не до неё.
add_action('init', function () {
  // Загрузка переводов WooWallet
  load_plugin_textdomain('woo-wallet', false, dirname(plugin_basename(__FILE__)) . '/languages');

  // Загрузка переводов WooCommerce
  load_plugin_textdomain('woocommerce', false, dirname(plugin_basename(__FILE__)) . '/languages');

});

//----------------------
add_action('init', function () {
    // Убедимся, что плагин TeraWallet загружен
    if (!class_exists('WooWallet')) {
        error_log('Плагин TeraWallet не загружен.'); // Логируем проблему
        return;
    }

    // Подключение кастомных маршрутов REST API
    require_once get_template_directory() . '/includes/custom-rest-routes.php';
});

add_filter('um_registration_redirect', function ($redirect_to, $user_id) {
  // URL страницы "Учётная запись"
  $account_page_url = site_url('/account-2/');

  // Перенаправляем пользователя на страницу "Учётная запись"
  return $account_page_url;
}, 10, 2);