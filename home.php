<?php
get_header();
?>
<main class="wrap" role="main">
  <div class="header">
    <div class="bar" aria-hidden="true"></div>
    <h1><?php echo esc_html__('Featured', 'jazira'); ?></h1>
  </div>
  <section class="grid" aria-labelledby="section-featured">
    <article class="card" itemscope itemtype="https://schema.org/NewsArticle">
      <?php
      $feature = new WP_Query([
        'posts_per_page' => 1,
        'ignore_sticky_posts' => 1,
      ]);
      if ($feature->have_posts()) : $feature->the_post();
      ?>
        <div class="feature-media">
          <?php if (has_post_thumbnail()) { the_post_thumbnail('large', ['itemprop' => 'image']); } ?>
        </div>
        <div class="feature-body">
          <p class="kicker">
            <?php
            $cats = get_the_category();
            if (!empty($cats)) echo esc_html($cats[0]->name);
            ?>
          </p>
          <h2 class="title" itemprop="headline"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
          <p class="desc" itemprop="description"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 30)); ?></p>
          <meta itemprop="datePublished" content="<?php echo esc_attr(get_the_date('c')); ?>" />
          <meta itemprop="dateModified" content="<?php echo esc_attr(get_the_modified_date('c')); ?>" />
        </div>
      <?php endif; wp_reset_postdata(); ?>
    </article>

    <aside class="side" aria-label="Related">
      <?php
      $related = new WP_Query([
        'posts_per_page' => 4,
        'offset' => 1,
        'ignore_sticky_posts' => 1,
      ]);
      if ($related->have_posts()) :
        while ($related->have_posts()) : $related->the_post();
      ?>
        <div class="item" itemscope itemtype="https://schema.org/NewsArticle">
          <div class="thumb" aria-hidden="true">
            <?php if (has_post_thumbnail()) { the_post_thumbnail('thumbnail', ['itemprop' => 'image']); } ?>
          </div>
          <div class="meta">
            <p class="tag">
              <?php $rCats = get_the_category(); if (!empty($rCats)) echo esc_html($rCats[0]->name); ?>
            </p>
            <p class="item-title"><a href="<?php the_permalink(); ?>" itemprop="url"><span itemprop="headline"><?php the_title(); ?></span></a></p>
          </div>
        </div>
      <?php
        endwhile;
      endif; wp_reset_postdata();
      ?>
      <div class="footer-link"><a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>"><span><?php echo esc_html__('See full coverage', 'jazira'); ?></span></a></div>
    </aside>
  </section>

  <?php
  $cats = get_categories(['hide_empty' => true]);
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
          <div class="feature-media">
            <?php if (has_post_thumbnail()) { the_post_thumbnail('large', ['itemprop' => 'image']); } ?>
          </div>
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
            <div class="thumb" aria-hidden="true">
              <?php if (has_post_thumbnail()) { the_post_thumbnail('thumbnail', ['itemprop' => 'image']); } ?>
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
