<?php // includes/about.php — 自己紹介（About）セクション ?>
<?php $img = get_theme_file_uri('/assets/img'); ?>
<section class="p-topAbout p-top__about" id="about">
  <div class="l-container">
    <h2 class="c-sectionTitle p-topAbout__title js-reveal js-reveal--stamp">
      <span class="c-sectionTitle__ja">自己紹介</span>
      <span class="c-sectionTitle__en">About</span>
    </h2>
    <div class="p-topAbout__columns">
      <figure class="p-topAbout__photo js-reveal js-reveal--left">
        <picture>
          <img src="<?php echo $img; ?>/about-photo.png" alt="" loading="lazy">
        </picture>
        <span class="p-topAbout__flower js-parallax" data-parallax="0.16" aria-hidden="true">
          <img src="<?php echo $img; ?>/about-flower.svg" alt="">
        </span>
      </figure>
      <div class="p-topAbout__body js-reveal js-reveal--right">
        <span class="p-topAbout__tape" aria-hidden="true">
          <img src="<?php echo $img; ?>/about-tape.svg" alt="">
        </span>
        <p class="p-topAbout__career">Webコーダーとして、HTML / CSS / WordPress を中心に<br><strong>Webサイトのコーディングや修正、保守対応</strong>を行っています。<br>塾・教育現場で<strong>10年以上、秘書・庶務</strong>として勤務した後、<br><strong>オンライン秘書として制作現場に関わり、<br>進行管理やコミュニケーション面でのサポート経験を積んできました</strong>。<br>Web制作においてもその経験を活かし、<br>制作前・制作中・納品前にはチェック表を用いた確認を行い、<br><strong>認識のズレや抜け漏れを防ぐ品質管理を徹底</strong>しています。<br>プライベートでは二児の母として日々を過ごしながら、カメラや手芸を趣味に、つくること・記録することを楽しんでいます。<br>仕事でもプライベートでも、<strong>「相手にとって心地よい形」を考えることを大切にし、<br>つくるだけで終わらせない伴走型のWebコーダー</strong>として向き合っています。</p>
      </div>
    </div>
  </div>
</section>
