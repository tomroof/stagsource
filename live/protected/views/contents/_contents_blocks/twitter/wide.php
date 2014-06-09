<div class="content-block twitter-block-wide">
    <div class="content-block-wrap">
    <p class="author"><?php echo Functions::getPrewText($data->content_title) ?>: </p>
    <a href="<?php echo $data->content_source ?>" title="" target="_blank"><?php echo (mb_strlen($data->content_content)<250)?$data->content_content:substr($data->content_content, 0 , 250) . '...' ;?></a>
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