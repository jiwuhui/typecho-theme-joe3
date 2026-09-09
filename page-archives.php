<?php
/**
 * 文章归档
 *
 * 自定义模板：新建独立页面时选择「文章归档」模板。
 * 页面正文可留空，归档数据自动生成。
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

global $JOE_HTML_TYPE;
$JOE_HTML_TYPE = 'archives';

$joeArchivesData = joe_archives_data();
$joeArchivesMetric = joe_opt('archives_timeline_metric');
$joeArchivesCats = joe_categories_all();

$this->need('header.php');
?>
<div class="joe_container joe_main_container page-archives<?php echo (joe_is_on('enable_show_in_up') ? ' animated showInUp' : '') . (joe_opt('aside_position') === 'left' ? ' revert' : ''); ?>">
    <div class="joe_main">
        <div class="joe_index joe_archives__filing">
            <div class="title"><?php echo joe_opt('archives_title') ?: '文章归档'; ?></div>
            <div class="content">
                <?php if (joe_is_on('enable_archives_category')): ?>
                    <div class="joe_archives__category animated fadeIn">
                        <div class="joe_archives-title">
                            <i class="joe-font joe-icon-fenlei"></i>分类
                        </div>
                        <ul class="joe_category-list">
                            <?php foreach ($joeArchivesCats as $joeArchiveCat): ?>
                                <li class="item">
                                    <a class="link" href="<?php echo $joeArchiveCat['url']; ?>"
                                       title="<?php echo $joeArchiveCat['name']; ?>">
                                        <span title="<?php echo $joeArchiveCat['name']; ?>">
                                            <?php echo $joeArchiveCat['name']; ?>
                                        </span>
                                        <em><?php echo $joeArchiveCat['count']; ?></em>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <div class="joe_archives__wrapper animated fadeIn">
                    <div class="joe_archives-title">
                        <?php if (joe_opt('archives_list_type') === 'timeline'): ?>
                            <i class="joe-font joe-icon-timeline"></i>时间轴<em>（<?php echo $joeArchivesMetric === 'month' ? '月' : '年'; ?>）</em>
                        <?php else: ?>
                            <i class="jiewen joe-icon-riqi"></i>列表
                        <?php endif; ?>
                    </div>
                    <?php if (joe_opt('archives_list_type') === 'list'): ?>
                        <ul class="joe_archives-list">
                            <?php foreach ($joeArchivesData as $joeYear => $joeMonths): ?>
                                <?php foreach ($joeMonths as $joeMonthPosts): ?>
                                    <?php foreach ($joeMonthPosts as $joeArchivePost): ?>
                                        <li class="item">
                                            <a rel="noopener noreferrer" target="_blank"
                                               title="<?php echo $joeArchivePost['title']; ?>"
                                               href="<?php echo $joeArchivePost['url']; ?>"><?php echo $joeArchivePost['title']; ?></a>
                                            <span> <?php echo $joeArchivePost['date']; ?> </span>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </ul>
                        <?php if (empty($joeArchivesData)): ?>
                            <div class="joe_empty">
                                <span><?php echo joe_opt('archives_empty_text'); ?></span>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <ul class="joe_archives-timelist">
                            <?php foreach ($joeArchivesData as $joeYear => $joeMonths): ?>
                                <?php if ($joeArchivesMetric === 'month'): ?>
                                    <?php foreach ($joeMonths as $joeMonthNum => $joeMonthPosts): ?>
                                        <li class="item">
                                            <div class="wrapper">
                                                <div class="panel in">
                                                    <?php echo $joeYear; ?> 年 <?php echo $joeMonthNum; ?> 月
                                                    <i class="joe-font joe-icon-arrow-down"></i>
                                                </div>
                                                <ol class="panel-body">
                                                    <?php foreach ($joeMonthPosts as $joeArchivePost): ?>
                                                        <li>
                                                            <a rel="noopener noreferrer" target="_blank"
                                                               title="<?php echo $joeArchivePost['title']; ?>"
                                                               href="<?php echo $joeArchivePost['url']; ?>">
                                                                <?php echo $joeArchivePost['date']; ?>：<?php echo $joeArchivePost['title']; ?>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ol>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li class="item">
                                        <div class="wrapper">
                                            <div class="panel in">
                                                <?php echo $joeYear; ?> 年
                                                <i class="joe-font joe-icon-arrow-down"></i>
                                            </div>
                                            <ol class="panel-body">
                                                <?php foreach ($joeMonths as $joeMonthPosts): ?>
                                                    <?php foreach ($joeMonthPosts as $joeArchivePost): ?>
                                                        <li>
                                                            <a rel="noopener noreferrer" target="_blank"
                                                               title="<?php echo $joeArchivePost['title']; ?>"
                                                               href="<?php echo $joeArchivePost['url']; ?>"><?php echo $joeArchivePost['date']; ?>：<?php echo $joeArchivePost['title']; ?></a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                <?php endforeach; ?>
                                            </ol>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                        <?php if (empty($joeArchivesData)): ?>
                            <div class="joe_empty">
                                <span><?php echo joe_opt('archives_empty_text'); ?></span>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php if (joe_is_on('enable_archives_aside')): ?>
        <?php $this->need('sidebar.php'); ?>
    <?php endif; ?>
</div>
<?php $this->need('lib/actions.php'); ?>
<?php $this->need('footer.php'); ?>
