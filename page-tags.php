<?php
/**
 * 标签列表页
 *
 * 自定义模板：新建独立页面时选择「标签列表」模板，展示全部标签。
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

global $JOE_HTML_TYPE;
$JOE_HTML_TYPE = 'tags';

$joeTagsPage = joe_tags_all();
$joeTagsType = joe_opt('tags_type');

$this->need('header.php');
?>
<div class="joe_container joe_main_container page-tags<?php echo (joe_is_on('enable_show_in_up') ? ' animated showInUp' : '') . (joe_opt('aside_position') === 'left' ? ' revert' : ''); ?>">
    <div class="joe_main">
        <div class="joe_index">
            <div class="joe_index__title">
                <ul class="joe_index__title-title pl-15">
                    <li class="item active">
                        <?php echo joe_opt('tags_title') ?: '全部标签'; ?><span
                            class="totals"><?php echo count($joeTagsPage); ?></span>
                    </li>
                </ul>
            </div>
            <div class="joe_index__hot">
                <ul class="joe_index__hot-list<?php echo $joeTagsType !== 'card' ? '-tag' : ''; ?> animated fadeIn"
                    style="padding-bottom: 10px">
                    <?php if ($joeTagsType === 'card'): ?>
                        <?php foreach ($joeTagsPage as $joeTag): ?>
                            <li class="item">
                                <a class="link" href="<?php echo $joeTag['url']; ?>"
                                   title="<?php echo $joeTag['name']; ?>">
                                    <figure class="inner">
                                        <?php if (joe_is_on('enable_tags_post_num')): ?>
                                            <em class="post-nums"><?php echo $joeTag['count']; ?>篇</em>
                                        <?php endif; ?>
                                        <img width="100%" height="120" class="image lazyload"
                                             data-src="<?php echo joe_asset('img/hot_cover1.jpg'); ?>"
                                             src="<?php echo joe_asset('img/hot_cover1.jpg'); ?>"
                                             alt="<?php echo $joeTag['name']; ?>"
                                             onerror="Joe.errorImg(this, 'HomeErrImg')" />
                                        <figcaption class="title"><?php echo $joeTag['name']; ?></figcaption>
                                    </figure>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <?php foreach ($joeTagsPage as $joeTag): ?>
                            <li class="item">
                                <a class="link" href="<?php echo $joeTag['url']; ?>"
                                   title="<?php echo $joeTag['name']; ?>">
                                    <span><?php echo $joeTag['name']; ?></span>
                                    <?php if (joe_is_on('enable_tags_post_num')): ?>
                                        <em class="post-nums"><?php echo $joeTag['count']; ?>篇</em>
                                    <?php endif; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php if (joe_is_on('enable_tags_aside')): ?>
        <?php $this->need('sidebar.php'); ?>
    <?php endif; ?>
</div>
<?php $this->need('lib/actions.php'); ?>
<?php $this->need('footer.php'); ?>
