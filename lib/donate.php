<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * 打赏模块（移植自 Halo 版 modules/donate.html）
 */
$joeDonateHas = joe_opt('qrcode_zfb') || joe_opt('qrcode_wx') || joe_opt('qrcode_qq') || trim((string) joe_opt('reward_code')) !== '';
?>
<div class="joe_donate">
    <i class="joe-font joe-icon-shang"></i>
    <?php if ($joeDonateHas): ?>
        <?php
        $joeDonateCount = 0;
        if (joe_opt('qrcode_zfb')) $joeDonateCount++;
        if (joe_opt('qrcode_wx')) $joeDonateCount++;
        if (joe_opt('qrcode_qq')) $joeDonateCount++;
        if (trim((string) joe_opt('reward_code')) !== '') $joeDonateCount++;
        ?>
        <ol class="joe_donate_list<?php echo $joeDonateCount >= 2 ? ' two' : ''; ?>">
            <?php if (joe_opt('qrcode_zfb')): ?>
                <li>
                    <p>支付宝打赏</p>
                    <img src="<?php echo joe_opt('qrcode_zfb'); ?>" alt="qrcode alipay"
                         onerror="Joe.errorImg(this, 'LoadFailedImg')" />
                </li>
            <?php endif; ?>
            <?php if (joe_opt('qrcode_wx')): ?>
                <li>
                    <p>微信打赏</p>
                    <img src="<?php echo joe_opt('qrcode_wx'); ?>" alt="qrcode weixin"
                         onerror="Joe.errorImg(this, 'LoadFailedImg')" />
                </li>
            <?php endif; ?>
            <?php if (joe_opt('qrcode_qq')): ?>
                <li>
                    <p>QQ打赏</p>
                    <img src="<?php echo joe_opt('qrcode_qq'); ?>" alt="qrcode qq"
                         onerror="Joe.errorImg(this, 'LoadFailedImg')" />
                </li>
            <?php endif; ?>
            <?php if (trim((string) joe_opt('reward_code')) !== ''): ?>
                <li><?php echo joe_opt('reward_code'); ?></li>
            <?php endif; ?>
        </ol>
    <?php endif; ?>
</div>
