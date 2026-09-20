<?php get_header(); ?>
<main class="p-lowerMain">
  <div class="l-lowerFv">
    <div class="l-container">
      <p class="l-lowerFv__en js-reveal">Works</p>
      <p class="l-lowerFv__title js-reveal js-reveal--up">制作実績</p>
    </div>
  </div>
  <?php
  if (have_posts()) :
    while (have_posts()) : the_post();
      $terms = tsumugu_works_tags(get_the_ID());
      $work_summary = get_post_meta(get_the_ID(), 'works_summary', true);
      $work_client = get_post_meta(get_the_ID(), 'works_client', true);
      $work_url = get_post_meta(get_the_ID(), 'works_url', true);
      $work_url_note = get_post_meta(get_the_ID(), 'works_url_note', true);
      $work_role = array_filter(array_map('trim', explode('／', (string) get_post_meta(get_the_ID(), 'works_role', true))));
      $work_video = get_post_meta(get_the_ID(), 'works_video', true);
      $work_design = get_post_meta(get_the_ID(), 'works_design', true);
      $work_period = get_post_meta(get_the_ID(), 'works_period', true);
      $work_tools = get_post_meta(get_the_ID(), 'works_tools', true);
      $work_tech = array_filter(array_map('trim', preg_split('/[,、，]/u', (string) get_post_meta(get_the_ID(), 'works_tech', true))));
      $has_content = trim(get_the_content()) !== '';
      $prev_work = get_previous_post();
  ?>
    <article class="p-worksSingle">
      <div class="l-container">
        <nav class="c-breadcrumb p-worksSingle__breadcrumb" aria-label="パンくず">
          <ol class="c-breadcrumb__list">
            <li class="c-breadcrumb__item">
              <a class="c-breadcrumb__link" href="<?php echo esc_url(home_url('/')); ?>">ホーム</a>
            </li>
            <li class="c-breadcrumb__item">
              <a class="c-breadcrumb__link" href="<?php echo esc_url(get_post_type_archive_link('works')); ?>">制作実績</a>
            </li>
            <li class="c-breadcrumb__item">
              <span class="c-breadcrumb__current"><?php the_title(); ?></span>
            </li>
          </ol>
        </nav>
        <div class="p-worksSingle__inner">
          <div class="p-worksSingle__head">
            <?php if ($terms) : ?>
              <ul class="p-worksSingle__tags">
                <?php foreach ($terms as $term) : ?>
                  <li class="c-tag c-tag--<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
            <h1 class="p-worksSingle__title"><?php the_title(); ?></h1>
            <?php if ($work_summary) : ?>
              <p class="p-worksSingle__summary">（<?php echo esc_html($work_summary); ?>）</p>
            <?php endif; ?>
          </div>
          <?php if ($work_video) : ?>
            <figure class="p-worksSingle__img" style="view-transition-name: work-<?php the_ID(); ?>;">
              <video class="p-worksSingle__video" src="<?php echo esc_url($work_video); ?>"<?php if (has_post_thumbnail()) : ?> poster="<?php echo esc_url(get_the_post_thumbnail_url(null, 'large')); ?>"<?php endif; ?> autoplay loop muted playsinline aria-label="<?php echo esc_attr(get_the_title() . 'の動きが確認できるデモ動画'); ?>"></video>
            </figure>
          <?php elseif (has_post_thumbnail()) : ?>
            <figure class="p-worksSingle__img" style="view-transition-name: work-<?php the_ID(); ?>;"><?php the_post_thumbnail('large'); ?></figure>
          <?php endif; ?>
          <?php if ($work_client || $work_role || $work_design || $work_period || $work_tools || $work_tech || $work_url || $work_url_note || $has_content) : ?>
            <dl class="p-worksSingle__info">
              <?php if ($work_client) : ?>
                <div class="p-worksSingle__row">
                  <dt class="p-worksSingle__term">クライアント</dt>
                  <dd class="p-worksSingle__desc"><?php echo esc_html($work_client); ?></dd>
                </div>
              <?php endif; ?>
              <?php if ($work_role) : ?>
                <div class="p-worksSingle__row">
                  <dt class="p-worksSingle__term">作業内容</dt>
                  <dd class="p-worksSingle__desc">
                    <ul class="p-worksSingle__roleList">
                      <?php foreach ($work_role as $role) : ?>
                        <li><?php echo esc_html($role); ?></li>
                      <?php endforeach; ?>
                    </ul>
                  </dd>
                </div>
              <?php endif; ?>
              <?php if ($work_design) : ?>
                <div class="p-worksSingle__row">
                  <dt class="p-worksSingle__term">デザインカンプ</dt>
                  <dd class="p-worksSingle__desc"><?php echo esc_html($work_design); ?></dd>
                </div>
              <?php endif; ?>
              <?php if ($work_period) : ?>
                <div class="p-worksSingle__row">
                  <dt class="p-worksSingle__term">制作期間</dt>
                  <dd class="p-worksSingle__desc"><?php echo esc_html($work_period); ?></dd>
                </div>
              <?php endif; ?>
              <?php if ($work_tools) : ?>
                <div class="p-worksSingle__row">
                  <dt class="p-worksSingle__term">ツール</dt>
                  <dd class="p-worksSingle__desc"><?php echo esc_html($work_tools); ?></dd>
                </div>
              <?php endif; ?>
              <?php if ($work_tech) : ?>
                <div class="p-worksSingle__row">
                  <dt class="p-worksSingle__term">使用言語</dt>
                  <dd class="p-worksSingle__desc">
                    <ul class="p-worksSingle__techList">
                      <?php foreach ($work_tech as $tech) : ?>
                        <li class="p-worksSingle__tech"><?php echo esc_html($tech); ?></li>
                      <?php endforeach; ?>
                    </ul>
                  </dd>
                </div>
              <?php endif; ?>
              <?php if ($work_url || $work_url_note) : ?>
                <div class="p-worksSingle__row">
                  <dt class="p-worksSingle__term">URL</dt>
                  <dd class="p-worksSingle__desc">
                    <?php if ($work_url) : ?>
                      <a class="p-worksSingle__url" href="<?php echo esc_url($work_url); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($work_url); ?></a>
                    <?php else : ?>
                      <?php echo esc_html($work_url_note); ?>
                    <?php endif; ?>
                  </dd>
                </div>
              <?php endif; ?>
              <?php if ($has_content) : ?>
                <div class="p-worksSingle__row">
                  <dt class="p-worksSingle__term">制作ポイント</dt>
                  <dd class="p-worksSingle__desc p-worksSingle__body"><?php the_content(); ?></dd>
                </div>
              <?php endif; ?>
            </dl>
          <?php endif; ?>
        </div>
        <div class="p-worksSingle__nav">
          <?php if ($prev_work) : ?>
            <a class="c-btn p-worksSingle__btn p-worksSingle__btn--prev" href="<?php echo esc_url(get_permalink($prev_work)); ?>">前の実績を見る</a>
          <?php endif; ?>
          <a class="c-btn p-worksSingle__btn p-worksSingle__btn--back" href="<?php echo esc_url(get_post_type_archive_link('works')); ?>">一覧に戻る</a>
        </div>
      </div>
    </article>
  <?php
    endwhile;
  endif;
  ?>
</main>
<?php get_footer(); ?>
