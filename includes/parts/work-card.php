<?php
/**
 * 制作実績カード（アーカイブのループ内で使用・引数不要）
 */
$terms = tsumugu_works_tags(get_the_ID());
$work_video = get_post_meta(get_the_ID(), 'works_video', true);
?>
<li class="p-workCard js-reveal">
  <a class="p-workCard__link<?php echo $work_video ? ' js-hoverVideoCard' : ''; ?>" href="<?php the_permalink(); ?>">
    <figure class="p-workCard__img" style="view-transition-name: work-<?php the_ID(); ?>;">
      <?php if (has_post_thumbnail()) : ?>
        <?php the_post_thumbnail('large'); ?>
      <?php endif; ?>
      <?php if ($work_video) : ?>
        <video class="p-workCard__video js-hoverVideo" src="<?php echo esc_url($work_video); ?>" muted loop playsinline preload="none" aria-hidden="true"></video>
      <?php endif; ?>
    </figure>
    <div class="p-workCard__body">
      <?php if ($terms) : ?>
        <ul class="p-workCard__tags">
          <?php foreach ($terms as $term) : ?>
            <li class="c-tag c-tag--<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <h3 class="p-workCard__title"><?php the_title(); ?></h3>
    </div>
  </a>
</li>
