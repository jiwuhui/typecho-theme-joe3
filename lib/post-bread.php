<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * 文章面包屑（移植自 Halo 版 post_bread.html）
 */
$joeBreadCat = null;
foreach ((array) $this->categories as $joeBreadRow) {
    $joeBreadCat = $joeBreadRow;
    break;
}
?>
<div class="joe_container joe_bread">
    <ul class="joe_bread__bread">
        <li class="item">
            <i class="jiewen joe-icon-shouye"></i>
            <a href="<?php echo joe_site_url(); ?>/" class="link" title="首页">首页</a>
        </li>
        <?php if ($joeBreadCat): ?>
            <li class="line">/</li>
            <li class="item">
                <a class="link" href="<?php echo $joeBreadCat['permalink'] ?? '#'; ?>"
                   title="<?php echo $joeBreadCat['name']; ?>"><?php echo $joeBreadCat['name']; ?></a>
            </li>
        <?php else: ?>
            <li class="line">/</li>
            <li class="item">
                <a class="link" href="<?php echo joe_site_url(); ?>" title="未分类">未分类</a>
            </li>
        <?php endif; ?>
        <li class="line">/</li>
        <li class="item">正文</li>
    </ul>
</div>
