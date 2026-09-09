<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * 精品分类（移植自 Halo 版 hot_category.html）
 * 数据格式（每行一条）：分类名 或 标题|链接|图片
 */
$joeHotRows = joe_lines('data_hot_category');
if (empty($joeHotRows)) {
    return;
}
?>
<div class="joe_index__hot">
    <div class="joe_index__title">
        <ul class="joe_index__title-title default">
            <li class="item active" data-type="created">精品分类</li>
        </ul>
        <div class="joe_index__title-notice">
            <a href="<?php echo Typecho\Common::url('categories.html', joe_site_url()); ?>" target="_blank"
               rel="noopener noreferrer nofollow"><i class="joe-font joe-icon-application"></i>全部分类</a>
        </div>
    </div>
    <ul class="joe_index__hot-list hotlist">
        <?php foreach ($joeHotRows as $joeHotRow): ?>
            <?php
            $joeHotTitle = '';
            $joeHotLink = '#';
            $joeHotImg = joe_asset('img/hot_cover1.jpg');
            $joeFirst = $joeHotRow[0] ?? '';
            if (count($joeHotRow) >= 3) {
                /* 自定义数据 */
                $joeHotTitle = $joeFirst;
                $joeHotLink = $joeHotRow[1];
                $joeHotImg = $joeHotRow[2] ?: $joeHotImg;
            } else {
                /* 分类名 */
                foreach (joe_categories_all() as $joeCat) {
                    if ($joeCat['name'] === $joeFirst) {
                        $joeHotTitle = $joeCat['name'];
                        $joeHotLink = $joeCat['url'];
                        break;
                    }
                }
                if ($joeHotTitle === '') {
                    $joeHotTitle = $joeFirst;
                }
            }
            ?>
            <li class="item animated fadeIn">
                <a class="link" target="_blank" href="<?php echo $joeHotLink; ?>" title="<?php echo $joeHotTitle; ?>">
                    <figure class="inner">
                        <img width="100%" height="120" class="image ls-is-cached lazyloaded"
                             data-src="<?php echo joe_asset('img/hot_cover1.jpg'); ?>"
                             src="<?php echo $joeHotImg; ?>" onerror="Joe.errorImg(this, 'HomeErrImg')"
                             alt="<?php echo $joeHotTitle; ?>" />
                        <figcaption class="title"><?php echo $joeHotTitle; ?></figcaption>
                    </figure>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
