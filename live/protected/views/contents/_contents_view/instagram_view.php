<div class="block-content-dark">
    <div class="details-main-block <?php echo (empty($prevModel)) ? 'left-empty' : ''; ?>">
        <div class="wrap">

            <?php if (!empty($prevModel)): ?>
                <div class="content-block instagram-block-big">
                    <?php if ($prevModel->content_thumbnail != null) { ?>
                        <div class="img-wrap">
                            <img src="<?php echo $prevModel->content_thumbnail; ?>" alt="" />
                        </div>
                    <?php } ?>

                    <div class="instagram-block-info">
                        <a class="author" href="#"><?php echo User::getUserFullNameById($prevModel->content_author); ?></a>
                        <p>Just another morning on Silicon Beach...</p>
                        <a class="inst-link" href="#" title="">#siliconbeachla</a>
                        <a class="inst-link" href="#" title="">#santamonica</a>
                        <a class="inst-link" href="#" title="">#thegoodlife</a>
                    </div>
                    <div class="instagram-icon"></div>
                    <?php echo $prevModel->IsPremiumType; ?>
                </div>
            <?php endif; ?>

            <div class="center-content-block">
                <?php if (!empty($prevModel)): ?>
                    <a id="prev-sh" href="<?php echo Yii::app()->createUrl('/contents/view', array('id' => $prevModel->id)); ?>" class="" style="display: block;"></a>
                <?php endif; ?>

                <div class="content-block instagram-block-big">
                    <?php if ($content->content_thumbnail != null) { ?>
                        <div class="img-wrap">
                            <img src="<?php echo $content->content_thumbnail; ?>" alt="" />
                        </div>
                    <?php } ?>
                    <div class="instagram-block-info">
                        <a class="author" href="#"><?php echo User::getUserFullNameById($content->content_author); ?></a>
                        <p>Just another morning on Silicon Beach...</p>
                        <a class="inst-link" href="#" title="">#siliconbeachla</a>
                        <a class="inst-link" href="#" title="">#santamonica</a>
                        <a class="inst-link" href="#" title="">#thegoodlife</a>
                    </div>
                    <div class="instagram-icon"></div>
                    <?php echo $content->IsPremiumType; ?>
                </div>

                <?php if (!empty($nextModel)): ?>
                    <a id="next-sh" href="<?php echo Yii::app()->createUrl('/contents/view', array('id' => $nextModel->id)); ?>" class="" style="display: block;"></a>
                <?php endif; ?>
            </div>

            <?php if (!empty($nextModel)): ?>
                <div class="content-block instagram-block-big">
                    <?php if ($nextModel->content_thumbnail != null) { ?>
                        <div class="img-wrap">
                            <img src="<?php echo $nextModel->content_thumbnail; ?>" alt="" />
                        </div>
                    <?php } ?>
                    <div class="instagram-block-info">
                        <a class="author" href="#"><?php echo User::getUserFullNameById($nextModel->content_author); ?></a>
                        <p>Just another morning on Silicon Beach...</p>
                        <a class="inst-link" href="#" title="">#siliconbeachla</a>
                        <a class="inst-link" href="#" title="">#santamonica</a>
                        <a class="inst-link" href="#" title="">#thegoodlife</a>
                    </div>
                    <div class="instagram-icon"></div>
                    <?php echo $nextModel->IsPremiumType; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
    <div class="bg-black">&nbsp;</div>
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



                <h1><?php echo $content->content_title ?></h1>
            </div>
            <div class="impression-block-center">
                <h3>Whats your first impression?</h3>
                <?php
                $this->widget('webroot.protected.modules.poll.components.widgets.PollWidgetFrontendImpression', array('model' => $content,
                    'view' => '_resultImpression',
                    'submit' => false,
                    'return_url' => $content->permalink,
                    'fixed_issues_type' => 'impression',
                    'fixed_issues' => array('Laugh', 'Think', 'Furious', 'Happy', 'Sad', 'Inspired', 'Intrigued')));
                ?>
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
<?php $this->renderPartial('_content_content_block', array('content' => $content)); ?>
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
