<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

global $JOE_HTML_TYPE;
$joeType = isset($JOE_HTML_TYPE) ? $JOE_HTML_TYPE : 'index';
$joeOptions = $this->options;
$joeFeedUrl = $joeOptions->feedUrl;
$joeSearchBase = Typecho\Common::url('search/', $joeOptions->index);
?>
<?php if (joe_is_on('enable_footer')): ?>
    <footer class="joe_footer<?php echo (joe_opt('footer_position') === 'fixed' ? ' fixed' : '') . (joe_is_on('enable_full_footer') ? ' full' : ''); ?>">
        <div class="joe_container<?php echo (!joe_is_on('enable_rss') && !joe_is_on('enable_sitemap')) ? ' central' : ''; ?>">
            <div class="item">
                <p>
                    © <?php echo mb_substr((string) joe_opt('custom_birthday'), 0, 4); ?> -
                    <?php echo date('Y'); ?><a href="<?php echo joe_site_url(); ?>" target="_blank"
                                               rel="noopener noreferrer">
                        <?php echo joe_site_title(); ?>
                    </a>
                    <?php if (joe_is_on('enable_icp') && trim((string) joe_opt('icp')) !== ''): ?>
                        -
                        <a class="icp" href="<?php echo joe_opt('icp_link') ?: 'https://beian.miit.gov.cn'; ?>"
                           target="_blank" rel="noopener noreferrer nofollow">
                            <?php echo joe_opt('icp'); ?>
                        </a>
                    <?php endif; ?>
                </p>
                <?php if (joe_is_on('enable_powerby')): ?>
                    <p class="site_powered">
                        Powered by<a class="a-powered" href="https://typecho.org/" target="_blank"
                                     rel="noopener noreferrer">
                            Typecho</a>&nbsp;|&nbsp;🌈 Theme by<a class="a-theme"
                                                                 title="Theme Joe3 v<?php echo JOE_THEME_VERSION; ?>"
                                                                 href="https://github.com/jiewenhuang/halo-theme-joe3.0"
                                                                 target="_blank" rel="noopener noreferrer">
                            M酷&Jiewen
                        </a>
                    </p>
                <?php endif; ?>
                <?php $joeDriven = joe_opt('driven_by'); ?>
                <?php if ($joeDriven && $joeDriven !== 'none'): ?>
                    <?php if ($joeDriven === 'custom' && joe_opt('driven_by_custom_img')): ?>
                        <p class="site_driven">
                            本站点由
                            <a href="<?php echo joe_opt('driven_by_custom_url') ?: 'javascript:;'; ?>"
                               target="_blank" rel="noopener noreferrer nofollow">
                                <img class="custom" src="<?php echo joe_opt('driven_by_custom_img'); ?>" alt="云服务商"
                                     onerror="Joe.errorImg(this, 'LoadFailedImg')" />
                            </a>
                            提供云服务
                        </p>
                    <?php elseif ($joeDriven !== 'custom'): ?>
                        <p class="site_driven">
                            本站点由
                            <?php
                            $joeDrivenLinks = [
                                'aliyun'  => 'https://www.aliyun.com',
                                'tencent' => 'https://cloud.tencent.com',
                                'baidu'   => 'https://cloud.baidu.com',
                                'upyun'   => 'https://www.upyun.com',
                                'qiniu'   => 'https://www.qiniu.com',
                                'huawei'  => 'https://www.huaweicloud.com',
                                'jinshan' => 'https://www.ksyun.com',
                            ];
                            ?>
                            <a href="<?php echo $joeDrivenLinks[$joeDriven] ?? 'javascript:;'; ?>" target="_blank"
                               rel="noopener noreferrer nofollow">
                                <img class="<?php echo $joeDriven; ?>"
                                     src="<?php echo joe_asset('img/cloud/' . $joeDriven . '.svg'); ?>" alt="云服务商"
                                     onerror="Joe.errorImg(this, 'LoadFailedImg')" />
                            </a>
                            提供云服务
                        </p>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (joe_is_on('enable_birthday')): ?>
                    <div class="site_life">
                        <i class="joe-font joe-icon-jiasu"></i>已运行&nbsp;<strong class="joe_run__day">00</strong>
                        天 <strong class="joe_run__hour">00</strong> 时
                        <strong class="joe_run__minute">00</strong> 分
                        <strong class="joe_run__second">00</strong> 秒
                    </div>
                <?php endif; ?>
                <?php if (joe_is_on('enable_police') && trim((string) joe_opt('police')) !== ''): ?>
                    <p class="site_police">
                        <a href="<?php echo joe_opt('gongan_link') ?: 'https://beian.mps.gov.cn/#/query/webSearch'; ?>"
                           target="_blank" rel="noopener noreferrer nofollow">
                            <?php echo joe_opt('police'); ?>
                        </a>
                    </p>
                <?php endif; ?>
            </div>
            <div class="side-col">
                <?php if (joe_is_on('enable_rss') || joe_is_on('enable_sitemap')): ?>
                    <div class="item">
                        <?php if (joe_is_on('enable_rss')): ?>
                            <a class="rss" href="<?php echo $joeFeedUrl; ?>" target="_blank"
                               rel="noopener noreferrer"><i class="joe-font joe-icon-rss-fill"></i>&nbsp;RSS</a>
                        <?php endif; ?>
                        <?php if (joe_is_on('enable_sitemap')): ?>
                            <a href="<?php echo Typecho\Common::url('sitemap.xml', $joeOptions->siteUrl); ?>"
                               target="_blank" rel="noopener noreferrer">
                                站点地图
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if (joe_is_on('enable_busuanzi')): ?>
                    <div class="item busuanzi-statistic">
                        <span class="site-pv">
                            <i class="joe-font joe-icon-zhexiantu"></i>访问量<em id="busuanzi_value_site_pv">
                                0
                            </em>
                        </span>
                        <span class="site-uv">
                            <i class="joe-font joe-icon-monitor"></i>访客量<em id="busuanzi_value_site_uv">
                                0
                            </em>
                        </span>
                        <span class="site-page-pv">
                            <i class="joe-font joe-icon-dianji"></i>本页访客<em id="busuanzi_value_page_pv">
                                0
                            </em>
                        </span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </footer>
<?php endif; ?>
</div>

<?php /* ===== tail 脚本（移植自 modules/macro/tail.html） ===== */ ?>
<script src="<?php echo joe_res_url(); ?>/assets/lib/jquery@3.5.1/jquery.min.js"></script>
<script src="<?php echo joe_res_url(); ?>/assets/lib/wowjs/wow.min.js"></script>
<script src="<?php echo joe_res_url(); ?>/assets/lib/lazysizes/lazysizes.min.js"></script>
<script src="<?php echo joe_res_url(); ?>/assets/lib/qmsg/qmsg.js"></script>
<script src="<?php echo joe_res_url(); ?>/assets/lib/clipboard/clipboard.min.js"></script>
<?php
$joeAsideKeys = array_map(function ($r) {
    return isset($r[0]) ? $r[0] : '';
}, joe_lines('aside_widgets'));
if ((!joe_is_on('enable_clean_mode') && in_array('show_newreply', $joeAsideKeys, true)) || $joeType === 'sheet'):
?>
    <script src="<?php echo joe_res_url(); ?>/assets/lib/j-marked/marked.min.js"></script>
<?php endif; ?>
<script src="<?php echo joe_res_url(); ?>/assets/js/min/utils.min.js"></script>

<?php if ($joeType === 'index' && joe_is_on('enable_banner')): ?>
    <link rel="stylesheet" href="<?php echo joe_res_url(); ?>/assets/lib/swiper/swiper-bundle.min.css" />
    <script src="<?php echo joe_res_url(); ?>/assets/lib/swiper/swiper-bundle.min.js"></script>
<?php endif; ?>
<link rel="stylesheet" href="<?php echo joe_res_url(); ?>/assets/lib/fancybox/jquery.fancybox.min.css" />
<?php if ($joeType === 'photos'): ?>
    <link rel="stylesheet" href="<?php echo joe_res_url(); ?>/assets/lib/justifiedGallery/justifiedGallery.min.css" />
<?php endif; ?>
<?php if ($joeType === 'post' && joe_is_on('enable_toc')): ?>
    <script src="<?php echo joe_res_url(); ?>/assets/lib/tocbot/tocbot.min.js"></script>
<?php endif; ?>
<?php if (joe_is_on('enable_clean_mode') && ($joeType === 'post' || $joeType === 'sheet')): ?>
    <script src="<?php echo joe_res_url(); ?>/assets/lib/vue@2.6.10/vue.min.js"></script>
<?php endif; ?>
<script src="<?php echo joe_res_url(); ?>/assets/lib/fancybox/jquery.fancybox.min.js"></script>
<?php if (joe_opt('music_id') || $joeType === 'post'): ?>
    <link rel="stylesheet" href="<?php echo joe_res_url(); ?>/assets/lib/APlayer/APlayer.min.css" />
    <script src="<?php echo joe_res_url(); ?>/assets/lib/APlayer/APlayer.min.js"></script>
    <script src="<?php echo joe_res_url(); ?>/assets/lib/meting/meting.min.js"></script>
<?php endif; ?>
<script src="<?php echo joe_res_url(); ?>/assets/js/min/custom.min.js?v=<?php echo JOE_THEME_VERSION; ?>"></script>
<?php if (joe_opt('favicon')): ?>
    <script src="<?php echo joe_res_url(); ?>/assets/lib/favico/favico.min.js"></script>
<?php endif; ?>
<?php if ($joeType === 'post'): ?>
    <script src="<?php echo joe_res_url(); ?>/assets/lib/jquery-qrcode/jquery.qrcode.min.js"></script>
<?php endif; ?>
<?php if ($joeType === 'photos'): ?>
    <script src="<?php echo joe_res_url(); ?>/assets/lib/justifiedGallery/justifiedGallery.min.js"></script>
    <script src="<?php echo joe_res_url(); ?>/assets/lib/masonry/masonry.pkgd.min.js"></script>
    <script src="<?php echo joe_res_url(); ?>/assets/lib/masonry/isotope.pkgd.min.js"></script>
    <script src="<?php echo joe_res_url(); ?>/assets/lib/masonry/imagesloaded.pkgd.min.js"></script>
<?php endif; ?>

<script src="<?php echo joe_res_url(); ?>/assets/js/min/common.min.js?v=<?php echo JOE_THEME_VERSION; ?>"></script>
<?php if ($joeType === 'post' || $joeType === 'sheet'): ?>
    <script src="<?php echo joe_res_url(); ?>/assets/lib/prism/prism.min.js"></script>
<?php endif; ?>
<?php if ($joeType === 'index'): ?>
    <script src="<?php echo joe_res_url(); ?>/assets/js/min/index.min.js?v=<?php echo JOE_THEME_VERSION; ?>"></script>
<?php endif; ?>
<?php if ($joeType === 'archives'): ?>
    <script src="<?php echo joe_res_url(); ?>/assets/js/min/archives.min.js?v=<?php echo JOE_THEME_VERSION; ?>"></script>
<?php endif; ?>
<?php if ($joeType === 'post'): ?>
    <script src="<?php echo joe_res_url(); ?>/assets/js/min/post.min.js?v=<?php echo JOE_THEME_VERSION; ?>"></script>
<?php endif; ?>
<?php if ($joeType === 'photos'): ?>
    <script src="<?php echo joe_res_url(); ?>/assets/js/min/photos.min.js?v=<?php echo JOE_THEME_VERSION; ?>"></script>
<?php endif; ?>
<?php if ($joeType === 'sheet'): ?>
    <script src="<?php echo joe_res_url(); ?>/assets/lib/draggabilly/draggabilly.min.js"></script>
    <script src="<?php echo joe_res_url(); ?>/assets/js/min/leaving.min.js"></script>
<?php endif; ?>
<?php if (joe_is_on('enable_big_banner')): ?>
    <script src="<?php echo joe_res_url(); ?>/assets/js/min/beauty.min.js"></script>
<?php endif; ?>

<?php if (joe_is_on('enable_busuanzi')): ?>
    <script src="<?php echo joe_res_url(); ?>/assets/lib/busuanzi/busuanzi.min.js"></script>
<?php endif; ?>

<?php if (joe_is_on('enable_debug')): ?>
    <script src="<?php echo joe_res_url(); ?>/assets/lib/vconsole/vconsole.min.js"></script>
<?php endif; ?>

<!-- 站内搜索（Typecho 移植版 SearchWidget） -->
<script>
    (function () {
        let joeSearchMask = null;
        window.SearchWidget = {
            open: function () {
                if (joeSearchMask) {
                    joeSearchMask.style.display = 'flex';
                    const input = joeSearchMask.querySelector('input');
                    if (input) input.focus();
                    return;
                }
                joeSearchMask = document.createElement('div');
                joeSearchMask.setAttribute('style', [
                    'position:fixed', 'top:0', 'left:0', 'right:0', 'bottom:0', 'z-index:99999',
                    'display:flex', 'align-items:center', 'justify-content:center',
                    'background:rgba(10,11,12,.75)'
                ].join(';'));
                joeSearchMask.innerHTML = '<div style="width:86%;max-width:560px;background:#fff;border-radius:8px;padding:18px;box-sizing:border-box">'
                    + '<form class="joe-search-form" action="<?php echo $joeSearchBase; ?>" style="display:flex;gap:8px">'
                    + '<input name="keywords" maxlength="32" autocomplete="off" placeholder="请输入关键字..."'
                    + ' style="flex:1;height:38px;padding:0 12px;border:1px solid #e0e0e0;border-radius:4px;outline:none;font-size:14px">'
                    + '<button type="submit" style="height:38px;padding:0 18px;border:none;border-radius:4px;'
                    + 'background:var(--theme,#fb6c28);color:#fff;cursor:pointer;font-size:14px">搜索</button>'
                    + '</form></div>';
                joeSearchMask.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const form = e.target;
                    const input = form.querySelector('input[name="keywords"]');
                    const kw = input ? input.value.trim() : '';
                    if (!kw) {
                        if (input) input.focus();
                        return;
                    }
                    window.location.href = form.getAttribute('action') + encodeURIComponent(kw) + '/';
                });
                joeSearchMask.addEventListener('click', function (e) {
                    if (e.target === joeSearchMask) joeSearchMask.style.display = 'none';
                });
                document.addEventListener('keyup', function (e) {
                    if (e.key === 'Escape' && joeSearchMask) joeSearchMask.style.display = 'none';
                });
                document.body.appendChild(joeSearchMask);
                const input = joeSearchMask.querySelector('input');
                if (input) input.focus();
            }
        };
        const searchButton = document.getElementById('halo-search');
        if (searchButton) {
            searchButton.addEventListener('click', function () {
                SearchWidget.open();
            });
        }
    })();
</script>

<!-- 兼容性检查 -->
<script id="compatiable-checker">
    (function () {
        function detectIE() {
            var n = window.navigator.userAgent,
                e = n.indexOf('MSIE ');
            if (e > 0) {
                return parseInt(n.substring(e + 5, n.indexOf('.', e)), 10);
            }
            if (n.indexOf('Trident/') > 0) {
                var r = n.indexOf('rv:');
                return parseInt(n.substring(r + 3, n.indexOf('.', r)), 10);
            }
            var i = n.indexOf('Edge/');
            return i > 0 && parseInt(n.substring(i + 5, n.indexOf('.', i)), 10);
        }
        detectIE() &&
            (alert('当前站点不支持IE浏览器或您开启了兼容模式，请使用其他浏览器访问或关闭兼容模式。'),
            (location.href = 'https://www.baidu.com'));
    })();
</script>

<script id="theme-config-getter" type="text/javascript">
    if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
        ThemeConfig['mode'] = 'development';
    }
    if (ThemeConfig.mode === 'development') {
        console.log('Joe3主题配置：', ThemeConfig);
        console.log('资源根路径：', ThemeConfig.BASE_RES_URL);
    }
    /* initThemeMode 已提前到 header.php head 内执行，避免浅色闪屏 */
    window.Joe = {
        BASE_API: '',
        isMobile: /windows phone|iphone|android/gi.test(window.navigator.userAgent),
        bloggerGenerateAvatarOpts: (function () {
            let generateAvatarOpts = {};
            let generate_avatar_opts_str = '<?php echo addslashes(joe_opt('generate_avatar_opts')); ?>';
            if (generate_avatar_opts_str) {
                try {
                    const eleTmp = document.createElement('div');
                    eleTmp.innerHTML = generate_avatar_opts_str;
                    generate_avatar_opts_str = eleTmp.innerHTML
                        .replace(/'/g, '"')
                        .replace(/([\w]+):/g, '"$1":');
                    generateAvatarOpts = JSON.parse(generate_avatar_opts_str);
                } catch (e) {
                    console.error(
                        'Joe3主题配置：生成文字性头像的配置解析失败，使用默认配置。',
                        e
                    );
                }
            }
            return generateAvatarOpts;
        })(),
        errorImg: function (target, src) {
            const targetSrc = target.getAttribute('src');
            let generatedTextAvatar;
            let generatedTextAvatarBase64;
            switch (src) {
                case 'HomeErrImg': {
                    src = '<?php echo joe_fallback_thumbnail(); ?>';
                    break;
                }
                case 'LinksErrImg': {
                    src = target.dataset.errSrc || '<?php echo joe_default_links_logo(); ?>';
                    if (
                        !src ||
                        src === targetSrc ||
                        (targetSrc && targetSrc.indexOf('/assets/img/transparent-placeholder.png') !== -1)
                    ) {
                        if (target.dataset.textAvatar || target.getAttribute('alt')) {
                            generatedTextAvatar = target.dataset.textAvatar || target.getAttribute('alt');
                            generatedTextAvatarBase64 = Joe.generateTextAvatarImage(generatedTextAvatar);
                            src = generatedTextAvatarBase64;
                        } else {
                            src = '<?php echo joe_asset('img/default_links_logo.png'); ?>';
                        }
                    }
                    break;
                }
                case 'ErrAvatarImg': {
                    src = target.dataset.errSrc || '<?php echo joe_default_avatar(); ?>';
                    if (
                        !src ||
                        src === targetSrc ||
                        (targetSrc && targetSrc.indexOf('/assets/img/transparent-placeholder.png') !== -1)
                    ) {
                        if (target.dataset.textAvatar || target.getAttribute('alt')) {
                            generatedTextAvatar = target.dataset.textAvatar || target.getAttribute('alt');
                            generatedTextAvatarBase64 = Joe.generateTextAvatarImage(generatedTextAvatar);
                            src = generatedTextAvatarBase64;
                        } else {
                            src = '<?php echo joe_asset('img/peeps-avatar.png'); ?>';
                        }
                    }
                    break;
                }
                case 'LoadFailedImg': {
                    src = target.dataset.errSrc || '<?php echo joe_asset('img/img_load_failed.jpg'); ?>';
                    break;
                }
            }
            const nowSrc = src || target.dataset.errSrc || '<?php echo joe_asset('img/Joe3.png'); ?>';
            if (targetSrc === nowSrc) return;
            if (
                generatedTextAvatarBase64 &&
                generatedTextAvatar &&
                nowSrc === generatedTextAvatarBase64
            ) {
                target.setAttribute('data-generated-text-avatar', generatedTextAvatar);
            } else if (target.getAttribute('data-generated-text-avatar')) {
                target.removeAttribute('data-generated-text-avatar');
            }
            target.setAttribute('onerror', null);
            target.setAttribute('src', nowSrc);
        },
        loadedPlaceholderReplaceImg: function (target, src) {
            const targetSrc = target.getAttribute('src');
            if (
                !targetSrc ||
                src === targetSrc ||
                targetSrc.indexOf('/assets/img/transparent-placeholder.png') === -1
            ) {
                return;
            }
            let generatedTextAvatar;
            let generatedTextAvatarBase64;
            switch (src) {
                case 'LinksImg': {
                    src = target.dataset.replaceSrc || '<?php echo joe_default_links_logo(); ?>';
                    if (!src || src === targetSrc) {
                        if (target.dataset.textAvatar || target.getAttribute('alt')) {
                            generatedTextAvatar = target.dataset.textAvatar || target.getAttribute('alt');
                            generatedTextAvatarBase64 = Joe.generateTextAvatarImage(generatedTextAvatar);
                            src = generatedTextAvatarBase64;
                        } else {
                            src = '<?php echo joe_asset('img/default_links_logo.png'); ?>';
                        }
                    }
                    break;
                }
                case 'AvatarImg': {
                    src = target.dataset.replaceSrc || '<?php echo joe_default_avatar(); ?>';
                    if (!src || src === targetSrc) {
                        if (target.dataset.textAvatar || target.getAttribute('alt')) {
                            generatedTextAvatar = target.dataset.textAvatar || target.getAttribute('alt');
                            target.setAttribute('data-generated-text-avatar', generatedTextAvatar);
                            generatedTextAvatarBase64 = Joe.generateTextAvatarImage(generatedTextAvatar);
                            src = generatedTextAvatarBase64;
                        } else {
                            src = '<?php echo joe_asset('img/peeps-avatar.png'); ?>';
                        }
                    }
                    break;
                }
            }
            const nowSrc =
                src || target.dataset.replaceSrc || '<?php echo joe_asset('img/Joe3.png'); ?>';
            if (targetSrc === nowSrc) return;
            if (
                generatedTextAvatarBase64 &&
                generatedTextAvatar &&
                nowSrc === generatedTextAvatarBase64
            ) {
                target.setAttribute('data-generated-text-avatar', generatedTextAvatar);
            } else if (target.getAttribute('data-generated-text-avatar')) {
                target.removeAttribute('data-generated-text-avatar');
            }
            target.setAttribute('onload', null);
            target.setAttribute('src', nowSrc);
        },
        replaceAllTextAvatarImage: function () {
            const generatedEles = document.querySelectorAll('img[data-generated-text-avatar]');
            generatedEles.forEach(function (ele) {
                const generatedTextAvatar = ele.getAttribute('data-generated-text-avatar');
                const generatedTextAvatarBase64 = Joe.generateTextAvatarImage(generatedTextAvatar);
                ele.setAttribute('src', generatedTextAvatarBase64);
            });
        },
        getRandomColor: function (alpha) {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            if (alpha !== undefined) {
                return color + (alpha >= 0 && alpha <= 1 ? Math.round(alpha * 255).toString(16) : 'FF');
            }
            return color;
        },
        generateTextAvatarImage: function (text, opts) {
            opts = Object.assign({}, Joe.bloggerGenerateAvatarOpts, opts || {});
            opts.fontSize = opts.fontSize || 50;
            opts.font = opts.font || 'Great Vibes';
            opts.canvasRadius = opts.canvasWidth || 1.5 * opts.fontSize;
            if (opts.textColor && /var\(--([\w-]+)\)/.test(opts.textColor)) {
                const match = opts.textColor.match(/var\(--([\w-]+)\)/);
                if (match) {
                    let cssVar =
                        getComputedStyle(document.documentElement)
                            .getPropertyValue('--' + match[1])
                            .trim() ||
                        getComputedStyle(document.body)
                            .getPropertyValue('--' + match[1])
                            .trim();
                    if (cssVar) {
                        opts.textColor = cssVar;
                    }
                }
            }
            if (opts.bgColor && /var\(--([\w-]+)\)/.test(opts.bgColor)) {
                const match = opts.bgColor.match(/var\(--([\w-]+)\)/);
                if (match) {
                    let cssVar =
                        getComputedStyle(document.documentElement)
                            .getPropertyValue('--' + match[1])
                            .trim() ||
                        getComputedStyle(document.body)
                            .getPropertyValue('--' + match[1])
                            .trim();
                    if (cssVar) {
                        opts.bgColor = cssVar;
                    }
                }
            }
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            canvas.width = opts.canvasRadius;
            canvas.height = opts.canvasRadius;
            if (opts.bgColor) {
                ctx.fillStyle = opts.bgColor;
            } else {
                const gradient = ctx.createRadialGradient(
                    canvas.width / 2,
                    canvas.height / 2,
                    0,
                    canvas.width / 2,
                    canvas.height / 2,
                    canvas.width / 2
                );
                gradient.addColorStop(0, Joe.getRandomColor(0.7));
                gradient.addColorStop(1, Joe.getRandomColor(0.7));
                ctx.fillStyle = gradient;
            }
            ctx.beginPath();
            ctx.arc(canvas.width / 2, canvas.height / 2, canvas.width / 2, 0, Math.PI * 2);
            ctx.fill();
            ctx.font = `${opts.fontSize}px ${opts.font}`;
            if (opts.textColor) {
                ctx.fillStyle = opts.textColor;
            } else if (opts.useTextGradient) {
                const textGradient = ctx.createLinearGradient(0, 0, canvas.width, canvas.height);
                textGradient.addColorStop(0, Joe.getRandomColor(0.9));
                textGradient.addColorStop(1, Joe.getRandomColor(0.9));
                ctx.fillStyle = textGradient;
            } else if (opts.bgColor) {
                ctx.fillStyle = /(#000000|#000|black)/.test(opts.bgColor) ? '#fff' : '#000';
            }
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(text.charAt(0), canvas.width / 2, canvas.height / 2);
            return canvas.toDataURL();
        }
    };
    ThemeConfig.enable_console_theme &&
        console.log(
            '%cTheme By  Jiewen' + ' | 版本 V' + ThemeConfig.version,
            'padding: 8px 15px;color:#fff;background: linear-gradient(270deg, #986fee, #8695e6, #68b7dd, #18d7d3);border-radius: 0 15px 0 15px;'
        );
</script>

<?php if (joe_is_on('enable_big_banner')): ?>
    <script>
        new EvanBigBanner({
            followMode: false,
            followTheme: false,
            titlePrint: true,
            titlePrintInterval: 300,
            titleTiktok: false,
            titleText: '<?php echo addslashes((string) (joe_opt('big_banner_title') ?: joe_site_title())); ?>',
            titleColor: '#ffffff',
            titleShadow: '-3px 2px 6px #1c1f21',
            hitokotoParams: {},
            hitokotoApi: 'https://v1.hitokoto.cn',
            hitokotoColor: '#ffffff',
            hitokotoEnable: <?php echo joe_is_on('enable_big_banner_hitokoto') ? 'true' : 'false'; ?>
        });
    </script>
<?php endif; ?>

<?php if (joe_is_on('enable_auto_ajax') && joe_is_on('enable_index_list_ajax') && $joeType === 'index'): ?>
    <script type="text/javascript">
        const ob = new IntersectionObserver(
            (entries) => {
                const domClick = document.querySelector('.joe_load');
                if (domClick && entries[0].isIntersecting) {
                    domClick.click();
                }
            },
            { threshold: 1 }
        );
        const loading = document.querySelector('.joe_load_container');
        if (loading) ob.observe(loading);
    </script>
<?php endif; ?>

<?php if (joe_opt('custom_js_body')): ?>
    <script type="text/javascript"><?php echo joe_opt('custom_js_body'); ?></script>
<?php endif; ?>
</section>
</body>
</html>
