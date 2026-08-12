<?php
if (!defined('ABSPATH')) {
  exit;
}

/**
 * テーマセットアップ
 */
add_action('after_setup_theme', function () {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('html5', ['style', 'script']);
});

/**
 * CSS / JS の読み込み（filemtime でバージョニング）
 */
add_action('wp_enqueue_scripts', function () {
  $ver_css = date('YmdGis', filemtime(get_theme_file_path('/assets/css/style.css')));
  wp_enqueue_style('tsumugu-style', get_theme_file_uri('/assets/css/style.css'), [], $ver_css);

  $ver_js = date('YmdGis', filemtime(get_theme_file_path('/assets/js/main.js')));
  wp_enqueue_script('tsumugu-main', get_theme_file_uri('/assets/js/main.js'), [], $ver_js, true);
});

/**
 * 管理バーのスタイル干渉を避ける
 */
add_filter('show_admin_bar', '__return_false');

/**
 * カスタム投稿「制作実績（works）」とカテゴリータクソノミーを登録
 */
add_action('init', function () {
  register_post_type('works', [
    'label' => '制作実績',
    'labels' => [
      'name' => '制作実績',
      'singular_name' => '制作実績',
      'add_new_item' => '制作実績を追加',
      'edit_item' => '制作実績を編集',
    ],
    'public' => true,
    'has_archive' => true,
    'menu_position' => 5,
    'menu_icon' => 'dashicons-portfolio',
    'rewrite' => ['slug' => 'works', 'with_front' => false],
    'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
    'show_in_rest' => true,
  ]);

  register_taxonomy('works_cat', 'works', [
    'label' => '制作カテゴリー',
    'hierarchical' => true,
    'public' => true,
    'rewrite' => ['slug' => 'works-cat', 'with_front' => false],
    'show_in_rest' => true,
  ]);
});

/**
 * 制作実績の追加フィールド（制作サイト URL）
 */
add_action('add_meta_boxes', function () {
  add_meta_box('works_meta', '制作情報', function ($post) {
    wp_nonce_field('works_meta_save', 'works_meta_nonce');
    $url = get_post_meta($post->ID, 'works_url', true);
    echo '<p><label for="works_url">制作サイト URL</label><br>';
    echo '<input type="url" id="works_url" name="works_url" value="' . esc_attr($url) . '" style="width:100%" placeholder="https://"></p>';
  }, 'works', 'side');
});

add_action('save_post_works', function ($post_id) {
  if (!isset($_POST['works_meta_nonce']) || !wp_verify_nonce($_POST['works_meta_nonce'], 'works_meta_save')) {
    return;
  }
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }
  if (isset($_POST['works_url'])) {
    update_post_meta($post_id, 'works_url', esc_url_raw($_POST['works_url']));
  }
});

/**
 * 固定ページの英語見出し（下層 FV の eyebrow 用・任意）
 */
add_action('add_meta_boxes', function () {
  add_meta_box('page_en_label', '英語見出し（任意）', function ($post) {
    wp_nonce_field('page_en_label_save', 'page_en_label_nonce');
    $en = get_post_meta($post->ID, 'en_label', true);
    echo '<p><label for="en_label">下層ページ上部の英語ラベル</label><br>';
    echo '<input type="text" id="en_label" name="en_label" value="' . esc_attr($en) . '" style="width:100%" placeholder="Privacy Policy"></p>';
  }, 'page', 'side');
});

add_action('save_post_page', function ($post_id) {
  if (!isset($_POST['page_en_label_nonce']) || !wp_verify_nonce($_POST['page_en_label_nonce'], 'page_en_label_save')) {
    return;
  }
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }
  if (isset($_POST['en_label'])) {
    update_post_meta($post_id, 'en_label', sanitize_text_field($_POST['en_label']));
  }
});

/**
 * 制作実績アーカイブの表示件数
 */
add_action('pre_get_posts', function ($query) {
  if (!is_admin() && $query->is_main_query() && is_post_type_archive('works')) {
    $query->set('posts_per_page', 9);
  }
});
