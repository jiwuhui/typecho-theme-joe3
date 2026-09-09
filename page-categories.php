<?php
/**
 * 分类列表页
 *
 * 自定义模板：新建独立页面时选择「分类列表」模板，展示全部分类。
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

global $JOE_HTML_TYPE;
$JOE_HTML_TYPE = 'categories';

$joeCatsPage = joe_categories_all();
$joeCatsType = joe_opt('categories_type');

$this->need('header.php');
?>
<div class="joe_container joe_main_container page-categories<?php echo (joe_is_on('enable_show_in_up') ? ' animated showInUp' : '') . (joe_opt('aside_position') === 'left' ? ' revert' : ''); ?>">
    <div class="joe_main">
        <div class="joe_index">
            <div class="joe_index__title">
                <ul class="joe_index__title-title pl-15">
                    <li class="item active">
                        <?php echo joe_opt('categories_title') ?: '全部分类'; ?><span
                            class="totals"><?php echo count($joeCatsPage); ?></span>
                    </li>
                </ul>
            </div>
            <div class="joe_index__hot categories">
                <ul class="joe_index__hot-list<?php echo $joeCatsType === 'card' ? '' : '-tag'; ?> animated fadeIn">
                    <?php if ($joeCatsType === 'card'): ?>
                        <?php foreach ($joeCatsPage as $joeCat): ?>
                            <li class="item">
                                <a class="link" href="<?php echo $joeCat['url']; ?>"
                                   title="<?php echo $joeCat['name']; ?>">
                                    <figure class="inner">
                                        <?php if (joe_is_on('enable_categories_post_num')): ?>
                                            <em class="post-nums"><?php echo $joeCat['count']; ?>篇</em>
                                        <?php endif; ?>
                                        <img width="100%" height="120" class="image lazyload"
                                             data-src="<?php echo joe_asset('img/hot_cover1.jpg'); ?>"
                                             src="<?php echo joe_asset('img/hot_cover1.jpg'); ?>"
                                             alt="<?php echo $joeCat['name']; ?>"
                                             onerror="Joe.errorImg(this, 'HomeErrImg')" />
                                        <figcaption class="title"><?php echo $joeCat['name']; ?></figcaption>
                                    </figure>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <?php foreach ($joeCatsPage as $joeCat): ?>
                            <li class="item">
                                <a class="link" href="<?php echo $joeCat['url']; ?>"
                                   title="<?php echo $joeCat['name']; ?>">
                                    <span title="<?php echo $joeCat['name']; ?>"><?php echo $joeCat['name']; ?></span>
                                    <?php if (joe_is_on('enable_categories_post_num')): ?>
                                        <em class="post-nums"><?php echo $joeCat['count']; ?>篇</em>
                                    <?php endif; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php if (joe_is_on('enable_categories_aside')): ?>
        <?php $this->need('sidebar.php'); ?>
    <?php endif; ?>
</div>
<?php $this->need('lib/actions.php'); ?>
<?php $this->need('footer.php'); ?>
