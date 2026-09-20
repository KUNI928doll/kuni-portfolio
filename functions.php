<?php
if (!defined('ABSPATH')) {
  exit;
}

// Google タグマネージャーのコンテナ ID（計測タグは GTM 側で管理する）
define('TSUMUGU_GTM_ID', 'GTM-KF5Q2CN7');

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
 * ページタイトル（<title>）：サイト名を「＜.Tsumugu＞」にし、トップは肩書きを添える
 */
add_filter('document_title_parts', function ($parts) {
  if (is_front_page()) {
    return ['title' => '＜.Tsumugu＞', 'tagline' => '伴走型Webコーダーのポートフォリオ'];
  }
  if (is_404()) {
    $parts['title'] = 'ページが見つかりませんでした';
  }
  $parts['site'] = '＜.Tsumugu＞';
  return $parts;
});
add_filter('document_title_separator', function () {
  return '｜';
});

/**
 * メタ情報（説明文・OGP・Twitter カード・ファビコン）
 * SEO プラグインを入れる場合は、重複しないようこの出力を外すこと
 */
add_action('wp_head', function () {
  $site_name = '＜.Tsumugu＞';
  $default_desc = 'つくるだけで終わらせない、伴走型Webコーダー ＜.Tsumugu＞ のポートフォリオ。HTML / CSS / WordPress のコーディングから進行サポートまで、制作会社様・デザイナー様からの外注・部分依頼に対応しています。';
  $img = get_theme_file_uri('/assets/img');

  $title = wp_get_document_title();
  $desc = $default_desc;
  $url = home_url('/');
  $image = $img . '/ogp.jpg';
  $type = 'website';

  if (is_singular()) {
    $url = get_permalink();
    $type = 'article';
    $summary = is_singular('works') ? get_post_meta(get_the_ID(), 'works_summary', true) : '';
    $excerpt = wp_strip_all_tags(get_the_excerpt());
    if ($summary) {
      $desc = get_the_title() . '（' . $summary . '）の制作実績。' . $default_desc;
    } elseif ($excerpt) {
      $desc = $excerpt;
    }
    if (is_singular('works') && has_post_thumbnail()) {
      $image = get_the_post_thumbnail_url(null, 'large');
    }
  } elseif (is_post_type_archive('works')) {
    $url = get_post_type_archive_link('works');
    $desc = '＜.Tsumugu＞ の制作実績一覧。WordPress オリジナルテーマ構築・LP コーディングなど、実装のポイントやコードの一部も紹介しています。';
  }
  $desc = wp_html_excerpt($desc, 120, '…');

  printf('<meta name="description" content="%s">' . "\n", esc_attr($desc));
  printf('<meta property="og:site_name" content="%s">' . "\n", esc_attr($site_name));
  printf('<meta property="og:type" content="%s">' . "\n", esc_attr($type));
  printf('<meta property="og:title" content="%s">' . "\n", esc_attr($title));
  printf('<meta property="og:description" content="%s">' . "\n", esc_attr($desc));
  printf('<meta property="og:url" content="%s">' . "\n", esc_url($url));
  printf('<meta property="og:image" content="%s">' . "\n", esc_url($image));
  echo '<meta property="og:locale" content="ja_JP">' . "\n";
  echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
  printf('<link rel="icon" href="%s" sizes="32x32">' . "\n", esc_url($img . '/favicon-32.png'));
  printf('<link rel="icon" href="%s" sizes="192x192">' . "\n", esc_url($img . '/icon-192.png'));
  printf('<link rel="apple-touch-icon" href="%s">' . "\n", esc_url($img . '/apple-touch-icon.png'));
}, 1);

/**
 * セキュリティ（ログイン ID を外から分からなくする・バージョンを隠す）
 * SiteGuard でログインページは隠しているので、ここでは情報の露出だけを塞ぐ
 */

// 1. REST API のユーザー情報は、ログインしていない人には返さない
add_filter('rest_endpoints', function ($endpoints) {
  if (is_user_logged_in()) {
    return $endpoints;
  }
  unset($endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)']);
  return $endpoints;
});

// 2. 作者ページ（/author/○○/）は使わないので 404 にする
add_action('template_redirect', function () {
  if (is_author()) {
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    nocache_headers();
  }
});

// 3. /?author=1 のような番号からユーザー名を探る動きを止める
add_action('init', function () {
  if (!is_admin() && isset($_GET['author']) && !is_user_logged_in()) {
    wp_safe_redirect(home_url('/'), 301);
    exit;
  }
});

// 4. WordPress のバージョンを隠す（脆弱性を狙われにくくする）
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');

// 5. ログイン失敗時に「ユーザー名が違う／パスワードが違う」を区別しない
add_filter('login_errors', function () {
  return 'ログイン情報が正しくありません。';
});

/**
 * Google タグマネージャー（GTM）
 * GA4・Clarity などの計測タグは GTM の管理画面から配信する（テーマには GTM だけ置く）
 * ログイン中のユーザー・管理画面・プレビューでは読み込まない
 */
function tsumugu_gtm_enabled() {
  return !is_admin() && !is_user_logged_in() && !is_preview() && !is_customize_preview();
}

add_action('wp_head', function () {
  if (!tsumugu_gtm_enabled()) {
    return;
  }
  ?>
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','<?php echo esc_js(TSUMUGU_GTM_ID); ?>');</script>
  <!-- End Google Tag Manager -->
  <?php
}, 4);

// JavaScript が無効な環境向け（GTM の推奨設置。body 直後に置く）
add_action('wp_body_open', function () {
  if (!tsumugu_gtm_enabled()) {
    return;
  }
  printf(
    '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=%s" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>' . "\n",
    esc_attr(TSUMUGU_GTM_ID)
  );
});

/**
 * サイトマップの調整
 * このサイトはブログを使わないため、投稿・カテゴリ・タグ・投稿者のサイトマップを外す。
 * 代わりに、制作実績の一覧（/works/）を載せる（WordPress 標準では一覧が入らない）
 */
add_filter('wp_sitemaps_post_types', function ($post_types) {
  unset($post_types['post']);
  return $post_types;
});

add_filter('wp_sitemaps_taxonomies', function ($taxonomies) {
  unset($taxonomies['category'], $taxonomies['post_tag']);
  return $taxonomies;
});

add_filter('wp_sitemaps_add_provider', function ($provider, $name) {
  if ($name === 'users') {
    return false;
  }
  return $provider;
}, 10, 2);

// 制作実績の一覧ページをサイトマップに追加
add_filter('wp_sitemaps_posts_pre_url_list', function ($url_list, $post_type, $page_num) {
  if ($post_type !== 'works' || (int) $page_num !== 1) {
    return $url_list;
  }
  $archive = get_post_type_archive_link('works');
  if (!$archive) {
    return $url_list;
  }
  $list = $url_list;
  if (!is_array($list)) {
    $list = [];
    $query = new WP_Query(['post_type' => 'works', 'posts_per_page' => -1, 'fields' => 'ids', 'no_found_rows' => true]);
    foreach ($query->posts as $id) {
      $list[] = ['loc' => get_permalink($id)];
    }
  }
  array_unshift($list, ['loc' => $archive]);
  return $list;
}, 10, 3);

/**
 * canonical（正規 URL）
 * WordPress は個別ページにしか出力しないため、トップ・一覧にも自前で出す
 */
add_action('wp_head', function () {
  if (is_singular()) {
    return; // WordPress 本体が出力する
  }
  $url = '';
  if (is_front_page()) {
    $url = home_url('/');
  } elseif (is_post_type_archive()) {
    $url = get_post_type_archive_link(get_query_var('post_type'));
  } elseif (is_tax() || is_category() || is_tag()) {
    $term = get_queried_object();
    $url = $term ? get_term_link($term) : '';
  }
  if ($url && !is_wp_error($url)) {
    printf('<link rel="canonical" href="%s">' . "\n", esc_url($url));
  }
}, 2);

/**
 * 構造化データ（JSON-LD）
 * トップ: サイト情報 + 制作者情報 / 制作実績の詳細: 制作物として記述
 */
add_action('wp_head', function () {
  $site_name = '＜.Tsumugu＞';
  $person = [
    '@type' => 'Person',
    'name' => $site_name,
    'alternateName' => 'Tsumugu（ツムグ）',
    'jobTitle' => 'Web コーダー',
    'url' => home_url('/'),
    'sameAs' => [
      'https://x.com/KUNI_webdesign',
      'https://www.instagram.com/pon8doll/',
    ],
  ];

  $data = null;
  if (is_front_page()) {
    $data = [
      '@context' => 'https://schema.org',
      '@graph' => [
        [
          '@type' => 'WebSite',
          'name' => $site_name,
          'url' => home_url('/'),
          'inLanguage' => 'ja',
          'author' => $person,
        ],
        $person,
      ],
    ];
  } elseif (is_singular('works')) {
    $work = [
      '@context' => 'https://schema.org',
      '@type' => 'CreativeWork',
      'name' => get_the_title(),
      'url' => get_permalink(),
      'inLanguage' => 'ja',
      'creator' => $person,
    ];
    $summary = get_post_meta(get_the_ID(), 'works_summary', true);
    if ($summary) {
      $work['description'] = $summary;
    }
    if (has_post_thumbnail()) {
      $work['image'] = get_the_post_thumbnail_url(null, 'large');
    }
    $tech = array_filter(array_map('trim', preg_split('/[,、，]/u', (string) get_post_meta(get_the_ID(), 'works_tech', true))));
    if ($tech) {
      $work['keywords'] = implode(', ', $tech);
    }
    $data = $work;
  }

  if ($data) {
    echo '<script type="application/ld+json">' . wp_json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
  }
}, 3);

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
 * 制作実績の追加フィールド（詳細ページの情報表に表示。本文は「制作ポイント」として表示）
 */
function tsumugu_works_fields() {
  return [
    'works_summary' => ['label' => 'サイト概要（タイトル下に表示）', 'type' => 'text', 'placeholder' => '横浜を拠点とした観光・予約代行サービス'],
    'works_client' => ['label' => 'クライアント', 'type' => 'text', 'placeholder' => '〇〇株式会社様'],
    'works_role' => ['label' => '作業内容（「／」区切りで改行）', 'type' => 'text', 'placeholder' => 'コーディング／WordPress オリジナルテーマ開発'],
    'works_design' => ['label' => 'デザインカンプ', 'type' => 'text', 'placeholder' => 'Figma（PC / SP）'],
    'works_period' => ['label' => '制作期間', 'type' => 'text', 'placeholder' => 'コーディング：3週間（トップ1P＋下層5P）'],
    'works_tools' => ['label' => 'ツール', 'type' => 'text', 'placeholder' => 'Cursor, Figma, GitHub'],
    'works_tech' => ['label' => '使用言語（カンマ区切り）', 'type' => 'text', 'placeholder' => 'HTML, SCSS, JavaScript'],
    'works_url' => ['label' => '制作サイト URL', 'type' => 'url', 'placeholder' => 'https://'],
    'works_url_note' => ['label' => 'URL を載せない場合の表記', 'type' => 'text', 'placeholder' => '非公開（センシティブ商材のため）'],
    'works_video' => ['label' => 'デモ動画 URL（メディアの mp4。入力するとアイキャッチ画像の代わりに表示）', 'type' => 'url', 'placeholder' => 'https://…/demo.mp4'],
  ];
}

/**
 * 制作実績のタグ（制作カテゴリー）を取得。WordPress などの技術タグは種別タグの後ろに並べる
 */
function tsumugu_works_tags($post_id) {
  $terms = get_the_terms($post_id, 'works_cat');
  if (!$terms || is_wp_error($terms)) {
    return [];
  }
  usort($terms, function ($a, $b) {
    return ($a->slug === 'wordpress') <=> ($b->slug === 'wordpress');
  });
  return $terms;
}

add_action('add_meta_boxes', function () {
  add_meta_box('works_meta', '制作情報', function ($post) {
    wp_nonce_field('works_meta_save', 'works_meta_nonce');
    foreach (tsumugu_works_fields() as $key => $field) {
      $value = get_post_meta($post->ID, $key, true);
      echo '<p><label for="' . esc_attr($key) . '">' . esc_html($field['label']) . '</label><br>';
      echo '<input type="' . esc_attr($field['type']) . '" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '" style="width:100%" placeholder="' . esc_attr($field['placeholder']) . '"></p>';
    }
  }, 'works', 'side');
});

add_action('save_post_works', function ($post_id) {
  if (!isset($_POST['works_meta_nonce']) || !wp_verify_nonce($_POST['works_meta_nonce'], 'works_meta_save')) {
    return;
  }
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }
  foreach (tsumugu_works_fields() as $key => $field) {
    if (isset($_POST[$key])) {
      $value = $field['type'] === 'url' ? esc_url_raw($_POST[$key]) : sanitize_text_field($_POST[$key]);
      update_post_meta($post_id, $key, $value);
    }
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
 * Contact Form 7 の自動整形（<p> / <br> の挿入）を無効化
 * フォームは c-form のマークアップで組んでいるため、余計な改行でラベルと入力欄の間が空くのを防ぐ
 */
add_filter('wpcf7_autop_or_not', '__return_false');

/**
 * お問い合わせフォームの簡易スパム対策（API キー不要）
 * 1. 人には見えない入力欄（ハニーポット）に何か入っていたらスパム扱い
 * 2. 表示から 4 秒未満で送信されたらスパム扱い（自動送信対策）
 * reCAPTCHA / Akismet を導入する場合は、この処理と併用して問題ない
 */
add_action('wpcf7_init', function () {
  wpcf7_add_form_tag('tsumugu_trap', function () {
    $nonce = time();
    return '<span class="c-form__trap" aria-hidden="true">'
      . '<label>この欄は入力しないでください<input type="text" name="tsumugu-website" value="" tabindex="-1" autocomplete="off"></label>'
      . '<input type="hidden" name="tsumugu-loaded-at" value="' . esc_attr($nonce) . '">'
      . '</span>';
  });
});

add_filter('wpcf7_spam', function ($spam, $submission = null) {
  if ($spam) {
    return $spam;
  }
  $posted = isset($_POST['tsumugu-website']) ? trim((string) $_POST['tsumugu-website']) : '';
  if ($posted !== '') {
    return true;
  }
  $loaded_at = isset($_POST['tsumugu-loaded-at']) ? (int) $_POST['tsumugu-loaded-at'] : 0;
  if ($loaded_at && (time() - $loaded_at) < 4) {
    return true;
  }
  return $spam;
}, 10, 2);

/**
 * 制作実績アーカイブの表示件数
 */
add_action('pre_get_posts', function ($query) {
  if (!is_admin() && $query->is_main_query() && is_post_type_archive('works')) {
    $query->set('posts_per_page', 9);
  }
});
