<div class="content-block article-block-big">
    <div class="content-block-wrap">
    <div class="img-wrap">
        <a href="<?= $data->permalink ?>" title="">
            <?php echo $data->getContentImage(Contents::SIZE_IMAGE_508x508, $data->content_thumbnail,Contents::DEFAULT_IMAGE_BIG); ?>
        </a>
    </div>
    <div class="bot-block">
        <div class="bot-block-in1"><a href="<?= $data->permalink ?>" title=""><?php echo Functions::getPrewText($data->content_title) ?></a></div>
        <div class="bot-block-in2">
            <p></p>
            <p><?php echo Functions::getDateUSA($data->created_at); ?></p>
        </div>
    </div>
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