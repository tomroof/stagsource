<div class="content-block instagram-block">
    <div class="content-block-wrap">
    <a href="<?php echo $data->content_source ?>" title="" target="_blank"><img src="<?php echo $data->content_content ;?>" alt=""></a>
    <div class="instagram-block-info">
        <a class="author" href="<?php echo $data->content_source ;?>" target="_blank"><?php echo (!empty($data->instagram_author))?$data->instagram_author:User::getUserFullNameById($data->content_author) ;?></a>
        <p><?php echo CHtml::link(Functions::getPrewText($data->content_title), $data->content_source, array('target' => '_blank'))  ;?></p>
    </div>
    <div class="instagram-icon"></div>
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