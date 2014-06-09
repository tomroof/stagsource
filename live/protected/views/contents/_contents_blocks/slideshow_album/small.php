<div class="content-block slideshow-block">
    <div class="flexslider">
        <ul class="slides">
            <?php
            if (!empty($data->content_slider_images)) {
                foreach ($data->content_slider_images as $slide) {
                    if(file_exists(Yii::getPathOfAlias('webroot') . $slide)){
                        $img=$slide;
                    }else{
                        $img=Contents::DEFAULT_IMAGE_BIG;
                    }
                    ?>
                    <li data-thumb="<?php echo $img ;?>">
                        <a href="<?= $data->permalink ?>" title=""><img src="<?php echo $img ;?>" /></a>
                        <img src="<?= $img ?>"/>
                    </li>
                <?php
                }
            }
            ?>
        </ul>
    </div>
    <?php echo $data->IsPremiumType; ?>
   <?php
    $this->widget(
            'application.modules.like.components.widgets.LikeWidget', array('model' => $data,
        'type' => 'like',
        'template' => '<div class="count">{countLikes}</div><a href="javascript:void(0)"></a>',
        'containerTag' => 'div',
        'htmlOptions' => array('class' => 'like-block',)
            )
    );
    ?>
    <?php
    $this->widget(
            'application.modules.like.components.widgets.LikeWidget', array('model' => $data,
        'type' => 'favorite',
        'template' => '<div class="count">{countLikes}</div><a href="javascript:void(0)"></a>',
        'containerTag' => 'div',
        'htmlOptions' => array('class' => 'repost-block',))
    );
    ?>
</div>
