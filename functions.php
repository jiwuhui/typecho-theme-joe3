<?php
/**
 * Joe 3 for Typecho（移植自 Halo 主题 halo-theme-joe3.0）
 *
 * @package Joe 3
 * @author  Jiewenhuang & M酷，Typecho 移植版
 * @version 1.0.0
 * @link    https://github.com/jiewenhuang/halo-theme-joe3.0
 */

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

use Typecho\Widget\Helper\Form;
use Typecho\Widget\Helper\Form\Element\Radio;
use Typecho\Widget\Helper\Form\Element\Select;
use Typecho\Widget\Helper\Form\Element\Number;
use Typecho\Widget\Helper\Form\Element\Text;
use Typecho\Widget\Helper\Form\Element\Textarea;

define('JOE_THEME_VERSION', '1.1.0');

/* 社交图标库 */
require_once __DIR__ . '/lib/social-icons.php';

/**
 * 主题内部状态持有
 */
final class joe
{
    /** @var int */
    public static $widgetSeq = 0;
}

/**
 * 主题默认配置（与 Halo 版 settings.yaml 默认值保持一致）
 */
function joe_default_config(): array
{
    return [
        /* 基本设置 */
        'theme_mode'                 => 'user',
        'comment_option'             => 'default',
        'waline_serverURL'           => '',
        'waline_css'                 => 'https://unpkg.com/@waline/client@v2/dist/waline.css',
        'waline_js_comment'          => 'https://unpkg.com/@waline/client@v2/dist/waline.mjs',
        'waline_js_leaving'          => 'https://cdn.jsdelivr.net/npm/@waline/client/dist/waline.mjs',
        'waline_js_list'             => 'https://unpkg.com/@waline/client@v2/dist/comment.mjs',
        'waline_config_basic_json'   => '',
        'waline_config_imageUpload_option' => 'default',
        'lskypro_apiURL'             => '',
        'lskypro_apiTOKEN'           => '',
        'source_link'                => '',
        'mode_color_light'           => '#fb6c28',
        'mode_color_dark'            => '#9999ff',
        'enable_background_light'    => '0',
        'background_light_mode'      => '',
        'enable_background_dark'     => '0',
        'background_dark_mode'       => '',
        'background_color'           => '#f2f2f2',
        'content_max_width'          => '1320',
        'enable_random_img_api'      => '0',
        'random_img_api_url'         => 'https://imgapi.xl0408.top/index.php',
        'light_time_scope'           => '5:00~19:00',
        'icp'                        => '',
        'icp_link'                   => 'https://beian.miit.gov.cn/',
        'police'                     => '',
        'gongan_link'                => 'https://beian.mps.gov.cn/#/query/webSearch',

        /* 首页 */
        'enable_index_list_ajax'     => '0',
        'enable_auto_ajax'           => '0',
        'enable_post_thumbnail'      => '0',
        'lazyload_thumbnail'         => '',
        'post_thumbnail'             => 'https://picsum.photos/id/1081/350/200',
        'fallback_thumbnail'         => '',
        'enable_index_list_effect'   => '0',
        'index_list_effect_class'    => 'fadeInUp',
        'enable_hot_category'        => '0',
        'data_hot_category'          => '',

        /* 主题相关 */
        'cursor_skin'                => 'off',
        'cursor_effect'              => 'off',
        'backdrop'                   => 'off',
        'enable_loading_bar'         => '0',
        'loading_bar_height'         => '3px',
        'loading_bar_color'          => '#fb6c28',
        'scrollbar_color'            => '#fb6c28',
        'scrollbar_width'            => '8px',
        'enable_offscreen_tip'       => '0',
        'offscreen_title_leave'      => '歪，你去哪里了？',
        'offscreen_title_back'       => '(つェ⊂)咦，又回来了!',
        'link_behavior'              => 'default',
        'enable_show_in_up'          => '0',
        'enable_back2top'            => '1',
        'enable_back2top_smooth'     => '1',
        'web_font'                   => 'off',

        /* 轮播图 */
        'enable_banner'              => '0',
        'banner_data_group'          => '',
        'banner_direction'           => 'horizontal',
        'enable_banner_loop'         => '1',
        'banner_effect'              => 'slide',
        'enable_banner_handle'       => '1',
        'enable_banner_switch_button' => '1',
        'enable_banner_pagination'   => '1',
        'enable_banner_autoplay'     => '1',
        'banner_delay'               => '3500',
        'banner_speed'               => '500',
        'banner_lazyload_img'        => '',

        /* 美化 */
        'enable_big_banner'          => '0',
        'big_banner_title'           => '',
        'big_banner_Photos'          => 'http://imgapi.xl0408.top/index.php',
        'enable_big_banner_hitokoto' => '0',
        'enable_big_banner_video'    => '0',
        'big_banner_video'           => '',
        'light_color'                => '#fff',
        'dark_color'                 => '#fff',

        /* 导航 */
        'navbar_menu'                => '',
        /* 图库 */
        'photos_aggregate'           => '1',
        'photos_aggregate_group'     => '文章',
        'enable_fixed_header'        => '0',
        'nav_login'                  => '0',
        'enable_full_header'         => '0',
        'show_logo'                  => '0',
        'logo_link'                  => '',
        'logo_radius'                => '4px',
        'enable_navbar_icon'         => '0',
        'enable_icon_animate'        => '0',
        'enable_active_shadow'       => '0',
        'enable_glass_blur'          => '0',

        /* 博主信息 */
        'show_blogger'               => '1',
        'enable_day_words'           => '0',
        'nickname'                   => '',
        'enable_blogger_level'       => '0',
        'motto'                      => '行动起来，活在当下',
        'lazyload_avatar'            => '',
        'avatar'                     => '',
        'default_avatar'             => '',
        'generate_avatar_opts'       => "{bgColor:'',textColor:'',useTextGradient:false}",
        'author_bg'                  => '',
        'avatar_type'                => 'circle',
        'overview_type'              => 'C',
        'enable_social'              => '0',
        'enable_mobile_social'       => '0',
        'option_social_data'         => 'default',
        'socials'                    => '',
        'custom_socials'             => '',
        'enable_weather'             => '0',
        'weather_token'              => '',
        'avatar_frame'               => '0',
        'avatar_widget'              => '0',
        'enable_strips'              => '0',

        /* 代码块 */
        'enable_code_title'          => '1',
        'enable_code_hr'             => '1',
        'enable_code_macdot'         => '1',
        'enable_code_copy'           => '1',
        'enable_code_line_number'    => '1',
        'enable_code_newline'        => '0',
        'enable_code_expander'       => '1',
        'enable_fold_long_code'      => '0',
        'long_code_height'           => '800',
        'code_theme'                 => 'one-dark',
        'show_tools_when_hover'      => '1',
        'enable_single_code_select'  => '0',

        /* 社交 */
        'qq_group'                   => '',
        'qq_text'                    => '欢迎加入QQ交流群',

        /* 侧边栏 */
        'enable_aside'               => '1',
        'aside_position'             => 'right',
        'set_newest_post_num'        => '5',
        'set_hot_post_num'           => '5',
        'enable_tags_aside'          => '1',
        'enable_categories_aside'    => '1',
        'enable_archives_aside'      => '1',
        'enable_post_aside'          => '1',
        'enable_links_aside'         => '1',
        'enable_sheet_aside'         => '1',
        'aside_widgets'              => "enable_blogger\nenable_newest_post\nenable_tag_cloud",
        'notice_title'               => '网站公告',
        'site_notice'                => '',
        'reward_list'                => '',
        'qrcode_url'                 => '',
        'qrcode_title'               => '我的二维码',
        'qrcode_description'         => '',
        'music_id'                   => '',
        'show_newreply_num'          => '3',
        'tag_cloud_type'             => 'list',
        'tag_cloud_num_type'         => 'num',
        'tag_cloud_num'              => '15',
        'tag_cloud_width'            => 'static',
        'category_cloud_type'        => 'list',
        'category_cloud_num_type'    => 'num',
        'category_cloud_num'         => '15',
        'category_cloud_width'       => 'static',
        'aside_custom_code'          => '',

        /* 文章页 */
        'enable_title_shadow'        => '0',
        'post_author_link'           => '',
        'enable_page_meta'           => '1',
        'enable_passage_tips'        => '0',
        'days'                       => '30',
        'days_type'                  => '1',
        'passage_tips_content'       => '',
        'post_img_align'             => 'center',
        'img_max_width'              => '100%',
        'enable_progress_bar'        => '1',
        'progress_bar_bgc'           => '#fb6c28',
        'enable_toc'                 => '1',
        'enable_mobile_toc'          => '1',
        'toc_depth'                  => '0',
        'enable_relate_post'         => '1',
        'relate_post_max'            => '5',
        'enable_edit'                => '0',
        'enable_comment'             => '1',
        'enable_like'                => '1',
        'enable_share'               => '1',
        'enable_copy'                => '1',
        'enable_indent'              => '0',
        'enable_copy_right_text'     => '1',
        'copy_right_text'            => '',
        'enable_share_weixin'        => '1',
        'enable_share_qq'            => '1',
        'enable_share_qzone'         => '1',
        'enable_share_weibo'         => '1',
        'enable_share_link'          => '1',
        'share_link_template'        => '',
        'passage_rights_content'     => '',
        'enable_donate'              => '0',
        'qrcode_zfb'                 => '',
        'qrcode_wx'                  => '',
        'qrcode_qq'                  => '',
        'reward_code'                => '',

        /* 标签页/分类页/归档页 */
        'tags_title'                 => '全部标签',
        'tags_type'                  => 'card',
        'enable_tags_post_num'       => '0',
        'categories_title'           => '全部分类',
        'categories_type'            => 'card',
        'enable_categories_post_num' => '0',
        'archives_title'             => '文章归档',
        'archives_empty_text'        => '暂无文章数据',
        'archives_list_type'         => 'timeline',
        'archives_timeline_metric'   => 'month',
        'enable_archives_category'   => '1',

        /* 友链 */
        'links_title'                => '友情链接',
        'links_default_logo'         => '',
        'enable_links_random'        => '0',
        'links_data'                 => '',

        /* 留言页 */
        'message_source'             => '1',

        /* 页脚 */
        'enable_footer'              => '1',
        'footer_position'            => 'none',
        'enable_full_footer'         => '0',
        'enable_birthday'            => '0',
        'custom_birthday'            => date('Y/m/d H:i'),
        'enable_icp'                 => '0',
        'enable_police'              => '0',
        'enable_powerby'             => '1',
        'driven_by'                  => 'none',
        'driven_by_custom_url'       => '',
        'driven_by_custom_img'       => '',
        'enable_rss'                 => '1',
        'enable_sitemap'             => '0',
        'enable_busuanzi'            => '0',

        /* 自定义 */
        'favicon'                    => '',
        'custom_font'                => '',
        'iconfont'                   => '',
        'custom_css'                 => '',
        'custom_js_head'             => '',
        'custom_js_body'             => '',
        'show_loaded_time'           => '0',

        /* 其他 */
        'enable_debug'               => '0',
        'rip_mode'                   => '0',
        'enable_clean_mode'          => '0',
        'check_baidu_collect'        => '0',
        'baidu_token'                => '',
        'enable_console_theme'       => '0',
    ];
}

/**
 * 动画效果类名选项（animate.css）
 */
function joe_animate_options(): array
{
    $list = [
        'fadeIn', 'fadeInUp', 'fadeInDown', 'fadeInDownBig', 'fadeInLeft', 'fadeInLeftBig',
        'fadeInRight', 'fadeInRightBig', 'fadeInUpBig', 'fadeOut', 'fadeOutDown',
        'fadeOutDownBig', 'fadeOutLeft', 'fadeOutLeftBig', 'fadeOutRight', 'fadeOutRightBig',
        'fadeOutUp', 'fadeOutUpBig', 'bounce', 'flash', 'pulse', 'rubberBand', 'headShake',
        'swing', 'tada', 'wobble', 'jello', 'heartBeat', 'bounceIn', 'bounceInDown',
        'bounceInLeft', 'bounceInRight', 'bounceInUp', 'bounceOut', 'bounceOutDown',
        'bounceOutLeft', 'bounceOutRight', 'bounceOutUp', 'flip', 'flipInX', 'flipInY',
        'flipOutX', 'flipOutY', 'rotateIn', 'rotateInDownLeft', 'rotateInDownRight',
        'rotateInUpLeft', 'rotateInUpRight', 'rotateOut', 'rotateOutDownLeft',
        'rotateOutDownRight', 'rotateOutUpLeft', 'rotateOutUpRight', 'hinge',
        'jackInTheBox', 'rollIn', 'rollOut', 'zoomIn', 'zoomInDown', 'zoomInLeft',
        'zoomInRight', 'zoomInUp', 'zoomOut', 'zoomOutDown', 'zoomOutLeft', 'zoomOutRight',
        'zoomOutUp', 'slideInDown', 'slideInLeft', 'slideInRight', 'slideInUp',
        'slideOutDown', 'slideOutLeft', 'slideOutRight', 'slideOutUp',
    ];

    return array_combine($list, $list);
}

/**
 * 设置分组统计（用于顶部导航与分组标题）
 */
function joe_setting_sections(): array
{
    return [
        'backup' => '备份 / 恢复',
        'basic'  => '基本设置',
        'home'   => '首页',
        'theme'  => '主题相关',
        'carousel' => '轮播图',
        'beauty' => '美化',
        'navbar' => '导航',
        'blogger' => '博主信息',
        'code'   => '代码块',
        'social' => '社交',
        'aside'  => '侧边栏',
        'post'   => '文章页',
        'pages'  => '标签页 / 分类页 / 归档页',
        'links'  => '友链 / 留言页',
        'photos' => '图库',
        'footer' => '页脚',
        'custom' => '自定义',
        'other'  => '其他',
    ];
}

/**
 * 向设置表单插入分组标题（原生 HTML，渲染于 description）
 */
function joe_form_heading($form, string $id, string $desc = '')
{
    $sections = joe_setting_sections();
    $title = $sections[$id] ?? $id;
    $html = '<h3 id="joe_s_' . $id . '" style="margin:36px 0 2px;padding:9px 14px;background:#fb6c28;'
        . 'color:#fff;font-size:14px;font-weight:600;border-radius:4px;">' . $title . '</h3>';
    if ($desc !== '') {
        $html .= '<div style="padding:8px 2px;">' . $desc . '</div>';
    }
    $el = new \Typecho\Widget\Helper\Form\Element\Fake('joe_heading_' . $id, null);
    $el->description($html);
    $form->addInput($el);
}

/**
 * 主题设置表单
 */
function themeConfig(Form $form)
{
    $defaults = joe_default_config();

    $el = function (string $cls, string $name, ?array $options, $value, string $label, string $desc = '') use ($form) {
        $map = [
            'radio'    => Radio::class,
            'select'   => Select::class,
            'number'   => Number::class,
            'text'     => Text::class,
            'textarea' => Textarea::class,
        ];
        $element = new $map[$cls]($name, $options, $value, _t($label), $desc === '' ? null : _t($desc));
        $form->addInput($element);
    };

    $d = function (string $key) use ($defaults) {
        return $defaults[$key] ?? '';
    };

    $boolOptions = ['0' => _t('关闭'), '1' => _t('开启')];

    /* ================= 顶部：设置导航 + 备份 / 恢复 ================= */
    $navLinks = [];
    foreach (joe_setting_sections() as $sid => $stitle) {
        if ($sid === 'backup' || $sid === 'top') {
            continue;
        }
        $navLinks[] = '<a style="display:inline-block;padding:3px 10px;margin:3px 4px 0 0;'
            . 'background:#f7f7f7;border:1px solid #eee;border-radius:3px;font-size:12px;'
            . 'text-decoration:none;color:#555;" href="#joe_s_' . $sid . '">' . $stitle . '</a>';
    }
    $navHtml = '<div style="padding:10px 12px;border:1px solid #f0d5c8;border-radius:4px;background:#fffaf7;">'
        . '<b style="color:#fb6c28;">Joe3 设置导航</b><span style="color:#999;font-size:12px;">（点击快速跳转到对应分组）</span><br>'
        . implode('', $navLinks) . '</div>'
        . '<p style="margin:6px 2px 0;color:#999;font-size:12px;">备份 / 恢复：可导出 JSON 下载到本地，或将设置备份到站点数据库；恢复时选中备份填入下方文本框，再点击页面底部「保存设置」即可。</p>';
    joe_form_heading($form, 'backup', $navHtml);

    $backupDesc = '<p>'
        . '<button type="button" id="joe_backup_export" style="cursor:pointer;padding:6px 14px;border:1px solid #fb6c28;'
        . 'border-radius:3px;background:#fb6c28;color:#fff;">导出当前设置（下载 JSON）</button> '
        . '<button type="button" id="joe_backup_fill" style="cursor:pointer;padding:6px 14px;border:1px solid #ccc;'
        . 'border-radius:3px;background:#fff;color:#555;">将当前设置填入下方文本框</button> '
        . '<button type="button" id="joe_backup_import_file" style="cursor:pointer;padding:6px 14px;border:1px solid #43a047;'
        . 'border-radius:3px;background:#fff;color:#43a047;">从本地文件导入</button> '
        . '<input type="file" id="joe_backup_file" accept=".json,application/json" style="display:none"> '
        . '<button type="button" id="joe_backup_save_db" style="cursor:pointer;padding:6px 14px;border:1px solid #1e88e5;'
        . 'border-radius:3px;background:#1e88e5;color:#fff;">备份到数据库</button>'
        . '</p>'
        . '<p style="margin:8px 0 2px;">数据库备份：<select id="joe_backup_list" '
        . 'style="min-width:240px;max-width:100%;vertical-align:middle;"><option value="">加载中…</option></select> '
        . '<button type="button" id="joe_backup_restore_db" style="cursor:pointer;padding:5px 12px;border:1px solid #ccc;'
        . 'border-radius:3px;background:#fff;color:#555;">恢复所选</button> '
        . '<button type="button" id="joe_backup_del_db" style="cursor:pointer;padding:5px 12px;border:1px solid #e53935;'
        . 'border-radius:3px;background:#fff;color:#e53935;">删除所选</button></p>'
        . '<p style="color:#999;font-size:12px;">导出 JSON 直接下载到本地；「从本地文件导入」选择备份 JSON 自动填入下方文本框；「备份到数据库」将设置存入站点数据库，换浏览器 / 重新安装后可在此直接取回。'
        . '恢复：内容进入下方文本框后 → 点页面底部「保存设置」即生效。</p>'
        . '<script>__JOE_BACKUP_JS__</script>';

    $siteUrl = '';
    try {
        $siteUrl = (string) \Typecho\Widget::widget('Widget\Options')->siteUrl;
    } catch (\Throwable $e) {
        $siteUrl = '/';
    }

    $backupJs = <<<'JOEJS'
(function () {
    function getForm() {
        return document.querySelector('form[action*="themes-edit"]') || document.forms[0];
    }
    function collect() {
        var form = getForm();
        var out = {};
        if (!form) return out;
        form.querySelectorAll('input[name^="joe_"], select[name^="joe_"], textarea[name^="joe_"]').forEach(function (el) {
            var name = el.name;
            if (name === 'joe_backup_box' || name.indexOf('joe_heading_') === 0) return;
            if (el.type === 'radio' && !el.checked) return;
            if (el.type === 'checkbox') { out[name] = el.checked ? el.value : ''; return; }
            out[name] = el.value;
        });
        return out;
    }
    function payload() {
        return JSON.stringify({ _joe_backup: 1, theme: 'joe3', time: new Date().toLocaleString(), values: collect() }, null, 2);
    }
    var SITE = "__SITE_URL__".replace(/\/+$/, "");
    var API = SITE + "/?joe_action=theme_backup&op=";
    var box = document.querySelector('textarea[name="joe_backup_box"]');
    var listSel = document.getElementById('joe_backup_list');
    var fillBtn = document.getElementById('joe_backup_fill');
    var dlBtn = document.getElementById('joe_backup_export');
    var importBtn = document.getElementById('joe_backup_import_file');
    var fileInput = document.getElementById('joe_backup_file');
    var saveBtn = document.getElementById('joe_backup_save_db');
    var restoreBtn = document.getElementById('joe_backup_restore_db');
    var delBtn = document.getElementById('joe_backup_del_db');

    function api(op, opts) {
        return fetch(API + op, Object.assign({ credentials: 'same-origin' }, opts || {}))
            .then(function (r) { return r.json(); });
    }
    function busy(btn, on, text) {
        if (!btn) return;
        if (!btn.dataset.label) btn.dataset.label = btn.textContent;
        btn.disabled = on;
        btn.textContent = on ? text : btn.dataset.label;
    }
    function refreshList() {
        if (!listSel) return;
        api('list').then(function (res) {
            listSel.innerHTML = '';
            var items = (res && res.code && res.list) ? res.list : [];
            if (!items.length) {
                var opt = document.createElement('option');
                opt.value = '';
                opt.textContent = '暂无数据库备份';
                listSel.appendChild(opt);
                return;
            }
            items.forEach(function (item) {
                var opt = document.createElement('option');
                opt.value = item.name;
                opt.textContent = item.time + '（' + item.count + ' 项）';
                listSel.appendChild(opt);
            });
        }).catch(function () {});
    }

    if (fillBtn && box) {
        fillBtn.addEventListener('click', function () { box.value = payload(); });
    }
    if (dlBtn) {
        dlBtn.addEventListener('click', function () {
            var text = payload();
            if (box) box.value = text;
            var blob = new Blob([text], { type: 'application/json' });
            var a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = 'joe3-settings-backup.json';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        });
    }
    if (importBtn && fileInput) {
        importBtn.addEventListener('click', function () { fileInput.click(); });
        fileInput.addEventListener('change', function () {
            var file = fileInput.files && fileInput.files[0];
            if (!file) return;
            var reader = new FileReader();
            reader.onload = function () {
                var ok = false;
                var values = 0;
                try {
                    var data = JSON.parse(reader.result);
                    ok = !!data && data._joe_backup === 1 && data.values && typeof data.values === 'object';
                    if (ok) values = Object.keys(data.values).length;
                } catch (e) {}
                if (ok) {
                    if (box) box.value = reader.result;
                    alert('已导入 ' + values + ' 项设置，请点击页面底部「保存设置」完成恢复');
                } else {
                    alert('这不是有效的 Joe3 备份文件（需要主题导出的 JSON）');
                }
                fileInput.value = '';
            };
            reader.readAsText(file, 'UTF-8');
        });
    }
    if (saveBtn) {
        saveBtn.addEventListener('click', function () {
            busy(saveBtn, true, '备份中…');
            api('save', { method: 'POST', body: payload() })
                .then(function (res) {
                    if (res && res.code) {
                        alert('备份成功：' + res.name);
                        refreshList();
                    } else {
                        alert((res && res.message) || '备份失败');
                    }
                })
                .catch(function () { alert('备份失败：请求异常'); })
                .finally(function () { busy(saveBtn, false); });
        });
    }
    if (restoreBtn) {
        restoreBtn.addEventListener('click', function () {
            var name = listSel ? listSel.value : '';
            if (!name) { alert('没有可恢复的数据库备份'); return; }
            busy(restoreBtn, true, '读取中…');
            api('get&name=' + encodeURIComponent(name))
                .then(function (res) {
                    if (res && res.code && box) {
                        box.value = res.data;
                        alert('备份已填入文本框，请点击页面底部「保存设置」完成恢复');
                    } else {
                        alert((res && res.message) || '读取失败');
                    }
                })
                .catch(function () { alert('读取失败：请求异常'); })
                .finally(function () { busy(restoreBtn, false); });
        });
    }
    if (delBtn) {
        delBtn.addEventListener('click', function () {
            var name = listSel ? listSel.value : '';
            if (!name) { alert('没有可删除的数据库备份'); return; }
            if (!confirm('确定删除该条数据库备份？')) return;
            api('delete&name=' + encodeURIComponent(name))
                .then(function (res) {
                    if (res && res.code) {
                        refreshList();
                    } else {
                        alert((res && res.message) || '删除失败');
                    }
                })
                .catch(function () { alert('删除失败：请求异常'); });
        });
    }
    refreshList();
})();
JOEJS;

    $backupJs = str_replace('__SITE_URL__', htmlspecialchars($siteUrl, ENT_QUOTES), $backupJs);
    $backupDesc = str_replace('__JOE_BACKUP_JS__', $backupJs, $backupDesc);

    $backupEl = new Textarea('joe_backup_box', null, '', _t('备份 / 恢复'), null);
    $backupEl->description($backupDesc);
    $form->addInput($backupEl);

    /* ================= 基本设置 ================= */
    joe_form_heading($form, 'basic');
    $el('radio', 'joe_theme_mode', [
        'user'  => _t('用户模式'),
        'auto'  => _t('自动模式'),
        'light' => _t('浅色模式'),
        'dark'  => _t('暗黑模式'),
    ], $d('theme_mode'), _t('主题模式'), _t('仅在用户模式下页面才有主题切换按钮，自动模式下根据时间自动切换'));

    $el('radio', 'joe_comment_option', [
        'default' => _t('默认'),
        'waline'  => _t('Waline'),
    ], $d('comment_option'), _t('评论系统'), _t('选择使用的评论系统'));

    $el('text', 'joe_waline_serverURL', null, $d('waline_serverURL'), _t('Waline 服务端地址'), _t('如 https://waline.example.com，不要加结尾反斜杠'));
    $el('text', 'joe_waline_css', null, $d('waline_css'), _t('Waline CSS 地址'));
    $el('text', 'joe_waline_js_comment', null, $d('waline_js_comment'), _t('用于评论的 JS 地址'));
    $el('text', 'joe_waline_js_leaving', null, $d('waline_js_leaving'), _t('功能 JS'));
    $el('text', 'joe_waline_js_list', null, $d('waline_js_list'), _t('列表 JS'), _t('首页加载显示评论数的 JS 地址'));
    $el('textarea', 'joe_waline_config_basic_json', null, $d('waline_config_basic_json'), _t('Waline 基础配置'), _t('json 格式，参考 https://waline.js.org'));
    $el('text', 'joe_lskypro_apiURL', null, $d('lskypro_apiURL'), _t('兰空图床 服务端地址（Waline 图床上传）'));
    $el('text', 'joe_lskypro_apiTOKEN', null, $d('lskypro_apiTOKEN'), _t('兰空图床 Token（Waline 图床上传）'));

    $el('text', 'joe_source_link', null, $d('source_link'), _t('外部资源地址'), _t('使用外部资源时填写，如 https://cdn.example.com，留空则使用主题本地资源'));
    /* 主题色调色板（预设色块 + 取色器，同步到下方文本框） */
    $joePalettePresets = [
        '#fb6c28', '#f55555', '#e53935', '#f06292', '#ba68c8', '#7367f0',
        '#5c6bc0', '#1e88e5', '#00acc1', '#00b96b', '#7cb342', '#9999ff',
    ];
    $joeBuildPalette = function (string $target, string $label) use ($joePalettePresets): string {
        $swatches = '';
        foreach ($joePalettePresets as $joeColor) {
            $swatches .= '<button type="button" class="joe-palette__swatch" data-color="' . $joeColor . '" style="background:' . $joeColor . '" title="' . $joeColor . '"></button>';
        }
        return '<div class="joe-palette" data-target="' . $target . '">'
            . '<div class="joe-palette__head">'
            . '<input type="color" class="joe-palette__picker" aria-label="' . $label . '取色器">'
            . '<span class="joe-palette__current"></span>'
            . '<span class="joe-palette__tip">点击色块或取色器选择' . $label . '，改完记得点页面底部「保存设置」</span>'
            . '</div>'
            . '<div class="joe-palette__presets">' . $swatches . '</div>'
            . '</div>';
    };
    $joePaletteCss = '<style>'
        . '.joe-palette{margin-top:8px}.joe-palette__head{align-items:center;display:flex;gap:8px}'
        . '.joe-palette__picker{background:#fff;border:1px solid #dcdfe6;border-radius:4px;cursor:pointer;height:32px;padding:2px;width:46px}'
        . '.joe-palette__current{background:#f5f5f5;border:1px solid #e4e7ed;border-radius:4px;font-family:monospace;font-size:12px;padding:4px 8px}'
        . '.joe-palette__tip{color:#909399;font-size:12px}'
        . '.joe-palette__presets{display:flex;flex-wrap:wrap;gap:6px;margin-top:8px}'
        . '.joe-palette__swatch{border:2px solid #fff;border-radius:50%;box-shadow:0 1px 4px rgba(0,0,0,.25);cursor:pointer;height:24px;padding:0;width:24px}'
        . '.joe-palette__swatch:hover{transform:scale(1.18);transition:transform .15s}'
        . '</style>';

    $joePaletteLight = new Text('joe_mode_color_light', null, $d('mode_color_light'), _t('主题色（浅色）'), null);
    $joePaletteLight->description($joeBuildPalette('joe_mode_color_light', '浅色主题色') . $joePaletteCss);
    $form->addInput($joePaletteLight);

    $joePaletteDark = new Text('joe_mode_color_dark', null, $d('mode_color_dark'), _t('主题色（暗黑）'), null);
    $joePaletteDark->description($joeBuildPalette('joe_mode_color_dark', '暗黑主题色') . $joePaletteCss
        . '<script>(function(){document.querySelectorAll(".joe-palette").forEach(function(pal){var target=document.querySelector(\'input[name="\'+pal.getAttribute("data-target")+\'"]\');var picker=pal.querySelector(".joe-palette__picker");var current=pal.querySelector(".joe-palette__current");if(!target||!picker)return;function norm(v){return /^#[0-9a-fA-F]{3}$/.test(v)?"#"+v[1]+v[1]+v[2]+v[2]+v[3]+v[3]:v}function paint(v){if(/^#[0-9a-fA-F]{6}$/.test(v)){picker.value=v;current.textContent=v;current.style.background=v;current.style.color=/^#(f|e|d|c)/i.test(v)?"#333":"#fff"}}paint(norm(target.value));picker.addEventListener("input",function(){target.value=picker.value;paint(picker.value)});target.addEventListener("change",function(){paint(norm(target.value))});pal.querySelectorAll(".joe-palette__swatch").forEach(function(sw){sw.addEventListener("click",function(){target.value=sw.getAttribute("data-color");paint(sw.getAttribute("data-color"))})})})})();</script>');
    $form->addInput($joePaletteDark);
    $el('radio', 'joe_enable_background_light', $boolOptions, $d('enable_background_light'), _t('开启浅色模式背景图'));
    $el('text', 'joe_background_light_mode', null, $d('background_light_mode'), _t('背景图（浅色模式）'), _t('填写图片地址，建议 webp'));
    $el('radio', 'joe_enable_background_dark', $boolOptions, $d('enable_background_dark'), _t('开启暗黑模式背景图'));
    $el('text', 'joe_background_dark_mode', null, $d('background_dark_mode'), _t('背景图（暗黑模式）'));
    $el('text', 'joe_background_color', null, $d('background_color'), _t('页面背景色'), _t('背景图与背景特效之外的纯色背景，默认 #f2f2f2'));
    $el('number', 'joe_content_max_width', null, $d('content_max_width'), _t('内容区最大宽度'), _t('单位 px，默认 1320'));
    $el('radio', 'joe_enable_random_img_api', $boolOptions, $d('enable_random_img_api'), _t('启用随机图'), _t('文章无封面时使用'));
    $el('text', 'joe_random_img_api_url', null, $d('random_img_api_url'), _t('随机图 api'));
    $el('text', 'joe_light_time_scope', null, $d('light_time_scope'), _t('浅色模式生效时间范围'), _t('仅在自动模式下生效，格式 5:00~19:00'));
    $el('text', 'joe_icp', null, $d('icp'), _t('ICP 备案号'), _t('示例：鄂ICP备20001234号-1'));
    $el('text', 'joe_icp_link', null, $d('icp_link'), _t('ICP 备案跳转链接'));
    $el('text', 'joe_police', null, $d('police'), _t('公网安备号'));
    $el('text', 'joe_gongan_link', null, $d('gongan_link'), _t('公安联网备案跳转链接'));

    /* ================= 首页 ================= */
    joe_form_heading($form, 'home');
    $el('radio', 'joe_enable_index_list_ajax', [
        '0' => _t('分页'),
        '1' => _t('加载更多'),
    ], $d('enable_index_list_ajax'), _t('文章加载形式'));
    $el('radio', 'joe_enable_auto_ajax', $boolOptions, $d('enable_auto_ajax'), _t('是否开启自动加载'), _t('开启后滑到底部自动加载文章'));
    $el('radio', 'joe_enable_post_thumbnail', $boolOptions, $d('enable_post_thumbnail'), _t('开启文章缩略图'));
    $el('text', 'joe_lazyload_thumbnail', null, $d('lazyload_thumbnail'), _t('文章预载图'), _t('留空则使用主题自带预载图'));
    $el('text', 'joe_post_thumbnail', null, $d('post_thumbnail'), _t('文章默认缩略图'), _t('文章无配图时生效'));
    $el('text', 'joe_fallback_thumbnail', null, $d('fallback_thumbnail'), _t('文章错误缺省图'), _t('留空则使用主题自带缺省图'));
    $el('radio', 'joe_enable_index_list_effect', $boolOptions, $d('enable_index_list_effect'), _t('开启列表动画效果'));
    $el('select', 'joe_index_list_effect_class', joe_animate_options(), $d('index_list_effect_class'), _t('动画效果类名'));
    $el('radio', 'joe_enable_hot_category', $boolOptions, $d('enable_hot_category'), _t('展示精品分类'));
    $el('textarea', 'joe_data_hot_category', null, $d('data_hot_category'), _t('分类数据'), _t('每行一条：分类名 或 标题|链接|图片地址，最多 4 条'));

    /* ================= 主题相关 ================= */
    joe_form_heading($form, 'theme');
    $el('select', 'joe_cursor_skin', [
        'off'                 => _t('无（默认）'),
        'simple_cursor'       => _t('简洁卡通'),
        'simple_cursor_blue'  => _t('简洁卡通-蓝'),
        'simple_sunset_light' => _t('简单日落(浅色)'),
        'simple_sunset_dark'  => _t('简单日落(暗黑)'),
        'crystallize'         => _t('简约水晶'),
        'emoji_zip'           => _t('魔力表情'),
        'black_cat'           => _t('小黑猫'),
    ], $d('cursor_skin'), _t('鼠标皮肤'));
    $el('select', 'joe_cursor_effect', [
        'off'     => _t('无（默认）'),
        'cursor0' => _t('樱花+颜文字'),
        'cursor1' => _t('小粒子'),
        'cursor2' => _t('大粒子'),
        'cursor3' => _t('社会主义价值观'),
        'cursor4' => _t('大爱心'),
        'cursor5' => _t('小爱心+颜文字'),
        'cursor6' => _t('多彩星星（移动）'),
        'cursor7' => _t('光标残影（移动）'),
        'cursor8' => _t('弹性表情（移动）'),
        'cursor9' => _t('表情雨（移动）'),
        'cursor10' => _t('上升气泡（移动）'),
        'cursor11' => _t('雪花雨（移动）'),
    ], $d('cursor_effect'), _t('鼠标特效'));
    $el('select', 'joe_backdrop', [
        'off'       => _t('无（默认）'),
        'universe'  => _t('宇宙空间（仅暗黑）'),
        'rain'      => _t('粒子雨（顶层+仅暗黑）'),
        'plexus'    => _t('自动吸附的线段'),
        'petals'    => _t('飘落的花瓣（顶层）'),
        'rainbow'   => _t('四色彩虹'),
        'silk'      => _t('变化的彩带'),
        'silk_static' => _t('固定的彩带'),
        'balloon'   => _t('上升的气球'),
    ], $d('backdrop'), _t('背景特效'));
    $el('radio', 'joe_enable_loading_bar', $boolOptions, $d('enable_loading_bar'), _t('开启页面加载条'));
    $el('text', 'joe_loading_bar_height', null, $d('loading_bar_height'), _t('加载条高度'));
    $el('text', 'joe_loading_bar_color', null, $d('loading_bar_color'), _t('加载条颜色'));
    $el('text', 'joe_scrollbar_color', null, $d('scrollbar_color'), _t('滚动条颜色'));
    $el('text', 'joe_scrollbar_width', null, $d('scrollbar_width'), _t('滚动条宽度'));
    $el('radio', 'joe_enable_offscreen_tip', $boolOptions, $d('enable_offscreen_tip'), _t('开启离屏提示'));
    $el('text', 'joe_offscreen_title_leave', null, $d('offscreen_title_leave'), _t('离屏文案（离开）'));
    $el('text', 'joe_offscreen_title_back', null, $d('offscreen_title_back'), _t('离屏文案（回来）'));
    $el('select', 'joe_link_behavior', [
        'default' => _t('默认'),
        'current' => _t('当前页'),
        'new'     => _t('新标签'),
    ], $d('link_behavior'), _t('链接跳转行为（全局-内容区域）'));
    $el('radio', 'joe_enable_show_in_up', $boolOptions, $d('enable_show_in_up'), _t('开启模块缓入效果（全局）'));
    $el('radio', 'joe_enable_back2top', $boolOptions, $d('enable_back2top'), _t('开启返回顶部'));
    $el('radio', 'joe_enable_back2top_smooth', $boolOptions, $d('enable_back2top_smooth'), _t('平滑返回顶部'));
    $el('select', 'joe_web_font', [
        'off'                => _t('默认'),
        'joe_slate.woff2'    => _t('Joe Slate'),
        'joe_future.woff2'   => _t('Joe Future'),
    ], $d('web_font'), _t('网站字体'));

    /* ================= 轮播图 ================= */
    joe_form_heading($form, 'carousel');
    $el('radio', 'joe_enable_banner', $boolOptions, $d('enable_banner'), _t('启用轮播图'));
    $el('textarea', 'joe_banner_data_group', null, $d('banner_data_group'), _t('轮播图数据设置'), _t('每行一条，格式：文章cid 或 custom|标题|描述|链接|图片 或 hot|数量'));
    $el('select', 'joe_banner_direction', [
        'horizontal' => _t('水平'),
        'vertical'   => _t('垂直'),
    ], $d('banner_direction'), _t('轮播方向'));
    $el('radio', 'joe_enable_banner_loop', $boolOptions, $d('enable_banner_loop'), _t('循环播放'));
    $el('select', 'joe_banner_effect', [
        'slide'     => _t('普通位移切换'),
        'fade'      => _t('淡入'),
        'cube'      => _t('方块'),
        'coverflow' => _t('3d流'),
        'flip'      => _t('3d翻转'),
        'cards'     => _t('卡片式'),
        'creative'  => _t('创意性'),
    ], $d('banner_effect'), _t('切换效果'));
    $el('radio', 'joe_enable_banner_handle', $boolOptions, $d('enable_banner_handle'), _t('允许手动控制'));
    $el('radio', 'joe_enable_banner_switch_button', $boolOptions, $d('enable_banner_switch_button'), _t('展示左右切换按钮'));
    $el('radio', 'joe_enable_banner_pagination', $boolOptions, $d('enable_banner_pagination'), _t('展示分页器'));
    $el('radio', 'joe_enable_banner_autoplay', $boolOptions, $d('enable_banner_autoplay'), _t('自动切换'));
    $el('number', 'joe_banner_delay', null, $d('banner_delay'), _t('切换间隔'), _t('单位毫秒'));
    $el('number', 'joe_banner_speed', null, $d('banner_speed'), _t('切换速度'), _t('单位毫秒'));
    $el('text', 'joe_banner_lazyload_img', null, $d('banner_lazyload_img'), _t('轮播图预载图'));

    /* ================= 美化 ================= */
    joe_form_heading($form, 'beauty');
    $el('radio', 'joe_enable_big_banner', $boolOptions, $d('enable_big_banner'), _t('顶部大图'));
    $el('text', 'joe_big_banner_title', null, $d('big_banner_title'), _t('标题'), _t('默认网站名'));
    $el('text', 'joe_big_banner_Photos', null, $d('big_banner_Photos'), _t('图片或者 api 地址'));
    $el('radio', 'joe_enable_big_banner_hitokoto', $boolOptions, $d('enable_big_banner_hitokoto'), _t('是否启用一言'));
    $el('radio', 'joe_enable_big_banner_video', $boolOptions, $d('enable_big_banner_video'), _t('是否启用视频背景'));
    $el('text', 'joe_big_banner_video', null, $d('big_banner_video'), _t('视频地址'));
    $el('text', 'joe_light_color', null, $d('light_color'), _t('底部波浪颜色'));
    $el('text', 'joe_dark_color', null, $d('dark_color'), _t('暗色底部波浪颜色'));

    /* ================= 导航 ================= */
    joe_form_heading($form, 'navbar');
    $el('textarea', 'joe_navbar_menu', null, $d('navbar_menu'), _t('导航菜单'), _t('每行一条：名称|链接|图标class（图标可留空）。留空则使用页面列表作为导航'));
    $el('radio', 'joe_enable_fixed_header', $boolOptions, $d('enable_fixed_header'), _t('导航条吸顶'));
    $el('radio', 'joe_nav_login', $boolOptions, $d('nav_login'), _t('导航栏登入按钮'));
    $el('radio', 'joe_enable_full_header', $boolOptions, $d('enable_full_header'), _t('100%宽度'));
    $el('radio', 'joe_show_logo', $boolOptions, $d('show_logo'), _t('展示博客 LOGO'));
    $el('text', 'joe_logo_link', null, $d('logo_link'), _t('LOGO 跳转链接'), _t('不填默认跳转博客主页'));
    $el('text', 'joe_logo_radius', null, $d('logo_radius'), _t('LOGO 圆角值'));
    $el('radio', 'joe_enable_navbar_icon', $boolOptions, $d('enable_navbar_icon'), _t('开启菜单图标'), _t('菜单格式中的第三段图标 class'));
    $el('radio', 'joe_enable_icon_animate', $boolOptions, $d('enable_icon_animate'), _t('菜单图标悬浮动画'));
    $el('radio', 'joe_enable_active_shadow', $boolOptions, $d('enable_active_shadow'), _t('文字阴影效果'));
    $el('radio', 'joe_enable_glass_blur', $boolOptions, $d('enable_glass_blur'), _t('毛玻璃效果'), _t('仅在“导航条吸顶”开启时生效'));

    /* ================= 博主信息 ================= */
    joe_form_heading($form, 'blogger');
    $el('radio', 'joe_show_blogger', $boolOptions, $d('show_blogger'), _t('展示博主信息'));
    $el('radio', 'joe_enable_day_words', $boolOptions, $d('enable_day_words'), _t('开启每日一句'));
    $el('text', 'joe_nickname', null, $d('nickname'), _t('博主显示昵称'), _t('默认使用网站 title'));
    $el('radio', 'joe_enable_blogger_level', $boolOptions, $d('enable_blogger_level'), _t('展示博主等级'));
    $el('text', 'joe_motto', null, $d('motto'), _t('个人独白'));
    $el('text', 'joe_lazyload_avatar', null, $d('lazyload_avatar'), _t('头像预载图'), _t('留空则使用主题自带预载图'));
    $el('text', 'joe_avatar', null, $d('avatar'), _t('头像'));
    $el('text', 'joe_default_avatar', null, $d('default_avatar'), _t('默认头像'), _t('头像未设置或加载出错时显示'));
    $el('text', 'joe_author_bg', null, $d('author_bg'), _t('博主栏背景图'));
    $el('select', 'joe_avatar_type', [
        'circle' => _t('圆形'),
        'round'  => _t('圆角矩形'),
    ], $d('avatar_type'), _t('头像外形'));
    $el('select', 'joe_overview_type', [
        'A' => _t('分类+标签+文章'),
        'B' => _t('分类+标签+评论'),
        'C' => _t('分类+文章+评论'),
        'D' => _t('标签+文章+评论'),
    ], $d('overview_type'), _t('概览指标'));
    $el('radio', 'joe_enable_social', $boolOptions, $d('enable_social'), _t('展示社交账号'));
    $el('radio', 'joe_enable_mobile_social', $boolOptions, $d('enable_mobile_social'), _t('展示社交账号（移动端）'));
    $el('radio', 'joe_option_social_data', [
        'default' => _t('默认'),
        'custom'  => _t('自定义'),
    ], $d('option_social_data'), _t('社交信息来源'));
    $el('textarea', 'joe_socials', null, $d('socials'), _t('社交信息'), _t('每行一条：平台|链接（平台支持 github/email/zhihu/gitee/telegram/bilibili/qq/wechat/weibo/tiktok/facebook/instagram/linkedin/twitter/x/discord/youtube/steam/gitlab 等）'));
    $el('textarea', 'joe_custom_socials', null, $d('custom_socials'), _t('自定义社交信息'), _t('每行一条：名称|链接|svg 代码或 img 标签'));
    $el('radio', 'joe_enable_weather', $boolOptions, $d('enable_weather'), _t('展示天气信息'));
    $el('text', 'joe_weather_token', null, $d('weather_token'), _t('天气插件 token'));
    $el('select', 'joe_avatar_frame', [
        '0'               => _t('无'),
        'rainbow-girl'    => _t('彩虹之女'),
        'honor-light'     => _t('荣誉之光'),
        'bird-girl'       => _t('彩雀之女'),
        'purple-crystal'  => _t('紫水晶'),
        'flower-ring'     => _t('清新花环'),
        'lantern-cloud'   => _t('灯笼祥云'),
        'ease-cloud'      => _t('福气祥云'),
        'festival-luck'   => _t('节日福旺'),
        'happy-mouse'     => _t('快乐小鼠'),
        'two-mouse'       => _t('两只小鼠'),
        'bull-puff'       => _t('牛气大发'),
        'christmas-knot'  => _t('圣诞彩结'),
        'christmas-ring'  => _t('圣诞花环'),
        'santa-claus'     => _t('圣诞老人'),
        'cactus'          => _t('仙人掌'),
        'rabbit'          => _t('幸福兔子（动态）'),
        'gaoda'           => _t('高达（动态）'),
        'donut'           => _t('甜甜圈（动态）'),
        'bat'             => _t('吸血蝙蝠（动态）'),
        'bilibili'        => _t('Bilibili'),
        'constellation'   => _t('星座'),
        'putin'           => _t('布丁'),
        'princess'        => _t('小公主'),
        'mangci'          => _t('芒刺'),
        'maid'            => _t('女仆'),
        'orchid'          => _t('兰花'),
        'gulu'            => _t('咕噜'),
        'gufeng'          => _t('古风'),
    ], $d('avatar_frame'), _t('头像框'));
    $el('select', 'joe_avatar_widget', [
        '0'            => _t('无'),
        'angel'        => _t('天使'),
        'meteor'       => _t('流星'),
        'rain'         => _t('下雨'),
        'wing'         => _t('天使之翼'),
        'rotate-heart' => _t('旋转的心'),
        'fall-in-love' => _t('坠入爱河'),
        'sun-flower'   => _t('向日葵'),
        'swirl-heart'  => _t('上升的心'),
    ], $d('avatar_widget'), _t('头像挂件'));
    $el('radio', 'joe_enable_strips', $boolOptions, $d('enable_strips'), _t('展示彩带动画'));

    /* ================= 代码块 ================= */
    joe_form_heading($form, 'code');
    $el('radio', 'joe_enable_code_title', $boolOptions, $d('enable_code_title'), _t('代码标题'));
    $el('radio', 'joe_enable_code_hr', $boolOptions, $d('enable_code_hr'), _t('标题分隔线'));
    $el('radio', 'joe_enable_code_macdot', $boolOptions, $d('enable_code_macdot'), _t('mac 彩点'));
    $el('radio', 'joe_enable_code_copy', $boolOptions, $d('enable_code_copy'), _t('代码复制'));
    $el('radio', 'joe_enable_code_line_number', $boolOptions, $d('enable_code_line_number'), _t('代码行号'), _t('“自动换行”开启时无效'));
    $el('radio', 'joe_enable_code_newline', $boolOptions, $d('enable_code_newline'), _t('自动换行'));
    $el('radio', 'joe_enable_code_expander', $boolOptions, $d('enable_code_expander'), _t('代码折叠'));
    $el('radio', 'joe_enable_fold_long_code', $boolOptions, $d('enable_fold_long_code'), _t('自动折叠长代码块'));
    $el('number', 'joe_long_code_height', null, $d('long_code_height'), _t('自动折叠的高度'), _t('单位 px，0 表示折叠所有代码块'));
    $el('select', 'joe_code_theme', [
        'one-dark' => _t('one-dark'), 'one-light' => _t('one-light'), 'a11y-dark' => _t('a11y-dark'),
        'atom-dark' => _t('atom-dark'), 'darcula' => _t('darcula'), 'dracula' => _t('dracula'),
        'duotone-dark' => _t('duotone-dark'), 'duotone-light' => _t('duotone-light'),
        'ghcolors' => _t('ghcolors'), 'gruvbox-dark' => _t('gruvbox-dark'), 'gruvbox-light' => _t('gruvbox-light'),
        'hopscotch' => _t('hopscotch'), 'lucario' => _t('lucario'), 'material-dark' => _t('material-dark'),
        'material-light' => _t('material-light'), 'material-oceanic' => _t('material-oceanic'),
        'night-owl' => _t('night-owl'), 'nord' => _t('nord'), 'pojoaque' => _t('pojoaque'),
        'shades-of-purple' => _t('shades-of-purple'), 'solarized-dark-atom' => _t('solarized-dark-atom'),
        'synthwave84' => _t('synthwave84'), 'vs' => _t('vs'), 'vsc-dark-plus' => _t('vsc-dark-plus'),
        'xonokai' => _t('xonokai'), 'z-touch' => _t('z-touch'),
    ], $d('code_theme'), _t('代码主题'));
    $el('radio', 'joe_show_tools_when_hover', $boolOptions, $d('show_tools_when_hover'), _t('仅悬浮时显示操作按钮'));
    $el('radio', 'joe_enable_single_code_select', $boolOptions, $d('enable_single_code_select'), _t('点击行内代码自动全选'));

    /* ================= 社交 ================= */
    joe_form_heading($form, 'social');
    $el('text', 'joe_qq_group', null, $d('qq_group'), _t('QQ 交流群「首页」'), _t('请填入 QQ 交流群链接，留空则不显示'));
    $el('text', 'joe_qq_text', null, $d('qq_text'), _t('欢迎语'));

    /* ================= 侧边栏 ================= */
    joe_form_heading($form, 'aside');
    $el('radio', 'joe_enable_aside', $boolOptions, $d('enable_aside'), _t('启用全局侧边栏'), _t('关闭后除文章页外所有页面都没有侧边栏'));
    $el('select', 'joe_aside_position', [
        'right' => _t('右侧'),
        'left'  => _t('左侧'),
    ], $d('aside_position'), _t('侧边栏位置'));
    $el('number', 'joe_set_newest_post_num', null, $d('set_newest_post_num'), _t('最新文章数'));
    $el('number', 'joe_set_hot_post_num', null, $d('set_hot_post_num'), _t('热门文章数'));
    $el('radio', 'joe_enable_tags_aside', $boolOptions, $d('enable_tags_aside'), _t('标签页侧边栏'));
    $el('radio', 'joe_enable_categories_aside', $boolOptions, $d('enable_categories_aside'), _t('分类页侧边栏'));
    $el('radio', 'joe_enable_archives_aside', $boolOptions, $d('enable_archives_aside'), _t('归档页侧边栏'));
    $el('radio', 'joe_enable_post_aside', $boolOptions, $d('enable_post_aside'), _t('文章页侧边栏'));
    $el('radio', 'joe_enable_links_aside', $boolOptions, $d('enable_links_aside'), _t('友链页侧边栏'));
    $el('radio', 'joe_enable_sheet_aside', $boolOptions, $d('enable_sheet_aside'), _t('自定义页侧边栏'));
    $el('textarea', 'joe_aside_widgets', null, $d('aside_widgets'), _t('侧边栏模块（顺序）'), _t('每行一个模块名，从上到下排列：enable_blogger / enable_notice / enable_reward / enable_picture / enable_music_player / enable_newest_post / enable_hot_post / enable_lifetime / show_newreply / enable_tag_cloud / enable_category_cloud / enable_custom'));
    $el('text', 'joe_notice_title', null, $d('notice_title'), _t('公告标题'));
    $el('textarea', 'joe_site_notice', null, $d('site_notice'), _t('网站公告内容'), _t('支持 html'));
    $el('textarea', 'joe_reward_list', null, $d('reward_list'), _t('打赏列表'), _t('每行一条：标签|图片地址 或 标签|图片地址|html 内容'));
    $el('text', 'joe_qrcode_url', null, $d('qrcode_url'), _t('图片链接（图片模块）'));
    $el('text', 'joe_qrcode_title', null, $d('qrcode_title'), _t('图片标题'));
    $el('textarea', 'joe_qrcode_description', null, $d('qrcode_description'), _t('图片描述'));
    $el('text', 'joe_music_id', null, $d('music_id'), _t('歌单 ID'), _t('仅支持网易云歌单 ID'));
    $el('number', 'joe_show_newreply_num', null, $d('show_newreply_num'), _t('展示最新评论数'));
    $el('select', 'joe_tag_cloud_type', ['3d' => _t('3D 标签云'), 'list' => _t('标签列表')], $d('tag_cloud_type'), _t('标签云类型'));
    $el('radio', 'joe_tag_cloud_num_type', ['num' => _t('固定数量'), 'all' => _t('所有标签')], $d('tag_cloud_num_type'), _t('标签数量类型'));
    $el('text', 'joe_tag_cloud_num', null, $d('tag_cloud_num'), _t('标签数量'));
    $el('select', 'joe_tag_cloud_width', ['static' => _t('固定宽度'), 'responsive' => _t('自适应宽度')], $d('tag_cloud_width'), _t('标签宽度'));
    $el('select', 'joe_category_cloud_type', ['3d' => _t('3D 分类云'), 'list' => _t('分类列表')], $d('category_cloud_type'), _t('分类云类型'));
    $el('radio', 'joe_category_cloud_num_type', ['num' => _t('固定数量'), 'all' => _t('所有分类')], $d('category_cloud_num_type'), _t('分类数量类型'));
    $el('text', 'joe_category_cloud_num', null, $d('category_cloud_num'), _t('分类数量'));
    $el('select', 'joe_category_cloud_width', ['static' => _t('固定宽度'), 'responsive' => _t('自适应宽度')], $d('category_cloud_width'), _t('分类宽度'));
    $el('textarea', 'joe_aside_custom_code', null, $d('aside_custom_code'), _t('自定义 html 内容'));

    /* ================= 文章页 ================= */
    joe_form_heading($form, 'post');
    $el('radio', 'joe_enable_title_shadow', $boolOptions, $d('enable_title_shadow'), _t('标题阴影'));
    $el('text', 'joe_post_author_link', null, $d('post_author_link'), _t('文章页作者跳转链接'), _t('留空则跳转作者文章归档'));
    $el('radio', 'joe_enable_page_meta', $boolOptions, $d('enable_page_meta'), _t('页面元数据'));
    $el('radio', 'joe_enable_passage_tips', $boolOptions, $d('enable_passage_tips'), _t('温馨提示'));
    $el('number', 'joe_days', null, $d('days'), _t('失效提示天数'));
    $el('radio', 'joe_days_type', ['1' => _t('日期'), '0' => _t('天数')], $d('days_type'), _t('失效提示类型'));
    $el('textarea', 'joe_passage_tips_content', null, $d('passage_tips_content'), _t('温馨提示文案'), _t('为空则使用默认文案'));
    $el('select', 'joe_post_img_align', ['left' => _t('左对齐'), 'center' => _t('居中'), 'right' => _t('右对齐')], $d('post_img_align'), _t('图片对齐方式'));
    $el('text', 'joe_img_max_width', null, $d('img_max_width'), _t('图片最大宽度'));
    $el('radio', 'joe_enable_progress_bar', $boolOptions, $d('enable_progress_bar'), _t('启用文章浏览进度条'));
    $el('radio', 'joe_enable_toc', $boolOptions, $d('enable_toc'), _t('文章 TOC 目录'));
    $el('radio', 'joe_enable_mobile_toc', $boolOptions, $d('enable_mobile_toc'), _t('移动端文章 TOC 目录'));
    $el('text', 'joe_toc_depth', null, $d('toc_depth'), _t('TOC 目录默认展开层级'), _t('0~6'));
    $el('radio', 'joe_enable_relate_post', $boolOptions, $d('enable_relate_post'), _t('展示相关文章'));
    $el('number', 'joe_relate_post_max', null, $d('relate_post_max'), _t('相关文章最大条数'));
    $el('radio', 'joe_enable_edit', $boolOptions, $d('enable_edit'), _t('文章编辑'), _t('登录用户展示后台编辑入口'));
    $el('radio', 'joe_enable_comment', $boolOptions, $d('enable_comment'), _t('文章评论'));
    $el('radio', 'joe_enable_like', $boolOptions, $d('enable_like'), _t('文章点赞'));
    $el('radio', 'joe_enable_share', $boolOptions, $d('enable_share'), _t('文章分享'));
    $el('radio', 'joe_enable_copy', $boolOptions, $d('enable_copy'), _t('文章可复制'));
    $el('radio', 'joe_enable_indent', $boolOptions, $d('enable_indent'), _t('首行缩进'));
    $el('radio', 'joe_enable_copy_right_text', $boolOptions, $d('enable_copy_right_text'), _t('复制时追加版权信息'));
    $el('textarea', 'joe_copy_right_text', null, $d('copy_right_text'), _t('自定义版权文案'));
    $el('radio', 'joe_enable_share_weixin', $boolOptions, $d('enable_share_weixin'), _t('微信分享'));
    $el('radio', 'joe_enable_share_qq', $boolOptions, $d('enable_share_qq'), _t('QQ 分享'));
    $el('radio', 'joe_enable_share_qzone', $boolOptions, $d('enable_share_qzone'), _t('QQ 空间分享'));
    $el('radio', 'joe_enable_share_weibo', $boolOptions, $d('enable_share_weibo'), _t('微博分享'));
    $el('radio', 'joe_enable_share_link', $boolOptions, $d('enable_share_link'), _t('链接分享'));
    $el('textarea', 'joe_share_link_template', null, $d('share_link_template'), _t('链接分享内容模版'), _t('支持变量 {postUrl}、{postTitle}、{postAuthor}、{postDescription}、{BlogTitle}、{BlogUrl}'));
    $el('textarea', 'joe_passage_rights_content', null, $d('passage_rights_content'), _t('许可协议文案'));
    $el('radio', 'joe_enable_donate', $boolOptions, $d('enable_donate'), _t('开启打赏'));
    $el('text', 'joe_qrcode_zfb', null, $d('qrcode_zfb'), _t('支付宝二维码'));
    $el('text', 'joe_qrcode_wx', null, $d('qrcode_wx'), _t('微信二维码'));
    $el('text', 'joe_qrcode_qq', null, $d('qrcode_qq'), _t('QQ 二维码'));
    $el('textarea', 'joe_reward_code', null, $d('reward_code'), _t('打赏自定义代码'));

    /* ================= 标签页/分类页/归档页 ================= */
    joe_form_heading($form, 'pages');
    $el('text', 'joe_tags_title', null, $d('tags_title'), _t('标签页标题'));
    $el('select', 'joe_tags_type', ['card' => _t('卡片'), 'tag' => _t('标签')], $d('tags_type'), _t('展示形式'));
    $el('radio', 'joe_enable_tags_post_num', $boolOptions, $d('enable_tags_post_num'), _t('展示文章数'));
    $el('text', 'joe_categories_title', null, $d('categories_title'), _t('分类页标题'));
    $el('select', 'joe_categories_type', ['card' => _t('卡片'), 'tag' => _t('标签')], $d('categories_type'), _t('展示形式'));
    $el('radio', 'joe_enable_categories_post_num', $boolOptions, $d('enable_categories_post_num'), _t('展示文章数'));
    $el('text', 'joe_archives_title', null, $d('archives_title'), _t('归档页标题'));
    $el('text', 'joe_archives_empty_text', null, $d('archives_empty_text'), _t('空白状态文案'));
    $el('select', 'joe_archives_list_type', ['timeline' => _t('时间轴'), 'list' => _t('列表')], $d('archives_list_type'), _t('展示方式'));
    $el('select', 'joe_archives_timeline_metric', ['month' => _t('月'), 'year' => _t('年')], $d('archives_timeline_metric'), _t('时间轴展示维度'));
    $el('radio', 'joe_enable_archives_category', $boolOptions, $d('enable_archives_category'), _t('展示分类数据'));

    /* ================= 友链 ================= */
    joe_form_heading($form, 'links');
    $el('text', 'joe_links_title', null, $d('links_title'), _t('友链页标题'));
    $el('text', 'joe_links_default_logo', null, $d('links_default_logo'), _t('友链默认 logo'), _t('留空则使用主题自带图片'));
    $el('radio', 'joe_enable_links_random', $boolOptions, $d('enable_links_random'), _t('随机前往'));
    $el('textarea', 'joe_links_data', null, $d('links_data'), _t('友链数据'), _t('分组行：[分组名]；链接行：名称|网址|logo|描述（logo、描述可留空）'));

    /* ================= 留言页 ================= */
    $el('radio', 'joe_message_source', ['1' => _t('全部评论'), '0' => _t('仅留言板评论')], $d('message_source'), _t('留言页展示来源'));

    /* ================= 图库 ================= */
    joe_form_heading($form, 'photos');
    $el('radio', 'joe_photos_aggregate', $boolOptions, $d('photos_aggregate'), _t('自动聚合文章图片'), _t('图库页自动收录文章正文中的图片'));
    $el('text', 'joe_photos_aggregate_group', null, $d('photos_aggregate_group'), _t('聚合分组名'), _t('自动收录的图片归入该分组，留空默认「文章」'));

    /* ================= 页脚 ================= */
    joe_form_heading($form, 'footer');
    $el('radio', 'joe_enable_footer', $boolOptions, $d('enable_footer'), _t('启用页脚'));
    $el('select', 'joe_footer_position', ['none' => _t('默认位置'), 'fixed' => _t('底部固定')], $d('footer_position'), _t('页脚位置'));
    $el('radio', 'joe_enable_full_footer', $boolOptions, $d('enable_full_footer'), _t('100%宽度'));
    $el('radio', 'joe_enable_birthday', $boolOptions, $d('enable_birthday'), _t('展示博客运行时间'));
    $el('text', 'joe_custom_birthday', null, $d('custom_birthday'), _t('自定义博客起始时间'), _t('示例：2021/11/11 06:30'));
    $el('radio', 'joe_enable_icp', $boolOptions, $d('enable_icp'), _t('展示 ICP'));
    $el('radio', 'joe_enable_police', $boolOptions, $d('enable_police'), _t('展示公网安备'));
    $el('radio', 'joe_enable_powerby', $boolOptions, $d('enable_powerby'), _t('展示 PowerBy'), _t('为了尊重作者的权益，建议展示'));
    $el('select', 'joe_driven_by', [
        'none'    => _t('不展示(默认)'),
        'aliyun'  => _t('阿里云'),
        'tencent' => _t('腾讯云'),
        'baidu'   => _t('百度云'),
        'upyun'   => _t('又拍云'),
        'qiniu'   => _t('七牛云'),
        'huawei'  => _t('华为云'),
        'jinshan' => _t('金山云'),
        'custom'  => _t('自定义'),
    ], $d('driven_by'), _t('云服务提供商'));
    $el('text', 'joe_driven_by_custom_url', null, $d('driven_by_custom_url'), _t('云服务跳转链接（自定义）'));
    $el('text', 'joe_driven_by_custom_img', null, $d('driven_by_custom_img'), _t('云服务图片地址（自定义）'));
    $el('radio', 'joe_enable_rss', $boolOptions, $d('enable_rss'), _t('展示 RSS'));
    $el('radio', 'joe_enable_sitemap', $boolOptions, $d('enable_sitemap'), _t('展示站点地图'));
    $el('radio', 'joe_enable_busuanzi', $boolOptions, $d('enable_busuanzi'), _t('展示访问量数据'), _t('使用不蒜子统计'));

    /* ================= 自定义 ================= */
    joe_form_heading($form, 'custom');
    $el('text', 'joe_favicon', null, $d('favicon'), _t('自定义 favicon'));
    $el('text', 'joe_custom_font', null, $d('custom_font'), _t('自定义网站字体'), _t('woff2 字体文件链接'));
    $el('text', 'joe_iconfont', null, $d('iconfont'), _t('字体图标链接'));
    $el('textarea', 'joe_custom_css', null, $d('custom_css'), _t('自定义 CSS'));
    $el('textarea', 'joe_custom_js_head', null, $d('custom_js_head'), _t('自定义 JS（head）'));
    $el('textarea', 'joe_custom_js_body', null, $d('custom_js_body'), _t('自定义 JS（body）'));
    $el('radio', 'joe_show_loaded_time', $boolOptions, $d('show_loaded_time'), _t('控制台输出页面加载耗时'));

    /* ================= 其他 ================= */
    joe_form_heading($form, 'other');
    $el('radio', 'joe_enable_debug', $boolOptions, $d('enable_debug'), _t('调试模式'), _t('开启后页面展示 vconsole 调试按钮'));
    $el('radio', 'joe_rip_mode', $boolOptions, $d('rip_mode'), _t('RIP 模式'), _t('全站黑白化'));
    $el('radio', 'joe_enable_clean_mode', $boolOptions, $d('enable_clean_mode'), _t('绿色模式'), _t('隐藏打赏、最新评论等模块'));
    $el('radio', 'joe_check_baidu_collect', $boolOptions, $d('check_baidu_collect'), _t('检查百度收录情况'));
    $el('text', 'joe_baidu_token', null, $d('baidu_token'), _t('百度推送 Token'));
    $el('radio', 'joe_enable_console_theme', $boolOptions, $d('enable_console_theme'), _t('控制台输出主题信息'));
}

/**
 * 主题设置保存 / 恢复处理
 *
 * 定义此函数后 Typecho 不再使用默认保存逻辑，由本函数负责将设置
 * 持久化到 theme:{主题名} 单条 option（与 1.3 默认行为一致），
 * 并在检测到备份 JSON 时执行恢复合并。
 */
function themeConfigHandle($settings, bool $isInit)
{
    $settings = json_decode(json_encode($settings), true);
    if (!is_array($settings)) {
        return;
    }

    /* 备份恢复：文本框中含备份 JSON 时合并覆盖 */
    $backup = trim((string) ($settings['joe_backup_box'] ?? ''));
    if ($backup !== '' && strpos($backup, '_joe_backup') !== false) {
        $data = json_decode($backup, true);
        if (is_array($data) && isset($data['values']) && is_array($data['values'])) {
            foreach ($data['values'] as $k => $v) {
                if (is_string($k) && strpos($k, 'joe_') === 0 && strpos($k, 'joe_heading_') !== 0) {
                    $settings[$k] = $v;
                }
            }
        }
    }

    /* 剔除内部辅助字段（分组标题 / 备份框） */
    unset($settings['joe_backup_box']);
    foreach (array_keys($settings) as $k) {
        if (strpos((string) $k, 'joe_heading_') === 0) {
            unset($settings[$k]);
        }
    }

    /* 持久化到 theme:{主题} 单条 option */
    $theme = basename(dirname(__FILE__));
    $db = \Typecho\Db::get();
    $json = json_encode($settings);
    $exist = $db->fetchRow($db->select('name')->from('table.options')
        ->where('name = ?', 'theme:' . $theme)->limit(1));

    if ($exist) {
        $db->query($db->update('table.options')->rows(['value' => $json])
            ->where('name = ?', 'theme:' . $theme));
    } else {
        $db->query($db->insert('table.options')->rows([
            'name'  => 'theme:' . $theme,
            'user'  => 0,
            'value' => $json,
        ]));
    }

    /* 清理历史遗留的逐项 joe_* option 行，统一以 theme:{主题} 为准 */
    $legacy = $db->fetchAll($db->select('name')->from('table.options')->where('name LIKE ?', 'joe%'));
    foreach ($legacy as $row) {
        if (strpos($row['name'], 'joe_') === 0 && strpos($row['name'], 'joe_heading_') !== 0) {
            $db->query($db->delete('table.options')->where('name = ?', $row['name']));
        }
    }
}

/* ============================================================
 * 辅助函数
 * ============================================================ */

/**
 * 读取主题配置
 */
function joe_opt(string $key, $default = null)
{
    static $cache = null;

    if ($cache === null) {
        $cache = joe_default_config();
        $options = \Utils\Helper::options();
        foreach ($cache as $k => $v) {
            $val = $options->{'joe_' . $k};
            if ($val !== null && $val !== '') {
                $cache[$k] = $val;
            } elseif ($val === '' && in_array($k, [
                'nickname', 'motto', 'site_notice', 'notice_title', 'qrcode_title',
                'qrcode_description', 'qq_text', 'copy_right_text', 'offscreen_title_leave',
                'offscreen_title_back', 'passage_tips_content', 'share_link_template',
                'links_title', 'tags_title', 'categories_title', 'archives_title',
                'big_banner_title', 'custom_birthday', 'loading_bar_height', 'scrollbar_width',
            ])) {
                // 明确允许为空的文本项
                $cache[$k] = '';
            }
        }
    }

    return $cache[$key] ?? $default;
}

/**
 * 是否开启某开关
 */
function joe_is_on(string $key): bool
{
    return joe_opt($key) === '1' || joe_opt($key) === 1 || joe_opt($key) === true;
}

/**
 * 将多行文本配置解析为二维数组（按 | 分隔）
 */
function joe_lines(string $key): array
{
    $raw = (string) joe_opt($key);
    if (trim($raw) === '') {
        return [];
    }
    $lines = preg_split('/\r\n|\r|\n/', $raw);
    $result = [];
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '') {
            continue;
        }
        $result[] = array_map('trim', explode('|', $line));
    }

    return $result;
}

/**
 * 主题资源地址
 */
function joe_theme_url(): string
{
    return \Utils\Helper::options()->themeUrl;
}

function joe_asset(string $path): string
{
    return joe_theme_url() . '/assets/' . ltrim($path, '/');
}

/**
 * JS / CSS 资源根路径（兼容 Halo 的外部资源地址配置）
 */
function joe_res_url(): string
{
    $external = trim((string) joe_opt('source_link'));
    return $external !== '' ? rtrim($external, '/') : joe_theme_url();
}

/**
 * 站点地址（无结尾斜杠）
 */
function joe_site_url(): string
{
    return rtrim(\Utils\Helper::options()->siteUrl, '/');
}

function joe_site_title(): string
{
    return \Utils\Helper::options()->title;
}

function joe_site_logo(): string
{
    $logo = \Utils\Helper::options()->logoUrl;
    return $logo ?: joe_asset('img/Joe3.png');
}

/**
 * 默认缩略图 / 预载图（带主题缺省值）
 */
function joe_lazyload_thumbnail(): string
{
    return joe_opt('lazyload_thumbnail') ?: joe_asset('img/lazyload.gif');
}

function joe_fallback_thumbnail(): string
{
    return joe_opt('fallback_thumbnail') ?: joe_asset('img/default_thumbnail.png');
}

function joe_lazyload_avatar(): string
{
    return joe_opt('lazyload_avatar') ?: joe_asset('svg/spinner-preloader.svg');
}

function joe_default_avatar(): string
{
    return joe_opt('default_avatar') ?: joe_asset('img/peeps-avatar.png');
}

function joe_default_links_logo(): string
{
    return joe_opt('links_default_logo') ?: joe_asset('img/default_links_logo.png');
}

/**
 * 博主显示名称
 */
function joe_blogger_name(): string
{
    return (string) (joe_opt('nickname') ?: joe_site_title());
}

/**
 * 从文本中提取第一张图片
 */
function joe_first_image(string $text): string
{
    // markdown 图片
    if (preg_match('/!\[[^\]]*\]\(([^)\s]+)/i', $text, $m)) {
        return trim($m[1]);
    }
    // html 图片
    if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $text, $m)) {
        return trim($m[1]);
    }

    return '';
}

/**
 * 解析文章封面
 * 优先级：自定义字段 thumb/cover > 正文第一张图 > 随机图 > 默认缩略图
 */
/**
 * 随机图 API 地址唯一化
 *
 * 同一随机图 API 地址会被多篇文章复用，若 URL 完全相同浏览器只请求一次，
 * 导致所有文章显示同一张图；为每篇文章每次请求追加唯一参数即可随机。
 * 命中规则：URL 与随机图 API（或开启随机图后的默认缩略图地址，用户常把
 * API 填在那里）剥离协议后前缀一致；其他地址原样返回。
 */
function joe_unique_random_url(string $url, int $seed = 0): string
{
    $candidates = [];
    $api = trim((string) joe_opt('random_img_api_url'));
    if ($api !== '') {
        $candidates[] = $api;
    }
    if (joe_is_on('enable_random_img_api')) {
        $thumb = trim((string) joe_opt('post_thumbnail'));
        if ($thumb !== '') {
            $candidates[] = $thumb;
        }
    }
    if (!$candidates) {
        return $url;
    }

    $bare = preg_replace('#^https?://#i', '', $url);
    foreach ($candidates as $candidate) {
        $bareCandidate = preg_replace('#^https?://#i', '', $candidate);
        if ($bareCandidate === '' || strpos($bare, $bareCandidate) !== 0) {
            continue;
        }
        $sep = strpos($url, '?') === false ? '?' : '&';

        return $url . $sep . '_r=' . $seed . '&_t=' . mt_rand() . mt_rand(100, 999);
    }

    return $url;
}

function joe_post_cover($widget): string
{
    $fields = $widget->fields ?? null;
    $cover = '';
    try {
        if ($fields && isset($fields->thumb) && trim((string) $fields->thumb) !== '') {
            $cover = (string) $fields->thumb;
        } elseif ($fields && isset($fields->cover) && trim((string) $fields->cover) !== '') {
            $cover = (string) $fields->cover;
        }
    } catch (\Throwable $e) {
        $cover = '';
    }

    if ($cover === '') {
        $cover = joe_first_image((string) ($widget->text ?? ''));
    }

    if ($cover === '' && joe_is_on('enable_random_img_api') && trim((string) joe_opt('random_img_api_url')) !== '') {
        $cover = trim((string) joe_opt('random_img_api_url'));
    }

    if ($cover === '') {
        $cover = (string) joe_opt('post_thumbnail');
    }

    /* 命中随机图 API 的封面：每篇文章、每次请求生成唯一参数，避免浏览器缓存同一张图 */
    return $cover !== '' ? joe_unique_random_url($cover, (int) $widget->cid) : '';
}

/**
 * 文章摘要
 */
function joe_excerpt($widget, int $length = 100): string
{
    $excerpt = '';
    ob_start();
    try {
        $widget->excerpt($length, '…');
        $excerpt = ob_get_clean();
    } catch (\Throwable $e) {
        ob_end_clean();
        $excerpt = '';
    }

    $excerpt = trim(strip_tags($excerpt));
    if (mb_strlen($excerpt) > $length) {
        $excerpt = mb_substr($excerpt, 0, $length) . '…';
    }

    return $excerpt;
}

/**
 * 给文章 HTML 的 h1~h6 补充锚点 id（TOC 依赖）
 *
 * 魔改版 tocbot 生成目录链接时直接取标题元素的 id，不会自动生成；
 * Halo 的 Markdown 渲染会给标题加 id，而 Typecho（HyperDown）不会，这里补齐。
 */
function joe_heading_ids(string $html): string
{
    $used = [];

    return preg_replace_callback(
        '/<h([1-6])([^>]*)>(.*?)<\/h\1>/is',
        function ($m) use (&$used) {
            list(, $level, $attrs, $inner) = $m;

            if (preg_match('/\bid\s*=\s*["\'][^"\']*["\']/i', $attrs)) {
                return $m[0];
            }

            $text = trim(preg_replace('/\s+/u', ' ', strip_tags($inner)));
            $slug = preg_replace('/[^\p{Han}\p{L}\p{Nd}_]+/u', '-', $text);
            $slug = trim((string) $slug, '-');
            if ($slug === '') {
                $slug = 'section';
            }
            if (preg_match('/^\d/u', $slug)) {
                $slug = 'h-' . $slug;
            }

            $base = $slug;
            $i = 2;
            while (isset($used[$slug])) {
                $slug = $base . '-' . $i++;
            }
            $used[$slug] = true;

            return '<h' . $level . rtrim($attrs) . ' id="' . htmlspecialchars($slug, ENT_QUOTES) . '">' . $inner . '</h' . $level . '>';
        },
        $html
    );
}

/**
 * 读取内容自定义字段
 */
function joe_field($widget, string $name, string $default = '')
{
    try {
        $fields = $widget->fields;
        if ($fields && isset($fields->{$name}) && (string) $fields->{$name} !== '') {
            return (string) $fields->{$name};
        }
    } catch (\Throwable $e) {
        // ignore
    }

    return $default;
}

/**
 * 数字自定义字段（views / likes）
 */
function joe_get_num_field(int $cid, string $name): int
{
    try {
        $db = \Typecho\Db::get();
        $row = $db->fetchRow($db->select('int_value', 'str_value')->from('table.fields')
            ->where('cid = ?', $cid)->where('name = ?', $name)->limit(1));

        if ($row === null) {
            return 0;
        }
        if ($row['int_value'] !== null && (int) $row['int_value'] > 0) {
            return (int) $row['int_value'];
        }

        return (int) $row['str_value'];
    } catch (\Throwable $e) {
        return 0;
    }
}

function joe_set_num_field(int $cid, string $name, int $value): void
{
    try {
        $db = \Typecho\Db::get();
        $exist = $db->fetchRow($db->select('cid')->from('table.fields')
            ->where('cid = ?', $cid)->where('name = ?', $name)->limit(1));

        if ($exist) {
            $db->query($db->update('table.fields')->rows([
                'type'      => 'int',
                'int_value' => $value,
            ])->where('cid = ?', $cid)->where('name = ?', $name));
        } else {
            $db->query($db->insert('table.fields')->rows([
                'cid'       => $cid,
                'name'      => $name,
                'type'      => 'int',
                'int_value' => $value,
            ]));
        }
    } catch (\Throwable $e) {
        // ignore
    }
}

function joe_views_num(int $cid): int
{
    return joe_get_num_field($cid, 'views');
}

function joe_likes_num(int $cid): int
{
    return joe_get_num_field($cid, 'likes');
}

/**
 * 浏览量自增（文章页调用）
 */
function joe_count_view(int $cid): void
{
    $views = joe_get_num_field($cid, 'views');
    joe_set_num_field($cid, 'views', $views + 1);
}

/**
 * 点赞 ajax 处理（header.php 中调用）
 * 访问 /?joe_action=like&cid=1 返回 json
 */
function joe_handle_ajax(): void
{
    $action = isset($_GET['joe_action']) ? $_GET['joe_action'] : '';
    if ($action === '') {
        return;
    }
    if ($action === 'theme_backup') {
        joe_handle_theme_backup();
    }
    if (!in_array($action, ['like', 'view'])) {
        return;
    }

    header('Content-Type: application/json; charset=UTF-8');
    @session_start();
    $cid = isset($_GET['cid']) ? (int) $_GET['cid'] : 0;

    if ($cid <= 0) {
        echo json_encode(['code' => 0, 'message' => '参数错误']);
        exit;
    }

    if ($action === 'view') {
        joe_count_view($cid);
        echo json_encode(['code' => 1, 'views' => joe_views_num($cid)]);
        exit;
    }

    $key = 'joe_liked_' . $cid;
    if (!empty($_SESSION[$key])) {
        echo json_encode(['code' => 0, 'message' => '已经点过赞啦', 'likes' => joe_likes_num($cid)]);
        exit;
    }

    $_SESSION[$key] = 1;
    joe_set_num_field($cid, 'likes', joe_likes_num($cid) + 1);
    echo json_encode(['code' => 1, 'likes' => joe_likes_num($cid)]);
    exit;
}

/**
 * 主题设置数据库备份 ajax（后台设置页经前台端点调用）
 * GET/POST /?joe_action=theme_backup&op=save|list|get|delete
 * 备份以 option 形式存储：name = theme:joe3_backup_<YmdHis>
 */
function joe_handle_theme_backup(): void
{
    header('Content-Type: application/json; charset=UTF-8');

    /* 仅管理员可用 */
    try {
        $user = \Typecho\Widget::widget('Widget\User@joe_backup');
        if (!$user->hasLogin() || $user->group !== 'administrator') {
            echo json_encode(['code' => 0, 'message' => '需要管理员权限']);
            exit;
        }
    } catch (\Throwable $e) {
        echo json_encode(['code' => 0, 'message' => '用户态校验失败']);
        exit;
    }

    $op = isset($_REQUEST['op']) ? (string) $_REQUEST['op'] : '';
    $prefix = 'theme:joe3_backup_';
    $db = \Typecho\Db::get();

    /* 写操作校验同源 */
    if (in_array($op, ['save', 'delete'], true)) {
        $ref = isset($_SERVER['HTTP_REFERER']) ? (string) $_SERVER['HTTP_REFERER'] : '';
        $site = '';
        try {
            $site = (string) \Typecho\Widget::widget('Widget\Options@joe_backup')->siteUrl;
        } catch (\Throwable $e) {
            // ignore
        }
        if ($site === '' || $ref === '' || strpos($ref, $site) !== 0) {
            echo json_encode(['code' => 0, 'message' => '来源校验失败']);
            exit;
        }
    }

    try {
        if ($op === 'save') {
            $raw = file_get_contents('php://input');
            $data = json_decode((string) $raw, true);
            if (!is_array($data) || !isset($data['values']) || !is_array($data['values']) || count($data['values']) === 0) {
                echo json_encode(['code' => 0, 'message' => '备份内容无效']);
                exit;
            }
            $data['_joe_backup'] = 1;
            $data['theme'] = 'joe3';
            $data['time'] = date('Y-m-d H:i:s');
            $name = $prefix . date('YmdHis');
            $db->query($db->insert('table.options')->rows([
                'name'  => $name,
                'user'  => 0,
                'value' => json_encode($data, JSON_UNESCAPED_UNICODE),
            ]));
            echo json_encode(['code' => 1, 'name' => $name, 'message' => '备份成功']);
            exit;
        }

        if ($op === 'list') {
            $rows = $db->fetchAll($db->select('name', 'value')->from('table.options')
                ->where('name LIKE ?', $prefix . '%')
                ->order('name', \Typecho\Db::SORT_DESC));
            $list = [];
            foreach ($rows as $row) {
                $data = json_decode((string) $row['value'], true);
                $list[] = [
                    'name'  => $row['name'],
                    'time'  => isset($data['time']) ? (string) $data['time'] : substr($row['name'], strlen($prefix)),
                    'count' => isset($data['values']) && is_array($data['values']) ? count($data['values']) : 0,
                ];
            }
            echo json_encode(['code' => 1, 'list' => $list]);
            exit;
        }

        if ($op === 'get') {
            $name = isset($_GET['name']) ? (string) $_GET['name'] : '';
            if (strpos($name, $prefix) !== 0) {
                echo json_encode(['code' => 0, 'message' => '参数错误']);
                exit;
            }
            $row = $db->fetchRow($db->select('value')->from('table.options')
                ->where('name = ?', $name)->limit(1));
            if (!$row) {
                echo json_encode(['code' => 0, 'message' => '备份不存在']);
                exit;
            }
            echo json_encode(['code' => 1, 'data' => $row['value']]);
            exit;
        }

        if ($op === 'delete') {
            $name = isset($_REQUEST['name']) ? (string) $_REQUEST['name'] : '';
            if (strpos($name, $prefix) !== 0) {
                echo json_encode(['code' => 0, 'message' => '参数错误']);
                exit;
            }
            $db->query($db->delete('table.options')->where('name = ?', $name));
            echo json_encode(['code' => 1, 'message' => '已删除']);
            exit;
        }

        echo json_encode(['code' => 0, 'message' => '未知操作']);
        exit;
    } catch (\Throwable $e) {
        echo json_encode(['code' => 0, 'message' => '数据库操作失败']);
        exit;
    }
}

/**
 * 评论者头像地址
 */
function joe_avatar_url(string $mail, int $size = 40): string
{
    $secure = false;
    try {
        $secure = \Typecho\Request::getInstance()->isSecure();
    } catch (\Throwable $e) {
        $secure = (isset($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off');
    }

    return \Typecho\Common::gravatarUrl($mail, $size, 'X', null, $secure);
}

/**
 * 时间格式化
 */
function joe_date(string $format, $time): string
{
    if (is_numeric($time)) {
        return date($format, (int) $time);
    }

    return date($format, strtotime((string) $time) ?: time());
}

/**
 * 分类列表（带文章数）
 */
function joe_categories_all(): array
{
    $categories = [];
    $widget = \Typecho\Widget::widget('Widget_Metas_Category_List@joe_cats_' . ++joe::$widgetSeq);
    $widget->to($category);
    while ($category->next()) {
        $categories[] = [
            'name'  => $category->name,
            'slug'  => $category->slug,
            'url'   => $category->permalink,
            'count' => (int) $category->count,
        ];
    }

    return $categories;
}

function joe_tags_all(): array
{
    $tags = [];
    $widget = \Typecho\Widget::widget('Widget_Metas_Tag_Cloud@joe_tags_' . ++joe::$widgetSeq);
    $widget->to($tag);
    while ($tag->next()) {
        $tags[] = [
            'name'  => $tag->name,
            'slug'  => $tag->slug,
            'url'   => $tag->permalink,
            'count' => (int) $tag->count,
        ];
    }

    return $tags;
}

/**
 * 最新文章列表
 */
function joe_recent_posts(int $pageSize = 5): array
{
    $posts = [];
    $widget = \Typecho\Widget::widget('Widget_Contents_Post_Recent@joe_recent_' . ++joe::$widgetSeq, 'pageSize=' . max(1, $pageSize));
    $widget->to($post);
    while ($post->next()) {
        $posts[] = [
            'title' => $post->title,
            'url'   => $post->permalink,
        ];
    }

    return $posts;
}

/**
 * 按浏览量排序的热门文章
 */
function joe_hot_posts(int $pageSize = 5): array
{
    static $cache = [];
    $cacheKey = 'hot_' . $pageSize;
    if (isset($cache[$cacheKey])) {
        return $cache[$cacheKey];
    }

    $posts = [];
    try {
        $db = \Typecho\Db::get();
        $rows = $db->fetchAll($db->select('table.contents.cid', 'table.contents.title', 'table.contents.slug', 'table.contents.created', 'table.contents.text')
            ->from('table.contents')
            ->where('table.contents.type = ?', 'post')
            ->where('table.contents.status = ?', 'publish')
            ->where("table.contents.password IS NULL OR table.contents.password = ''")
            ->order('table.contents.created', \Typecho\Db::SORT_DESC)
            ->limit(max(1, $pageSize) * 20));

        $withViews = [];
        foreach ($rows as $row) {
            $withViews[] = [
                'title'   => $row['title'],
                'slug'    => $row['slug'],
                'created' => (int) $row['created'],
                'type'    => 'post',
                'cover'   => joe_first_image((string) $row['text']),
                'views'   => joe_get_num_field((int) $row['cid'], 'views'),
            ];
        }
        usort($withViews, function ($a, $b) {
            return $b['views'] <=> $a['views'];
        });

        foreach (array_slice($withViews, 0, max(1, $pageSize)) as $item) {
            $params = [
                'title'     => $item['title'],
                'slug'      => $item['slug'],
                'type'      => 'post',
                'directory' => [],
                'year'      => date('Y', $item['created']),
                'month'     => date('n', $item['created']),
                'day'       => date('j', $item['created']),
            ];
            $posts[] = [
                'title' => $item['title'],
                'url'   => \Typecho\Router::url('post', $params, \Utils\Helper::options()->index),
                'cover' => $item['cover'],
            ];
        }
    } catch (\Throwable $e) {
        $posts = [];
    }

    if (count($posts) === 0) {
        $posts = joe_recent_posts($pageSize);
    }

    $cache[$cacheKey] = $posts;

    return $posts;
}

/**
 * 最新评论列表
 */
function joe_recent_comments(int $pageSize = 3): array
{
    $comments = [];
    $widget = \Typecho\Widget::widget('Widget_Comments_Recent@joe_reply_' . ++joe::$widgetSeq, 'pageSize=' . max(1, $pageSize));
    $widget->to($comment);
    while ($comment->next()) {
        $comments[] = [
            'author'   => $comment->author,
            'url'      => $comment->url,
            'permalink'=> $comment->permalink,
            'date'     => $comment->date('Y-m-d H:i:s'),
            'mail'     => $comment->mail,
            'text'     => strip_tags(trim($comment->text)),
        ];
    }

    return $comments;
}

/**
 * 站点统计
 */
function joe_stats(): array
{
    static $stats = null;
    if ($stats !== null) {
        return $stats;
    }

    $widget = \Widget\Stat::alloc();
    $stats = [
        'posts'    => (int) $widget->publishedPostsNum,
        'comments' => (int) $widget->publishedCommentsNum,
        'categories' => (int) $widget->categoriesNum,
        'tags'     => (int) $widget->tagsNum,
    ];
    $stats['tags'] = max($stats['tags'], count(joe_tags_all()));
    $stats['categories'] = max($stats['categories'], count(joe_categories_all()));

    return $stats;
}

/**
 * 归档数据（按 年/月 分组）
 */
function joe_archives_data(): array
{
    $data = [];
    try {
        $db = \Typecho\Db::get();
        $rows = $db->fetchAll($db->select('cid', 'title', 'slug', 'created', 'type')
            ->from('table.contents')
            ->where('type = ?', 'post')
            ->where('status = ?', 'publish')
            ->where("password IS NULL OR password = ''")
            ->order('created', \Typecho\Db::SORT_DESC));

        foreach ($rows as $row) {
            $year = date('Y', $row['created']);
            $month = date('n', $row['created']);
            $params = [
                'slug'      => $row['slug'],
                'type'      => 'post',
                'directory' => [],
                'year'      => $year,
                'month'     => $month,
                'day'       => date('j', $row['created']),
            ];
            $item = [
                'title' => $row['title'],
                'url'   => \Typecho\Router::url('post', $params, \Utils\Helper::options()->index),
                'date'  => date('Y-m-d', $row['created']),
            ];

            $data[$year][$month][] = $item;
        }
    } catch (\Throwable $e) {
        $data = [];
    }

    return $data;
}

/**
 * 分页导航（Joe 样式）
 */
function joe_page_nav($widget, string $splitWord = '...'): void
{
    $widget->pageNav(
        '<i class="joe-font joe-icon-prev"></i>',
        '<i class="joe-font joe-icon-next"></i>',
        3,
        $splitWord,
        [
            'wrapTag'      => 'ul',
            'wrapClass'    => 'joe_pagination',
            'itemTag'      => 'li',
            'textTag'      => 'a',
            'currentClass' => 'active',
            'prevClass'    => 'prev',
            'nextClass'    => 'next',
        ]
    );
}

/**
 * 加载更多（获取下一页地址）
 */
function joe_next_page_url($widget): ?string
{
    if (!$widget->have()) {
        return null;
    }

    ob_start();
    $widget->pageLink('NEXT', 'next');
    $html = ob_get_clean();

    if (preg_match('/href="([^"]+)"/', $html, $m)) {
        return $m[1];
    }

    return null;
}

function joe_load_more($widget): void
{
    $next = joe_next_page_url($widget);
    if ($next === null) {
        return;
    }
    ?>
    <div class="joe_load_container">
        <div class="joe_load" data-next="<?php echo $next; ?>">查看更多</div>
    </div>
    <?php
}

/**
 * 评论列表回调（Typecho threadedComments 机制）
 */
function threadedComments($comments, $options)
{
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    }
    ?>
    <li id="li-<?php $comments->theId(); ?>" class="comment-body<?php
    if ($comments->levels > 0) {
        echo ' comment-child';
        $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
    } else {
        echo ' comment-parent';
    }
    $comments->alt(' comment-odd', ' comment-even');
    echo $commentClass;
    ?>">
        <div class="joe_comment__avatar">
            <img src="<?php echo joe_avatar_url((string) $comments->mail, 48); ?>"
                 alt="<?php $comments->author(false); ?>" width="48" height="48" loading="lazy" />
        </div>
        <div class="joe_comment__body">
            <div class="joe_comment__meta">
                <?php if ($comments->url): ?>
                    <a href="<?php $comments->url(); ?>" rel="nofollow" target="_blank"
                       class="joe_comment__author"><?php $comments->author(false); ?></a>
                <?php else: ?>
                    <span class="joe_comment__author"><?php $comments->author(false); ?></span>
                <?php endif; ?>
                <?php if ($comments->authorId && $comments->authorId == $comments->ownerId): ?>
                    <span class="joe_comment__badge">博主</span>
                <?php endif; ?>
                <span class="joe_comment__date"><?php $comments->date('Y-m-d H:i'); ?></span>
            </div>
            <div class="joe_comment__content">
                <?php $comments->content(); ?>
            </div>
            <div class="joe_comment__actions">
                <?php $comments->reply('回复'); ?>
            </div>
            <?php if ($comments->children): ?>
                <div class="joe_comment__children"><?php $comments->threadedComments(); ?></div>
            <?php endif; ?>
        </div>
    </li>
    <?php
}
