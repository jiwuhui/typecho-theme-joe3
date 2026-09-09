<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * 相关文章（移植自 Halo 版 modules/macro/relate.html）
 * 使用 Typecho 内置的标签相关文章组件
 */
$joeRelateMax = (int) joe_opt('relate_post_max') ?: 5;
$joeRelate = $this->related($joeRelateMax, 'post');
$joeRelate->to($joeRelatedPosts);
?>
<?php if ($joeRelate->have()): ?>
    <section class="joe_aside__item newest">
        <div class="joe_aside__item-title">
            <i class="joe-font joe-icon-huo"></i>
            <span class="text">相关文章</span>
        </div>
        <div class="joe_aside__item-contain">
            <ul class="list">
                <?php while ($joeRelatedPosts->next()): ?>
                    <li class="item">
                        <a class="link" target="_blank" href="<?php $joeRelatedPosts->permalink(); ?>"
                           title="<?php $joeRelatedPosts->title(); ?>"><?php $joeRelatedPosts->title(); ?></a>
                        <i class="joe-font joe-icon-link"></i>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </section>
<?php endif; ?>
