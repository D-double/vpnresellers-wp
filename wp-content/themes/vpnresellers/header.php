<!DOCTYPE html>
<html lang="en" class="page">

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="shortcut icon" href="https://smsbower.net/favicon.ico" type="image/x-icon">
  <title><?php echo wp_get_document_title(); ?></title>
  <script crossorigin src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
  <script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>
  <!-- <link rel="alternate" href="https://smsbower.net/ru/login5" hreflang="en">
  <link rel="alternate" href="https://smsbower.net/ru/ru/login5" hreflang="ru">
  <link rel="alternate" href="https://smsbower.net/cn/ru/login5" hreflang="zh">
  <link rel="canonical" href="https://smsbower.net/ru/login5"> -->

  <?php wp_head(); ?>
  <?php if (is_user_logged_in()): ?>

    <script defer>
      localStorage.setItem('access_token', REST_API_data.nonce)
      const getToken = async () => {
        const results = await fetch(`wp-json/wc/v3/products?_wpnonce=${REST_API_data.nonce}`);
        const data = await results.json();
        console.log(data);
        // try {
        //   const response = await fetch(REST_API_data.root + 'custom/v1/get-token', {
        //     method: 'POST',
        //   	headers: {
        //       'Content-Type': 'application/json',
        //   		'X-WP-Nonce': REST_API_data.nonce
        //   	},
        //     credentials: 'include', // Чтобы отправлять куки с авторизацией
        //     // body: new URLSearchParams( 'nonce='+REST_API_data.nonce )
        //     body: JSON.stringify({nonce: REST_API_data.nonce})
        //   });

        //   const data = await response.json();
        //   console.log(data);
        //   if (response.ok) {
        //     console.log('Токен получен:', data.token);
        //     localStorage.setItem('access_token', data.token)
        //     return data.token;
        //   } else {
        //     console.error('Ошибка получения токена:', data.message);
        //     return null;
        //   }
        // } catch (error) {
        //   console.error('Ошибка запроса токена:', error);
        //   return null;
        // }
      }
      // getToken()
    </script>
  <?php else: ?>
    <script>
      localStorage.removeItem('access_token')
    </script>
  <?php endif; ?>

</head>

<body>

  <header>
    <div class="header">
      <a href="https://smsbower.net/" class="header__logo navigation-link">
        <span><?php the_custom_logo(); ?></span>
      </a>
      <?php wp_nav_menu(
        [
          'theme_location'  => 'top',
          'container'       => false,
          'menu_class'      => 'header__menu',
          'menu_id'         => 'pc-parent-menu',
          'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
          'link_before'      => '<span>',
        ]
      ) ?>
      <div class="header__actions">
        <div class="language-select">
          <!-- <div class="dropdown">
            <button class="dropdown-toggle button light lang-btn" type="button" data-bs-toggle="dropdown">
              <img src="./SmsBower. Not found_files/en.svg" alt="" width="16px" height="16px">
              EN
            </button>
            <ul class="dropdown-menu">
              <li class="dropdown-menu-item">
                <img src="./SmsBower. Not found_files/en.svg" alt="">
                <a class="dropdown-item" href="https://smsbower.net/login5">English</a>
              </li>
              <li class="dropdown-menu-item">
                <img src="./SmsBower. Not found_files/ru.svg" alt="">
                <a class="dropdown-item" href="https://smsbower.net/ru/login5">Русский</a>
              </li>
              <li class="dropdown-menu-item">
                <img src="./SmsBower. Not found_files/cn.svg" alt="">
                <a class="dropdown-item" href="https://smsbower.net/cn/login5">中文</a>
              </li>
            </ul>
          </div> -->
        </div>
        <div class="header__open-mobile-menu">
          <img src="<?= get_template_directory_uri() . "/assets/images/menu.svg" ?>">
        </div>
      </div>
      <div class="header__buttons">
        <?php wp_nav_menu(
          [
            'theme_location'  => 'sign',
            'container'       => false,
            'menu_class'      => 'button-container',
            'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
          ]
        ) ?>
      </div>
    </div>
    <div class="header-client-menu">
      <?php wp_nav_menu(
        [
          'theme_location'  => 'user',
          'container'       => false,
          'menu_class'      => 'mobile-menu-user-menu justify-content-center',
          'menu_id'         => '',
          'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        ]
      ) ?>
      <div class="mobile-menu-user-withdrawal">
        <?php
        // Проверяем, авторизован ли пользователь
        if (is_user_logged_in()) :
          $user_id = get_current_user_id();
          // Получаем баланс пользователя
          if (function_exists('get_wallet_balance')) {
            $balance = apply_filters('woo_wallet_balance', get_wallet_balance($user_id, true), $user_id);
          } else {
            $balance = 0; // Если функция недоступна
          }
          // URL страницы оплаты (замените на URL вашей страницы)
          $payment_page_url = site_url('/payment-page');
        ?>
          <a style="text-decoration: none" href="<?php echo esc_url($payment_page_url); ?>">
            <div class="--button">
              <img src="/img/svg/header-user-menu/dollor-coin.svg">
              Пополнить
            </div>
          </a>
          <div class="--value user-balance-new">
            <?php echo wc_price($balance); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="mobile-menu">
      <div class="mobile-menu__all">
        <div id="mobile-parent-menu" class="mobile-menu-all-menu"></div>


        <div class="mobile-menu__user">
          <?php wp_nav_menu(
            [
              'theme_location'  => 'user',
              'container'       => false,
              'menu_class'      => 'mobile-menu-user-menu justify-content-center',
              'menu_id'         => '',
              'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            ]
          ) ?>
        </div>
      </div>
  </header>