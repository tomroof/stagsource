<div class="content-block fb-block">
    <div class="content-block-wrap">
    <p class="author"><?php echo Functions::getPrewText($data->content_title) ;?>: </p>
    <a href="<?= $data->content_facebook_link ?>" target="_blank" title=""><?php echo (mb_strlen($data->content_content)<120)?$data->content_content:substr($data->content_content, 0 , 120) . '...' ;?></a>
    <p class="time"><?php echo date('H:i A', strtotime($data->created_at)) ;?></p>
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