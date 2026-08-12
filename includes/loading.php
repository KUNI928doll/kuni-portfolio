<?php $img = get_theme_file_uri('/assets/img'); ?>
<div class="c-loading js-loading">
  <div class="c-loading__page c-loading__page--left" aria-hidden="true"></div>
  <div class="c-loading__page c-loading__page--right" aria-hidden="true"></div>
  <div class="c-loading__inner">
    <div class="c-loading__draw">
      <svg class="c-loading__logo" viewBox="0 0 536 448" role="img" aria-label="Tsumugu" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <mask id="c-loading-draw" maskUnits="userSpaceOnUse" maskContentUnits="userSpaceOnUse" x="0" y="0" width="536" height="448">
            <g fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round">
              <path class="c-loading__ink" style="--i:0"  pathLength="1" stroke-width="32" d="M46,258 L46,130 Q46,90 92,88 Q170,86 198,122"/>
              <path class="c-loading__ink" style="--i:1"  pathLength="1" stroke-width="32" d="M376,144 L376,94 Q376,84 328,84 Q240,84 198,122"/>
              <path class="c-loading__ink" style="--i:2"  pathLength="1" stroke-width="20" d="M166,98 L220,138"/>
              <path class="c-loading__ink" style="--i:3"  pathLength="1" stroke-width="20" d="M220,98 L166,138"/>
              <path class="c-loading__ink" style="--i:4"  pathLength="1" stroke-width="22" d="M84,182 L56,199 L84,218"/>
              <path class="c-loading__ink" style="--i:5"  pathLength="1" stroke-width="34" d="M84,218 Q272,254 474,216"/>
              <path class="c-loading__ink c-loading__ink--word" pathLength="1" stroke-width="70" d="M118,206 C130,180 150,165 165,180 C175,192 168,210 185,205 C210,198 205,176 235,178 C255,180 250,205 268,206 C285,207 285,188 300,190 C318,192 315,210 332,206 C345,203 352,196 360,192"/>
              <path class="c-loading__ink" style="--i:7"  pathLength="1" stroke-width="70" d="M354,214 C372,206 388,190 404,174 C416,162 428,150 438,138"/>
              <path class="c-loading__ink" style="--i:8"  pathLength="1" stroke-width="48" d="M352,206 L398,226"/>
              <path class="c-loading__ink" style="--i:9"  pathLength="1" stroke-width="32" d="M334,244 Q372,272 410,248"/>
              <path class="c-loading__ink" style="--i:10" pathLength="1" stroke-width="24" d="M470,180 L500,199 L470,218"/>
            </g>
          </mask>
        </defs>
        <image href="<?php echo $img; ?>/logo.svg" x="0" y="0" width="536" height="448" mask="url(#c-loading-draw)"/>
        <image class="c-loading__pencil" href="<?php echo $img; ?>/fv-pencil.svg" width="92" height="76" aria-hidden="true"/>
      </svg>
    </div>
  </div>
</div>
