<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * 博主信息卡片（移植自 Halo 版 modules/common/blogger.html）
 */
$joeStats = joe_stats();
?>
<section class="joe_aside__item author">
    <img width="100%" height="120" class="image lazyload"
         data-src="<?php echo joe_opt('author_bg') ?: joe_asset('img/author_bg.jpg'); ?>"
         src="<?php echo joe_asset('img/author_bg.jpg'); ?>" alt="博主栏壁纸" onerror="Joe.errorImg(this)" />
    <div class="user">
        <div class="avatar_wrapper<?php echo joe_opt('avatar_type') === 'circle' ? ' circle' : ' round'; ?>">
            <img class="avatar lazyload"
                 data-src="<?php echo joe_opt('avatar') ?: joe_default_avatar(); ?>"
                 src="<?php echo joe_lazyload_avatar(); ?>" alt="博主头像"
                 data-text-avatar="<?php echo joe_blogger_name(); ?>"
                 onload="Joe.loadedPlaceholderReplaceImg(this, 'AvatarImg')"
                 onerror="Joe.errorImg(this, 'ErrAvatarImg')" />
            <?php if (joe_opt('avatar_frame') && joe_opt('avatar_frame') !== '0'): ?>
                <img class="avatar_frame <?php echo joe_opt('avatar_frame'); ?>"
                     src="<?php echo joe_asset('frame/' . joe_opt('avatar_frame') . '.png'); ?>" alt="挂架" />
            <?php endif; ?>
            <?php if (joe_opt('avatar_widget') && joe_opt('avatar_widget') !== '0'): ?>
                <img class="avatar_widget <?php echo joe_opt('avatar_widget'); ?>"
                     src="<?php echo joe_asset('widget/' . joe_opt('avatar_widget') . '.gif'); ?>" alt="相框" />
            <?php endif; ?>
        </div>
        <a class="link" href="<?php echo joe_site_url(); ?>" target="_blank" rel="noopener noreferrer nofollow">
            <?php echo joe_blogger_name(); ?>
            <?php if (joe_is_on('enable_blogger_level')): ?>
                <img class="level" src="<?php echo joe_asset('svg/level_1.svg'); ?>" alt="博主等级" />
            <?php endif; ?>
        </a>
        <?php if (joe_opt('motto') !== ''): ?>
            <p class="motto joe_motto"><?php echo joe_opt('motto'); ?></p>
        <?php elseif (joe_is_on('enable_day_words')): ?>
            <img class="motto_day_words" height="14"
                 src="https://v2.jinrishici.com/one.svg?font-size=146&spacing=2&color=grey" />
        <?php endif; ?>
    </div>
    <div class="count">
        <?php
        $joeWalineServer = trim((string) joe_opt('waline_serverURL'));
        $joeUseWaline = joe_opt('comment_option') === 'waline' && $joeWalineServer !== '';
        $joeOverview = joe_opt('overview_type');
        ?>
        <?php if ($joeOverview === 'A'): ?>
            <div class="item" title="累计分类数 <?php echo $joeStats['categories']; ?>">
                <span class="num"><?php echo $joeStats['categories']; ?></span>
                <span>分类数</span>
            </div>
            <div class="item" title="累计标签数 <?php echo $joeStats['tags']; ?>">
                <span class="num"><?php echo $joeStats['tags']; ?></span>
                <span>标签数</span>
            </div>
            <div class="item" title="累计文章数 <?php echo $joeStats['posts']; ?>">
                <span class="num"><?php echo $joeStats['posts']; ?></span>
                <span>文章数</span>
            </div>
        <?php elseif ($joeOverview === 'B'): ?>
            <div class="item" title="累计分类数 <?php echo $joeStats['categories']; ?>">
                <span class="num"><?php echo $joeStats['categories']; ?></span>
                <span>分类数</span>
            </div>
            <div class="item" title="累计标签数 <?php echo $joeStats['tags']; ?>">
                <span class="num"><?php echo $joeStats['tags']; ?></span>
                <span>标签数</span>
            </div>
            <?php if (!$joeUseWaline): ?>
                <div class="item" title="累计评论数 <?php echo $joeStats['comments']; ?>">
                    <span class="num"><?php echo $joeStats['comments']; ?></span>
                    <span>评论数</span>
                </div>
            <?php else: ?>
                <div class="item waline-comment" title="">
                    <span class="num">0</span>
                    <span>评论数</span>
                </div>
            <?php endif; ?>
        <?php elseif ($joeOverview === 'C'): ?>
            <div class="item" title="累计分类数 <?php echo $joeStats['categories']; ?>">
                <span class="num"><?php echo $joeStats['categories']; ?></span>
                <span>分类数</span>
            </div>
            <div class="item" title="累计文章数 <?php echo $joeStats['posts']; ?>">
                <span class="num"><?php echo $joeStats['posts']; ?></span>
                <span>文章数</span>
            </div>
            <?php if (!$joeUseWaline): ?>
                <div class="item" title="累计评论数 <?php echo $joeStats['comments']; ?>">
                    <span class="num"><?php echo $joeStats['comments']; ?></span>
                    <span>评论数</span>
                </div>
            <?php else: ?>
                <div class="item waline-comment" title="">
                    <span class="num">0</span>
                    <span>评论数</span>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="item" title="累计标签数 <?php echo $joeStats['tags']; ?>">
                <span class="num"><?php echo $joeStats['tags']; ?></span>
                <span>标签数</span>
            </div>
            <div class="item" title="累计文章数 <?php echo $joeStats['posts']; ?>">
                <span class="num"><?php echo $joeStats['posts']; ?></span>
                <span>文章数</span>
            </div>
            <?php if (!$joeUseWaline): ?>
                <div class="item" title="累计评论数 <?php echo $joeStats['comments']; ?>">
                    <span class="num"><?php echo $joeStats['comments']; ?></span>
                    <span>评论数</span>
                </div>
            <?php else: ?>
                <div class="item waline-comment" title="">
                    <span class="num">0</span>
                    <span>评论数</span>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <?php if (joe_is_on('enable_weather') && joe_opt('weather_token') !== ''): ?>
        <div id="tp-weather-widget"></div>
    <?php endif; ?>
    <?php
    $joeSocials = joe_lines('socials');
    $joeCustomSocials = joe_lines('custom_socials');
    ?>
    <?php if ((!empty($joeSocials) || !empty($joeCustomSocials)) && joe_is_on('enable_social')): ?>
        <?php if (joe_opt('option_social_data') === 'custom' && !empty($joeCustomSocials)): ?>
            <div class="social-account">
                <?php foreach ($joeCustomSocials as $joeSocial): ?>
                    <?php if (count($joeSocial) < 2) { continue; } ?>
                    <?php echo isset($joeSocial[2]) && $joeSocial[2] !== '' ? $joeSocial[2] : joe_social_icon('github', $joeSocial[1]); ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="social-account">
                <?php foreach ($joeSocials as $joeSocial): ?>
                    <?php if (count($joeSocial) < 2) { continue; } ?>
                    <?php echo joe_social_icon($joeSocial[0], $joeSocial[1]); ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (joe_is_on('enable_strips')): ?>
        <canvas id="canvas-strips" width="300" height="340"></canvas>
        <script src="<?php echo joe_asset('effect/bg/strips.js'); ?>"></script>
    <?php endif; ?>
</section>
