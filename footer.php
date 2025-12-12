<footer class="site-footer" role="contentinfo">
  <div class="footer-inner">
    <div class="footer-brand">
      <div class="logo" aria-hidden="true"></div>
      <div class="brandname"><?php bloginfo('name'); ?></div>
    </div>
    <?php
      wp_nav_menu([
        'theme_location' => 'footer',
        'container' => false,
        'menu_class' => 'footer-menu',
        'fallback_cb' => false,
      ]);
    ?>
    <div class="footer-copy">&copy; <?php echo esc_html(date('Y')); ?> <?php bloginfo('name'); ?></div>
  </div>
</footer>
<?php
wp_footer();
?>
</body>
</html>
