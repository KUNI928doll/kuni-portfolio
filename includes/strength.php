<?php // includes/strength.php — セクション実装担当が埋める（所有ファイル） ?>
<?php $img = get_theme_file_uri('/assets/img'); ?>
<section class="p-topStrength p-top__strength" id="strength">
  <div class="l-container">
    <h2 class="c-sectionTitle js-reveal js-reveal--stamp">
      <span class="c-sectionTitle__ja">強み</span>
      <span class="c-sectionTitle__en">Strength</span>
    </h2>
    <ul class="p-topStrength__list">
      <li class="p-topStrength__item js-reveal" data-reveal-delay="0">
        <span class="p-topStrength__mark" aria-hidden="true">
          <img src="<?php echo $img; ?>/strength-deco-01.svg" alt="">
        </span>
        <div class="p-topStrength__head">
          <span class="p-topStrength__num js-reveal js-reveal--left" data-reveal-delay="150">1</span>
          <h3 class="p-topStrength__title">チェック表による品質管理</h3>
        </div>
        <p class="p-topStrength__text">制作前・制作中・納品前の各工程でチェック表を使用し、<br>レスポンシブ崩れや構造ミス、設定漏れなどを未然に防ぎます。<br>手戻りの少ない、安定した品質での納品を大切にしています。</p>
      </li>
      <li class="p-topStrength__item js-reveal" data-reveal-delay="120">
        <span class="p-topStrength__mark" aria-hidden="true">
          <img src="<?php echo $img; ?>/strength-deco-02.svg" alt="">
        </span>
        <div class="p-topStrength__head">
          <span class="p-topStrength__num js-reveal js-reveal--left" data-reveal-delay="270">2</span>
          <h3 class="p-topStrength__title">デザイン意図の再現力</h3>
        </div>
        <p class="p-topStrength__text">デザインカンプの世界観や余白、文字組みを大切にしながら、HTML / CSS / WordPressを用いて忠実に再現します。<br>見た目だけでなく、更新しやすさや運用面も考慮したコーディングを心がけています。</p>
      </li>
      <li class="p-topStrength__item js-reveal" data-reveal-delay="240">
        <span class="p-topStrength__mark" aria-hidden="true">
          <img src="<?php echo $img; ?>/strength-deco-03.svg" alt="">
        </span>
        <div class="p-topStrength__head">
          <span class="p-topStrength__num js-reveal js-reveal--left" data-reveal-delay="390">3</span>
          <h3 class="p-topStrength__title">進行・コミュニケーション</h3>
        </div>
        <p class="p-topStrength__text">オンライン秘書としての経験を活かし、<br>Slack / Chatworkを用いた進捗共有・タスク整理・連絡対応が可能です。<br>「今どこまで進んでいるか」が常に見える状態を<br>意識しています。</p>
      </li>
      <li class="p-topStrength__item js-reveal" data-reveal-delay="360">
        <span class="p-topStrength__mark" aria-hidden="true">
          <img src="<?php echo $img; ?>/strength-deco-04.svg" alt="">
        </span>
        <div class="p-topStrength__head">
          <span class="p-topStrength__num js-reveal js-reveal--left" data-reveal-delay="510">4</span>
          <h3 class="p-topStrength__title">修正・保守対応</h3>
        </div>
        <p class="p-topStrength__text">既存サイトのテキスト・画像修正やレイアウト調整など、<br>公開後の軽微な修正にも柔軟に対応します。<br>長期的に相談しやすいパートナーであることを大切にしています。</p>
      </li>
    </ul>
  </div>
</section>
