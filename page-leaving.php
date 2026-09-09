<?php
/**
 * 留言板
 *
 * 自定义模板：新建独立页面时选择「留言板」模板
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

global $JOE_HTML_TYPE;
$JOE_HTML_TYPE = 'sheet';

$joeLeavingAuthor = $this->author;
$joeLeavingSourceAll = joe_opt('message_source') === '1';
$joeLeavingWaline = joe_opt('comment_option') === 'waline' && trim((string) joe_opt('waline_serverURL')) !== '';

/* 获取留言数据 */
$joeLeavingComments = [];
try {
    $joeDb = \Typecho\Db::get();
    $joeSelect = $joeDb->select('table.comments.author', 'table.comments.mail', 'table.comments.url',
        'table.comments.created', 'table.comments.text', 'table.comments.cid')
        ->from('table.comments')
        ->where('table.comments.status = ?', 'approved');
    if (!$joeLeavingSourceAll) {
        $joeSelect = $joeSelect->where('table.comments.cid = ?', $this->cid);
    }
    $joeSelect = $joeSelect->order('table.comments.created', \Typecho\Db::SORT_DESC)->limit(20);
    $joeLeavingComments = $joeDb->fetchAll($joeSelect);
} catch (\Throwable $e) {
    $joeLeavingComments = [];
}

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
                             data-src="<?php echo joe_avatar_url((string) $joeLeavingAuthor->mail, 35); ?>"
                             alt="<?php echo htmlspecialchars((string) $joeLeavingAuthor->screenName); ?>"
                             onerror="Joe.errorImg(this, 'ErrAvatarImg')" />
                        <div class="meta">
                            <div class="author">
                                <a class="link" href="javascript:;"
                                   title="<?php echo htmlspecialchars((string) $joeLeavingAuthor->screenName); ?>"><?php $joeLeavingAuthor->screenName(); ?></a>
                            </div>
                            <div class="item">
                                <span class="text"><?php $this->date('Y-m-d'); ?></span>
                                <span class="line">/</span>
                                <span class="text"><?php $this->commentsNum(); ?> 评论</span>
                                <span class="line">/</span>
                                <span class="text"><?php echo joe_views_num((int) $this->cid); ?> 阅读</span>
                            </div>
                        </div>
                    </div>
                    <time class="joe_detail__count-created"
                          datetime="<?php echo joe_date('m/d', $this->modified); ?>"><?php echo joe_date('m/d', $this->modified); ?></time>
                </div>
            <?php endif; ?>
            <article class="joe_detail__article animated fadeIn center-img">
                <div class="joe_leaving tpl">
                    <?php if (!$joeLeavingWaline): ?>
                        <ul class="joe_leaving-list">
                            <?php foreach ($joeLeavingComments as $joeLeavingItem): ?>
                                <li class="item">
                                    <div class="user">
                                        <img class="avatar lazyload"
                                             src="<?php echo joe_lazyload_avatar(); ?>" alt="用户头像"
                                             data-src="<?php echo joe_avatar_url((string) $joeLeavingItem['mail'], 50); ?>"
                                             data-text-avatar="<?php echo $joeLeavingItem['author']; ?>"
                                             onload="Joe.loadedPlaceholderReplaceImg(this, 'AvatarImg')"
                                             onerror="Joe.errorImg(this, 'ErrAvatarImg')" />
                                        <div class="nickname"><?php echo $joeLeavingItem['author']; ?></div>
                                        <div class="date"><?php echo joe_date('Y-m-d', $joeLeavingItem['created']); ?></div>
                                    </div>
                                    <div class="wrapper">
                                        <div
                                            class="content leaving-content"><?php echo $joeLeavingItem['text']; ?></div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <ul class="joe_leaving-list" id="waline-leaving"></ul>
                        <style>
                            .joe_leaving-list img {
                                display: inline-block;
                                height: 24px;
                                max-width: 100%;
                            }
                        </style>
                        <script type="module">
                            import { RecentComments } from '<?php echo joe_opt('waline_js_leaving'); ?>';
                            const serverURL = '<?php echo trim((string) joe_opt('waline_serverURL'), '/'); ?>';
                            const path = window.location.pathname;
                            const url = serverURL + '/api/comment?path=' + path + '&pageSize=100';
                            fetch(url).then(async (response) => {
                                const data = await response.json();
                                const comments = data.data.data;
                                document.getElementById('waline-leaving').innerHTML = comments
                                    .map((comment) => {
                                        const timestamp = new Date(comment.time);
                                        const pad = (n) => (n < 10 ? '0' : '') + n;
                                        const commentTime = `${timestamp.getFullYear()}-${pad(timestamp.getMonth() + 1)}-${pad(timestamp.getDate())}`;
                                        return `<li class="item">
                                            <div class="user">
                                                <img class="avatar lazyload" src="${ThemeConfig.lazyload_avatar}" alt="用户头像" data-src="${comment.avatar || ''}" data-text-avatar="${comment.nick}" onload="Joe.loadedPlaceholderReplaceImg(this, 'AvatarImg')" onerror="Joe.errorImg(this, 'ErrAvatarImg')" />
                                                <div class="nickname">${comment.nick}</div>
                                                <div class="date">${commentTime}</div>
                                            </div>
                                            <div class="wrapper">
                                                <div class="content leaving-content">${comment.comment}</div>
                                            </div>
                                        </li>`;
                                    })
                                    .join('');
                                const leaving = document.createElement('script');
                                leaving.src = '<?php echo joe_asset('js/min/leaving.min.js'); ?>';
                                leaving.type = 'module';
                                document.body.appendChild(leaving);
                            });
                        </script>
                    <?php endif; ?>
                    <div class="joe_leaving-none tpl">暂无留言，期待第一个脚印。</div>
                </div>
            </article>
        </div>
        <div class="joe_comment">
            <?php $this->need('comments.php'); ?>
        </div>
    </div>
    <?php if (joe_is_on('enable_sheet_aside')): ?>
        <?php $this->need('sidebar.php'); ?>
    <?php endif; ?>
</div>
<?php $this->need('lib/actions.php'); ?>
<?php $this->need('footer.php'); ?>
