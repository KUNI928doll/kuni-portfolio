<?php get_header(); ?>
<main class="p-lowerMain">
  <div class="l-lowerFv">
    <div class="l-container">
      <p class="l-lowerFv__en js-reveal">404 Not Found</p>
      <h1 class="l-lowerFv__title js-reveal js-reveal--up">ページが見つかりませんでした</h1>
    </div>
  </div>
  <section class="p-notFound">
    <div class="l-container">
      <div class="p-notFound__inner">
        <p class="p-notFound__lead js-reveal">
          お探しのページは、削除されたかURLが変更された可能性があります。<br>
          お手数ですが、下のボタンからお探しください。
        </p>
        <div class="p-notFound__actions js-reveal" data-reveal-delay="120">
          <a class="c-btn p-notFound__btn" href="<?php echo esc_url(home_url('/')); ?>">トップへ戻る</a>
          <a class="c-btn p-notFound__btn" href="<?php echo esc_url(get_post_type_archive_link('works')); ?>">制作実績を見る</a>
        </div>
        <p class="p-notFound__note js-reveal" data-reveal-delay="200">
          お問い合わせは <a href="<?php echo esc_url(home_url('/#contact')); ?>">こちらのフォーム</a> からお願いいたします。
        </p>
      </div>
    </div>
  </section>
</main>
<?php get_footer(); ?>
