<div class="block-content-gray">
    <div class="wrap">
        <div class="block-content-in celebrity-top-block event-top-block">
            <div class="content-img">
                <div class="content-in-img">
                    <a title=""><img src="<?php echo $content->getImageSrc(); ?>" width="185" alt="" /></a>
                </div>
                <div class="clear">&nbsp;</div>
                <?php if (!empty($content->content_source)) { ?>
                <a class="but-big but-green" href="<?php echo $content->content_source ?>" target="_blank">Buy Tickets</a>
                <?php } ?>
            </div>
            <div class="content-info">
                <h2><?php echo $content->content_title ?></h2>
                <span><?php echo date('F d, Y - ga', strtotime($content->created_at)) ?></span>
            </div>
            <p><?php echo $content->content_content ?></p>
            <?php
            $LinkTags = ContentTag::getLinkTags($content->id);
            if (!empty($LinkTags)) {
                ?>
                <div class="block-tags"><span>Tags:</span><?php echo ContentTag::getLinkTags($content->id) ?></div>
            <?php } ?>
            <div class="content-block-details-bot">
                <?php $this->renderPartial('addthis_block', array('data' => $content)); ?>
                <?php
                $this->widget(
                        'application.modules.like.components.widgets.LikeWidget', array('model' => $content,
                    'type' => 'like',
                    'template' => '<div class="count">{countLikes}</div><a href="javascript:void(0)"></a>',
                    'containerTag' => 'div',
                    'htmlOptions' => array('class' => 'activity-block heart',))
                );
                ?>

                <?php
                $this->widget(
                        'application.modules.like.components.widgets.LikeWidget', array('model' => $content,
                    'type' => 'favorite',
                    'template' => '<div class="count">{countLikes}</div><a href="javascript:void(0)"></a>',
                    'containerTag' => 'div',
                    'htmlOptions' => array('class' => 'activity-block plus',))
                );
                ?>

                <?php $this->renderPartial('_content_share_block', array('data' => $content)); ?>
            </div>
        </div>
    </div>
</div>
<?php if (!empty($content->content_slider_images) || !empty($content->content_video_embed)) { ?>

    <div class="block-content-dark profile-dancer-block">
        <div class="wrap">
            <div class="main-content" style="padding-top:0;">
                <div class="content-block-all">
                    <!--                <div class="content-block instagram-block-big profile_dancer">-->
                    <!--                    <img src="-->
                    <?php //echo Yii::app()->request->baseUrl; ?><!--/images/img-dancer-1.jpg" alt="" />-->
                    <!--                </div>-->
                    <?php if (!empty($content->content_slider_images)) { ?>
                        <div class="content-block slideshow-block-big">
                            <div id="slider2" class="flexslider-slideshow">
                                <ul class="slides">
                                    <?php
                                    if (!empty($content->content_slider_images)) {
                                        foreach ($content->content_slider_images as $key => $slide) {
                                            $this->renderPartial('_content_slider_images', array('data' => $slide, 'permalink' => '#'));
                                        }
                                        ?>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div id="carousel2" class="flexslider-slideshow carousel">
                                <ul class="slides">
                                    <?php
                                    if (!empty($content->content_slider_images)) {
                                        foreach ($content->content_slider_images as $key => $slide) {
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
                        </div>

                        <?php
                    } else {
                        ?>
                        <div class="content-block instagram-block-big profile_dancer">
                            <?php echo CHtml::image('/images/img-dancer-1.jpg'); ?>
                        </div>
                        <?php }
                    ?>
                    <div class="content-block instagram-block-big">
                        <?php
                        if (!empty($content->content_video_embed)) {
                            echo Contents::getContentVideoSizeLink($content->content_video_embed, Contents::VIDEO_SIZE_508x508_DENSER);
                        } else {
                            echo CHtml::image('/images/img-dancer-1.jpg');
                        }
                        ?>
                    </div>
                    <div class="clear">&nbsp;</div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
