<?php
/**
 * 首页（移植自 Halo 版 templates/index.html）
 */
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

global $JOE_HTML_TYPE, $JOE_ITER_INDEX;
$JOE_HTML_TYPE = 'index';
$this->need('header.php');
?>
<?php if (joe_is_on('enable_big_banner')): ?>
    <?php
    $joeBannerTitle = (string) (joe_opt('big_banner_title') ?: joe_site_title());
    $joeBannerIsIndex = true;
    $this->need('lib/big-banner.php');
    ?>
<?php endif; ?>
<div class="joe_container joe_main_container page-index<?php echo (joe_is_on('enable_show_in_up') ? ' animated showInUp' : '') . (joe_opt('aside_position') === 'left' ? ' revert' : ''); ?>">
    <div class="joe_main">
        <div class="joe_index">
            <?php /* 轮播图 */ ?>
            <?php if (joe_is_on('enable_banner') && joe_lines('banner_data_group')): ?>
                <?php $this->need('lib/banner.php'); ?>
            <?php endif; ?>

            <?php /* 精品分类 */ ?>
            <?php if (joe_is_on('enable_hot_category') && joe_lines('data_hot_category')): ?>
                <?php $this->need('lib/hot-category.php'); ?>
            <?php endif; ?>

            <div class="joe_index__article">
                <div class="joe_index__title">
                    <ul class="joe_index__title-title passage-list-tabs default">
                        <li class="item active" data-type="1">最新文章</li>
                    </ul>
                    <?php if (joe_opt('qq_group')): ?>
                        <div class="joe_index__title-notice">
                            <svg viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                                <path
                                    d="M656.261 347.208a188.652 188.652 0 1 0 0 324.05v-324.05z"
                                    fill="var(--theme)"></path>
                                <path
                                    d="M668.35 118.881a73.35 73.35 0 0 0-71.169-4.06l-310.01 148.68a4.608 4.608 0 0 1-2.013.46h-155.11a73.728 73.728 0 0 0-73.728 73.636v349.64a73.728 73.728 0 0 0 73.728 73.636h156.554a4.68 4.68 0 0 1 1.94.43l309.592 143.196a73.702 73.702 0 0 0 104.668-66.82V181.206a73.216 73.216 0 0 0-34.453-62.326zM125.403 687.237v-349.64a4.608 4.608 0 0 1 4.608-4.608h122.035v358.882H130.048a4.608 4.608 0 0 1-4.644-4.634zm508.319 150.441a4.608 4.608 0 0 1-6.564 4.193L321.132 700.32V323.773l305.97-146.723a4.608 4.608 0 0 1 6.62 4.157v656.471zM938.26 478.72H788.01a34.509 34.509 0 1 0 0 69.018H938.26a34.509 34.509 0 1 0 0-69.018zM810.01 360.96a34.447 34.447 0 0 0 24.417-10.102l106.245-106.122a34.524 34.524 0 0 0-48.84-48.809L785.587 302.08a34.509 34.509 0 0 0 24.423 58.88zm24.417 314.609a34.524 34.524 0 1 0-48.84 48.814L891.832 830.52a34.524 34.524 0 0 0 48.84-48.809z"
                                    fill="#595BB3"></path>
                            </svg>
                            <a href="<?php echo joe_opt('qq_group'); ?>" target="_blank"
                               rel="noopener noreferrer nofollow">
                                <?php echo joe_opt('qq_text'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="joe_index__list">
                    <ul class="joe_list">
                        <?php $JOE_ITER_INDEX = 0; ?>
                        <?php if ($this->have()): ?>
                            <?php while ($this->next()): ?>
                                <?php $this->need('lib/post-item.php'); ?>
                                <?php $JOE_ITER_INDEX++; ?>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="joe_empty">
                                <span>暂无文章</span>
                            </div>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php if (!joe_is_on('enable_index_list_ajax')): ?>
            <?php joe_page_nav($this); ?>
        <?php endif; ?>
        <?php if (joe_is_on('enable_index_list_ajax')): ?>
            <?php joe_load_more($this); ?>
        <?php endif; ?>
    </div>
    <?php $this->need('sidebar.php'); ?>
</div>

<?php $this->need('lib/actions.php'); ?>
<?php $this->need('footer.php'); ?>
