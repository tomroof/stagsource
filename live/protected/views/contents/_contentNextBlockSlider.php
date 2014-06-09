<div class="content-block slideshow-block-big">
    <div id="slider" class="flexslider-slideshow">
        <ul class="slides">
            <?php
            if (!empty($nextModel->content_slider_images)) {
                foreach ($nextModel->content_slider_images as $key => $slide) {
                    $this->renderPartial('_content_slider_images', array('data' => $slide, 'permalink' => $nextModel->permalink));
                }
                ?>
            <?php } ?>
        </ul>
    </div>
    <div id="carousel" class="flexslider-slideshow carousel">
        <ul class="slides">
            <?php
            if (!empty($nextModel->content_slider_images)) {
                foreach ($nextModel->content_slider_images as $key => $slide) {
                    if (file_exists(Yii::getPathOfAlias('webroot') . $slide)) {
                        $img = $slide;
                    } else {
                        $img = Contents::DEFAULT_IMAGE_BIG;
                    }
                    ?>
                    <li>
                        <img src="<?= $img ?>"/>
                    </li>
                <?php
                }
            }
            ?>
        </ul>
    </div>
    <?php echo $nextModel->IsPremiumType; ?>
</div>