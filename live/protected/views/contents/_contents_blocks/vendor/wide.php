<div class="content-block article-block-wide celebrity">
    <div class="content-block-wrap">
    <div class="img-wrap">
        <a href="<?php echo $data->permalink ?>" title="">
            <img src="<?php echo $data->getImageSrc(); ?>" alt="">
        </a>
    </div>
        <div class="bot-block">
            <div class="bot-block-in1">
                <a class="ttl" href="<?php echo $data->permalink ?>" title=""><?php echo Functions::getPrewText($data->content_title) ?></a>
<!--                <div class="info">--><?php //echo $data->content_excerpt ?><!--</div>-->
            </div>
            <div class="bot-block-in2">
<!--                <p>--><?php //echo CHtml::link(User::getUserFullNameById($data->content_author), $data->permalink); ?><!--</p>-->
                <p><?php echo date('M d, Y', strtotime($data->created_at)) ?></p>
            </div>
        </div>
    </div>
    <?php  if (!empty($data->content_is_premium)) {
        if ($data->content_is_premium == '1') {
            echo '<div class="pro-black">&nbsp;</div>';
        } elseif ($data->content_is_premium == '2') {
            echo '<div class="pro-white">&nbsp;</div>';
        }
    } ?>
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