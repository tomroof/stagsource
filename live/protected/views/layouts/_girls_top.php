<div>
    <?php if ($data->getImageSrc() != false) { ?>
        <a href="<?php echo $data->permalink ?>" title="">
            <img src="<?php echo ResizeImage::resizeImg($data->getImageSrc(), 164, 87, array('zc' => 1)); ?>" alt=""/>
        </a>
    <?php } ?>
    <p>
        <a href="<?php echo $data->permalink ?>" title="">
            <?php echo $data->content_title; ?>
        </a>
    </p>
</div>