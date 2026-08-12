<?php $img = get_theme_file_uri('/assets/img'); ?>
<?php
$steps = [
  [
    'num'   => '1',
    'title' => 'ヒアリング・ご相談',
    'lead'  => '目的やご要望、現在の状況を丁寧にお伺いします。<br>デザインデータの有無や、対応範囲についてもこの段階で整理します。',
    'list'  => [],
    'close' => '',
    'shot'  => 'flow-shot-01.png',
    'alt'   => 'オンラインでヒアリングを行う様子',
  ],
  [
    'num'   => '2',
    'title' => '制作前チェック・進行確認',
    'lead'  => '制作に入る前に、チェック表を用いて内容を確認します。',
    'list'  => ['PC / SPデザインの有無', 'ページ構成・見出し階層', '実装範囲・優先順位', '納期・進行スケジュール'],
    'close' => '認識のズレを防ぎ、スムーズな進行を目指します。',
    'shot'  => 'flow-shot-02.png',
    'alt'   => 'カラー付箋を使った制作前チェック表',
  ],
  [
    'num'   => '3',
    'title' => 'コーディング・実装',
    'lead'  => 'デザインの意図や世界観を大切にしながら、<br>HTML / CSS / WordPress にて丁寧にコーディングを行います。<br>進捗は随時共有し、ご確認いただきながら進めます。',
    'list'  => [],
    'close' => '',
    'shot'  => 'flow-shot-03.png',
    'alt'   => 'HTML・CSS・WordPress でコーディングを行うイメージ',
  ],
  [
    'num'   => '4',
    'title' => '品質チェック・最終確認',
    'lead'  => '納品前にチェック表を用いて最終確認を行います。',
    'list'  => ['レスポンシブ表示', '表示崩れ・リンク・動作確認', '構造や設定漏れの確認'],
    'close' => '安心して公開できる状態に整えます。',
    'shot'  => '',
    'alt'   => '',
  ],
  [
    'num'   => '5',
    'title' => '納品・公開後サポート',
    'lead'  => 'ご確認後、納品となります。<br>公開後の軽微な修正やご相談にも、柔軟に対応いたします。',
    'list'  => [],
    'close' => '',
    'shot'  => '',
    'alt'   => '',
  ],
];
$revealDelay = 0;
?>
<section class="p-topFlow p-top__flow" id="flow">
  <span class="p-topFlow__hatch" aria-hidden="true">
    <img src="<?php echo $img; ?>/flow-hatch.svg" alt="">
  </span>
  <span class="p-topFlow__branch js-parallax" data-parallax="0.18" aria-hidden="true">
    <img src="<?php echo $img; ?>/flow-branch.svg" alt="">
  </span>
  <span class="p-topFlow__note" aria-hidden="true">
    <img src="<?php echo $img; ?>/flow-illust-note.svg" alt="">
  </span>
  <div class="l-container">
    <h2 class="c-sectionTitle js-reveal js-reveal--stamp">
      <span class="c-sectionTitle__ja">制作フロー</span>
      <span class="c-sectionTitle__en">Flow</span>
    </h2>
    <ol class="p-topFlow__list">
      <?php foreach ($steps as $step) : ?>
        <li class="p-topFlow__step js-reveal" data-reveal-delay="<?php echo $revealDelay; ?>">
          <div class="p-topFlow__card">
            <span class="p-topFlow__num" aria-hidden="true"><?php echo $step['num']; ?></span>
            <div class="p-topFlow__body">
              <h3 class="p-topFlow__stepTitle"><?php echo $step['title']; ?></h3>
              <p class="p-topFlow__text"><?php echo $step['lead']; ?></p>
              <?php if (!empty($step['list'])) : ?>
                <ul class="p-topFlow__checkList">
                  <?php foreach ($step['list'] as $item) : ?>
                    <li class="p-topFlow__checkItem"><?php echo $item; ?></li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
              <?php if ($step['close']) : ?>
                <p class="p-topFlow__text"><?php echo $step['close']; ?></p>
              <?php endif; ?>
            </div>
          </div>
          <?php if ($step['shot']) : ?>
            <figure class="p-topFlow__photo">
              <picture>
                <source srcset="<?php echo $img; ?>/<?php echo $step['shot']; ?>">
                <img src="<?php echo $img; ?>/<?php echo $step['shot']; ?>" alt="<?php echo $step['alt']; ?>" loading="lazy">
              </picture>
            </figure>
          <?php endif; ?>
          <?php if ($step['num'] !== '5') : ?>
            <span class="p-topFlow__connector" aria-hidden="true">
              <img src="<?php echo $img; ?>/flow-connector-0<?php echo $step['num']; ?>.svg" alt="">
            </span>
          <?php endif; ?>
        </li>
        <?php $revealDelay += 120; ?>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
