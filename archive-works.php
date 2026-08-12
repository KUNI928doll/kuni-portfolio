<?php get_header(); ?>
<main class="p-lowerMain">
  <div class="l-lowerFv">
    <div class="l-container">
      <p class="l-lowerFv__en js-reveal">Works</p>
      <h1 class="l-lowerFv__title js-reveal js-reveal--up">制作実績</h1>
    </div>
  </div>
  <section class="p-worksArchive">
    <div class="l-container">
      <nav class="c-breadcrumb p-worksArchive__breadcrumb" aria-label="パンくず">
        <ol class="c-breadcrumb__list">
          <li class="c-breadcrumb__item">
            <a class="c-breadcrumb__link" href="<?php echo esc_url(home_url('/')); ?>">ホーム</a>
          </li>
          <li class="c-breadcrumb__item">
            <span class="c-breadcrumb__current"><?php post_type_archive_title(); ?></span>
          </li>
        </ol>
      </nav>
      <?php if (have_posts()) : ?>
        <ul class="p-worksArchive__list js-revealGroup">
          <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('includes/parts/work-card'); ?>
          <?php endwhile; ?>
        </ul>
        <div class="p-worksArchive__pagination">
          <?php the_posts_pagination(['prev_text' => '‹', 'next_text' => '›', 'mid_size' => 1]); ?>
        </div>
      <?php else : ?>
        <p class="p-worksArchive__empty">制作実績はまだありません。</p>
      <?php endif; ?>
    </div>
  </section>
</main>
<?php get_footer(); ?>
