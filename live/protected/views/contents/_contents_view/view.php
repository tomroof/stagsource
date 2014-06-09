<div id="slider-home-all">
    <div id="slider-home">
        <div class="slider-home-in">
            <a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/img-slider-home-1.jpg" alt="" /></a>
            <div style="z-index: 9999;" class="info-slider-home">
                <h1>The 700 LVL girls The 700 LVL girls</h1>
            </div>
            <div class="bg-black">&nbsp;</div>
        </div>
        <div class="slider-home-in">
            <a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/img-slider-home-1.jpg" alt="" /></a>
            <div style="z-index: 9999;" class="info-slider-home">
                <h1>The 700 LVL girls</h1>
            </div>
            <div class="bg-black">&nbsp;</div>
        </div>
        <div class="slider-home-in">
            <a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/img-slider-home-1.jpg" alt="" /></a>
            <div style="z-index: 9999;" class="info-slider-home">
                <h1>The 700 LVL girls The 700 LVL girls</h1>
            </div>
            <div class="bg-black">&nbsp;</div>
        </div>
        <div class="slider-home-in">
            <a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/img-slider-home-1.jpg" alt="" /></a>
            <div style="z-index: 9999;" class="info-slider-home">
                <h1>The 700 LVL girls</h1>
            </div>
            <div class="bg-black">&nbsp;</div>
        </div>
        <div class="slider-home-in">
            <a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/img-slider-home-1.jpg" alt="" /></a>
            <div style="z-index: 9999;" class="info-slider-home">
                <h1>The 700 LVL girls The 700 LVL girls</h1>
            </div>
            <div class="bg-black">&nbsp;</div>
        </div>
        <div class="slider-home-in">
            <a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/img-slider-home-1.jpg" alt="" /></a>
            <div style="z-index: 9999;" class="info-slider-home">
                <h1>The 700 LVL girls</h1>
            </div>
            <div class="bg-black">&nbsp;</div>
        </div>
    </div>
    <a id="prev-sh" href="#"></a>
    <a id="next-sh" href="#"></a>
</div>
<div class="block-content-light">
    <div class="wrap">
        <div class="impression-block">
            <div class="impression-block-in">
                <?php
                $this->widget(
                        'application.modules.like.components.widgets.LikeWidget', array('model' => $content,
                    'type' => 'like',
                    'template' => '<div class="count">{countLikes}</div><a href="javascript:void(0)"></a>',
                    'containerTag' => 'div',
                    'htmlOptions' => array('class' => 'activity-block heart',))
                );
                ?>

                 <?php $this->renderPartial('addthis_block', array('data' => $content)); ?>

                <?php
//                $this->widget(
//                    'application.modules.like.components.widgets.LikeWidget',
//                    array('model'       => $model,
//                          'type' => 'star',
//                          'template' => '<div class="count">{countLikes}</div><a href="#"></a>',
//                         'containerTag' => 'div',
//                          'htmlOptions' => array('class' => 'activity-block star',))
                //               );
                ?>

                <?php
                $this->widget(
                        'application.modules.like.components.widgets.LikeWidget', array('model' => $content,
                    'type' => 'favorite',
                    'template' => '<div class="count">{countLikes}</div><a href="javascript:void(0)"></a>',
                    'containerTag' => 'div',
                    'htmlOptions' => array('class' => 'activity-block plus',))
                );
                ?>

                <h1><?= $content->content_title ?></h1>
            </div>
            <div class="impression-block-center">
                <h3>Whats your first impression?</h3>
                <a href="#" class="impression-box">
                    <b>52<span>%</span></b>
                    <span class="impress">Laugh</span>
                    <span class="marked"></span>
                </a>
                <a href="#" class="impression-box">
                    <b>5<span>%</span></b>
                    <span class="impress">Think</span>
                    <span class="marked"></span>
                </a>
                <a href="#" class="impression-box">
                    <b>11<span>%</span></b>
                    <span class="impress">Furious</span>
                    <span class="marked"></span>
                </a>
                <a href="#" class="impression-box checked">
                    <b>11<span>%</span></b>
                    <span class="impress">Happy</span>
                    <span class="marked"></span>
                </a>
                <a href="#" class="impression-box">
                    <b>14<span>%</span></b>
                    <span class="impress">Sad</span>
                    <span class="marked"></span>
                </a>
                <a href="#" class="impression-box">
                    <b>7<span>%</span></b>
                    <span class="impress">Inspired</span>
                    <span class="marked"></span>
                </a>
                <a href="#" class="impression-box">
                    <b>7<span>%</span></b>
                    <span class="impress">Intrigued</span>
                    <span class="marked"></span>
                </a>
            </div>
            <?php $this->renderPartial('_content_share_block', array('data' => $content)); ?>
        </div>
    </div>
</div>
<?php if (!empty($content->content_is_premium)) { ?>
    <div class="premium-details-wrap">
        <div class="premium-details-block">
            <div class="premium-label">&nbsp;</div>
            <p class="ttl"><?php echo Settings::getSettingValue('premium_services_title') ?></p>
            <p><?php echo Settings::getSettingValue('premium_services_description') ?></p>
            <a class="btn light" href="<?php echo Yii::app()->createUrl('/page/premium-services'); ?>" title="">Learn More</a>
        </div>
    </div>
<?php } ?>
<div class="block-content-dark">
    <div class="wrap">
        <div class="slider-wrap">
            <div id="slides">
                <div class="slides_container">
                    <?php
                    if (!empty($model->content_content)) {
                        foreach ($model->content_content as $content) {
                            ?>
                            <div class="slide">
                                <?php echo $content; ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <a href="#" class="prev"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bg-arrow-sh-l.png" width="20" height="34" alt="Arrow Prev" /></a>
                <a href="#" class="next"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bg-arrow-sh-r.png" width="20" height="34" alt="Arrow Next" /></a>
            </div>
        </div>
    </div>
</div>
<div class="block-content-light">
    <div class="wrap">
        <div class="block-content-in">

            <?php
            if (!Yii::app()->user->isGuest) {
                if ($current_user) {
                    ?>
                    <div class="block-comment block-comment-white block-comment-write">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'comments-form',
                            'enableAjaxValidation' => false,
                            'htmlOptions' => array(
                                'autocomplete' => 'off',
                                'class' => 'add_comment_form'
                            ),
                                ));
                        ?>
                        <table cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="block-comment-img">
                                            <div class="photo-avatar">
                                                <?php echo $current_user->getUserAvatar() ?>   
                                            </div>
                                            <b><?= $current_user->first_name . ' ' . $current_user->last_name ?></b>
                                            <?php if ($current_user->city_id): ?>
                                                <?php echo $current_user->state_id ? '<p><span>' . $current_user->zipareas->city . '</span></p><p> ' . $current_user->state_id . '</p>' : '' ?>
                                            <?php endif ?>                                                                                                         
                                        </div>
                                    </td>
                                    <td>
                                        <div class="block-comment-gray">
                                            <span class="block-comment-arrow"> &nbsp; </span>
                                            <p class="label text-3">
                                                <label for="text-com">Write your comment here.</label>
                                                <?php echo $form->textArea($new_comment, 'content', array('size' => 20, 'maxlength' => 255, 'id' => 'text-com')); ?>
                                            </p>
                                            <button class="but-big but-red" onclick="jQuery('#comments-form').submit()">Submit</button>
                                            <?php echo $form->error($new_comment, 'content'); ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?php $this->endWidget(); ?>
                    </div>
                <?php } ?>
                <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $dataProvider,
                    'itemView' => '_comments_list', // refers to the partial view named '_post'
                    'template' => "{items}",
                    'emptyText' => '',
                    'viewData' => array('current_user' => $current_user)
                ));
            } else {
                ?>
                <span class="span_comment_sign_up">TO LEAVE A COMMENT, <a class="link_comment_sign_up" href="#header">SIGN UP</a> NOW</span>
            <?php } ?>
        </div>
    </div>
</div>
<div class="block-content-dark">
    <div class="wrap">
        <div class="content-block-all">

            <div class="row">
                <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => Contents::model()->searchNotCommunity(8),
                    'template' => '{items}',
                    'itemView' => '_contents_details_box',
                ));
                ?>
                <!--                <div class="content-block video-block">
                                    <a href="#" title=""><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/video-img.png" alt="" /></a>
                                    <div class="play-btn"></div>
                                    <div class="premium"> &nbsp; </div>
                                    <div class="like-block"> &nbsp; </div>
                                    <div class="repost-block"> &nbsp; </div>
                                </div>
                
                                <div class="content-block video-block">
                                    <a href="#" title=""><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/video-img2.png" alt="" /></a>
                                    <div class="play-btn-white"></div>
                                    <div class="like-block"> &nbsp; </div>
                                    <div class="repost-block"> &nbsp; </div>
                                </div>
                                <div class="content-block video-block">
                                    <a href="#" title=""><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/video-img.png" alt="" /></a>
                                    <div class="play-btn"></div>
                                    <div class="premium"> &nbsp; </div>
                                    <div class="like-block"> &nbsp; </div>
                                    <div class="repost-block"> &nbsp; </div>
                                </div>
                                <div class="content-block video-block">
                                    <a href="#" title=""><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/video-img2.png" alt="" /></a>
                                    <div class="play-btn-white"></div>
                                    <div class="like-block"> &nbsp; </div>
                                    <div class="repost-block"> &nbsp; </div>
                                </div>-->
            </div>

            <!--            <div class="row">
                            <div class="content-block video-block">
                                <a href="#" title=""><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/video-img.png" alt="" /></a>
                                <div class="play-btn"></div>
                                <div class="premium"> &nbsp; </div>
                                <div class="like-block"> &nbsp; </div>
                                <div class="repost-block"> &nbsp; </div>
                            </div>
                            <div class="content-block video-block">
                                <a href="#" title=""><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/video-img2.png" alt="" /></a>
                                <div class="play-btn-white"></div>
                                <div class="like-block"> &nbsp; </div>
                                <div class="repost-block"> &nbsp; </div>
                            </div>
                            <div class="content-block video-block">
                                <a href="#" title=""><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/video-img.png" alt="" /></a>
                                <div class="play-btn"></div>
                                <div class="premium"> &nbsp; </div>
                                <div class="like-block"> &nbsp; </div>
                                <div class="repost-block"> &nbsp; </div>
                            </div>
                            <div class="content-block video-block">
                                <a href="#" title=""><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/video-img2.png" alt="" /></a>
                                <div class="play-btn-white"></div>
                                <div class="like-block"> &nbsp; </div>
                                <div class="repost-block"> &nbsp; </div>
                            </div>
                        </div>-->

        </div>
    </div>
</div>