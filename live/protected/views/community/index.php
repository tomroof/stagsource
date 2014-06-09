<div class="banner-block-wrap">
<img src="<?php echo Settings::getSettingValue('commmunity_banner'); ?>" alt="" title="" />
    <div class="banner-block banner-block-slider-in">
        <div class="slider-wrap">
            <div id="slides">
                <div class="slides_container">
                    <div class="slide">
                        <h1><?php echo Settings::getSettingValue('commmunity_title') ?></h1>
                        <p><?php echo Settings::getSettingValue('commmunity_text') ?></p>
                        <?php if (!Yii::app()->user->isGuest) { ?>
                            <a id="community_create" href="<?php echo Yii::app()->createUrl('/Community/Create'); ?>"
                               class="but-big but-red link-create-topic">Start a Topic</a>
                        <?php } else { ?>
                            <a id="community_create" href="<?php echo Yii::app()->createUrl('/auth/Registration'); ?>"
                               class="but-big but-red link-create-topic">Start a Topic</a>
                        <?php } ?>
                    </div>
                </div>
                <a href="#" class="prev"><img src="images/bg-arrow-sh-l.png" width="20" height="34"
                                              alt="Arrow Prev"/></a>
                <a href="#" class="next"><img src="images/bg-arrow-sh-r.png" width="20" height="34"
                                              alt="Arrow Next"/></a>
            </div>
        </div>
    </div>
</div>
<div class="block-content-dark">
    <div class="wrap">
        <div class="main-content featured">
            <h2><span>Featured</span></h2>
            <div class="content-block-all">
                <div class="row">
                    <?php
                    $this->widget('zii.widgets.CListView', array(
                        'dataProvider' => $dataProvider,
                        'itemView' => '_community_list',
                        'template' => '{items}<div class="pagination-block"><div class="pagination">{pager}</div></div>',
                        'pager' => array(
                            'cssFile' => false,
                            'prevPageLabel' => '&nbsp;',
                            'nextPageLabel' => '&nbsp;',
                            'header' => '',
                            'maxButtonCount' => '3',
                        ),
                    ));?>
                </div>
            </div>
        </div>
    </div>
</div>