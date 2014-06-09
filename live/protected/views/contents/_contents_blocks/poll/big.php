<div class="content-block poll-block-big">
    <a href="<?= $data->permalink ?>" title=""><?php echo Functions::getPrewText($data->content_title) ?></a>
    <?php
    $this->widget('webroot.protected.modules.poll.components.widgets.PollWidgetfrontend', array('model' => $data,'return_url'=>$data->permalink));
    ?>
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