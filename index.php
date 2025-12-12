<?php
get_header();
?>
<main class="site-main">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php the_content(); ?>
<?php endwhile; else : ?>
<?php echo esc_html__('No posts found.', 'jazira'); ?>
<?php endif; ?>
</main>
<?php
get_footer();
?>
