<?php
$img = get_theme_file_uri('/assets/img');

/**
 * Contact Form 7 のフォームを「タイトル」で取得して表示する。
 * 管理画面で作った CF7 フォーム（タイトル：お問い合わせ）を自動で拾うので、
 * ショートコード ID をテーマに書かなくてよい。
 * CF7 未導入 or 未作成のときは、従来の「お問い合わせはこちら」ボタンを表示。
 */
$cf7_title = 'お問い合わせ';
$cf7_form_id = 0;
if (defined('WPCF7_VERSION')) {
  $cf7_posts = get_posts([
    'post_type'      => 'wpcf7_contact_form',
    'title'          => $cf7_title,
    'posts_per_page' => 1,
    'fields'         => 'ids',
    'no_found_rows'  => true,
  ]);
  if (!empty($cf7_posts)) {
    $cf7_form_id = (int) $cf7_posts[0];
  }
}
?>
<section class="p-topContact p-top__contact" id="contact">
  <div class="l-container">
    <div class="p-topContact__inner">
      <h2 class="p-topContact__heading js-reveal js-reveal--up">
        <span class="p-topContact__en">Contact</span>
        <span class="p-topContact__ja">お問い合わせ</span>
      </h2>

      <div class="p-topContact__form js-reveal" data-reveal-delay="200">
        <?php if ($cf7_form_id) : ?>
          <?php echo do_shortcode('[contact-form-7 id="' . $cf7_form_id . '" title="' . esc_attr($cf7_title) . '"]'); ?>
        <?php else : ?>
          <p class="p-topContact__note">お問い合わせは下記ボタンよりお願いいたします。</p>
          <div class="p-topContact__action">
            <a class="c-btn p-topContact__btn" href="mailto:ayaka@tsumugu-kunizaki.com">お問い合わせはこちら</a>
          </div>
        <?php endif; ?>
      </div>

      <ul class="p-topContact__sns js-reveal" data-reveal-delay="320">
        <li>
          <a class="p-topContact__snsLink" href="#" target="_blank" rel="noopener noreferrer" aria-label="X">
            <span class="p-topContact__snsIcon p-topContact__snsIcon--x">
              <img src="<?php echo $img; ?>/icon-x.png" alt="" loading="lazy">
            </span>
          </a>
        </li>
        <li>
          <a class="p-topContact__snsLink" href="#" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
            <span class="p-topContact__snsIcon">
              <img src="<?php echo $img; ?>/icon-instagram.png" alt="" loading="lazy">
            </span>
          </a>
        </li>
      </ul>
    </div>
  </div>
  <figure class="p-topContact__plane js-reveal js-reveal--left" aria-hidden="true">
    <img class="p-topContact__planeThread" src="<?php echo $img; ?>/contact-plane.svg" alt="" loading="lazy">
    <img class="p-topContact__planeBody" src="<?php echo $img; ?>/contact-heading-deco.svg" alt="" loading="lazy">
  </figure>
</section>
