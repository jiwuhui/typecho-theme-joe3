<?php
/**
 * 文章页（移植自 Halo 版 templates/post.html）
 */
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

global $JOE_HTML_TYPE;
$JOE_HTML_TYPE = 'post';

/* 浏览计数 */
joe_count_view((int) $this->cid);

$joePostCover = joe_post_cover($this);
$joePostImgAlign = joe_field($this, 'img_align', (string) joe_opt('post_img_align'));
$joePostCopy = joe_field($this, 'enable_copy', joe_is_on('enable_copy') ? 'true' : 'false');
$joePostAuthor = $this->author;
$joePostAuthorLink = joe_opt('post_author_link') ?: (string) ($joePostAuthor->permalink ?? 'javascript:;');
$joeDays = floor((time() - $this->modified) / 86400);
$joeTipsDays = (int) joe_opt('days') ?: 30;

$this->need('header.php');

/* 文章级自定义字段 → 全局 PageAttrs（post.min.js 依赖，移植自 Halo 版 modules/postMetaVariable.html） */
$joePageAttrs = [
    'metas_enable_read_limit'     => joe_field($this, 'enable_read_limit', 'false'),
    'metas_enable_page_meta'      => joe_field($this, 'enable_page_meta', 'true'),
    'metas_enable_passage_tips'   => joe_field($this, 'enable_passage_tips', 'true'),
    'metas_enable_collect_check'  => joe_field($this, 'enable_collect_check', 'true'),
    'metas_use_raw_content'       => joe_field($this, 'use_raw_content', 'false'),
    'metas_enable_comment'        => joe_field($this, 'enable_comment', 'true'),
    'metas_enable_toc'            => joe_field($this, 'enable_toc', 'true'),
    'metas_toc_depth'             => joe_field($this, 'toc_depth', '0'),
    'metas_img_max_width'         => joe_field($this, 'img_max_width', '100%'),
    'metas_img_align'             => $joePostImgAlign,
    'metas_enable_copy'           => $joePostCopy,
    'metas_enable_donate'         => joe_field($this, 'enable_donate', 'true'),
    'metas_enable_share'          => joe_field($this, 'enable_share', 'true'),
    'metas_enable_like'           => joe_field($this, 'enable_like', 'true'),
    'metas_enable_fold_long_code' => joe_field($this, 'enable_fold_long_code', 'true'),
];
?>
<script>
    window.PageAttrs = <?php echo json_encode($joePageAttrs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
    window.PageAttrs.metas_toc_depth = parseInt(window.PageAttrs.metas_toc_depth) || 0;
</script>
<?php $this->need('lib/post-bread.php'); ?>
<div class="joe_container joe_main_container page-post<?php echo joe_is_on('enable_show_in_up') ? ' animated fadeIn' : ''; ?>">
    <div class="joe_main joe_post">
        <div class="joe_detail" data-status="PUBLISHED"
             data-cid="<?php $this->cid(); ?>"
             data-clikes="<?php echo joe_likes_num((int) $this->cid); ?>"
             data-author="<?php echo htmlspecialchars((string) $joePostAuthor->screenName); ?>">
            <?php if (!empty($this->categories)): ?>
                <div class="joe_detail__category">
                    <?php foreach ((array) $this->categories as $joeCat): ?>
                        <a href="<?php echo $joeCat['permalink'] ?? '#'; ?>" class="item item-0"
                           title="<?php echo $joeCat['name']; ?>"><?php echo $joeCat['name']; ?></a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="joe_detail-wrapper">
                <h1 class="joe_detail__title<?php echo joe_is_on('enable_title_shadow') ? ' txt-shadow' : ''; ?>">
                    <?php $this->title(); ?>
                </h1>
                <?php if (joe_is_on('enable_page_meta')): ?>
                    <div class="joe_detail__count">
                        <div class="joe_detail__count-information">
                            <img width="35" height="35" class="avatar lazyload"
                                 src="<?php echo joe_lazyload_avatar(); ?>"
                                 data-src="<?php echo joe_avatar_url((string) $joePostAuthor->mail, 35); ?>"
                                 alt="<?php echo htmlspecialchars((string) $joePostAuthor->screenName); ?>"
                                 onerror="Joe.errorImg(this, 'ErrAvatarImg')" />
                            <div class="meta">
                                <div class="author">
                                    <a class="link" href="<?php echo $joePostAuthorLink; ?>"
                                       title="<?php echo htmlspecialchars((string) $joePostAuthor->screenName); ?>"><?php $joePostAuthor->screenName(); ?></a>
                                </div>
                                <div class="item">
                                    <span class="text"><?php $this->date('Y-m-d'); ?></span>
                                    <span class="line">/</span>
                                    <?php if (joe_opt('comment_option') === 'default' || trim((string) joe_opt('waline_serverURL')) === ''): ?>
                                        <span class="text"><?php $this->commentsNum(); ?> 评论</span>
                                    <?php else: ?>
                                        <span class="text waline-comment-count"
                                              data-path="<?php echo joe_site_url() . $this->path; ?>">0</span>&nbsp;评论
                                    <?php endif; ?>
                                    <span class="line">/</span>
                                    <span class="text"><?php echo joe_likes_num((int) $this->cid); ?> 点赞</span>
                                    <span class="line">/</span>
                                    <span class="text"><?php echo joe_views_num((int) $this->cid); ?> 阅读</span>
                                    <span class="line">/</span>
                                    <span class="text" id="wordCount">0 字</span>
                                    <?php if (joe_is_on('check_baidu_collect')): ?>
                                        <span class="line">/</span>
                                        <span class="text" id="joe_baidu_record">正在检测是否收录...</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <time class="joe_detail__count-created"
                              datetime="<?php echo joe_date('m/d', $this->modified); ?>"><?php echo joe_date('m/d', $this->modified); ?></time>
                    </div>
                <?php endif; ?>

                <?php if (joe_is_on('enable_passage_tips') && $joeDays >= $joeTipsDays): ?>
                    <div class="joe_detail__overdue">
                        <div class="joe_detail__overdue-wrapper">
                            <div class="title">
                                <svg class="icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg"
                                     width="20" height="20">
                                    <path
                                        d="M0 512c0 282.778 229.222 512 512 512s512-229.222 512-512S794.778 0 512 0 0 229.222 0 512z"
                                        fill="#FF8C00" fill-opacity=".51" />
                                    <path
                                        d="M462.473 756.326a45.039 45.039 0 0 0 41.762 28.74 45.039 45.039 0 0 0 41.779-28.74h-83.541zm119.09 0c-7.73 35.909-39.372 62.874-77.311 62.874-37.957 0-69.598-26.965-77.33-62.874H292.404a51.2 51.2 0 0 1-42.564-79.65l23.723-35.498V484.88a234.394 234.394 0 0 1 167.492-224.614c3.635-31.95 30.498-56.815 63.18-56.815 31.984 0 58.386 23.808 62.925 54.733A234.394 234.394 0 0 1 742.093 484.88v155.512l24.15 36.454a51.2 51.2 0 0 1-42.668 79.48H581.564zm-47.957-485.922c.069-.904.12-1.809.12-2.73 0-16.657-13.26-30.089-29.491-30.089-16.214 0-29.474 13.432-29.474 30.089 0 1.245.085 2.491.221 3.703l1.81 15.155-14.849 3.499a200.226 200.226 0 0 0-154.265 194.85v166.656l-29.457 44.1a17.067 17.067 0 0 0 14.182 26.556h431.155a17.067 17.067 0 0 0 14.234-26.487l-29.815-45.04V484.882A200.21 200.21 0 0 0 547.26 288.614l-14.985-2.986 1.331-15.224z"
                                        fill="#FFF" />
                                    <path
                                        d="M612.864 322.697c0 30.378 24.303 55.022 54.272 55.022 30.003 0 54.323-24.644 54.323-55.022 0-30.38-24.32-55.023-54.306-55.023s-54.306 24.644-54.306 55.023z"
                                        fill="#FA5252" />
                                </svg>
                                <span class="text">温馨提示：</span>
                            </div>
                            <div class="content">
                                <?php if (joe_opt('passage_tips_content') !== ''): ?>
                                    <?php if (joe_opt('days_type') === '1'): ?>
                                        本文最后更新于<?php echo joe_date('Y-m-d', $this->modified); ?>，若内容或图片失效，请留言反馈。
                                    <?php else: ?>
                                        本文最后更新于<?php echo $joeDays; ?>天前，若内容或图片失效，请留言反馈。
                                    <?php endif; ?>
                                    <?php echo joe_opt('passage_tips_content'); ?>
                                <?php else: ?>
                                    <?php if (joe_opt('days_type') === '1'): ?>
                                        本文最后更新于<?php echo joe_date('Y-m-d', $this->modified); ?>，若内容或图片失效，请留言反馈。
                                    <?php else: ?>
                                        本文最后更新于<?php echo $joeDays; ?>天前，若内容或图片失效，请留言反馈。
                                    <?php endif; ?>
                                    部分素材来自网络，若不小心影响到您的利益，请联系我们删除。
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <article class="joe_detail__article animated fadeIn <?php echo $joePostImgAlign; ?>-img<?php
                if ($joePostCopy === 'false') {
                    echo ' uncopy';
                }
                echo joe_is_on('enable_indent') ? ' indent' : '';
                echo (joe_is_on('enable_code_line_number') && !joe_is_on('enable_code_newline')) ? ' line-numbers' : '';
                echo joe_is_on('enable_single_code_select') ? ' single_code_select' : '';
                ?>">
                    <div id="post-inner">
                        <?php ob_start(); $this->content(); echo joe_heading_ids((string) ob_get_clean()); ?>
                    </div>
                </article>
                <?php if (joe_is_on('enable_like')): ?>
                    <?php global $JOE_FAVORITE_MODE;
                    $JOE_FAVORITE_MODE = 'bottom'; ?>
                    <?php $this->need('lib/favorite.php'); ?>
                <?php endif; ?>
            </div>
            <?php $this->need('lib/post-operate.php'); ?>
            <?php $this->need('lib/post-copyright.php'); ?>
        </div>
        <?php $this->need('lib/post-operate-aside.php'); ?>
        <ul class="joe_post__pagination">
            <?php ob_start(); $this->thePrev('%s', '', ['title' => '上一篇']); $joePrevHtml = ob_get_clean(); ?>
            <?php if (trim($joePrevHtml) !== ''): ?>
                <li class="joe_post__pagination-item prev"><?php echo $joePrevHtml; ?></li>
            <?php endif; ?>
            <?php ob_start(); $this->theNext('%s', '', ['title' => '下一篇']); $joeNextHtml = ob_get_clean(); ?>
            <?php if (trim($joeNextHtml) !== ''): ?>
                <li class="joe_post__pagination-item next"><?php echo $joeNextHtml; ?></li>
            <?php endif; ?>
        </ul>
        <?php if (!joe_is_on('enable_clean_mode') && joe_is_on('enable_comment')): ?>
            <div class="joe_comment">
                <?php $this->need('comments.php'); ?>
            </div>
        <?php else: ?>
            <div class="joe_comment">
                <div class="joe_comment__close">
                    <svg class="joe_comment__close-icon" viewBox="0 0 1024 1024"
                         xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                        <path
                            d="M512.307.973c282.317 0 511.181 201.267 511.181 449.587a402.842 402.842 0 0 1-39.27 173.26 232.448 232.448 0 0 0-52.634-45.977c16.384-39.782 25.293-82.688 25.293-127.283 0-211.098-199.117-382.157-444.621-382.157-245.555 0-444.57 171.06-444.57 382.157 0 133.427 79.514 250.88 200.039 319.18v107.982l102.041-65.127a510.157 510.157 0 0 0 142.49 20.122l19.405-.359c19.405-.716 38.758-2.508 57.958-5.427l3.584 13.415a230.607 230.607 0 0 0 22.323 50.688l-20.633 3.328a581.478 581.478 0 0 1-227.123-12.288L236.646 982.426c-19.66 15.001-35.635 7.168-35.635-17.664v-157.39C79.411 725.198 1.024 595.969 1.024 450.56 1.024 202.24 229.939.973 512.307.973zm318.464 617.011c97.485 0 176.794 80.435 176.794 179.2S928.256 976.23 830.77 976.23c-97.433 0-176.742-80.281-176.742-179.046 0-98.816 79.309-179.149 176.742-179.149zM727.757 719.002a131.174 131.174 0 0 0-25.754 78.182c0 71.885 57.805 130.406 128.768 130.406 28.877 0 55.552-9.625 77.056-26.01zm103.014-52.327c-19.712 0-39.117 4.557-56.678 13.312L946.33 854.58c8.499-17.305 13.158-36.864 13.158-57.395 0-71.987-57.805-130.509-128.717-130.509z" />
                    </svg>
                    <span><?php echo joe_is_on('enable_clean_mode') ? '博主关闭了所有页面的评论' : '博主关闭了当前页面的评论'; ?></span>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php $this->need('lib/aside-post.php'); ?>
</div>
<?php if (joe_is_on('enable_progress_bar')): ?>
    <div class="joe_progress_bar" style="background: var(--theme);"></div>
<?php endif; ?>
<?php $this->need('lib/actions.php'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const postContent = document.getElementById('post-inner');
        const wordCountEl = document.getElementById('wordCount');
        if (!postContent || !wordCountEl) return;
        const text = postContent.innerText || '';
        const matches = text.match(/[\u4e00-\u9fa5a-zA-Z0-9]/g);
        const wordCount = matches ? matches.length : 0;
        wordCountEl.innerText = `${wordCount} 字`;
    });
</script>
<?php $this->need('footer.php'); ?>
