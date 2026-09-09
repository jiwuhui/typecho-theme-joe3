<?php
/**
 * 友情链接
 *
 * 自定义模板：新建独立页面时选择「友情链接」模板。
 * 友链数据在主题设置「友链 → 友链数据」中维护：
 *   [分组名]
 *   名称|网址|logo|描述
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

global $JOE_HTML_TYPE;
$JOE_HTML_TYPE = 'links';

/* 解析友链数据 */
$joeLinkGroups = [];
$joeCurrentGroup = '友情链接';
foreach (joe_lines('links_data') as $joeLinkRow) {
    $joeFirst = $joeLinkRow[0] ?? '';
    if (count($joeLinkRow) === 1 && preg_match('/^\[.*\]$/', $joeFirst)) {
        $joeCurrentGroup = trim($joeFirst, '[]');
        if ($joeCurrentGroup === '') {
            $joeCurrentGroup = '友情链接';
        }
        if (!isset($joeLinkGroups[$joeCurrentGroup])) {
            $joeLinkGroups[$joeCurrentGroup] = [];
        }
        continue;
    }
    if (count($joeLinkRow) < 2) {
        continue;
    }
    if (!isset($joeLinkGroups[$joeCurrentGroup])) {
        $joeLinkGroups[$joeCurrentGroup] = [];
    }
    $joeLinkGroups[$joeCurrentGroup][] = [
        'name'  => $joeLinkRow[0],
        'url'   => $joeLinkRow[1],
        'logo'  => $joeLinkRow[2] ?? '',
        'desc'  => $joeLinkRow[3] ?? '',
    ];
}

$joeLinkColors = [
    '#F8D800', '#0396FF', '#EA5455', '#7367F0', '#32CCBC', '#F6416C', '#32B76E', '#9F44D3',
    '#F55555', '#736EFE', '#E96D71', '#DE4313', '#D939CD', '#4C83FF', '#F072B6', '#C346C2',
    '#5961F9', '#FD6585', '#5569E8', '#FFC600', '#FA742B', '#5151E5', '#BB4E75', '#FF52E5',
    '#4DA037', '#15D1E2', '#F067B4', '#F067B4', '#ff9a9e', '#00f2fe', '#4facfe', '#f093fb',
    '#6fa3ef', '#bc99c4', '#46c47c', '#f9bb3c', '#e8583d', '#f68e5f',
];

$this->need('header.php');
?>
<div class="joe_container joe_main_container page-journals<?php echo (joe_is_on('enable_show_in_up') ? ' animated showInUp' : '') . (joe_opt('aside_position') === 'left' ? ' revert' : ''); ?>">
    <div class="joe_main">
        <div class="joe_detail">
            <h1 class="joe_detail__title txt-shadow"><?php echo trim((string) joe_opt('links_title')) !== '' ? joe_opt('links_title') : $this->title(); ?></h1>
            <article class="joe_detail__article animated fadeIn">
                <h3>友链列表<span class="totals"> </span></h3>
                <?php $joeColorIndex = 0; ?>
                <?php foreach ($joeLinkGroups as $joeGroupName => $joeGroupLinks): ?>
                    <?php if ($joeGroupName === '' || empty($joeGroupLinks)) {
                        continue;
                    } ?>
                    <div class="links-group">
                        <h5><?php echo $joeGroupName; ?></h5>
                        <ul class="joe_detail__friends evan-friends">
                            <?php foreach ($joeGroupLinks as $joeLink): ?>
                                <?php
                                $joeRandomColor = $joeLinkColors[$joeColorIndex % count($joeLinkColors)];
                                $joeColorIndex++;
                                $joeLogo = $joeLink['logo'] !== '' ? $joeLink['logo'] : joe_default_links_logo();
                                ?>
                                <li class="joe_detail__friends-item">
                                    <a class="contain" href="<?php echo $joeLink['url']; ?>" target="_blank"
                                       style="--fcolor:<?php echo $joeRandomColor; ?>;"
                                       rel="noopener noreferrer">
                                        <div class="evan-f-left">
                                            <div class="f-avatar">
                                                <img width="40" height="40" class="avatar lazyload"
                                                     src="<?php echo joe_lazyload_avatar(); ?>"
                                                     data-src="<?php echo $joeLogo; ?>"
                                                     alt="<?php echo $joeLink['name']; ?>"
                                                     onload="Joe.loadedPlaceholderReplaceImg(this, 'LinksImg')"
                                                     onerror="Joe.errorImg(this, 'LinksErrImg')" />
                                            </div>
                                        </div>
                                        <div class="evan-f-right">
                                                <span class="title" style="--fcolor:<?php echo $joeRandomColor; ?>;">
                                                    <span class="sub-text" title="<?php echo $joeLink['name']; ?>"><?php echo $joeLink['name']; ?></span>
                                                    <svg t="1658027717181" class="icon" viewBox="0 0 1024 1024"
                                                         version="1.1" xmlns="http://www.w3.org/2000/svg"
                                                         p-id="25920" width="200" height="200">
                                                        <path d="M0 0h1024v1024H0V0z" fill="#202425" opacity=".01"
                                                              p-id="25921"></path>
                                                        <path
                                                            d="M989.866667 512c0 263.918933-213.947733 477.866667-477.866667 477.866667S34.133333 775.918933 34.133333 512 248.081067 34.133333 512 34.133333s477.866667 213.947733 477.866667 477.866667z"
                                                            fill="#FF7744" p-id="25922"></path>
                                                        <path
                                                            d="M787.114667 339.285333a51.2 51.2 0 0 1 0 72.362667l-307.2 307.2a51.2 51.2 0 0 1-72.362667 0l-170.666667-170.666667a51.2 51.2 0 0 1 72.362667-72.362666L443.733333 610.235733l271.018667-271.018666a51.2 51.2 0 0 1 72.362667 0z"
                                                            fill="#FFFFFF" p-id="25923"></path>
                                                    </svg>
                                                </span>
                                            <div class="content">
                                                <div class="desc"
                                                     title="<?php echo $joeLink['desc']; ?>"><?php echo $joeLink['desc']; ?></div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </article>
            <article class="joe_detail__article animated fadeIn">
                <?php $this->content(); ?>
            </article>
        </div>
        <div class="joe_comment">
            <?php $this->need('comments.php'); ?>
        </div>
    </div>
    <?php if (joe_is_on('enable_links_aside')): ?>
        <?php $this->need('sidebar.php'); ?>
    <?php endif; ?>
</div>
<?php $this->need('lib/actions.php'); ?>
<?php $this->need('footer.php'); ?>
