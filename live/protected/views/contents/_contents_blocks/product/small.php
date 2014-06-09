<div class="content-block article-block product">
    <div class="content-block-wrap">
        <div class="img-wrap">
            <a href="<?= $data->permalink ?>" title="">
                <?php echo $data->getContentImage(Contents::SIZE_IMAGE_250x250, $data->content_thumbnail,Contents::DEFAULT_IMAGE_SMALL); ?>
            </a>
        </div>
        <div class="bot-block">
            <b><a href="<?= $data->permalink ?>" title=""><?php echo Functions::getPrewText($data->content_title) ?></a></b>
            <div class="price-product">$<?php echo (!empty($data->product_price)? round($data->product_price) : '0.00'); ?></div>
            <p><?php echo Functions::getPrewText($data->content_content, 120) ?></p>
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