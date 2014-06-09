<div class="block-content-dark">
    <div class="details-main-block <?php echo (empty($prevModel)) ? 'left-empty' : ''; ?>">
        <div class="wrap">

            <?php if (!empty($prevModel)):
                if ($prevModel->content_type == Contents::TYPE_SLIDESHOW_ALBUM) {
                    $this->renderPartial('_contentPrevBlockSlider', array('prevModel' => $prevModel));
                } else
                    $this->renderPartial('_contents_blocks/' . $prevModel->content_type . '/big', array('data' => $prevModel));?>
            <?php endif; ?>

            <div class="center-content-block">
                <?php if (!empty($prevModel)): ?>
                    <a id="prev-sh" href="<?php echo $prevModel->permalink; ?>" class="" style="display: block;"></a>
                <?php endif; ?>

                <div class="content-block image-block-big">
                    <?php Contents::model()->getContentThumbnail($content->content_thumbnail); ?>
                    <?php echo $content->IsPremiumType; ?>
                </div>

                <?php if (!empty($nextModel)): ?>
                    <a id="next-sh" href="<?php echo $nextModel->permalink; ?>" class="" style="display: block;"></a>
                <?php endif; ?>
            </div>

            <?php if (!empty($nextModel)):
                if ($nextModel->content_type == Contents::TYPE_SLIDESHOW_ALBUM) {
                    $this->renderPartial('_contentNextBlockSlider', array('nextModel' => $nextModel));
                } else
                    $this->renderPartial('_contents_blocks/' . $nextModel->content_type . '/big', array('data' => $nextModel));
            endif; ?>

        </div>
    </div>
    <div class="bg-black">&nbsp;</div>
</div>
<div class="block-content-dark" style="overflow: visible;">
    <div class="wrap">
        <div class="main-content" style="overflow: visible;">
            <h2><span><?php echo $content->content_title ?></span></h2>
            <div class="content-block-all content-block-details">
                <?php echo $content->content_content ?>
                
                <?php
                $LinkTags = ContentTag::getLinkTags($content->id);
                if (!empty($LinkTags)) {
                    ?>
                    <div class="block-tags"><span>Tags:</span><?php echo ContentTag::getLinkTags($content->id) ?></div>
                <?php } ?>
            </div>
            <div class="content-block-details-bot">

                <?php $this->renderPartial('addthis_block', array('data' => $content)); ?>

                <?php
                $this->widget(
                        'application.modules.like.components.widgets.LikeWidget', array('model' => $content,
                    'type' => 'like',
                    'template' => '<div class="count">{countLikes}</div><a href="javascript:void(0)"></a>',
                    'containerTag' => 'div',
                    'htmlOptions' => array('class' => 'activity-block heart',))
                );
                ?>

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

                <?php $this->renderPartial('_content_share_block', array('data' => $content)); ?>

            </div>
            <!-- <div class="impression-block-center">
                <h3>Whats your first impression?</h3>
                <?php
//                $this->widget('webroot.protected.modules.poll.components.widgets.PollWidgetFrontendImpression', array('model' => $content,
//                    'view' => '_resultImpression',
//                    'submit' => false,
//                    'return_url' => $content->permalink,
//                    'fixed_issues_type' => 'impression',
//                    'fixed_issues' => array('Laugh', 'Think', 'Furious', 'Happy', 'Sad', 'Inspired', 'Intrigued')));
                ?>
            </div> -->
            <div class="clear">&nbsp;</div>
        </div>
    </div>
</div>
<!-- <?php if (!empty($content->content_is_premium)) { ?>
    <div class="premium-details-wrap">
        <div class="premium-details-block">
            <div class="premium-label">&nbsp;</div>
            <p class="ttl"><?php echo Settings::getSettingValue('premium_services_title') ?></p>
            <p><?php echo Settings::getSettingValue('premium_services_description') ?></p>
            <a class="btn light" href="<?php echo Yii::app()->createUrl('/page/premium-services'); ?>" title="">Learn More</a>
        </div>
    </div>
<?php } ?>
<?php $this->renderPartial('_content_content_block', array('content' => $content)); ?> -->
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
                                            <b><?php echo User::getUserFullNameById($current_user->id) ?></b>
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
                                                <button class="but-big but-red" onclick="jQuery('#comments-form').submit()">Submit</button>
                                            </p>
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
            </div>
        </div>
    </div>
</div>