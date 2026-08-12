<?php
/**
 * 制作実績カード（アーカイブのループ内で使用・引数不要）
 */
$terms = get_the_terms(get_the_ID(), 'works_cat');
?>
<li class="p-workCard js-reveal">
  <a class="p-workCard__link" href="<?php the_permalink(); ?>">
    <figure class="p-workCard__img">
      <?php if (has_post_thumbnail()) : ?>
        <?php the_post_thumbnail('large'); ?>
      <?php endif; ?>
    </figure>
    <div class="p-workCard__body">
      <?php if ($terms && !is_wp_error($terms)) : ?>
        <span class="p-workCard__cat"><?php echo esc_html($terms[0]->name); ?></span>
      <?php endif; ?>
      <h3 class="p-workCard__title"><?php the_title(); ?></h3>
    </div>
  </a>
</li>
