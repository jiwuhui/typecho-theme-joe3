<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * 首页轮播图（移植自 Halo 版 banner.html + banner_item_data.html）
 * 数据格式（每行一条）：
 *   文章cid
 *   custom|标题|描述|链接|图片
 *   hot|数量
 */
$joeBannerRows = joe_lines('banner_data_group');
if (empty($joeBannerRows)) {
    return;
}

/**
 * 输出单个轮播 slide
 */
function joe_banner_slide(string $cover, string $title, string $excerpt, string $href): void
{
    if ($cover === '') {
        $cover = (string) joe_opt('post_thumbnail');
    }
    $clickable = trim($href) !== '' ? ' clickable' : '';
    $link = trim($href) !== '' ? $href : 'javascript:;';
    ?>
    <div class="swiper-slide">
        <a class="item<?php echo $clickable; ?>" href="<?php echo $link; ?>" target="_blank"
           rel="noopener noreferrer nofollow">
            <img width="100%" height="100%" class="thumbnail lazyload" data-src="<?php echo $cover; ?>"
                 src="<?php echo joe_opt('banner_lazyload_img') ?: joe_asset('img/lazyload_h.gif'); ?>"
                 onerror="Joe.errorImg(this, 'HomeErrImg')" alt="<?php echo $title; ?>" />
            <div class="title-row">
                <h3 class="title"><?php echo $title; ?></h3>
                <?php if ($excerpt !== ''): ?>
                    <p class="subtitle"><?php echo $excerpt; ?></p>
                <?php endif; ?>
            </div>
            <i class="joe-font joe-icon-zhifeiji"></i>
        </a>
    </div>
    <?php
}
?>
<div class="joe_index__banner">
    <div class="swiper">
        <div class="swiper-wrapper">
            <?php foreach ($joeBannerRows as $joeRow): ?>
                <?php
                $joeType = $joeRow[0] ?? '';
                if ($joeType === 'custom' && count($joeRow) >= 5) {
                    joe_banner_slide(
                        $joeRow[4] ?? '',
                        $joeRow[1] ?? '',
                        $joeRow[2] ?? '',
                        $joeRow[3] ?? ''
                    );
                } elseif ($joeType === 'hot') {
                    foreach (joe_hot_posts((int) ($joeRow[1] ?? 3) ?: 3) as $joeHotPost) {
                        joe_banner_slide(
                            $joeHotPost['cover'] ?? '',
                            $joeHotPost['title'],
                            '',
                            $joeHotPost['url']
                        );
                    }
                } else {
                    /* 视为文章 cid */
                    $joeCid = (int) $joeType;
                    if ($joeCid > 0) {
                        try {
                            $db = \Typecho\Db::get();
                            $joeRow2 = $db->fetchRow($db->select('cid', 'title', 'slug', 'created', 'text', 'type')
                                ->from('table.contents')
                                ->where('cid = ?', $joeCid)
                                ->where('type = ?', 'post')
                                ->where('status = ?', 'publish')
                                ->limit(1));
                            if ($joeRow2) {
                                $joeCreated = (int) $joeRow2['created'];
                                $joeParams = [
                                    'title'     => $joeRow2['title'],
                                    'slug'      => $joeRow2['slug'],
                                    'type'      => 'post',
                                    'directory' => [],
                                    'year'      => date('Y', $joeCreated),
                                    'month'     => date('n', $joeCreated),
                                    'day'       => date('j', $joeCreated),
                                ];
                                $joePermalink = \Typecho\Router::url('post', $joeParams, \Utils\Helper::options()->index);
                                $joeCover = joe_first_image((string) $joeRow2['text']);
                                joe_banner_slide(
                                    $joeCover ?: (string) joe_opt('post_thumbnail'),
                                    $joeRow2['title'],
                                    '',
                                    $joePermalink
                                );
                            }
                        } catch (\Throwable $e) {
                            // ignore invalid cid
                        }
                    }
                }
                ?>
            <?php endforeach; ?>
        </div>
        <?php if (joe_is_on('enable_banner_pagination')): ?>
            <div class="swiper-pagination"></div>
        <?php endif; ?>
        <?php if (joe_is_on('enable_banner_handle') && joe_is_on('enable_banner_switch_button')): ?>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        <?php endif; ?>
    </div>
</div>
