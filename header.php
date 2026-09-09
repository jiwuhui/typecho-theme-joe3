<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/* 点赞等 ajax 动作 */
joe_handle_ajax();

global $JOE_HTML_TYPE;
$joeType = isset($JOE_HTML_TYPE) ? $JOE_HTML_TYPE : 'index';
$options = $this->options;
?>
<!doctype html>
<html lang="zh-CN"<?php echo ($joeType === 'index' && joe_is_on('enable_big_banner')) ? ' class="joe_banner_header joe_banner_top"' : ''; ?>>
<head>
    <meta charset="UTF-8">
    <style>html[data-mode="dark"]{background:#232323}</style>
    <?php if ($joeType === 'index' && joe_is_on('enable_big_banner')): ?>
    <style>
        /* 首页大图沉浸式导航：顶部时透明覆盖在大图上、主题切换按钮淡出；滚过后白底吸顶、按钮淡入（仅桌面） */
        @media (min-width: 768px) {
            html.joe_banner_header .joe_header { height: 0; }
            html.joe_banner_header .joe_header__above { transition: opacity .35s, transform .35s, background .35s ease; }
            html.joe_banner_header.joe_banner_top .joe_header__above {
                background: linear-gradient(180deg, rgba(0,0,0,.45) 0%, rgba(0,0,0,0) 100%) !important;
                box-shadow: none !important;
            }
            html.joe_banner_header.joe_banner_top .joe_header__above .joe_header__above-nav a.item,
            html.joe_banner_header.joe_banner_top .joe_header__above .nav_login a,
            html.joe_banner_header.joe_banner_top .joe_header__above .joe_header__above-search .joe_tools_palette,
            html.joe_banner_header.joe_banner_top .joe_header__above .joe_header__above-search .joe_tools_mode,
            html.joe_banner_header.joe_banner_top .joe_header__above .joe_header__above-search .submit#halo-search {
                color: #fff !important;
                text-shadow: 0 1px 3px rgba(0,0,0,.35);
            }
            html.joe_banner_header.joe_banner_top .joe_header__above .joe_header__above-search .joe_tools_palette i,
            html.joe_banner_header.joe_banner_top .joe_header__above .joe_header__above-search .joe_tools_mode svg,
            html.joe_banner_header.joe_banner_top .joe_header__above .joe_header__above-search .submit#halo-search i {
                fill: #fff;
                color: #fff;
            }
            html.joe_banner_header.joe_banner_top .joe_header__above .joe_header__above-nav a.item.active {
                color: var(--theme) !important;
            }
            html.joe_banner_header.joe_banner_top .joe_header__above .joe_header__above-slideicon {
                color: #fff !important;
            }
            html.joe_banner_header .joe_action .mode { transition: opacity .35s ease, transform .35s ease; }
            html.joe_banner_header.joe_banner_top .joe_action .mode {
                opacity: 0;
                pointer-events: none;
                transform: scale(0);
            }
            html.joe_banner_header:not(.joe_banner_top) .joe_header__above {
                animation: joe_banner_header_in .4s ease both;
            }
            @keyframes joe_banner_header_in {
                from { transform: translateY(-100%); }
                to { transform: translateY(0); }
            }
        }
    </style>
    <script>
        (function () {
            var root = document.documentElement;
            if (!root.classList.contains('joe_banner_header')) return;
            var ticking = false;
            function update() {
                ticking = false;
                if (window.scrollY > 120) {
                    root.classList.remove('joe_banner_top');
                } else {
                    root.classList.add('joe_banner_top');
                }
            }
            window.addEventListener('scroll', function () {
                if (!ticking) {
                    ticking = true;
                    window.requestAnimationFrame(update);
                }
            }, { passive: true });
            update();
        })();
    </script>
    <?php endif; ?>
    <script>
        /* 深色模式预置：必须排在所有 CSS/JS 之前，解析到即同步执行，页面首帧就是深色 */
        (function () {
            try {
                var mode = '<?php echo joe_opt('theme_mode'); ?>';
                var cur = mode;
                if (mode === 'auto') {
                    var scope = '<?php echo addslashes(joe_opt('light_time_scope')); ?>'.split('~');
                    var now = new Date();
                    var today = now.toLocaleString().split(' ')[0];
                    cur = now >= new Date(today + ' ' + scope[0]) && now <= new Date(today + ' ' + scope[1])
                        ? 'light'
                        : 'dark';
                    localStorage.removeItem('data-mode');
                } else if (mode === 'user') {
                    cur = localStorage.getItem('data-mode') || 'light';
                } else {
                    localStorage.removeItem('data-mode');
                }
                if (cur === 'dark') {
                    document.documentElement.setAttribute('data-mode', 'dark');
                    document.documentElement.setAttribute('data-color-scheme', 'dark');
                }
            } catch (e) { /* ignore */ }
        })();
    </script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">
    <title><?php $this->archiveTitle([
        'category' => '分类 %s 下的文章',
        'search'   => '包含关键字 %s 的文章',
        'tag'      => '标签 %s 下的文章',
        'author'   => '%s 发布的文章',
        'date'     => '%s',
    ], '', ' - '); ?><?php $options->title(); ?></title>
    <?php /* antiSpam=1 保留 Typecho 反垃圾 token 注入 JS（评论提交必需）；commentReply= 禁用官方回复 JS（主题自制） */ ?>
    <?php $this->header('generator=&template=&pingback=&wlw=&xmlrpc=&rss1=&rss2=&atom=&commentReply=&antiSpam=1'); ?>
    <link rel="stylesheet" href="<?php echo joe_asset('css/min/style.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo joe_asset('css/joe-icons.css'); ?>">
    <?php $cursorSkin = joe_opt('cursor_skin'); ?>
    <?php if ($cursorSkin && $cursorSkin !== 'off'): ?>
    <link rel="stylesheet" href="<?php echo joe_asset('cursor/style/min/' . $cursorSkin . '.min.css'); ?>">
    <?php endif; ?>
    <script src="<?php echo joe_asset('js/min/main.min.js'); ?>"></script>
    <script id="theme-config-getter" type="text/javascript">
        const ThemeConfig = {
            theme_mode: '<?php echo joe_opt('theme_mode'); ?>',
            enable_loading_bar: <?php echo joe_is_on('enable_loading_bar') ? 'true' : 'false'; ?>,
            loading_bar_height: '<?php echo joe_opt('loading_bar_height'); ?>',
            loading_bar_color: '<?php echo joe_opt('loading_bar_color'); ?>',
            enable_footer: <?php echo joe_is_on('enable_footer') ? 'true' : 'false'; ?>,
            footer_position: '<?php echo joe_opt('footer_position'); ?>',
            check_baidu_collect: <?php echo joe_is_on('check_baidu_collect') ? 'true' : 'false'; ?>,
            baidu_token: '<?php echo joe_opt('baidu_token'); ?>',
            enable_back2top: <?php echo joe_is_on('enable_back2top') ? 'true' : 'false'; ?>,
            enable_back2top_smooth: <?php echo joe_is_on('enable_back2top_smooth') ? 'true' : 'false'; ?>,
            enable_weather: <?php echo joe_is_on('enable_weather') ? 'true' : 'false'; ?>,
            weather_token: '<?php echo joe_opt('weather_token'); ?>',
            weather_key: '',
            link_behavior: '<?php echo joe_opt('link_behavior'); ?>',
            enable_tag_cloud: true,
            tag_cloud_type: document.getElementById('tags-3d') ? '3d' : 'list',
            enable_fixed_header: <?php echo joe_is_on('enable_fixed_header') ? 'true' : 'false'; ?>,
            enable_clean_mode: <?php echo joe_is_on('enable_clean_mode') ? 'true' : 'false'; ?>,
            cursor_effect: '<?php echo joe_opt('cursor_effect'); ?>',
            enable_offscreen_tip: <?php echo joe_is_on('enable_offscreen_tip') ? 'true' : 'false'; ?>,
            enable_birthday: <?php echo joe_is_on('enable_birthday') ? 'true' : 'false'; ?>,
            birthday: '<?php echo joe_opt('custom_birthday'); ?>',
            light_time_scope: '<?php echo joe_opt('light_time_scope'); ?>',
            enable_console_theme: <?php echo joe_is_on('enable_console_theme') ? 'true' : 'false'; ?>,
            version: '<?php echo JOE_THEME_VERSION; ?>',

            enable_big_banner: <?php echo joe_is_on('enable_big_banner') ? 'true' : 'false'; ?>,
            enable_banner: <?php echo joe_is_on('enable_banner') ? 'true' : 'false'; ?>,
            banner_direction: '<?php echo joe_opt('banner_direction'); ?>',
            enable_banner_loop: <?php echo joe_is_on('enable_banner_loop') ? 'true' : 'false'; ?>,
            banner_effect: '<?php echo joe_opt('banner_effect'); ?>',
            banner_speed: parseInt('<?php echo (int) joe_opt('banner_speed'); ?>'),
            enable_banner_handle: <?php echo joe_is_on('enable_banner_handle') ? 'true' : 'false'; ?>,
            enable_banner_autoplay: <?php echo joe_is_on('enable_banner_autoplay') ? 'true' : 'false'; ?>,
            banner_delay: parseInt('<?php echo (int) joe_opt('banner_delay'); ?>'),
            enable_banner_switch_button: <?php echo joe_is_on('enable_banner_switch_button') ? 'true' : 'false'; ?>,
            enable_banner_pagination: <?php echo joe_is_on('enable_banner_pagination') ? 'true' : 'false'; ?>,
            enable_index_list_ajax: <?php echo joe_is_on('enable_index_list_ajax') ? 'true' : 'false'; ?>,
            backdrop: '<?php echo joe_opt('backdrop'); ?>',
            favicon: '<?php echo joe_opt('favicon'); ?>',
            enable_index_list_effect: <?php echo joe_is_on('enable_index_list_effect') ? 'true' : 'false'; ?>,
            index_list_effect_class: '<?php echo joe_opt('index_list_effect_class'); ?>',
            show_loaded_time: <?php echo joe_is_on('show_loaded_time') ? 'true' : 'false'; ?>,
            enable_debug: <?php echo joe_is_on('enable_debug') ? 'true' : 'false'; ?>,
            access_key: false,
            enable_copy: <?php echo joe_is_on('enable_copy') ? 'true' : 'false'; ?>,
            enable_share: <?php echo joe_is_on('enable_share') ? 'true' : 'false'; ?>,
            enable_share_link: <?php echo joe_is_on('enable_share_link') ? 'true' : 'false'; ?>,
            enable_share_weixin: <?php echo joe_is_on('enable_share_weixin') ? 'true' : 'false'; ?>,
            enable_like: <?php echo joe_is_on('enable_like') ? 'true' : 'false'; ?>,
            enable_toc: <?php echo joe_is_on('enable_toc') ? 'true' : 'false'; ?>,
            enable_progress_bar: <?php echo joe_is_on('enable_progress_bar') ? 'true' : 'false'; ?>,
            enable_code_expander: <?php echo joe_is_on('enable_code_expander') ? 'true' : 'false'; ?>,
            enable_fold_long_code: <?php echo joe_is_on('enable_fold_long_code') ? 'true' : 'false'; ?>,
            enable_comment: <?php echo joe_is_on('enable_comment') ? 'true' : 'false'; ?>,
            toc_depth: parseInt('<?php echo (int) joe_opt('toc_depth'); ?>'),
            enable_code_title: <?php echo joe_is_on('enable_code_title') ? 'true' : 'false'; ?>,
            enable_code_hr: <?php echo joe_is_on('enable_code_hr') ? 'true' : 'false'; ?>,
            enable_code_macdot: <?php echo joe_is_on('enable_code_macdot') ? 'true' : 'false'; ?>,
            enable_code_line_number: <?php echo joe_is_on('enable_code_line_number') ? 'true' : 'false'; ?>,
            enable_code_newline: <?php echo joe_is_on('enable_code_newline') ? 'true' : 'false'; ?>,
            show_tools_when_hover: <?php echo joe_is_on('show_tools_when_hover') ? 'true' : 'false'; ?>,
            enable_code_copy: <?php echo joe_is_on('enable_code_copy') ? 'true' : 'false'; ?>,
            enable_copy_right_text: <?php echo joe_is_on('enable_copy_right_text') ? 'true' : 'false'; ?>,
            copy_right_text: '<?php echo joe_opt('copy_right_text'); ?>',
            offscreen_title_leave: '<?php echo joe_opt('offscreen_title_leave'); ?>',
            offscreen_title_back: '<?php echo joe_opt('offscreen_title_back'); ?>',
            enable_journal_effect: true,
            enable_friend_effect: true,
            journal_list_effect_class: 'fadeInUp',
            friend_list_effect_class: 'fadeInUp',
            enable_like_journal: false,
            enable_comment_journal: false,
            journal_block_height: 300,
            long_code_height: parseInt('<?php echo (int) joe_opt('long_code_height'); ?>'),
            lazyload_avatar: '<?php echo joe_lazyload_avatar(); ?>',
            photos_layout: 'waterfall',
            blog_url: '<?php echo joe_site_url(); ?>',
            blog_title: '<?php echo addslashes(joe_site_title()); ?>',
            BASE_RES_URL: '<?php echo joe_res_url(); ?>',
            BASE_URL: '<?php echo joe_site_url(); ?>',
            /* 点赞接口（Typecho 移植版） */
            like_api: '<?php echo joe_site_url(); ?>/?joe_action=like&cid=__CID__'
        };
        ThemeConfig.enable_photos_effect = true;
        ThemeConfig.photos_gap = 10;
        ThemeConfig.enable_visit_number = false;
        ThemeConfig.enable_global_music_player = false;
    </script>
    <script>
        /* 深色模式初始化提前到 head：页面渲染前就定好 data-mode，避免先白后黑闪屏 */
        var initThemeMode = function () {
            try {
                var curMode = '';
                if (ThemeConfig.theme_mode === 'auto') {
                    var light_scope = ThemeConfig.light_time_scope.split('~');
                    var now = new Date();
                    var today = now.toLocaleString().split(' ')[0];
                    var curMode =
                        now >= new Date(today + ' ' + light_scope[0]) &&
                        now <= new Date(today + ' ' + light_scope[1])
                            ? 'light'
                            : 'dark';
                    localStorage.removeItem('data-mode');
                } else if (ThemeConfig.theme_mode === 'user') {
                    curMode = localStorage.getItem('data-mode') || 'light';
                    localStorage.setItem('data-mode', curMode);
                } else {
                    curMode = ThemeConfig.theme_mode;
                    localStorage.removeItem('data-mode');
                }
                document.querySelector('html').setAttribute('data-mode', curMode);
                document.documentElement.setAttribute('data-color-scheme', curMode);
            } catch (e) {
                console.log(e);
            }
        };
        initThemeMode();
    </script>
    <?php if (joe_opt('favicon')): ?>
    <link rel="shortcut icon" href="<?php echo joe_opt('favicon'); ?>">
    <?php elseif ($options->siteIcon): ?>
    <link rel="shortcut icon" href="<?php $options->siteIcon(); ?>">
    <?php endif; ?>
    <style id="joe-key-css">
        <?php if (joe_is_on('rip_mode')): ?>
        html {
            -webkit-filter: grayscale(100%);
            -moz-filter: grayscale(100%);
            -ms-filter: grayscale(100%);
            -o-filter: grayscale(100%);
            filter: grayscale(100%);
            filter: progid:DXImageTransform.Microsoft.BasicImage(grayscale=1);
        }
        <?php endif; ?>
        @font-face {
            font-family: "Joe Font";
            font-weight: 400;
            font-style: normal;
            font-display: swap;
            <?php if (joe_opt('custom_font')): ?>
            src: url("<?php echo joe_opt('custom_font'); ?>") format("woff2");
            <?php elseif (joe_opt('web_font') && joe_opt('web_font') !== 'off'): ?>
            src: url("<?php echo joe_asset('font/' . joe_opt('web_font')); ?>") format("woff2");
            <?php endif; ?>
        }
        html body {
            --waline-avatar-size: 2.25rem;
            --waline-m-avatar-size: calc(var(--waline-avatar-size) * 9 / 13);
            --waline-theme-color: <?php echo joe_opt('mode_color_light'); ?>;
            --waline-active-color: <?php echo joe_opt('mode_color_light'); ?>;
            --theme: <?php echo joe_opt('mode_color_light'); ?>;
            --wave-color: <?php echo joe_opt('light_color') ?: '#fff'; ?>;
            --scroll-bar: <?php echo joe_opt('scrollbar_color') ?: '#c0c4cc'; ?>;
            --loading-bar: <?php echo joe_opt('loading_bar_color') ?: 'var(--theme)'; ?>;
            --img-max-width: <?php echo joe_opt('img_max_width') ?: '100%'; ?>;
            font-family: "Joe Font", "Helvetica Neue", Helvetica, "PingFang SC", "Hiragino Sans GB", "Microsoft YaHei", "微软雅黑", Arial, "sans-serif";
            --halo-comment-widget-base-color: var(--main);
            --halo-comment-widget-base-info-color: var(--routine);
        }
        html[data-mode='dark'] body {
            background-color: var(--background) !important;
            --waline-theme-color: <?php echo joe_opt('mode_color_dark') ?: '#9999ff'; ?>;
            --waline-active-color: <?php echo joe_opt('mode_color_dark') ?: '#9999ff'; ?>;
            --theme: <?php echo joe_opt('mode_color_dark') ?: '#9999ff'; ?>;
            --wave-color: <?php echo joe_opt('dark_color') ?: '#fff'; ?>;
            --scroll-bar: <?php echo joe_opt('scrollbar_color') ?: '#666'; ?>;
            --loading-bar: <?php echo joe_opt('loading_bar_color') ?: 'var(--theme)'; ?>;
        }
        ::-webkit-scrollbar {
            width: <?php echo joe_opt('scrollbar_width') ?: '8px'; ?>;
        }
        ::-webkit-scrollbar-thumb {
            background: var(--scroll-bar);
        }
        /* 页脚居中显示 */
        .joe_footer .joe_container {
            flex-direction: column;
            gap: 8px;
            justify-content: center;
        }
        .joe_footer .joe_container .item {
            text-align: center;
            width: 100%;
        }
        .joe_footer .joe_container .side-col {
            align-items: center;
        }
        <?php if (joe_is_on('enable_full_header')): ?>
        /* 页眉 100% 宽度（设置开启） */
        .joe_header__above .joe_container {
            max-width: 100% !important;
        }
        <?php else: ?>
        /* 页眉与内容区左右对齐（跟随响应式断点） */
        @media (min-width: 576px) {
            .joe_header__above .joe_container {
                max-width: 540px !important;
            }
        }
        @media (min-width: 768px) {
            .joe_header__above .joe_container {
                max-width: 720px !important;
            }
        }
        @media (min-width: 992px) {
            .joe_header__above .joe_container {
                max-width: 960px !important;
            }
        }
        @media (min-width: 1200px) {
            .joe_header__above .joe_container {
                max-width: 1140px !important;
            }
        }
        <?php endif; ?>
        <?php if (joe_is_on('enable_background_light') && joe_opt('background_light_mode')): ?>
        html[data-mode="light"] body {
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
        }
        html[data-mode="light"] body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("<?php echo joe_opt('background_light_mode'); ?>");
            background-position: top center;
            background-size: cover;
            background-repeat: no-repeat;
            z-index: -1;
        }
        <?php endif; ?>
        <?php if (joe_is_on('enable_background_dark') && joe_opt('background_dark_mode')): ?>
        html[data-mode="dark"] body {
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
        }
        html[data-mode="dark"] body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("<?php echo joe_opt('background_dark_mode'); ?>");
            background-position: top center;
            background-size: cover;
            background-repeat: no-repeat;
            z-index: -1;
        }
        <?php else: ?>
        html[data-mode="dark"] body {
            background-image: none;
        }
        <?php endif; ?>
        /* Typecho 原生评论样式补丁（Joe 风格） */
        .joe_comment__list ol, .joe_comment__list ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .joe_comment__list .comment-list {
            padding-left: 0;
        }
        .joe_comment__list .comment-body {
            display: flex;
            gap: 10px;
            padding: 16px 0;
            border-bottom: 1px dashed var(--classD, #e9e9e9);
        }
        .joe_comment__list .comment-body .joe_comment__avatar img {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
        }
        .joe_comment__list .joe_comment__body {
            flex: 1;
            min-width: 0;
        }
        .joe_comment__list .joe_comment__meta {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
        }
        .joe_comment__list .joe_comment__author {
            color: var(--routine);
            font-weight: 600;
            text-decoration: none;
        }
        .joe_comment__list .joe_comment__badge {
            font-size: 12px;
            padding: 0 6px;
            border-radius: 4px;
            color: #fff;
            background: var(--theme);
        }
        .joe_comment__list .joe_comment__date {
            color: var(--seat);
            font-size: 12px;
        }
        .joe_comment__list .joe_comment__content {
            margin-top: 6px;
            font-size: 14px;
            color: var(--main);
            word-break: break-word;
        }
        .joe_comment__list .joe_comment__content p {
            margin: 4px 0;
        }
        .joe_comment__list .joe_comment__actions {
            margin-top: 6px;
            font-size: 12px;
        }
        .joe_comment__list .joe_comment__actions a {
            color: var(--seat);
            text-decoration: none;
        }
        .joe_comment__list .joe_comment__actions a:hover {
            color: var(--theme);
        }
        .joe_comment__list .joe_comment__children {
            margin-top: 12px;
            padding-left: 14px;
            border-left: 2px solid var(--classD, #e9e9e9);
        }
        .joe_comment__list .children {
            margin: 0;
            padding: 0 0 0 12px;
            list-style: none;
        }
        .joe_comment__form {
            margin-top: 20px;
        }
        .joe_comment__form .joe_form__row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }
        .joe_comment__form input[type="text"], .joe_comment__form input[type="url"], .joe_comment__form input[type="email"], .joe_comment__form textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 9px 12px;
            border: 1px solid var(--classC, #ebeef5);
            border-radius: 4px;
            outline: none;
            background: var(--background);
            color: var(--main);
            font-size: 13px;
            resize: vertical;
        }
        .joe_comment__form input:focus, .joe_comment__form textarea:focus {
            border-color: var(--theme);
        }
        .joe_comment__form button {
            border: none;
            cursor: pointer;
            padding: 8px 24px;
            border-radius: 4px;
            color: #fff;
            background: var(--theme);
            font-size: 13px;
        }
        .joe_comment__form .cancel-comment-reply {
            margin-bottom: 8px;
            font-size: 12px;
        }
        .joe_comment__close {
            padding: 30px 0;
            text-align: center;
            color: var(--seat);
        }
    </style>
    <?php if (joe_opt('custom_css')): ?>
    <style id="joe-custom-css"><?php echo joe_opt('custom_css'); ?></style>
    <?php endif; ?>
    <?php if (joe_opt('custom_js_head')): ?>
    <script type="text/javascript"><?php echo joe_opt('custom_js_head'); ?></script>
    <?php endif; ?>
</head>
<body style="background-color: <?php echo joe_opt('background_color') ?: '#f2f2f2'; ?>">
<section>
<div id="Joe">
    <?php $this->need('lib/navbar.php'); ?>
