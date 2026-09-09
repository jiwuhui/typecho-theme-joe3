<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * 评论区（移植自 Halo 版 modules/macro/comment.html）
 * 默认使用 Typecho 原生评论，可选择 Waline
 */
$joeWalineServer = trim((string) joe_opt('waline_serverURL'));
$joeUseWaline = joe_opt('comment_option') === 'waline' && $joeWalineServer !== '';
?>
<div class="joe_comment_box">
    <div class="box_title">
        <h2>评论区</h2>
    </div>
    <?php if (!$joeUseWaline): ?>
        <?php $this->comments()->to($joeComments); ?>
        <div class="joe_comment__list">
            <?php if ($joeComments->have()): ?>
                <?php
                $joeComments->listComments([
                    'before'      => '<ol class="comment-list">',
                    'after'       => '</ol>',
                    'avatarSize'  => 48,
                    'replyWord'   => _t('回复'),
                    'commentStatus' => _t('您的评论正等待审核!'),
                ]);
                ?>
            <?php else: ?>
                <div class="joe_comment__empty">还没有评论，快来抢沙发吧！</div>
            <?php endif; ?>
        </div>
        <?php $joeComments->pageNav('<i class="joe-font joe-icon-prev"></i>', '<i class="joe-font joe-icon-next"></i>', 3, '...', [
            'wrapTag'      => 'ul',
            'wrapClass'    => 'joe_pagination',
            'itemTag'      => 'li',
            'textTag'      => 'a',
            'currentClass' => 'active',
            'prevClass'    => 'prev',
            'nextClass'    => 'next',
        ]); ?>
        <?php if ($this->allow('comment')): ?>
            <div id="<?php $this->respondId(); ?>" class="joe_comment__form respond">
                <div class="cancel-comment-reply"><?php $joeComments->cancelReply(); ?></div>
                <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
                    <?php if ($this->user->hasLogin()): ?>
                        <div class="joe_form__row joe_form__logged">
                            登录身份：<a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>
                            <a href="<?php $this->options->logoutUrl(); ?>" title="退出">退出 »</a>
                        </div>
                    <?php else: ?>
                        <div class="joe_form__row">
                            <input type="text" name="author" id="author" class="text" maxlength="20"
                                   placeholder="称呼<?php if ($this->options->commentsRequireMail) echo ' *'; ?>"
                                   value="<?php $this->remember('author'); ?>"
                                   <?php if ($this->options->commentsRequireMail): ?>required<?php endif; ?> />
                            <input type="email" name="mail" id="mail" class="text"
                                   placeholder="邮箱（不会被公开）<?php if ($this->options->commentsRequireMail) echo ' *'; ?>"
                                   value="<?php $this->remember('mail'); ?>"
                                   <?php if ($this->options->commentsRequireMail): ?>required<?php endif; ?> />
                            <input type="url" name="url" id="url" class="text"
                                   placeholder="网站（http://）"
                                   value="<?php $this->remember('url'); ?>"
                                   <?php if ($this->options->commentsRequireUrl): ?>required<?php endif; ?> />
                        </div>
                    <?php endif; ?>
                    <div class="joe_form__row">
                        <textarea rows="5" cols="50" name="text" id="textarea" class="textarea"
                                  required placeholder="说点什么吧…"><?php $this->remember('text'); ?></textarea>
                    </div>
                    <div class="joe_form__row">
                        <button type="submit" class="submit">提交评论</button>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div class="joe_comment__close">
                <span>博主关闭了当前页面的评论</span>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div id="waline"></div>
        <style>
            #waline .wl-count {
                color: var(--routine);
            }
        </style>
        <script type="module">
            import { init } from '<?php echo joe_opt('waline_js_comment'); ?>';

            const waline_config_basic_jsonString =
                '<?php echo addslashes(joe_opt('waline_config_basic_json')); ?>';
            const waline_config_basic_object = JSON.parse(
                waline_config_basic_jsonString === null || waline_config_basic_jsonString.trim() === ''
                    ? '{}'
                    : waline_config_basic_jsonString.trim()
            );

            let waline_config_imageUpload_option =
                '<?php echo joe_opt('waline_config_imageUpload_option'); ?>';
            let imageUploader = 'true';
            if (waline_config_imageUpload_option === 'lskypro') {
                imageUploader = (file) => {
                    let lskypro_apiURL = '<?php echo joe_opt('lskypro_apiURL'); ?>';
                    let lskypro_apiTOKEN = '<?php echo joe_opt('lskypro_apiTOKEN'); ?>';
                    let formData = new FormData();
                    let headers = new Headers();
                    formData.append('file', file);
                    if (lskypro_apiTOKEN.trim() !== '') {
                        headers.append('Authorization', 'Bearer ' + lskypro_apiTOKEN.trim());
                    }
                    headers.append('Accept', 'application/json');
                    return fetch(lskypro_apiURL.trim(), {
                        method: 'POST',
                        headers: headers,
                        body: formData,
                    })
                        .then((resp) => resp.json())
                        .then((resp) => resp.data.links.url);
                };
            }

            init({
                el: '#waline',
                dark: 'html[data-mode="dark"]',
                serverURL: '<?php echo $joeWalineServer; ?>',
                comment: true,
                requiredMeta: ['nick', 'mail'],
                imageUploader,
                ...waline_config_basic_object,
            });
        </script>
    <?php endif; ?>
</div>
