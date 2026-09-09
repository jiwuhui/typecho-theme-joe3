<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * 导航栏（移植自 Halo 版 modules/macro/navbar.html）
 */

/* 组装菜单数据：自定义菜单 > 页面列表（页面列表模式自动补“首页”） */
$joeMenuItems = [];
$joeMenuRaw = joe_lines('navbar_menu');
if (!empty($joeMenuRaw)) {
    foreach ($joeMenuRaw as $row) {
        $joeMenuItems[] = [
            'title' => isset($row[0]) ? $row[0] : '',
            'href'  => isset($row[1]) ? $row[1] : '#',
            'icon'  => isset($row[2]) && $row[2] !== '' ? $row[2] : 'jiewen joe-icon-zuzhijiagou',
        ];
    }
} else {
    $joeMenuItems[] = [
        'title' => '首页',
        'href'  => joe_site_url() . '/',
        'icon'  => 'jiewen joe-icon-shouye',
    ];
    \Typecho\Widget::widget('Widget_Contents_Page_List@joe_nav_' . ++joe::$widgetSeq)->to($joeNavPages);
    while ($joeNavPages->next()) {
        $joeMenuItems[] = [
            'title' => $joeNavPages->title,
            'href'  => $joeNavPages->permalink,
            'icon'  => 'jiewen joe-icon-zuzhijiagou',
        ];
    }
}

/* 当前路径（用于高亮） */
$joeCurrentPath = parse_url($this->request->getRequestUrl(), PHP_URL_PATH) ?: '/';
$joeCurrentPath = rtrim($joeCurrentPath, '/');
if ($joeCurrentPath === '') {
    $joeCurrentPath = '/';
}
?>
<header class="joe_header">
    <div class="joe_header__above<?php echo (joe_is_on('enable_show_in_up') ? ' topInDown' : '') . (joe_is_on('enable_fixed_header') ? ' fixed' : '') . (joe_is_on('enable_fixed_header') && joe_is_on('enable_glass_blur') ? ' glass' : ''); ?>">
        <div class="joe_container joe_header_container<?php echo joe_is_on('enable_full_header') ? ' full' : ''; ?>">
            <i class="joe-font joe-icon-caidan joe_header__above-slideicon"></i>
            <?php if (joe_is_on('show_logo')): ?>
                <?php $joeLogoLink = joe_opt('logo_link'); if ($joeLogoLink === '#'): $joeLogoHref = 'javascript:;'; else: $joeLogoHref = $joeLogoLink ?: joe_site_url(); endif; ?>
                <a title="<?php echo joe_site_title(); ?>" class="joe_header__above-logo" href="<?php echo $joeLogoHref; ?>">
                    <img style="border-radius: <?php echo joe_opt('logo_radius') ?: '4px'; ?>"
                         src="<?php echo joe_site_logo(); ?>" alt="<?php echo joe_site_title(); ?>"
                         onerror="Joe.errorImg(this, 'ErrAvatarImg')" />
                </a>
            <?php endif; ?>
            <nav class="joe_header__above-nav<?php echo (joe_is_on('enable_active_shadow') ? ' active-shadow' : '') . (joe_is_on('enable_icon_animate') ? ' active-animate' : ''); ?>">
                <?php foreach ($joeMenuItems as $joeItem): ?>
                    <?php
                    $joeHref = $joeItem['href'];
                    $joeItemPath = parse_url($joeHref, PHP_URL_PATH) ?: '/';
                    $joeItemPath = rtrim($joeItemPath, '/');
                    if ($joeItemPath === '') {
                        $joeItemPath = '/';
                    }
                    $joeActive = ($joeItemPath === $joeCurrentPath) ? ' active' : '';
                    ?>
                    <a class="item<?php echo $joeActive; ?>" href="<?php echo $joeHref; ?>"
                       title="<?php echo $joeItem['title']; ?>">
                        <?php if (joe_is_on('enable_navbar_icon')): ?>
                            <i class="m-icon <?php echo $joeItem['icon']; ?>"></i>
                        <?php endif; ?>
                        <?php echo $joeItem['title']; ?>
                    </a>
                <?php endforeach; ?>
            </nav>

            <?php /* 顶栏工具：主题切换（用户模式）与调色板置于搜索和登录之间 */ ?>
            <div class="joe_header__above-search">
                <button type="submit" id="halo-search" class="submit" aria-label="搜索按钮" title="搜索">
                    <i class="joe-font joe-icon-search"></i>
                </button>
                <button type="button" class="joe_tools_palette" aria-label="主题色调色板" title="主题色调色板">
                    <i class="joe-font joe-icon-palette"></i>
                </button>
                <?php if (joe_opt('theme_mode') === 'user'): ?>
                    <button type="button" class="joe_tools_mode" aria-label="切换深浅色模式" title="切换深浅色模式">
                        <svg class="mode-light" height="20" viewBox="0 0 1024 1024" width="20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M234.24 512a277.76 277.76 0 1 0 555.52 0 277.76 277.76 0 1 0-555.52 0zM512 187.733a42.667 42.667 0 0 1-42.667-42.666v-102.4a42.667 42.667 0 0 1 85.334 0v102.826A42.667 42.667 0 0 1 512 187.733zm-258.987 107.52a42.667 42.667 0 0 1-29.866-12.373l-72.96-73.387a42.667 42.667 0 0 1 59.306-59.306l73.387 72.96a42.667 42.667 0 0 1 0 59.733 42.667 42.667 0 0 1-29.867 12.373zm-107.52 259.414H42.667a42.667 42.667 0 0 1 0-85.334h102.826a42.667 42.667 0 0 1 0 85.334zm34.134 331.946a42.667 42.667 0 0 1-29.44-72.106l72.96-73.387a42.667 42.667 0 0 1 59.733 59.733l-73.387 73.387a42.667 42.667 0 0 1-29.866 12.373zM512 1024a42.667 42.667 0 0 1-42.667-42.667V878.507a42.667 42.667 0 0 1 85.334 0v102.826A42.667 42.667 0 0 1 512 1024zm332.373-137.387a42.667 42.667 0 0 1-29.866-12.373l-73.387-73.387a42.667 42.667 0 0 1 0-59.733 42.667 42.667 0 0 1 59.733 0l72.96 73.387a42.667 42.667 0 0 1-29.44 72.106zm136.96-331.946H878.507a42.667 42.667 0 1 1 0-85.334h102.826a42.667 42.667 0 0 1 0 85.334zM770.987 295.253a42.667 42.667 0 0 1-29.867-12.373 42.667 42.667 0 0 1 0-59.733l73.387-72.96a42.667 42.667 0 1 1 59.306 59.306l-72.96 73.387a42.667 42.667 0 0 1-29.866 12.373z" />
                        </svg>
                        <svg class="mode-dark" height="20" viewBox="0 0 1024 1024" width="20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M587.264 104.96c33.28 57.856 52.224 124.928 52.224 196.608 0 218.112-176.128 394.752-393.728 394.752-29.696 0-58.368-3.584-86.528-9.728C223.744 832.512 369.152 934.4 538.624 934.4c229.376 0 414.72-186.368 414.72-416.256 1.024-212.992-159.744-389.12-366.08-413.184z" />
                            <path d="M340.48 567.808l-23.552-70.144-70.144-23.552 70.144-23.552 23.552-70.144 23.552 70.144 70.144 23.552-70.144 23.552-23.552 70.144zM168.96 361.472l-30.208-91.136-91.648-30.208 91.136-30.208 30.72-91.648 30.208 91.136 91.136 30.208-91.136 30.208-30.208 91.648z" />
                        </svg>
                    </button>
                <?php endif; ?>
                <?php if (joe_is_on('nav_login')): ?>
                    <div class="nav_login">
                        <?php if ($this->user->hasLogin()): ?>
                            <a class="login_after" href="<?php $this->options->adminUrl(); ?>"
                               title="<?php $this->user->screenName(); ?>（进入后台）" target="_blank">
                                <i class="joe-font joe-icon-zhanghao"></i>
                            </a>
                        <?php else: ?>
                            <a class="login_before" href="#"
                               onclick="window.location.href = '<?php $this->options->adminUrl(); ?>login.php?referer=' + encodeURIComponent(window.location.href)"
                               title="登入" target="_self"><i class="jiewen joe-icon-zhanghao"></i></a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <a href="javascript:SearchWidget.open()" title="搜索"><i
                    class="joe-font joe-icon-search joe_header__above-searchicon"></i></a>
        </div>
    </div>

    <div class="joe_header__slideout">
        <div class="joe_header__slideout-wrap">
            <img width="100%" height="150" class="joe_header__slideout-image"
                 src="<?php echo joe_opt('author_bg') ?: joe_asset('img/author_bg.jpg'); ?>" alt="侧边栏壁纸"
                 onerror="Joe.errorImg(this)" />
            <div class="joe_header__slideout-author">
                <img width="50" height="50" class="avatar ls-is-cached lazyloaded"
                     data-src="<?php echo joe_opt('avatar') ?: joe_default_avatar(); ?>"
                     src="<?php echo joe_lazyload_avatar(); ?>" alt="博主头像"
                     data-text-avatar="<?php echo joe_blogger_name(); ?>"
                     onload="Joe.loadedPlaceholderReplaceImg(this, 'AvatarImg')"
                     onerror="Joe.errorImg(this, 'ErrAvatarImg')" />
                <div class="info">
                    <a class="link" href="<?php echo joe_site_url(); ?>" target="_blank"
                       rel="noopener noreferrer nofollow">
                        <?php echo joe_blogger_name(); ?>
                        <?php if (joe_is_on('enable_blogger_level')): ?>
                            <img class="level" src="<?php echo joe_asset('svg/level_1.svg'); ?>" alt="博主等级" />
                        <?php endif; ?>
                    </a>
                    <p class="motto joe_motto"><?php echo joe_opt('motto'); ?></p>
                </div>
            </div>
            <?php
            $joeSocials = joe_lines('socials');
            $joeCustomSocials = joe_lines('custom_socials');
            ?>
            <?php if ((!empty($joeSocials) || !empty($joeCustomSocials)) && joe_is_on('enable_social') && joe_is_on('enable_mobile_social')): ?>
                <div class="social-account">
                    <?php if (joe_opt('option_social_data') === 'custom' && !empty($joeCustomSocials)): ?>
                        <?php foreach ($joeCustomSocials as $joeSocial): ?>
                            <?php if (count($joeSocial) < 2) { continue; } ?>
                            <?php echo isset($joeSocial[2]) && $joeSocial[2] !== '' ? $joeSocial[2] : joe_social_icon('github', $joeSocial[1]); ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <?php foreach ($joeSocials as $joeSocial): ?>
                            <?php if (count($joeSocial) < 2) { continue; } ?>
                            <?php echo joe_social_icon($joeSocial[0], $joeSocial[1]); ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php $joeStats = joe_stats(); ?>
            <ul class="joe_header__slideout-count">
                <li class="item">
                    <i class="joe-font joe-icon-danganguanli"></i>
                    <span>累计撰写 <strong><?php echo $joeStats['posts']; ?></strong> 篇文章</span>
                </li>
                <li class="item">
                    <i class="joe-font joe-icon-remen"></i>
                    <span>累计创建 <strong><?php echo $joeStats['tags']; ?></strong> 个标签</span>
                </li>
                <?php if (joe_opt('comment_option') === 'default' || trim((string) joe_opt('waline_serverURL')) === ''): ?>
                    <li class="item">
                        <i class="joe-font joe-icon-message"></i>
                        <span>累计收到 <strong><?php echo $joeStats['comments']; ?></strong> 条评论</span>
                    </li>
                <?php else: ?>
                    <li class="item">
                        <i class="joe-font joe-icon-message"></i>
                        <span class="m-waline-comment-count">累计收到 <strong>0</strong> 条评论</span>
                    </li>
                    <script>
                        (function () {
                            const url = '<?php echo rtrim((string) joe_opt('waline_serverURL'), '/'); ?>/api/comment?type=count';
                            fetch(url).then(async (response) => {
                                const data = await response.json();
                                const el = document.querySelector('.m-waline-comment-count strong');
                                if (el) el.innerHTML = data.data;
                            });
                        })();
                    </script>
                <?php endif; ?>
            </ul>
            <ul class="joe_header__slideout-menu panel-box">
                <li>
                    <a class="link panel in" href="#" rel="nofollow">
                        <span>栏目</span>
                        <i class="joe-font joe-icon-arrow-right"></i>
                    </a>
                    <ul class="slides panel-body panel-box panel-side-menu" style="display: block">
                        <?php foreach ($joeMenuItems as $joeItem): ?>
                            <li>
                                <a class="link" href="<?php echo $joeItem['href']; ?>"
                                   title="<?php echo $joeItem['title']; ?>"><?php echo $joeItem['title']; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <div class="joe_header__searchout">
        <a href="javascript:SearchWidget.open()" title="搜索"></a>
    </div>

    <div class="joe_header__toc">
        <div class="joe_header__toc-wrap">
            <div class="toc_top">
                <h3>目 录<span>CONTENT</span></h3>
                <img width="100%" height="150"
                     src="<?php echo joe_opt('author_bg') ?: joe_asset('img/context_bg.png'); ?>" alt="文章目录"
                     onerror="Joe.errorImg(this)" />
            </div>
            <div id="js-toc-mobile" class="toc"></div>
        </div>
    </div>

    <div class="joe_header__mask"></div>

    <?php /* 主题色调色板浮层（访客个性化，localStorage 按深浅模式分别记忆） */ ?>
    <div class="joe_palette_mask" style="display:none">
        <div class="joe_palette_panel">
            <div class="joe_palette__head">
                <i class="joe-font joe-icon-palette"></i>
                <span class="joe_palette__title">主题色调色板</span>
                <button type="button" class="joe_palette__close" aria-label="关闭">×</button>
            </div>
            <div class="joe_palette__body">
                <div class="joe_palette__preview">
                    <span class="joe_palette__dot"></span>
                    <span class="joe_palette__val"></span>
                    <button type="button" class="joe_palette__reset">恢复默认</button>
                </div>
                <input type="range" class="joe_palette__hue" min="0" max="360" step="1" aria-label="色相滑块" />
                <div class="joe_palette__presets">
                    <?php foreach (['#fb6c28', '#f55555', '#e53935', '#f06292', '#ba68c8', '#7367f0', '#5c6bc0', '#1e88e5', '#00acc1', '#00b96b', '#7cb342', '#9999ff'] as $joePresetColor): ?>
                        <button type="button" class="joe_palette__swatch" data-color="<?php echo $joePresetColor; ?>" style="background:<?php echo $joePresetColor; ?>" title="<?php echo $joePresetColor; ?>"></button>
                    <?php endforeach; ?>
                </div>
                <p class="joe_palette__note">拖动滑块或点击色块即时预览，配色仅保存在你自己的浏览器中；博主的全站配色请在后台「主题色」设置。</p>
            </div>
        </div>
    </div>
    <style>
        .joe_header__above-search .joe_tools_palette,
        .joe_header__above-search .joe_tools_mode { align-items: center; background: transparent; border: none; color: var(--theme); cursor: pointer; display: flex; height: 34px; justify-content: center; margin-left: 10px; padding: 0; position: relative; width: 30px; }
        .joe_header__above-search .joe_tools_palette i { color: var(--theme); font-size: 20px; transition: color .3s, transform .3s; }
        .joe_header__above-search .joe_tools_palette:hover i { opacity: .75; transform: scale(1.1); }
        .joe_header__above-search .submit#halo-search { align-items: center; background: transparent; border: none; border-radius: 0; color: var(--theme); cursor: pointer; display: flex; height: 34px; justify-content: center; padding: 0; width: 30px; }
        .joe_header__above-search .submit#halo-search i { color: var(--theme); font-size: 20px; transition: color .3s, transform .3s; }
        .joe_header__above-search .submit#halo-search:hover i { opacity: .75; transform: scale(1.1); }
        .joe_tools_mode svg { fill: var(--theme); left: 50%; opacity: 0; position: absolute; top: 50%; transform: scale(0) translate(-50%, -50%); transition: transform .3s, opacity .3s, fill .3s; }
        .joe_tools_mode svg.active { opacity: 1; transform: scale(1) translate(-50%, -50%); }
        .joe_header__above-search .joe_tools_mode:hover svg.active { fill: var(--theme); opacity: .75; }
        .nav_login { margin-left: 10px; }
        .nav_login a { align-items: center; background: transparent; border-radius: 0; color: var(--theme); display: flex; font-size: 20px; height: 34px; justify-content: center; transition: color .3s, opacity .3s; width: 30px; }
        .nav_login a:hover { background: transparent; color: var(--theme); opacity: .75; }
        /* 滚动条跟随主题色 */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-thumb { background: var(--theme); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { opacity: .8; }
        ::-webkit-scrollbar-track { background: transparent; }
        .nav_login a { align-items: center; color: var(--theme); display: flex; font-size: 20px; height: 34px; justify-content: center; margin-left: 10px; transition: color .3s, opacity .3s; width: 30px; }
        .nav_login a:hover { color: var(--theme); opacity: .75; }
        @media (max-width: 767px) { .joe_header__above-search .joe_tools_palette, .joe_header__above-search .joe_tools_mode { display: none; } }
        /* 悬浮条的切换/调色板按钮：仅移动端显示（桌面用顶栏按钮） */
        .joe_action .joe_action_item.mode svg { fill: var(--theme); }
        .joe_action .joe_action_item.palette i { color: var(--theme); font-size: 22px; }
        .joe_action .joe_action_item.palette { margin-bottom: 15px; }
        @media (min-width: 768px) { .joe_action .joe_action_item.mode, .joe_action .joe_action_item.palette { display: none; } }

        .joe_palette_mask { align-items: center; background: rgba(10, 11, 12, .75); bottom: 0; display: flex; justify-content: center; left: 0; position: fixed; right: 0; top: 0; z-index: 99999; }
        .joe_palette_panel { background: var(--background, #fff); border-radius: 10px; box-shadow: 0 10px 40px rgba(0, 0, 0, .3); box-sizing: border-box; color: var(--main, #303133); max-width: 440px; padding: 16px 18px; width: 88%; }
        .joe_palette__head { align-items: center; border-bottom: 1px solid var(--classC, #ebeef5); display: flex; gap: 8px; padding-bottom: 10px; }
        .joe_palette__head i { color: var(--theme, #fb6c28); font-size: 18px; }
        .joe_palette__title { flex: 1; font-weight: 700; }
        .joe_palette__close { background: none; border: none; color: var(--minor, #909399); cursor: pointer; font-size: 20px; line-height: 1; padding: 0 4px; }
        .joe_palette__body { padding-top: 12px; }
        .joe_palette__preview { align-items: center; display: flex; gap: 10px; margin-bottom: 12px; }
        .joe_palette__dot { border-radius: 50%; box-shadow: 0 0 0 2px rgba(0, 0, 0, .08); display: inline-block; height: 22px; width: 22px; }
        .joe_palette__val { flex: 1; font-family: monospace; font-size: 13px; }
        .joe_palette__reset { background: none; border: 1px solid var(--classA, #dcdfe6); border-radius: 4px; color: var(--routine, #606266); cursor: pointer; font-size: 12px; padding: 4px 10px; }
        .joe_palette__reset:hover { color: var(--theme, #fb6c28); border-color: var(--theme, #fb6c28); }
        .joe_palette__hue { -webkit-appearance: none; appearance: none; background: linear-gradient(90deg, #ff0000, #ffff00, #00ff00, #00ffff, #0000ff, #ff00ff, #ff0000); border-radius: 6px; cursor: pointer; height: 12px; width: 100%; }
        .joe_palette__hue::-webkit-slider-thumb { -webkit-appearance: none; appearance: none; background: #fff; border: 2px solid var(--theme, #fb6c28); border-radius: 50%; box-shadow: 0 1px 4px rgba(0, 0, 0, .3); height: 20px; width: 20px; }
        .joe_palette__presets { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 14px; }
        .joe_palette__swatch { border: 2px solid #fff; border-radius: 50%; box-shadow: 0 1px 4px rgba(0, 0, 0, .25); cursor: pointer; height: 26px; padding: 0; width: 26px; }
        .joe_palette__swatch:hover { transform: scale(1.15); transition: transform .15s; }
        .joe_palette__note { color: var(--minor, #909399); font-size: 12px; line-height: 1.6; margin: 14px 0 0; }
    </style>
    <script>
        (function () {
            var root = document.documentElement;
            var MODE_KEY = 'data-mode';
            var SERVER = {
                light: '<?php echo joe_opt('mode_color_light'); ?>',
                dark: '<?php echo joe_opt('mode_color_dark'); ?>'
            };

            function currentMode() {
                return root.getAttribute(MODE_KEY) || 'light';
            }
            function applyCustomTheme(mode) {
                var saved = localStorage.getItem('joe_theme_color_' + mode);
                if (saved && /^#[0-9a-fA-F]{6}$/.test(saved)) {
                    document.body.style.setProperty('--theme', saved);
                } else {
                    document.body.style.removeProperty('--theme');
                }
                return saved;
            }
            window.joeApplyCustomTheme = applyCustomTheme;
            applyCustomTheme(currentMode());

            /* 顶栏深浅切换 */
            var modeBtn = document.querySelector('.joe_tools_mode');
            function paintModeIcons(mode) {
                if (!modeBtn) return;
                modeBtn.querySelector('.mode-light').classList.toggle('active', mode !== 'dark');
                modeBtn.querySelector('.mode-dark').classList.toggle('active', mode === 'dark');
            }
            paintModeIcons(currentMode());
            if (modeBtn) {
                modeBtn.addEventListener('click', function () {
                    var next = currentMode() === 'dark' ? 'light' : 'dark';
                    root.setAttribute(MODE_KEY, next);
                    root.setAttribute('data-color-scheme', next);
                    localStorage.setItem(MODE_KEY, next);
                    applyCustomTheme(next);
                    paintModeIcons(next);
                    syncSlider();
                });
            }

            /* 调色板浮层 */
            var mask = document.querySelector('.joe_palette_mask');
            var paletteBtn = document.querySelector('.joe_tools_palette');
            var hue = mask ? mask.querySelector('.joe_palette__hue') : null;
            var dot = mask ? mask.querySelector('.joe_palette__dot') : null;
            var val = mask ? mask.querySelector('.joe_palette__val') : null;

            function hslToHex(h, s, l) {
                s /= 100; l /= 100;
                var k = function (n) { return (n + h / 30) % 12; };
                var a = s * Math.min(l, 1 - l);
                var f = function (n) { return Math.round(255 * (l - a * Math.max(-1, Math.min(k(n) - 3, Math.min(9 - k(n), 1))))); };
                var to = function (n) { return ('0' + n.toString(16)).slice(-2); };
                return '#' + to(f(0)) + to(f(8)) + to(f(4));
            }
            function hexToHue(hex) {
                var r = parseInt(hex.slice(1, 3), 16) / 255;
                var g = parseInt(hex.slice(3, 5), 16) / 255;
                var b = parseInt(hex.slice(5, 7), 16) / 255;
                var max = Math.max(r, g, b), min = Math.min(r, g, b), d = max - min, h = 0;
                if (d) {
                    if (max === r) h = ((g - b) / d) % 6;
                    else if (max === g) h = (b - r) / d + 2;
                    else h = (r - g) / d + 4;
                }
                return Math.round(((h * 60) + 360) % 360);
            }
            function paint(color) {
                if (!/^#[0-9a-fA-F]{6}$/.test(color)) return;
                document.body.style.setProperty('--theme', color);
                if (dot) dot.style.background = color;
                if (val) val.textContent = color;
                localStorage.setItem('joe_theme_color_' + currentMode(), color);
            }
            function syncSlider() {
                var mode = currentMode();
                var saved = localStorage.getItem('joe_theme_color_' + mode);
                var base = saved || SERVER[mode] || '#fb6c28';
                if (hue) hue.value = hexToHue(base);
                if (dot) dot.style.background = base;
                if (val) val.textContent = base;
            }
            function openPalette() {
                if (!mask) return;
                mask.style.display = 'flex';
                syncSlider();
            }
            function closePalette() {
                if (mask) mask.style.display = 'none';
            }
            if (paletteBtn) paletteBtn.addEventListener('click', openPalette);
            /* 悬浮条的调色板按钮（移动端）——位于页面底部，需等 DOM 就绪再绑定 */
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.joe_action .joe_action_item.palette').forEach(function (btn) {
                    btn.addEventListener('click', openPalette);
                });
            });
            if (mask) {
                mask.querySelector('.joe_palette__close').addEventListener('click', closePalette);
                mask.addEventListener('click', function (e) {
                    if (e.target === mask) closePalette();
                });
                if (hue) hue.addEventListener('input', function () {
                    paint(hslToHex(+hue.value, 78, 56));
                });
                mask.querySelectorAll('.joe_palette__swatch').forEach(function (sw) {
                    sw.addEventListener('click', function () {
                        paint(sw.getAttribute('data-color'));
                        if (hue) hue.value = hexToHue(sw.getAttribute('data-color'));
                    });
                });
                var resetBtn = mask.querySelector('.joe_palette__reset');
                if (resetBtn) resetBtn.addEventListener('click', function () {
                    var mode = currentMode();
                    localStorage.removeItem('joe_theme_color_' + mode);
                    document.body.style.removeProperty('--theme');
                    var base = SERVER[mode] || '#fb6c28';
                    if (dot) dot.style.background = base;
                    if (val) val.textContent = base + '（默认）';
                    if (hue) hue.value = hexToHue(base);
                });
                document.addEventListener('keyup', function (e) {
                    if (e.key === 'Escape') closePalette();
                });
            }
            /* 任意入口切换深浅模式（顶栏/悬浮条/其他脚本）后，应用对应模式的访客配色 */
            new MutationObserver(function () {
                applyCustomTheme(currentMode());
                syncSlider();
            }).observe(root, { attributes: true, attributeFilter: ['data-mode'] });
        })();
    </script>
</header>
