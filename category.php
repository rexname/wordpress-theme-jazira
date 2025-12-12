<?php
get_header();
?>
<main role="main">
  <?php $term = get_queried_object(); $term_name = $term && isset($term->name) ? $term->name : ''; ?>
  <section class="wrap cat-mock" aria-labelledby="cat-title">
    <h1 id="cat-title" class="cat-mock-title"><?php echo esc_html($term_name); ?></h1>

    <div class="cat-mock-top">
      <div>
        <?php if (have_posts()): the_post(); ?>
        <article class="cat-card" itemscope itemtype="https://schema.org/NewsArticle">
          <?php if (has_post_thumbnail()) { ?>
            <a class="cat-media" href="<?php the_permalink(); ?>" rel="bookmark">
              <?php the_post_thumbnail('large', ['itemprop' => 'image']); ?>
            </a>
          <?php } ?>
          <div class="cat-body">
            <p class="cat-kicker"><?php echo esc_html($term_name); ?></p>
            <h2 class="cat-headline" itemprop="headline"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <p class="cat-desc" itemprop="description"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 28)); ?></p>
            <div class="cat-date"><?php echo esc_html(get_the_date()); ?></div>
          </div>
        </article>
        <?php endif; ?>
      </div>
      <div class="cat-right">
        <div class="small-grid">
          <?php $n=0; while (have_posts() && $n < 2): the_post(); $n++; ?>
          <article class="small-card" itemscope itemtype="https://schema.org/NewsArticle">
            <?php if (has_post_thumbnail()) { ?>
              <a class="small-media" href="<?php the_permalink(); ?>" rel="bookmark">
                <?php the_post_thumbnail('medium', ['itemprop' => 'image']); ?>
              </a>
            <?php } ?>
            <div class="small-body">
              <div class="small-kicker"><?php echo esc_html($term_name); ?></div>
              <div class="small-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></div>
              <div class="small-date"><?php echo esc_html(get_the_date()); ?></div>
            </div>
          </article>
          <?php endwhile; ?>
        </div>
        <div class="small-list">
          <?php $m=0; while (have_posts() && $m < 4): the_post(); $m++; ?>
          <div class="small-row">
            <div>
              <div class="small-kicker"><?php echo esc_html($term_name); ?></div>
              <div class="title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></div>
              <div class="small-date"><?php echo esc_html(get_the_date()); ?></div>
            </div>
            <?php if (has_post_thumbnail()) { ?>
              <a class="thumb" href="<?php the_permalink(); ?>" rel="bookmark">
                <?php the_post_thumbnail('thumbnail'); ?>
              </a>
            <?php } ?>
          </div>
          <?php endwhile; ?>
        </div>
      </div>
    </div>

    <div class="cat-mock-body">
      <div class="list-rows">
        <?php $k=0; while (have_posts() && $k < 4): the_post(); $k++; ?>
        <div class="list-row">
          <div class="meta">
            <div class="kicker"><?php echo esc_html($term_name); ?></div>
            <h3 class="title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
            <p class="desc"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 26)); ?></p>
            <div class="date"><?php echo esc_html(get_the_date()); ?></div>
          </div>
          <?php if (has_post_thumbnail()) { ?>
            <a class="thumb" href="<?php the_permalink(); ?>" rel="bookmark">
              <?php the_post_thumbnail('medium'); ?>
            </a>
          <?php } ?>
        </div>
        <?php endwhile; ?>
      </div>
      <div></div>
    </div>

    <nav class="pagination" aria-label="Pagination">
      <?php
      echo paginate_links([
        'prev_text' => '&larr;',
        'next_text' => '&rarr;',
        'type' => 'list',
      ]);
      ?>
    </nav>
  </section>
</main>
<?php
get_footer();
?>
