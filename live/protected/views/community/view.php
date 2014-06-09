<!--<div id="content" class="details-community">-->
<div class="block-content-dark" style="overflow: visible;">
    <div class="wrap">
        <div class="main-content" style="overflow: visible;">
            <h2><span><?php echo $model->content_title; ?></span></h2>
            <div class="content-block-all content-block-details">

                <?php echo $model->content_content ?>
                
                <?php
                $LinkTags = ContentTag::getLinkTags($model->id);
                if (!empty($LinkTags)) {
                    ?>
                    <div class="block-tags"><span>Tags:</span><?php echo ContentTag::getLinkTags($model->id) ?></div>
                <?php } ?>
            </div>
            <div class="content-block-details-bot">

                <?php $this->renderPartial('addthis_block', array('data' => $model)); ?>

                <?php
                $this->widget(
                        'application.modules.like.components.widgets.LikeWidget', array('model' => $model,
                    'type' => 'like',
                    'template' => '<div class="count">{countLikes}</div><a href="javascript:void(0)"></a>',
                    'containerTag' => 'div',
                    'htmlOptions' => array('class' => 'activity-block heart',))
                );
                ?>

                <?php
                $this->widget(
                        'application.modules.like.components.widgets.LikeWidget', array('model' => $model,
                    'type' => 'favorite',
                    'template' => '<div class="count">{countLikes}</div><a href="javascript:void(0)"></a>',
                    'containerTag' => 'div',
                    'htmlOptions' => array('class' => 'activity-block plus',))
                );
                ?>

                <?php $this->renderPartial('_share_block', array('data' => $model)); ?>

            </div>
            <!-- <div class="impression-block-center">
                <h3>Whats your first impression?</h3>
                <?php
                $this->widget('webroot.protected.modules.poll.components.widgets.PollWidgetFrontendImpression', array('model' => $model,
                    'view' => '_resultImpression',
                    'submit' => false,
                    'return_url' => $model->permalink,
                    'fixed_issues_type' => 'impression',
                    'fixed_issues' => array('Laugh', 'Think', 'Furious', 'Happy', 'Sad', 'Inspired', 'Intrigued')));
                ?>
            </div> -->
            <div  class="block-community_create">
                <?php if (!Yii::app()->user->isGuest) { ?>
                    <a id="community_create" href="<?php echo Yii::app()->createUrl('/Community/Create'); ?>"
                       class="but-big but-red">Start a Topic</a>
                <?php } else { ?>
                    <a id="community_create" href="<?php echo Yii::app()->createUrl('/auth/Registration'); ?>"
                       class="but-big but-red">Start a Topic</a>
                <?php } ?>
            </div>
            <div class="clear">&nbsp;</div>
        </div>
    </div>
</div>
<!-- <?php if (!empty($model->content_is_premium)) { ?>
    <div class="premium-details-wrap">
        <div class="premium-details-block">
            <div class="premium-label">&nbsp;</div>
            <p class="ttl"><?php echo Settings::getSettingValue('premium_services_title') ?></p>

            <p><?php echo Settings::getSettingValue('premium_services_description') ?></p>
            <a class="btn light" href="<?php echo Yii::app()->createUrl('/page/premium-services'); ?>" title="">Learn
                More</a>
        </div>
    </div>
<?php } ?> -->
<!-- <?php if (!empty($model->content_content)) {?>
<div class="block-content-dark">
    <div class="wrap">
    <div><?php echo $model->content_content ?></div>
    </div>
</div>
<?php   } ?> -->
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
                                            <b><?php echo User::getUserFullNameById($current_user->id);?></b>


                                            <?php if ($current_user->city_id): ?>
                                                <?php echo $current_user->state_id ? '<p><span>' . $current_user->zipareas->city . '</span></p><p> ' . $current_user->state_id . '</p>' : '' ?>
                                            <?php endif ?>

                                                                                                                                                <!--                                        <p><span>Santa Monica</span></p>
                                                                                                                                                                                        <p>California</p>-->
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
                    //'model' => $model,
                    'itemView' => '_comments_list', // refers to the partial view named '_post'
                    'template' => "{items}",
                    'emptyText' => '',
                    'viewData' => array('current_user' => $current_user)
                        // 'emptyText' => "Not found comments",
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
                    'dataProvider' => Contents::model()->searchCommunity(8),
                    'template' => '{items}',
                    'itemView' => '_community_details_box',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<!--</div>-->