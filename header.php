<?php
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="topbar">
  <nav class="nav" aria-label="Primary">
    <div class="brand">
      <div class="logo" aria-hidden="true"></div>
      <div class="brandname"><?php bloginfo('name'); ?></div>
    </div>
    <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'container' => false,
        'menu_class' => 'menu',
        'fallback_cb' => false,
      ]);
    ?>
  </nav>
  <div class="trending-bar">
    <div class="trending-wrap">
      <div class="label">
        <span class="icon" aria-hidden="true"></span>
        <span><?php echo esc_html__('Trending', 'jazira'); ?></span>
      </div>
      <?php
        wp_nav_menu([
          'theme_location' => 'trending',
          'container' => false,
          'menu_class' => 'items',
          'fallback_cb' => false,
        ]);
      ?>
    </div>
  </div>
</header>
