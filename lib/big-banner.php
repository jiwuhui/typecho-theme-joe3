<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * 顶部大图（移植自 Halo 版 big_banner.html）
 * $joeBannerTitle：非首页时展示的标题
 */
$joeBigTitle = isset($joeBannerTitle) ? $joeBannerTitle : joe_site_title();
$joeIsIndex = (isset($joeBannerIsIndex) ? $joeBannerIsIndex : true);
/* 首页大图沉浸式导航（header.php 输出 html.joe_banner_header）时，header 不再占位，高度补回 60px */
$joeBannerImmersive = $joeIsIndex && ($joeType ?? 'index') === 'index' && joe_is_on('enable_big_banner');
$joeBannerHeight = $joeBannerImmersive ? '100vh' : 'calc(100vh - 60px)';
?>
<div id="EvanBigBanner" class="evan-big-banner"
     style="background-image:url(<?php echo joe_opt('big_banner_Photos'); ?>);<?php echo $joeIsIndex ? 'height:' . $joeBannerHeight . ';margin-top: initial;' : ''; ?>">
    <?php if (joe_is_on('enable_big_banner_video') && joe_opt('big_banner_video')): ?>
        <video id="EvanBigBannerVideo" class="video" preload="auto" loop="" autoplay="" muted=""
               src="<?php echo joe_opt('big_banner_video'); ?>"
               style="width: 100%; height: 100%; object-fit: cover"></video>
    <?php endif; ?>
    <div class="infomation">
        <div id="EvanBigBanner_Title" class="title">
            <span id="EvanBigBanner_SubTitle" style="opacity: 0">
                <?php echo $joeBigTitle; ?>
            </span>
        </div>
        <div class="desctitle hitokoto_desctitle">
            <div id="HitokotoText" class="motto joe_motto hitokoto_text"></div>
            <div id="HitokotoForm" class="motto joe_motto hitokoto_form"></div>
        </div>
    </div>
    <?php if ($joeIsIndex): ?>
        <a href="#" class="evan-big-banner_goto" id="evan-big-banner_goto">
            <span class="index-goto-icon jiewen joe-icon-xiangxia"></span>
        </a>
    <?php endif; ?>
    <section class="evan-big-banner_bottom" id="indexPosition">
        <svg id="EvanWaves" class="waves-svg" xmlns="http://www.w3.org/2000/svg"
             xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none"
             shape-rendering="auto">
            <defs>
                <path id="gentle-wave"
                      d="M -160 44 c 30 0 58 -18 88 -18 s 58 18 88 18 s 58 -18 88
                    -18 s 58 18 88 18 v 44 h -352 Z"></path>
            </defs>
            <g class="parallax">
                <use xlink:href="#gentle-wave" fill="#fff" x="48" y="0"></use>
                <use xlink:href="#gentle-wave" fill="#fff" x="48" y="3"></use>
                <use xlink:href="#gentle-wave" fill="#fff" x="48" y="5"></use>
                <use xlink:href="#gentle-wave" fill="#fff" x="48" y="7"></use>
            </g>
        </svg>
    </section>
</div>
