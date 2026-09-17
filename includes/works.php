<?php
// 制作実績（管理画面の「制作実績」から新しい順に 3 件を表示）
$works_query = new WP_Query([
  'post_type'      => 'works',
  'posts_per_page' => 3,
  'no_found_rows'  => true,
]);
$revealDelay = 0;
?>
<section class="p-topWorks p-top__works" id="works">
  <div class="l-container">
    <h2 class="p-topWorks__heading js-reveal js-reveal--up">
      <span class="p-topWorks__headingJa">制作実績</span>
      <span class="p-topWorks__headingEn">Works</span>
    </h2>
    <?php if ($works_query->have_posts()) : ?>
      <ul class="p-topWorks__list">
        <?php while ($works_query->have_posts()) : $works_query->the_post(); ?>
          <li class="p-topWorks__item js-reveal" data-reveal-delay="<?php echo $revealDelay; ?>">
            <?php $work_video = get_post_meta(get_the_ID(), 'works_video', true); ?>
            <a class="p-topWorks__link<?php echo $work_video ? ' js-hoverVideoCard' : ''; ?>" href="<?php the_permalink(); ?>">
              <figure class="p-topWorks__img<?php echo $work_video ? ' p-topWorks__img--video' : ''; ?>" style="view-transition-name: work-<?php the_ID(); ?>;">
                <?php if (has_post_thumbnail()) : ?>
                  <?php the_post_thumbnail('large'); ?>
                <?php endif; ?>
                <?php if ($work_video) : ?>
                  <video class="p-topWorks__video js-hoverVideo" src="<?php echo esc_url($work_video); ?>" muted loop playsinline preload="none" aria-hidden="true"></video>
                <?php endif; ?>
                <figcaption class="p-topWorks__caption"><?php the_title(); ?></figcaption>
              </figure>
            </a>
          </li>
          <?php $revealDelay += 120; ?>
        <?php endwhile; ?>
      </ul>
      <?php wp_reset_postdata(); ?>
    <?php endif; ?>
    <a class="c-btn p-topWorks__more js-reveal" href="<?php echo esc_url(get_post_type_archive_link('works')); ?>">もっと見る</a>
  </div>
</section>
