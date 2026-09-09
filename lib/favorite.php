<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * 点赞按钮（移植自 Halo 版 modules/macro/favorite.html）
 */
global $JOE_FAVORITE_MODE;
$joeFavMode = isset($JOE_FAVORITE_MODE) ? $JOE_FAVORITE_MODE : 'bottom';
$joeFavLikes = joe_likes_num((int) $this->cid);
$joeFavApi = joe_site_url() . '/?joe_action=like&cid=' . $this->cid;
?>
<?php if ($joeFavMode === 'bottom'): ?>
    <div class="joe_detail__agree">
        <div class="agree" data-joe-like data-joe-like-api="<?php echo $joeFavApi; ?>">
            <div class="icon">
                <i class="joe-font joe-icon-like icon-like"></i>
                <i class="joe-font joe-icon-like-fill icon-unlike"></i>
            </div>
            <span class="nums" data-joe-like-num><?php echo $joeFavLikes; ?></span>
        </div>
    </div>
<?php else: ?>
    <li class="post-operate-like" data-joe-like data-joe-like-api="<?php echo $joeFavApi; ?>">
        <i class="joe-font joe-icon-dianzan icon-like"></i>
        <i class="joe-font joe-icon-dianzan-fill icon-unlike"></i>
        <span class="nums" df="" data-joe-like-num
              classappend="<?php echo $joeFavLikes > 0 ? 'visible' : ''; ?>"
              <?php if ($joeFavLikes > 0): ?>style="display:inline-block"<?php endif; ?>><?php echo $joeFavLikes; ?></span>
    </li>
<?php endif; ?>
