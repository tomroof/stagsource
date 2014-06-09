<div class="content-block video-block">
    <div class="video-block-in">
        <a href="<?= $data->permalink ?>" title="">
            <?php echo Contents::getContentVideoSizeLink($data->content_video_embed, Contents::VIDEO_SIZE_250x250); ?>
        </a>
    </div>
    <div class="video-block-bot">
        <a href="<?= $data->permalink ?>"><?php echo Functions::getPrewText($data->content_title) ?></a>
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