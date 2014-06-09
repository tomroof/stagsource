<div class="banner-block-wrap">
    <div class="banner-block">
        <a href="#" title=""><img src="/images/banner-logo.png" alt="" /></a>
        <h1>Sports. Music. entertainment.</h1>
    </div>
</div>
<div class="block-content-light">
    <div class="wrap">
        <div class="block-content-in">
            <?php
            $image_src_1 = Settings::getSettingValue('premium_services_block1_image');
            if (!empty($image_src_1)) {
                ?>
                <div class="content-in-img">
                    <img src="<?php echo ResizeImage::resizeImg(Yii::app()->createAbsoluteUrl($image_src_1),234, 234, array('zc' => '1')) ?>" alt="" />
                </div>
            <?php } ?>
            <h2><?php echo Settings::getSettingValue('premium_services_block1_title') ?></h2>
            <p><?php echo Settings::getSettingValue('premium_services_block1_description') ?></p>
        </div>
    </div>
</div>
<div class="block-content-dark">
    <div class="wrap">
        <div class="block-content-in">
            <?php
            $image_src_2 = Settings::getSettingValue('premium_services_block2_image');
            if (!empty($image_src_2)) {
                ?>
                <div class="content-in-img">
                    <img src="<?php echo ResizeImage::resizeImg(Yii::app()->createAbsoluteUrl($image_src_2),234, 234, array('zc' => '1')) ?>" alt="" />
                </div>
            <?php } ?>
            <h2><?php echo Settings::getSettingValue('premium_services_block2_title') ?></h2>
            <p><?php echo Settings::getSettingValue('premium_services_block2_description') ?></p>
        </div>
    </div>
</div>
<div class="block-content-light">
    <div class="wrap">
        <div class="block-content-in">
            <?php
            $image_src_3 = Settings::getSettingValue('premium_services_block3_image');
            if (!empty($image_src_3)) {
                ?>
                <div class="content-in-img">
                    <img src="<?php echo ResizeImage::resizeImg(Yii::app()->createAbsoluteUrl($image_src_3),234, 234, array('zc' => '1')) ?>" alt="" />
                </div>
            <?php } ?>
            <h2><?php echo Settings::getSettingValue('premium_services_block3_title') ?></h2>
            <p><?php echo Settings::getSettingValue('premium_services_block3_description') ?></p>

            <div class="block-learn-more">
                <div class="ttl-block"><h3>Want to Learn More About Us? <a href="#">Let's Talk!</a></h3></div>
                <a href="<?php echo Yii::app()->createUrl('/site/contact'); ?>" class="btn light-big">Contact Us</a></div>
        </div>
    </div>
</div>
</div>
