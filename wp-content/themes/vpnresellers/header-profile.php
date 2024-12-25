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
  <?php if(is_user_logged_in()): ?>
  
  <script>
    localStorage.setItem('access_token', REST_API_data.nonce)
  </script>
  <?php else: ?>
  <script>
    localStorage.removeItem('access_token')
  </script>
  <?php endif; ?>

</head>

<body>
<style>
  header {
    left: 0;
    margin: 8px 8px 0px;
    position: relative;
    right: 0;
    top: 0;
    z-index: 100;
  }
</style>
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
    
  </header>