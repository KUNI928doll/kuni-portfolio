<?php
// フロントページでは同一ページ内アンカー、それ以外のページではトップの各セクションへ遷移させる
$nav_base = is_front_page() ? '' : esc_url(home_url('/'));
?>
<button class="p-navToggle js-navToggle" type="button" aria-label="メニューを開く" aria-expanded="false" aria-controls="js-navList">
  <span class="p-navToggle__bar" aria-hidden="true"></span>
  <span class="p-navToggle__bar" aria-hidden="true"></span>
  <span class="p-navToggle__bar" aria-hidden="true"></span>
</button>
<div class="p-navOverlay js-navOverlay" aria-hidden="true"></div>
<nav aria-label="サイトナビ">
  <ul class="p-nav js-navList" id="js-navList">
    <li class="p-nav__item"><a class="p-nav__link p-nav__link--contact" href="<?php echo $nav_base; ?>#contact">Contact</a></li>
    <li class="p-nav__item"><a class="p-nav__link" href="<?php echo $nav_base; ?>#works">Works</a></li>
    <li class="p-nav__item"><a class="p-nav__link" href="<?php echo $nav_base; ?>#strength">Strength</a></li>
    <li class="p-nav__item"><a class="p-nav__link" href="<?php echo $nav_base; ?>#service">Service</a></li>
    <li class="p-nav__item"><a class="p-nav__link" href="<?php echo $nav_base; ?>#flow">Flow</a></li>
    <li class="p-nav__item"><a class="p-nav__link" href="<?php echo $nav_base; ?>#about">About</a></li>
  </ul>
</nav>
