<footer>
    <div class="footer">
      <div class="footer__top">
        <a href="https://smsbower.net/ru/login5#" class="footer__logo">
          <img src="<?= get_template_directory_uri()."/assets/images/logo-footer.svg" ?>" class="--pc">
          <img src="<?= get_template_directory_uri()."/assets/images/logo-footer-mobile.svg" ?>" class="--mobile">
        </a>
        <div>
        <?php dynamic_sidebar("footer__buttons-link"); ?>
        </div>
      </div>
      <div class="--divider"></div>
      <div class="footer__center">
      <?php  wp_nav_menu([
          'theme_location'  => 'bottom', 
          'container'       => false, 
          'menu_class'      => 'footer__menu', 
          'menu_id'         => 'pc-parent-menu',
          'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
          'link_before'      => '<span>',
        ]
        ) ?>
       
        <?php dynamic_sidebar("footer_sidebar"); ?>
      </div>
      <div class="--divider"></div>
      <div class="footer__bottom">
        <div class="footer__additional-links" itemscope="" itemtype="https://schema.org/Organization">
          <a href="https://smsbower.net/offer" itemprop="url" target="_blank"><span itemprop="name">Public
              offer</span></a>
          <a href="https://smsbower.net/privacy" itemprop="url" target="_blank"><span itemprop="name">Privacy
              Policy</span></a>
        </div>
      </div>
    </div>
  </footer>
  <?php wp_footer(); ?>
</body>

</html>