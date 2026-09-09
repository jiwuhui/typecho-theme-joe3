<?php
/**
 * 独立页面（移植自 Halo 版 templates/page.html）
 */
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

global $JOE_HTML_TYPE;
$JOE_HTML_TYPE = 'sheet';

$joePageImgAlign = joe_field($this, 'img_align', (string) joe_opt('post_img_align'));
$joePageCopy = joe_field($this, 'enable_copy', joe_is_on('enable_copy') ? 'true' : 'false');
$joePageAuthor = $this->author;
$joePageEnableComment = joe_field($this, 'enable_comment', 'true') === 'true';

$this->need('header.php');
?>
<div class="joe_container joe_main_container page-sheet<?php echo (joe_is_on('enable_show_in_up') ? ' animated showInUp' : '') . (joe_opt('aside_position') === 'left' ? ' revert' : ''); ?>">
    <div class="joe_main">
        <div class="joe_detail">
            <h1 class="joe_detail__title<?php echo joe_is_on('enable_title_shadow') ? ' txt-shadow' : ''; ?>">
                <?php $this->title(); ?>
            </h1>
            <?php if (joe_is_on('enable_page_meta')): ?>
                <div class="joe_detail__count">
                    <div class="joe_detail__count-information">
                        <img width="35" height="35" class="avatar lazyload"
                             src="<?php echo joe_lazyload_avatar(); ?>"
                             data-src="<?php echo joe_avatar_url((string) $joePageAuthor->mail, 35); ?>"
                             alt="<?php echo htmlspecialchars((string) $joePageAuthor->screenName); ?>"
                             onerror="Joe.errorImg(this, 'ErrAvatarImg')" />
                        <div class="meta">
                            <div class="author">
                                <a class="link" href="javascript:;"
                                   title="<?php echo htmlspecialchars((string) $joePageAuthor->screenName); ?>"><?php $joePageAuthor->screenName(); ?></a>
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
                                <span class="text"><?php echo joe_views_num((int) $this->cid); ?> 阅读</span>
                                <span class="line">/</span>
                                <span class="text" id="wordCount">0 字</span>
                            </div>
                        </div>
                    </div>
                    <time class="joe_detail__count-created"
                          datetime="<?php echo joe_date('m/d', $this->modified); ?>"><?php echo joe_date('m/d', $this->modified); ?></time>
                </div>
            <?php endif; ?>

            <article class="joe_detail__article animated fadeIn <?php echo $joePageImgAlign; ?>-img<?php
            if ($joePageCopy === 'false') {
                echo ' uncopy';
            }
            echo joe_is_on('enable_indent') ? ' indent' : '';
            echo (joe_is_on('enable_code_line_number') && !joe_is_on('enable_code_newline')) ? ' line-numbers' : '';
            echo joe_is_on('enable_single_code_select') ? ' single_code_select' : '';
            ?>">
                <div id="singlePage-inner">
                    <?php $this->content(); ?>
                </div>
            </article>
        </div>
        <?php if (!joe_is_on('enable_clean_mode') && joe_is_on('enable_comment') && $joePageEnableComment): ?>
            <div class="joe_comment">
                <?php $this->need('comments.php'); ?>
            </div>
        <?php else: ?>
            <div class="joe_comment">
                <div class="joe_comment__close">
                    <svg class="joe_comment__close-icon" viewBox="0 0 1024 1024"
                         xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                        <path
                            d="M512.307.973c282.317 0 511.181 201.267 511.181 449.587a402.842 402.842 0 0 1-39.27 173.26 232.448 232.448 0 0 0-52.634-45.977c16.384-39.782 25.293-82.688 25.293-127.283 0-211.098-199.117-382.157-444.621-382.157-245.555 0-444.57 171.06-444.57 382.157 0 133.427 79.514 250.88 200.039 319.18v107.982l102.041-65.127a510.157 510.157 0 0 0 142.49 20.122l19.405-.359c19.405-.716 38.758-2.508 57.958-5.427l3.584 13.415a230.607 230.607 0 0 0 22.323 50.688l-20.633 3.328a581.478 581.478 0 0 1-227.123-12.288L236.646 982.426c-19.66 15.001-35.635 7.168-35.635-17.664v-157.39C79.411 725.198 1.024 595.969 1.024 450.56 1.024 202.24 229.939.973 512.307.973zm318.464 617.011c97.485 0 176.794 80.435 176.794 179.2S928.256 976.23 830.77 976.23c-97.433 0-176.742-80.281-176.742-179.046 0-98.816 79.309-179.149 176.742-179.149zM727.757 719.002a131.174 131.174 0 0 0-25.754 78.182c0 71.885 57.805 130.406 128.768 130.406 28.877 0 55.552-9.625 77.056-26.01zm103.014-52.327c-19.712 0-39.117 4.557-56.678 13.312L946.33 854.58c8.499-17.305 13.158-36.864 13.158-57.395 0-71.987-57.805-130.509-128.717-130.509zM512.307 383.13l6.861.358a67.072 67.072 0 0 1 59.853 67.072l-.307 6.86a67.072 67.072 0 0 1-66.407 60.57l-6.81-.358a67.072 67.072 0 0 1-59.852-67.072 67.072 67.072 0 0 1 66.662-67.43zm266.752 0l6.861.358a67.072 67.072 0 0 1 59.853 67.072l-.307 6.86a67.072 67.072 0 0 1-66.407 60.57l-6.81-.358a67.072 67.072 0 0 1-59.852-67.072h-.051l.307-6.86a67.072 67.072 0 0 1 66.406-60.57zm-533.504 0l6.861.358a67.072 67.072 0 0 1 59.853 67.072l-.307 6.86a67.072 67.072 0 0 1-66.407 60.57l-6.81-.358a67.072 67.072 0 0 1-59.852-67.072 67.072 67.072 0 0 1 66.662-67.43z" />
                    </svg>
                    <span>博主关闭了当前页面的评论</span>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php if (joe_is_on('enable_sheet_aside')): ?>
        <?php $this->need('sidebar.php'); ?>
    <?php endif; ?>
</div>
<?php $this->need('lib/actions.php'); ?>
<?php $this->need('footer.php'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const postContent = document.getElementById('singlePage-inner');
        const wordCountEl = document.getElementById('wordCount');
        if (!postContent || !wordCountEl) return;
        const text = postContent.innerText || '';
        const matches = text.match(/[\u4e00-\u9fa5a-zA-Z0-9]/g);
        const wordCount = matches ? matches.length : 0;
        wordCountEl.innerText = `${wordCount} 字`;
    });
</script>
