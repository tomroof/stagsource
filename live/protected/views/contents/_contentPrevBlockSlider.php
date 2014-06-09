<div class="content-block slideshow-block-big">
    <div id="slider3" class="flexslider-slideshow">
        <ul class="slides">
            <?php
            if (!empty($prevModel->content_slider_images)) {
                foreach ($prevModel->content_slider_images as $key => $slide) {
                    $this->renderPartial('_content_slider_images', array('data' => $slide, 'permalink' => $prevModel->permalink));
                }
            }
            ?>
        </ul>
    </div>
    <div id="carousel3" class="flexslider-slideshow carousel">
        <ul class="slides">
            <?php
            if (!empty($prevModel->content_slider_images)) {
                foreach ($prevModel->content_slider_images as $key => $slide) {
                    ?>
                    <li>
                        <img src="<?= $slide ?>"/>
                    </li>
                <?php
                }
            }
            ?>
        </ul>
    </div>
    <?php echo $prevModel->IsPremiumType; ?>
</div>