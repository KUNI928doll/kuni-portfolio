<?php $img = get_theme_file_uri('/assets/img'); ?>
<section class="p-fv p-top__fv" id="fv">
  <div class="l-container">
    <div class="p-fv__inner">
      <div class="p-fv__body">
        <div class="p-fv__catchWrap">
          <h1 class="p-fv__catch js-typing">つくる<span class="p-fv__dots">だけ</span>で終わらせない、<br><span class="p-fv__catchLine2"><span class="p-fv__dots">伴走型</span>Webコーダー</span></h1>
          <span class="p-fv__underline" aria-hidden="true"><img src="<?php echo $img; ?>/fv-underline.svg" alt="" loading="eager"></span>
          <span class="p-fv__pencil" aria-hidden="true"><img src="<?php echo $img; ?>/fv-pencil.svg" alt="" loading="eager"></span>
        </div>
        <p class="p-fv__lead js-afterTyping">ディレクター様の進行を止めない、<br><span class="p-fv__mark">安心</span>して任せられるWebコーディング</p>
      </div>
      <figure class="p-fv__photo js-reveal js-reveal--soft">
        <span class="p-fv__frame" aria-hidden="true"><img src="<?php echo $img; ?>/fv-photo-frame.svg" alt="" loading="eager"></span>
        <picture class="p-fv__photoPicture">
          <source srcset="<?php echo $img; ?>/fv-photo.webp" type="image/webp">
          <img class="p-fv__photoImg" src="<?php echo $img; ?>/fv-photo.png" alt="ノートパソコンを持ってほほえむツムグ" width="673" height="817" loading="eager" fetchpriority="high">
        </picture>
        <span class="p-fv__leaf js-parallax" data-parallax="0.14" aria-hidden="true"><img src="<?php echo $img; ?>/fv-leaf.svg" alt="" loading="eager"></span>
      </figure>
    </div>
  </div>
</section>
