<?php $img = get_theme_file_uri('/assets/img'); ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php // ローディングは同じタブで初回だけ表示。2 ページ目以降は描画前に隠してチラつきを防ぐ ?>
  <script>try{if(sessionStorage.getItem('tsumugu-loaded')){document.documentElement.classList.add('is-loadingSkip');}}catch(e){}</script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Kiwi+Maru:wght@400;500&family=Noto+Sans+JP:wght@400;500&family=Sacramento&display=swap" rel="stylesheet">
  <?php wp_head(); ?>
</head>

<body <?php body_class('fadeIn'); ?>>
  <?php get_template_part('includes/loading'); ?>
  <header class="l-header">
    <div class="l-header__logo">
      <a href="<?php echo is_front_page() ? '#top' : esc_url(home_url('/')); ?>">
        <img src="<?php echo $img; ?>/logo.png" alt="Tsumugu">
      </a>
    </div>
  </header>
  <?php get_template_part('includes/nav'); ?>
