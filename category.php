<?php
/**
 * 分类归档页（移植自 Halo 版 templates/category.html）
 */
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

global $JOE_HTML_TYPE, $JOE_ITER_INDEX;
$JOE_HTML_TYPE = 'category';
$this->need('header.php');
?>
<div class="joe_container joe_main_container page-category<?php echo joe_is_on('enable_show_in_up') ? ' animated fadeIn' : ''; ?>">
    <div class="joe_main">
        <div class="joe_archive">
            <div class="joe_archive__title">
                <div class="joe_archive__title-title">
                    <i class="joe-font joe-icon-feather joe_archive__title-icon"></i>以下是
                    <span class="muted ellipsis"><?php $this->archiveTitle(['category' => '%s'], '', ''); ?></span>
                    <span>相关的文章</span>
                </div>
            </div>

            <ul class="joe_archive__list joe_list">
                <?php if ($this->have()): ?>
                    <?php $JOE_ITER_INDEX = 0; ?>
                    <?php while ($this->next()): ?>
                        <?php global $JOE_HTML_TYPE;
                        $JOE_HTML_TYPE = 'category'; ?>
                        <?php $this->need('lib/post-item.php'); ?>
                        <?php $JOE_ITER_INDEX++; ?>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="joe_empty">
                        <span>暂无文章</span>
                    </div>
                <?php endif; ?>
            </ul>
            <?php joe_page_nav($this); ?>
        </div>
    </div>
</div>
<?php $this->need('lib/actions.php'); ?>
<?php $this->need('footer.php'); ?>
