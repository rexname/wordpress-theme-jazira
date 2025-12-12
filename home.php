<?php
get_header();
?>
<main role="main">
  <section class="home-top home-hero" aria-labelledby="section-featured">
    <div class="home-main">
      <?php
      $feature = new WP_Query([
        'posts_per_page' => 1,
        'ignore_sticky_posts' => 1,
      ]);
      if ($feature->have_posts()) : $feature->the_post();
      ?>
        <a class="hero-img" href="<?php the_permalink(); ?>" rel="bookmark">
          <?php if (has_post_thumbnail()) { the_post_thumbnail('large', ['itemprop' => 'image']); } ?>
          <div class="progress" aria-hidden="true"></div>
        </a>
        <h1><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
        <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 30)); ?></p>
        <div class="divider" aria-hidden="true"></div>
        <?php
        $secondary = new WP_Query([
          'posts_per_page' => 1,
          'offset' => 1,
          'ignore_sticky_posts' => 1,
        ]);
        if ($secondary->have_posts()): $secondary->the_post();
        ?>
        <article class="hero-secondary">
          <div>
            <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 22)); ?></p>
          </div>
          <div class="secondary-img">
            <?php if (has_post_thumbnail()) { ?>
              <a href="<?php the_permalink(); ?>" rel="bookmark">
                <?php the_post_thumbnail('medium'); ?>
              </a>
            <?php } ?>
          </div>
        </article>
        <?php endif; wp_reset_postdata(); ?>
      <?php endif; wp_reset_postdata(); ?>
    </div>
    <div class="hero-right">
    <aside class="side-reads module" aria-label="Must Reads (Hero)">
      <h2 class="section-title"><span class="bar"></span><span><?php echo esc_html__('Must Reads', 'jazira'); ?></span></h2>
      <?php
      $aside_q = new WP_Query([
        'posts_per_page' => 5,
        'offset' => 2,
        'ignore_sticky_posts' => 1,
      ]);
      if ($aside_q->have_posts()):
        $aside_q->the_post();
      ?>
      <div class="lead">
        <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
        <div class="thumb">
          <?php if (has_post_thumbnail()) { ?>
            <a href="<?php the_permalink(); ?>" rel="bookmark">
              <?php the_post_thumbnail('thumbnail'); ?>
            </a>
          <?php } ?>
        </div>
      </div>
      <div class="list">
        <?php while ($aside_q->have_posts()): $aside_q->the_post(); ?>
          <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        <?php endwhile; ?>
      </div>
      <?php endif; wp_reset_postdata(); ?>
    </aside>
    <aside class="page-aside module" aria-label="More Headlines">
      <h2 class="section-title"><span class="bar"></span><span><?php echo esc_html__('More Headlines', 'jazira'); ?></span></h2>
      <?php
      $more_q = new WP_Query([
        'posts_per_page' => 5,
        'ignore_sticky_posts' => 1,
        'offset' => 5,
      ]);
      if ($more_q->have_posts()):
        $more_q->the_post();
      ?>
      <div class="lead">
        <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
        <div class="thumb">
          <?php if (has_post_thumbnail()) { ?>
            <a href="<?php the_permalink(); ?>" rel="bookmark">
              <?php the_post_thumbnail('thumbnail'); ?>
            </a>
          <?php } ?>
        </div>
      </div>
      <div class="list">
        <?php while ($more_q->have_posts()): $more_q->the_post(); ?>
          <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        <?php endwhile; ?>
      </div>
      <?php endif; wp_reset_postdata(); ?>
    </aside>
    </div>
  </section>

  <?php
  $selected = get_theme_mod('jazira_home_cat_select', []);
  if (is_array($selected) && !empty($selected)) {
    $cats = [];
    foreach ($selected as $slug) {
      $term = get_category_by_slug($slug);
      if ($term && $term->count > 0) { $cats[] = $term; }
    }
  } else {
    $cats = get_categories(['hide_empty' => true]);
  }
  foreach ($cats as $cat):
  ?>
  <section class="wrap" aria-labelledby="cat-<?php echo esc_attr($cat->slug); ?>">
    <div class="header">
      <div class="bar" aria-hidden="true"></div>
      <h2 id="cat-<?php echo esc_attr($cat->slug); ?>"><?php echo esc_html($cat->name); ?></h2>
    </div>
    <div class="grid">
      <article class="card" itemscope itemtype="https://schema.org/NewsArticle">
        <?php
        $q = new WP_Query([
          'cat' => $cat->term_id,
          'posts_per_page' => 1,
          'ignore_sticky_posts' => 1,
        ]);
        if ($q->have_posts()): $q->the_post();
        ?>
          <a class="feature-media" href="<?php the_permalink(); ?>" rel="bookmark">
            <?php if (has_post_thumbnail()) { the_post_thumbnail('large', ['itemprop' => 'image']); } ?>
          </a>
          <div class="feature-body">
            <p class="kicker"><?php echo esc_html($cat->name); ?></p>
            <h3 class="title" itemprop="headline"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
            <p class="desc" itemprop="description"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 26)); ?></p>
          </div>
        <?php endif; wp_reset_postdata(); ?>
      </article>
      <aside class="side" aria-label="More from <?php echo esc_attr($cat->name); ?>">
        <?php
        $q2 = new WP_Query([
          'cat' => $cat->term_id,
          'posts_per_page' => 4,
          'offset' => 1,
          'ignore_sticky_posts' => 1,
        ]);
        if ($q2->have_posts()): while ($q2->have_posts()): $q2->the_post();
        ?>
          <div class="item" itemscope itemtype="https://schema.org/NewsArticle">
            <div class="thumb">
              <?php if (has_post_thumbnail()) { ?>
                <a href="<?php the_permalink(); ?>" rel="bookmark">
                  <?php the_post_thumbnail('thumbnail', ['itemprop' => 'image']); ?>
                </a>
              <?php } ?>
            </div>
            <div class="meta">
              <p class="tag"><?php echo esc_html($cat->name); ?></p>
              <p class="item-title"><a href="<?php the_permalink(); ?>" itemprop="url"><span itemprop="headline"><?php the_title(); ?></span></a></p>
            </div>
          </div>
        <?php endwhile; endif; wp_reset_postdata(); ?>
        <div class="footer-link"><a href="<?php echo esc_url(get_category_link($cat)); ?>"><span><?php echo esc_html__('See full coverage', 'jazira'); ?></span></a></div>
      </aside>
    </div>
  </section>
  <?php endforeach; ?>
</main>
<?php
get_footer();
?>
