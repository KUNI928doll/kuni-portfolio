<?php // includes/service.php — サービス内容セクション（所有ファイル） ?>
<?php $img = get_theme_file_uri('/assets/img'); ?>
<section class="p-topService p-top__service" id="service">
  <div class="l-container">
    <div class="p-topService__head">
      <h2 class="c-sectionTitle p-topService__title js-reveal js-reveal--stamp">
        <span class="c-sectionTitle__ja">サービス内容</span>
        <span class="c-sectionTitle__en">Service</span>
      </h2>
      <p class="p-topService__lead">制作会社様・デザイナー様からの<br>コーディング業務の外注・部分依頼に対応しています。</p>
    </div>
  </div>
  <div class="p-topService__venn">
    <span class="p-topService__circle p-topService__circle--left js-reveal js-reveal--scale" aria-hidden="true"></span>
    <span class="p-topService__circle p-topService__circle--right js-reveal js-reveal--scale" aria-hidden="true"></span>
    <figure class="p-topService__icon p-topService__icon--laptop">
      <img src="<?php echo $img; ?>/service-laptop.svg" alt="" loading="lazy">
    </figure>
    <div class="p-topService__col p-topService__col--left">
      <h3 class="p-topService__subheading">Web制作・コーディング</h3>
      <ul class="p-topService__list">
        <li class="p-topService__item js-reveal" data-reveal-delay="0">LP／Webサイトのコーディング<br><span class="p-topService__itemNote">（HTML / CSS / WordPress 対応）</span></li>
        <li class="p-topService__item js-reveal" data-reveal-delay="120">既存サイトの保守・修正対応<br><span class="p-topService__itemNote">テキスト・画像差し替え、軽微なレイアウト調整など</span></li>
        <li class="p-topService__item js-reveal" data-reveal-delay="240">レスポンシブ対応<br><span class="p-topService__itemNote">（PC／タブレット／スマートフォン）</span></li>
        <li class="p-topService__item js-reveal" data-reveal-delay="360">軽微なJavaScriptカスタマイズ<br><span class="p-topService__itemNote">（スライダー、アコーディオン、UI調整など）</span></li>
      </ul>
    </div>
    <figure class="p-topService__icon p-topService__icon--book">
      <img src="<?php echo $img; ?>/service-book.svg" alt="" loading="lazy">
    </figure>
    <figure class="p-topService__icon p-topService__icon--pen">
      <img src="<?php echo $img; ?>/service-pen.svg" alt="" loading="lazy">
    </figure>
    <div class="p-topService__col p-topService__col--right">
      <h3 class="p-topService__subheading p-topService__subheading--right">進行サポート・業務補助<span class="p-topService__subNote">（オンライン秘書経験を活かした対応）</span></h3>
      <ul class="p-topService__list">
        <li class="p-topService__item js-reveal" data-reveal-delay="0">Slack／Chatworkを使用した進行フォロー・連絡対応</li>
        <li class="p-topService__item js-reveal" data-reveal-delay="120">スケジュール管理・進捗整理</li>
        <li class="p-topService__item js-reveal" data-reveal-delay="240">会議メモ・議事録作成補助</li>
        <li class="p-topService__item js-reveal" data-reveal-delay="360">見積書・資料作成、連絡文ドラフト作成</li>
        <li class="p-topService__item js-reveal" data-reveal-delay="480">デザイン補助・簡易的な画像修正対応</li>
      </ul>
    </div>
    <span class="p-topService__cross" aria-hidden="true">
      <img src="<?php echo $img; ?>/service-cross.svg" alt="" loading="lazy">
    </span>
  </div>
</section>
