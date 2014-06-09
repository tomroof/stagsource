<div class="content-block picture-poll-block-wide">
    <div class="content-block-wrap">
        <p class="ttl"><a href="<?= $data->permalink ?>" title=""><?php echo Functions::getPrewText($data->content_title) ?></a></p>
        <?php
        $this->widget('webroot.protected.modules.poll.components.widgets.PollWidgetfrontend',
            array('model' => $data,'return_url'=>$data->permalink,
                'view'=>'_pollfrontend_img','scripts'=>array('pollwidgetfrontend_img.js'),
                'submit'=>false,
            ));
        ?>
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