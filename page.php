<?php get_header(); ?>
<main class="p-lowerMain">
  <?php while (have_posts()) : the_post(); ?>
    <div class="l-lowerFv">
      <div class="l-container">
        <?php $en = get_post_meta(get_the_ID(), 'en_label', true); ?>
        <?php if ($en) : ?>
          <p class="l-lowerFv__en js-reveal"><?php echo esc_html($en); ?></p>
        <?php endif; ?>
        <h1 class="l-lowerFv__title js-reveal js-reveal--up"><?php the_title(); ?></h1>
      </div>
    </div>
    <article class="p-page">
      <div class="l-container">
        <nav class="c-breadcrumb p-page__breadcrumb" aria-label="パンくず">
          <ol class="c-breadcrumb__list">
            <li class="c-breadcrumb__item">
              <a class="c-breadcrumb__link" href="<?php echo esc_url(home_url('/')); ?>">ホーム</a>
            </li>
            <li class="c-breadcrumb__item">
              <span class="c-breadcrumb__current"><?php the_title(); ?></span>
            </li>
          </ol>
        </nav>
        <div class="p-page__body">
          <?php the_content(); ?>
        </div>
      </div>
    </article>
  <?php endwhile; ?>
</main>
<?php get_footer(); ?>
