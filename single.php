<?php
get_header();
?>
<main role="main">
  <?php $cats = get_the_category(); $cat = !empty($cats) ? $cats[0] : null; ?>
  <section class="wrap" aria-labelledby="post-title">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
      <?php if ($cat) { ?>
        <span class="sep" aria-hidden="true">/</span>
        <a href="<?php echo esc_url(get_category_link($cat)); ?>"><?php echo esc_html($cat->name); ?></a>
      <?php } ?>
      <span class="sep" aria-hidden="true">/</span>
      <span><?php the_title(); ?></span>
    </nav>

    <div class="single-layout">
      <div class="single-main">
        <?php if (have_posts()): while (have_posts()): the_post(); ?>
          <?php if (has_post_thumbnail()) { ?>
            <div class="single-hero">
              <?php the_post_thumbnail('large'); ?>
            </div>
          <?php } ?>
          <h1 id="post-title" class="post-title"><?php the_title(); ?></h1>
          <article class="post-content">
            <?php the_content(); ?>
          </article>
        <?php endwhile; endif; ?>

        <nav class="pagination post-nav" aria-label="Post Navigation">
          <ul>
            <li class="prev"><?php previous_post_link('%link', '&larr; Prev'); ?></li>
            <li class="next"><?php next_post_link('%link', 'Next &rarr;'); ?></li>
          </ul>
        </nav>
      </div>
      <div class="hero-right">
        <aside class="side-reads module" aria-label="Must Reads">
          <h2 class="section-title"><span class="bar"></span><span><?php echo esc_html__('Must Reads', 'jazira'); ?></span></h2>
          <?php
          $exclude = get_the_ID();
          $args = [
            'posts_per_page' => 5,
            'post__not_in' => [$exclude],
            'ignore_sticky_posts' => 1,
          ];
          if ($cat) { $args['category__in'] = [$cat->term_id]; }
          $aside_q = new WP_Query($args);
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
              <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
            <?php endwhile; ?>
          </div>
          <?php endif; wp_reset_postdata(); ?>
        </aside>
      </div>
    </div>
  </section>
</main>
<?php
get_footer();
?>
