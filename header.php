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
    <a class="brand" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
      <div class="logo" aria-hidden="true"></div>
      <div class="brandname"><?php bloginfo('name'); ?></div>
    </a>
    <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'container' => false,
        'menu_class' => 'menu',
        'fallback_cb' => false,
      ]);
    ?>
    <div class="nav-tools">
      <?php
        $topcats = get_categories(['hide_empty' => true, 'parent' => 0]);
      ?>
      <div class="dropdown cats" id="cats-dropdown" tabindex="0" aria-haspopup="true" aria-expanded="false">
        <button type="button" class="cats-toggle" aria-controls="cats-panel">Kategori</button>
        <div class="dropdown-panel" id="cats-panel" role="menu">
          <?php foreach ($topcats as $tc): ?>
            <div class="cat-group">
              <a class="cat-title" href="<?php echo esc_url(get_category_link($tc)); ?>"><?php echo esc_html($tc->name); ?></a>
              <?php
                $children = get_categories(['hide_empty' => true, 'parent' => $tc->term_id]);
              ?>
              <?php if (!empty($children)): ?>
                <div class="chips">
                  <?php foreach ($children as $ch): ?>
                    <a class="chip" href="<?php echo esc_url(get_category_link($ch)); ?>"><?php echo esc_html($ch->name); ?></a>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="search">
        <input class="search-input" type="search" name="s" placeholder="Cari..." value="<?php echo esc_attr(get_search_query()); ?>" />
        <button class="search-btn" type="submit">Cari</button>
      </form>
    </div>
  </nav>
  <script>
  (function(){
    var dd = document.getElementById('cats-dropdown');
    if(!dd) return;
    var btn = dd.querySelector('.cats-toggle');
    var panel = document.getElementById('cats-panel');
    function close(){dd.setAttribute('data-open','0');dd.setAttribute('aria-expanded','false');}
    function open(){dd.setAttribute('data-open','1');dd.setAttribute('aria-expanded','true');}
    btn.addEventListener('click', function(e){
      e.stopPropagation();
      if(dd.getAttribute('data-open')==='1') close(); else open();
    });
    document.addEventListener('click', function(e){
      if(!dd.contains(e.target)) close();
    });
    dd.addEventListener('keydown', function(e){
      if(e.key==='Escape') close();
    });
  })();
  </script>
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
