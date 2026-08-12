<?php $img = get_theme_file_uri('/assets/img'); ?>
<?php
$works = [
  [
    'shot'    => 'works-shot-01.jpg',
    'alt'     => '横浜の夜景と花火を背景にした YOKOHAMA Concierge の Web サイト',
    'caption' => 'YOKOHAMA Concierge｜Web サイト制作',
  ],
  [
    'shot'    => 'works-shot-02.jpg',
    'alt'     => 'ARE のグリーンを基調とした名刺デザイン',
    'caption' => 'ARE｜名刺デザイン',
  ],
  [
    'shot'    => 'works-shot-03.jpg',
    'alt'     => 'MIHON の淡いカラーを基調とした名刺デザイン',
    'caption' => 'MIHON｜名刺デザイン',
  ],
];
$revealDelay = 0;
?>
<section class="p-topWorks p-top__works" id="works">
  <div class="l-container">
    <h2 class="p-topWorks__heading js-reveal js-reveal--up">
      <span class="p-topWorks__headingJa">制作実績</span>
      <span class="p-topWorks__headingEn">Works</span>
    </h2>
    <ul class="p-topWorks__list">
      <?php foreach ($works as $work) : ?>
        <li class="p-topWorks__item js-reveal" data-reveal-delay="<?php echo $revealDelay; ?>">
          <figure class="p-topWorks__img">
            <picture>
              <source srcset="<?php echo $img; ?>/<?php echo $work['shot']; ?>">
              <img src="<?php echo $img; ?>/<?php echo $work['shot']; ?>" alt="<?php echo $work['alt']; ?>" loading="lazy">
            </picture>
            <figcaption class="p-topWorks__caption"><?php echo $work['caption']; ?></figcaption>
          </figure>
        </li>
        <?php $revealDelay += 120; ?>
      <?php endforeach; ?>
    </ul>
    <a class="c-btn p-topWorks__more js-reveal" href="<?php echo esc_url(get_post_type_archive_link('works')); ?>">もっと見る</a>
  </div>
</section>
