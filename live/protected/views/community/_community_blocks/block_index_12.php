<div class="content-block community-block">
    <?php $data->getCommunityThumbnail(); ?>
    <p><?php echo CHtml::link(Functions::getPrewText($data->content_title, 75), $data->permalink); ?></p>

    <p class="author"><?php echo CHtml::link('- ' . User::getUserFullNameById($data->content_author),Yii::app()->createUrl('/user/PublicProfile/'.$data->content_author)); ?></p>
<!--    <a class="btn" href="<?php // echo Yii::app()->createUrl('/Community/view', array('c_id' => $data->id)) ;?>">Join Discussion</a>-->

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