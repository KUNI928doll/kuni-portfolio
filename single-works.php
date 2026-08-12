<?php get_header(); ?>
<main class="p-lowerMain">
  <div class="l-lowerFv">
    <div class="l-container">
      <p class="l-lowerFv__en js-reveal">Works</p>
      <p class="l-lowerFv__title js-reveal js-reveal--up">制作実績</p>
    </div>
  </div>
  <?php
  if (have_posts()) :
    while (have_posts()) : the_post();
      $terms = get_the_terms(get_the_ID(), 'works_cat');
      $work_url = get_post_meta(get_the_ID(), 'works_url', true);
  ?>
    <article class="p-worksSingle">
      <div class="l-container">
        <nav class="c-breadcrumb p-worksSingle__breadcrumb" aria-label="パンくず">
          <ol class="c-breadcrumb__list">
            <li class="c-breadcrumb__item">
              <a class="c-breadcrumb__link" href="<?php echo esc_url(home_url('/')); ?>">ホーム</a>
            </li>
            <li class="c-breadcrumb__item">
              <a class="c-breadcrumb__link" href="<?php echo esc_url(get_post_type_archive_link('works')); ?>">制作実績</a>
            </li>
            <li class="c-breadcrumb__item">
              <span class="c-breadcrumb__current"><?php the_title(); ?></span>
            </li>
          </ol>
        </nav>
        <div class="p-worksSingle__head">
          <?php if ($terms && !is_wp_error($terms)) : ?>
            <span class="p-worksSingle__cat"><?php echo esc_html($terms[0]->name); ?></span>
          <?php endif; ?>
          <h1 class="p-worksSingle__title"><?php the_title(); ?></h1>
        </div>
        <?php if (has_post_thumbnail()) : ?>
          <figure class="p-worksSingle__img"><?php the_post_thumbnail('large'); ?></figure>
        <?php endif; ?>
        <div class="p-worksSingle__body">
          <?php the_content(); ?>
        </div>
        <div class="p-worksSingle__actions">
          <?php if ($work_url) : ?>
            <a class="c-btn p-worksSingle__btn" href="<?php echo esc_url($work_url); ?>" target="_blank" rel="noopener noreferrer">制作サイトを見る</a>
          <?php endif; ?>
          <a class="c-btn p-worksSingle__btn" href="<?php echo esc_url(get_post_type_archive_link('works')); ?>">一覧へ戻る</a>
        </div>
      </div>
    </article>
  <?php
    endwhile;
  endif;
  ?>
</main>
<?php get_footer(); ?>
