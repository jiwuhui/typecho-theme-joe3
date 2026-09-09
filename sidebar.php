<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * 侧边栏（移植自 Halo 版 aside.html + asideWidget.html + blogger.html）
 * 渲染顺序由设置「侧边栏模块（顺序）」控制
 */
?>
<?php if (joe_is_on('enable_aside')): ?>
    <aside class="joe_aside<?php echo joe_opt('aside_position') === 'left' ? ' pos_left' : ''; ?>">
        <?php
        foreach (joe_lines('aside_widgets') as $joeAsideRow) {
            $joeAsideKey = isset($joeAsideRow[0]) ? $joeAsideRow[0] : '';
            if ($joeAsideKey === '' || $joeAsideKey === 'none') {
                continue;
            }
            switch ($joeAsideKey) {
                case 'enable_blogger':
                    $this->need('lib/aside-blogger.php');
                    break;

                case 'enable_notice':
                    if (joe_opt('site_notice') === '' && joe_opt('notice_title') === '') {
                        break;
                    }
                    ?>
                    <section class="joe_aside__item notice">
                        <div class="joe_aside__item-title">
                            <?php $this->need('lib/speaker.php'); ?>
                            <span class="text"><?php echo joe_opt('notice_title'); ?></span>
                        </div>
                        <div class="joe_aside__item-contain">
                            <div class="notice_content"><?php echo joe_opt('site_notice'); ?></div>
                        </div>
                    </section>
                    <?php
                    break;

                case 'enable_reward':
                    if (joe_is_on('enable_clean_mode')) {
                        break;
                    }
                    $joeRewardList = joe_lines('reward_list');
                    if (empty($joeRewardList)) {
                        break;
                    }
                    ?>
                    <section class="joe_aside__item reward">
                        <div class="joe_aside__item-title">
                            <i class="joe-font joe-icon-coffee"></i>
                            <span class="text">请作者喝杯咖啡</span>
                        </div>
                        <div class="pay-tab-content">
                            <ul>
                                <?php foreach ($joeRewardList as $joeIndex => $joeReward): ?>
                                    <li>
                                        <input type="radio" value="<?php echo $joeIndex; ?>"
                                               <?php echo $joeIndex === 0 ? 'checked' : ''; ?> name="radio"
                                               id="aside_reward_<?php echo $joeIndex; ?>" />
                                        <label for="aside_reward_<?php echo $joeIndex; ?>">
                                            <?php echo isset($joeReward[0]) ? $joeReward[0] : '打赏'; ?>
                                        </label>
                                        <div>
                                            <?php if (isset($joeReward[1]) && $joeReward[1] !== ''): ?>
                                                <img class="reward_image reward-image" src="<?php echo $joeReward[1]; ?>"
                                                     alt="打赏" />
                                            <?php endif; ?>
                                            <?php if (isset($joeReward[2]) && trim($joeReward[2]) !== ''): ?>
                                                <?php echo $joeReward[2]; ?>
                                            <?php endif; ?>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </section>
                    <?php
                    break;

                case 'enable_picture':
                    if (!joe_opt('qrcode_url')) {
                        break;
                    }
                    ?>
                    <section class="joe_aside__item qrcode">
                        <div class="joe_aside__item-title">
                            <i class="joe-font joe-icon-qrcode"></i>
                            <span class="text"><?php echo joe_opt('qrcode_title'); ?></span>
                        </div>
                        <div class="joe_aside__item-contain">
                            <img class="qrcode_img lazyload" src="<?php echo joe_opt('qrcode_url'); ?>"
                                 data-src="<?php echo joe_opt('qrcode_url'); ?>"
                                 alt="<?php echo joe_opt('qrcode_title'); ?>"
                                 onerror="Joe.errorImg(this, 'LoadFailedImg')" />
                            <?php if (joe_opt('qrcode_description') !== ''): ?>
                                <p class="qrcode_description"><?php echo joe_opt('qrcode_description'); ?></p>
                            <?php endif; ?>
                        </div>
                    </section>
                    <?php
                    break;

                case 'enable_music_player':
                    if (!joe_opt('music_id')) {
                        break;
                    }
                    ?>
                    <section class="joe_aside__item timelife">
                        <div class="joe_aside__item-title">
                            <i class="joe-font joe-icon-yinfu"></i>
                            <span class="text">我的歌单</span>
                        </div>
                        <div id="aplayer" class="aplayer" data-id="<?php echo joe_opt('music_id'); ?>"
                             list-max-height="20px" data-server="netease" data-type="playlist"
                             data-fixed="false" data-listfolded="true" data-order="random"
                             data-mode="#f3f3f7"></div>
                    </section>
                    <?php
                    break;

                case 'enable_newest_post':
                    $joeNewest = joe_recent_posts((int) joe_opt('set_newest_post_num') ?: 5);
                    ?>
                    <section class="joe_aside__item newest">
                        <div class="joe_aside__item-title">
                            <i class="joe-font joe-icon-huo"></i>
                            <span class="text">最新文章</span>
                        </div>
                        <div class="joe_aside__item-contain">
                            <ul class="list">
                                <?php foreach ($joeNewest as $joePost): ?>
                                    <li class="item">
                                        <a class="link" href="<?php echo $joePost['url']; ?>"
                                           title="<?php echo $joePost['title']; ?>"><?php echo $joePost['title']; ?></a>
                                        <i class="joe-font joe-icon-link"></i>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </section>
                    <?php
                    break;

                case 'enable_hot_post':
                    $joeHot = joe_hot_posts((int) joe_opt('set_hot_post_num') ?: 5);
                    ?>
                    <section class="joe_aside__item newest">
                        <div class="joe_aside__item-title">
                            <i class="joe-font joe-icon-huo"></i>
                            <span class="text">热门文章</span>
                        </div>
                        <div class="joe_aside__item-contain">
                            <ul class="list">
                                <?php foreach ($joeHot as $joePost): ?>
                                    <li class="item">
                                        <a class="link" href="<?php echo $joePost['url']; ?>"
                                           title="<?php echo $joePost['title']; ?>"><?php echo $joePost['title']; ?></a>
                                        <i class="joe-font joe-icon-link"></i>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </section>
                    <?php
                    break;

                case 'enable_lifetime':
                    ?>
                    <section class="joe_aside__item timelife">
                        <div class="joe_aside__item-title">
                            <i class="joe-font joe-icon-shalou"></i>
                            <span class="text">人生倒计时</span>
                        </div>
                        <div class="joe_aside__item-contain"></div>
                    </section>
                    <?php
                    break;

                case 'show_newreply':
                    if (joe_is_on('enable_clean_mode')) {
                        break;
                    }
                    $joeWalineServer = trim((string) joe_opt('waline_serverURL'));
                    $joeReplyNum = (int) joe_opt('show_newreply_num') ?: 3;
                    ?>
                    <section class="joe_aside__item newreply">
                        <div class="joe_aside__item-title">
                            <i class="joe-font joe-icon-message"></i>
                            <span class="text">最新回复</span>
                        </div>
                        <?php if (joe_opt('comment_option') === 'default' || $joeWalineServer === ''): ?>
                            <ul class="joe_aside__item-contain">
                                <?php foreach (joe_recent_comments($joeReplyNum) as $joeReply): ?>
                                    <li class="item">
                                        <div class="user">
                                            <img width="35" height="35" class="avatar lazyload"
                                                 data-src="<?php echo joe_avatar_url($joeReply['mail'], 35); ?>"
                                                 src="<?php echo joe_lazyload_avatar(); ?>" alt="头像"
                                                 data-text-avatar="<?php echo $joeReply['author']; ?>"
                                                 onload="Joe.loadedPlaceholderReplaceImg(this, 'AvatarImg')"
                                                 onerror="Joe.errorImg(this, 'ErrAvatarImg')" />
                                            <div class="info">
                                                <div class="author"><?php echo $joeReply['author']; ?></div>
                                                <span class="date"><?php echo $joeReply['date']; ?></span>
                                            </div>
                                        </div>
                                        <div class="reply">
                                            <a class="link aside-reply-content"
                                               href="<?php echo $joeReply['permalink']; ?>">
                                                <p><?php echo mb_substr($joeReply['text'], 0, 100); ?></p>
                                            </a>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <ul class="joe_aside__item-contain" id="waline-recent"></ul>
                            <style>
                                .reply img {
                                    display: inline-block;
                                    height: 24px;
                                    max-width: 100%;
                                }
                            </style>
                            <script type="module">
                                import { RecentComments } from '<?php echo joe_opt('waline_js_leaving'); ?>';
                                RecentComments({
                                    serverURL: '<?php echo $joeWalineServer; ?>',
                                    count: <?php echo $joeReplyNum; ?>
                                }).then(({ comments }) => {
                                    document.getElementById('waline-recent').innerHTML = comments
                                        .map((comment) => {
                                            const commentContent = document.createElement('div');
                                            let commentText = '';
                                            commentContent.innerHTML = comment.comment;
                                            const hasAnchor = commentContent.querySelector('a') !== null;
                                            if (hasAnchor) {
                                                commentText = commentContent.textContent;
                                            } else {
                                                commentText = commentContent.outerHTML || commentContent.textContent;
                                            }
                                            const timestamp = new Date(comment.time);
                                            const pad = (n) => (n < 10 ? '0' : '') + n;
                                            const commentTime = `${timestamp.getFullYear()}-${pad(timestamp.getMonth() + 1)}-${pad(timestamp.getDate())} ${pad(timestamp.getHours())}:${pad(timestamp.getMinutes())}:${pad(timestamp.getSeconds())}`;
                                            return `<li class="item">
                                                <div class="user">
                                                    <img width="35" height="35" class="avatar lazyload" data-src="${comment.avatar || ''}" src="${ThemeConfig.lazyload_avatar}" alt="头像" data-text-avatar="${comment.nick}" onload="Joe.loadedPlaceholderReplaceImg(this, 'AvatarImg')" onerror="Joe.errorImg(this, 'ErrAvatarImg')" />
                                                    <div class="info">
                                                        <div class="author">${comment.nick}</div>
                                                        <span class="date">${commentTime}</span>
                                                    </div>
                                                </div>
                                                <div class="reply">
                                                    <a href="${comment.url}" class="link aside-reply-content">${commentText}</a>
                                                </div>`;
                                        })
                                        .join('');
                                });
                            </script>
                        <?php endif; ?>
                    </section>
                    <?php
                    break;

                case 'enable_tag_cloud':
                    $joeTagCloudType = joe_opt('tag_cloud_type');
                    $joeTagNumType = joe_opt('tag_cloud_num_type');
                    ?>
                    <section class="joe_aside__item tags-cloud" id="tags-cloud">
                        <div class="joe_aside__item-title">
                            <i class="joe-font joe-icon-tag"></i>
                            <span class="text">标签云</span>
                            <a class="tags_more" href="<?php echo Typecho\Common::url('tags.html', joe_site_url()); ?>">更多<i
                                    class="joe-font joe-icon-more-right"></i></a>
                        </div>
                        <div class="joe_aside__item-contain">
                            <div class="tags-cloud-list <?php echo joe_opt('tag_cloud_width') === 'responsive' ? 'responsive' : 'static'; ?>"
                                 <?php if ($joeTagCloudType === '3d'): ?>style="display:none"<?php endif; ?>>
                                <?php
                                $joeTagList = joe_tags_all();
                                if ($joeTagNumType === 'num') {
                                    $joeTagList = array_slice($joeTagList, 0, (int) joe_opt('tag_cloud_num') ?: 15);
                                }
                                foreach ($joeTagList as $joeTag):
                                    ?>
                                    <a data-label="<?php echo $joeTag['name']; ?>"
                                       data-url="<?php echo $joeTag['url']; ?>"
                                       href="<?php echo $joeTag['url']; ?>"
                                       title="<?php echo $joeTag['name']; ?>"><?php echo $joeTag['name']; ?></a>
                                <?php endforeach; ?>
                            </div>
                            <?php if ($joeTagCloudType === '3d'): ?>
                                <div id="tags-3d">
                                    <div class="empty">加载中…</div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </section>
                    <?php
                    break;

                case 'enable_category_cloud':
                    $joeCatCloudType = joe_opt('category_cloud_type');
                    $joeCatNumType = joe_opt('category_cloud_num_type');
                    ?>
                    <section class="joe_aside__item tags-cloud" id="categories-cloud">
                        <div class="joe_aside__item-title">
                            <i class="joe-font joe-icon-tag"></i>
                            <span class="text">分类云</span>
                            <a class="tags_more"
                               href="<?php echo Typecho\Common::url('categories.html', joe_site_url()); ?>">更多<i
                                    class="joe-font joe-icon-more-right"></i></a>
                        </div>
                        <div class="joe_aside__item-contain">
                            <div class="categories-cloud-list <?php echo joe_opt('category_cloud_width') === 'responsive' ? 'responsive' : 'static'; ?>"
                                 <?php if ($joeCatCloudType === '3d'): ?>style="display:none"<?php endif; ?>>
                                <?php
                                $joeCatList = joe_categories_all();
                                if ($joeCatNumType === 'num') {
                                    $joeCatList = array_slice($joeCatList, 0, (int) joe_opt('category_cloud_num') ?: 15);
                                }
                                foreach ($joeCatList as $joeCat):
                                    ?>
                                    <a data-label="<?php echo $joeCat['name']; ?>"
                                       data-url="<?php echo $joeCat['url']; ?>"
                                       href="<?php echo $joeCat['url']; ?>"
                                       title="<?php echo $joeCat['name']; ?>"><?php echo $joeCat['name']; ?></a>
                                <?php endforeach; ?>
                            </div>
                            <?php if ($joeCatCloudType === '3d'): ?>
                                <div id="categories-3d">
                                    <div class="empty">加载中…</div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </section>
                    <?php
                    break;

                case 'enable_custom':
                    if (joe_opt('aside_custom_code') === '') {
                        break;
                    }
                    ?>
                    <section class="joe_aside__item aside_custom">
                        <?php echo joe_opt('aside_custom_code'); ?>
                    </section>
                    <?php
                    break;
            }
        }
        ?>
    </aside>
<?php endif; ?>
