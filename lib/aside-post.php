<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * 文章页侧边栏（TOC + 相关文章 + 广告）（移植自 Halo 版 aside_post.html）
 */
?>
<aside class="joe_aside">
    <?php if (joe_is_on('show_blogger')): ?>
        <?php $this->need('lib/aside-blogger.php'); ?>
    <?php endif; ?>
    <div class="joe_aside_post">
        <?php if (joe_is_on('enable_toc')): ?>
            <div class="toc-container">
                <h3 class="toc-header">
                    <i class="jiewen joe-icon-mulu" title="文章目录"></i>文章目录
                </h3>
                <div id="js-toc" class="toc"></div>
            </div>
        <?php endif; ?>
        <?php if (joe_is_on('enable_relate_post')): ?>
            <?php $this->need('lib/relate.php'); ?>
        <?php endif; ?>
    </div>
</aside>
