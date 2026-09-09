<?php
/**
 * 图库/相册
 *
 * 自定义模板：新建独立页面时选择「图库」模板。
 * 相册数据通过页面自定义字段 photos 配置，每行一条：
 *   图片地址|描述
 * 分组语法：
 *   [分组名]
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

global $JOE_HTML_TYPE;
$JOE_HTML_TYPE = 'photos';

/* 解析相册数据（来自页面自定义字段 photos，每行一条：图片地址|描述，[分组名] 为分组行） */
$joePhotoGroups = [];
$joeCurrentGroup = '全部';
$joePhotosRaw = '';
try {
    if (isset($this->fields->photos)) {
        $joePhotosRaw = (string) $this->fields->photos;
    }
} catch (\Throwable $e) {
    $joePhotosRaw = '';
}
$joePhotoLines = $joePhotosRaw !== '' ? preg_split('/\r\n|\r|\n/', $joePhotosRaw) : [];
foreach ($joePhotoLines as $joePhotoLine) {
    $joePhotoLine = trim($joePhotoLine);
    if ($joePhotoLine === '') {
        continue;
    }
    $joePhotoRow = array_map('trim', explode('|', $joePhotoLine));
    $joeFirst = $joePhotoRow[0] ?? '';
    if (count($joePhotoRow) === 1 && preg_match('/^\[.*\]$/', $joeFirst)) {
        $joeCurrentGroup = trim($joeFirst, '[]');
        if ($joeCurrentGroup === '') {
            $joeCurrentGroup = '全部';
        }
        if (!isset($joePhotoGroups[$joeCurrentGroup])) {
            $joePhotoGroups[$joeCurrentGroup] = [];
        }
        continue;
    }
    if ($joeFirst === '') {
        continue;
    }
    if (!isset($joePhotoGroups[$joeCurrentGroup])) {
        $joePhotoGroups[$joeCurrentGroup] = [];
    }
    $joePhotoGroups[$joeCurrentGroup][] = [
        'url' => $joeFirst,
        'title' => $joePhotoRow[1] ?? '',
    ];
}

/* 自动聚合文章正文图片（markdown 与 HTML 语法均支持，按文章时间倒序） */
if (joe_is_on('photos_aggregate')) {
    try {
        $joeAutoGroup = trim((string) joe_opt('photos_aggregate_group'));
        if ($joeAutoGroup === '') {
            $joeAutoGroup = '文章';
        }
        if (!isset($joePhotoGroups[$joeAutoGroup])) {
            $joePhotoGroups[$joeAutoGroup] = [];
        }

        /* 已登记的地址不重复收录（手动配置优先） */
        $joeSeen = [];
        foreach ($joePhotoGroups as $joeGroupPhotos) {
            foreach ($joeGroupPhotos as $joeGroupPhoto) {
                $joeSeen[$joeGroupPhoto['url']] = true;
            }
        }

        $db = \Typecho\Db::get();
        $joePosts = $db->fetchAll(
            $db->select('cid', 'title', 'text')->from('table.contents')
                ->where('type = ?', 'post')
                ->where('status = ?', 'publish')
                ->where("(password IS NULL OR password = '')")
                ->order('created', \Typecho\Db::SORT_DESC)
        );
        foreach ($joePosts as $joePost) {
            $joeText = (string) $joePost['text'];
            $joeUrls = [];
            /* markdown 图片：![描述](地址) */
            if (preg_match_all('/!\[[^\]]*\]\(\s*([^\s)]+)/i', $joeText, $joeMatches)) {
                $joeUrls = array_merge($joeUrls, $joeMatches[1]);
            }
            /* HTML 图片：<img src="地址"> */
            if (preg_match_all('/<img[^>]*\bsrc=["\']([^"\']+)["\']/i', $joeText, $joeMatches)) {
                $joeUrls = array_merge($joeUrls, $joeMatches[1]);
            }
            foreach ($joeUrls as $joeUrl) {
                $joeUrl = htmlspecialchars_decode($joeUrl);
                if (strpos($joeUrl, 'data:') === 0 || !preg_match('/^https?:\/\//i', $joeUrl)) {
                    continue;
                }
                if (isset($joeSeen[$joeUrl])) {
                    continue;
                }
                $joeSeen[$joeUrl] = true;
                $joePhotoGroups[$joeAutoGroup][] = [
                    'url'   => $joeUrl,
                    'title' => (string) $joePost['title'],
                ];
            }
        }

        /* 分组为空则移除，避免出现空筛选标签 */
        if (empty($joePhotoGroups[$joeAutoGroup])) {
            unset($joePhotoGroups[$joeAutoGroup]);
        }
    } catch (\Throwable $e) {
        // 聚合失败不影响手动配置的展示
    }
}

$this->need('header.php');
?>
<div class="joe_container joe_main_container page-photos<?php echo (joe_is_on('enable_show_in_up') ? ' animated showInUp' : '') . (joe_opt('aside_position') === 'left' ? ' revert' : ''); ?>">
    <div class="joe_main">
        <div class="joe_photos__type">
            <div class="joe_photos__type-title">
                <i class="jiewen joe-icon-tupian"></i>&nbsp;<?php $this->title(); ?>
            </div>
            <?php if (count($joePhotoGroups) > 1): ?>
                <nav class="joe_photos__filter">
                    <ul>
                        <li data-sjslink="*" class="active">
                            <a>全部</a>
                        </li>
                        <?php foreach ($joePhotoGroups as $joePhotoGroupName => $joeGroupPhotos): ?>
                            <li data-sjslink="<?php echo $joePhotoGroupName; ?>">
                                <a><?php echo $joePhotoGroupName; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>

        <div class="wrapper">
            <div class="grid" id="image-grid">
                <?php foreach ($joePhotoGroups as $joePhotoGroupName => $joeGroupPhotos): ?>
                    <?php foreach ($joeGroupPhotos as $joePhoto): ?>
                        <div class="grid-item wow fadeIn" data-sjsel="<?php echo $joePhotoGroupName; ?>">
                            <div class="card__picture">
                                <a class="item animated wow jg-entry" href="<?php echo $joePhoto['url']; ?>"
                                   data-fancybox="gallery">
                                    <img class="lazy-load" data-src="<?php echo $joePhoto['url']; ?>"
                                         alt="<?php echo $joePhoto['title']; ?>"
                                         src="<?php echo joe_asset('img/photo_loading.gif'); ?>"
                                         onerror="Joe.errorImg(this, 'LoadFailedImg')" />
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
            <div class="joe_loading">
                <img src="<?php echo joe_asset('svg/loading-ball.svg'); ?>" />
            </div>
        </div>
    </div>
    <?php if (joe_is_on('enable_sheet_aside')): ?>
        <?php $this->need('sidebar.php'); ?>
    <?php endif; ?>
</div>
<?php $this->need('lib/actions.php'); ?>
<?php $this->need('footer.php'); ?>
