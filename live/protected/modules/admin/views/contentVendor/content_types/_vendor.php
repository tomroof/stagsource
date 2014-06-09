<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'contents-form',
        'enableAjaxValidation' => false,
            ));
    ?>

    <div class="widgets">
        <div class="twoOne">
            <div class="widget">
                <div class="header"><span><span class="ico gray window"></span>  Main Information   </span></div>
                <div class="content">
                    <?php echo $form->errorSummary($model); ?>
                    <div class="row">
                        <?php echo $form->labelEx($model, 'content_title'); ?>
                        <?php echo $form->textField($model, 'content_title'); ?>
                    </div>
                    <div class="row">
                        <?php echo $form->labelEx($model, 'content_slug'); ?>
                        <?php echo $form->textField($model, 'content_slug'); ?>
                    </div>
                    <div class="row">
                        <?php echo $form->labelEx($model, 'content_sub_title'); ?>
                        <?php echo $form->textField($model, 'content_sub_title'); ?>
                    </div>
                    <div class="row">
                        <?php
                        echo $form->labelEx($model,'content_content');
                        echo Chtml::openTag('div',array('class' => 'row-in'));
                        echo $form->textArea($model,'content_content',array('rows' => 10, 'cols' => 50, 'class' => 'redactor'));
                        echo Chtml::closeTag('div');
                        ?>
                    </div>
                    <div class="row">
                        <div class="block_callback">
                            <?php echo $form->labelEx($model, 'content_thumbnail'); ?>
                            <div class="row-in">
                                <div class="block_callback_img">
                                    <?php if ($model->content_thumbnail != null) { ?>
                                        <img
                                            src="<?php echo Yii::app()->createAbsoluteUrl($model->content_thumbnail) ?>"
                                            width="180" alt="thumbnail">
                                    <?php } else { ?>
                                        <img
                                            src="<?php echo Yii::app()->request->hostInfo . '/images/no_thumbnail.jpg'; ?>"
                                            width="180" alt="no_thumbnail">
                                    <?php } ?>
                                </div>
                                <?php echo CHtml::button('remove', array('class' => 'remove_thumbnail uibutton special top-space')) ?>
                                <div>
                                    <?php echo $form->textField($model, 'content_thumbnail', array('class' => 'fileDialogCustom ', 'title' => 'fileimport')) ?>
                                    <p align="center"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <?php echo CHtml::label('Web', 'Web') ?>
                        <?php
                        echo CHtml::textField('Contents[content_celebrity_social_links][web]', isset($model->content_celebrity_social_links['web']) ? $model->content_celebrity_social_links['web'] : ''
                        )
                        ?>
                    </div>
                    <div class="row">
                        <?php echo CHtml::label('Facebook', 'facebook') ?>
                        <?php echo  CHtml::textField('Contents[content_celebrity_social_links][fb]', isset($model->content_celebrity_social_links['fb']) ? $model->content_celebrity_social_links['fb'] : '')
                        ?>
                    </div>
                    <div class="row">
                        <?php echo CHtml::label('Twitter', 'twitter') ?>
                        <?php echo  CHtml::textField('Contents[content_celebrity_social_links][twitter]', isset($model->content_celebrity_social_links['twitter']) ? $model->content_celebrity_social_links['twitter'] : '')
                        ?>
                    </div>
                    <div class="row">
                        <?php echo CHtml::label('Instagram', 'instagram') ?>
                        <?php
                        echo CHtml::textField('Contents[content_celebrity_social_links][instagram]', isset($model->content_celebrity_social_links['instagram']) ? $model->content_celebrity_social_links['instagram'] : ''
                        )
                        ?>
                    </div>
                    <div class="row">
                        <?php echo CHtml::label('G-plus', 'g-plus') ?>
                        <?php
                        echo CHtml::textField('Contents[content_celebrity_social_links][g-plus]', isset($model->content_celebrity_social_links['g-plus']) ? $model->content_celebrity_social_links['g-plus'] : ''
                        )
                        ?>
                    </div>
                    <div class="row">
                        <?php echo CHtml::label('Youtube', 'youtube') ?>
                        <?php echo CHtml::textField('Contents[content_celebrity_social_links][youtube]', isset($model->content_celebrity_social_links['youtube']) ? $model->content_celebrity_social_links['youtube'] : '')
                        ?>
                    </div>
                    <?php $this->widget('application.modules.seopack.components.SeopackAdminWidget', array('model' => $model)); ?>
                    <div class="clear"></div>
                </div>
            </div>
        </div>

        <?php
        $this->renderpartial('_right_content_block', array('model' => $model, 'form' => $form));
        ?>
        <div class="clear"></div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<?php
$this->widget('ext.yiiext-imperavi-redactor-widget.ImperaviRedactorWidget', array(
    'selector' => '.redactor',
    'options' => array('convertDivs' => false,
        'height' => 350,
        'imageUpload' => Yii::app()->createAbsoluteUrl('/admin/posts/imageupload'),
        'buttons' => array(
            'html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', /* 'image', */
            'filemanager', /* 'video', */
            'table', 'link', '|', 'fontcolor', 'backcolor', '|', 'alignleft', 'aligncenter', 'alignright', 'justify', '|', 'horizontalrule'
        ),
        'buttonsCustom' => array('filemanager' => array('title' => 'filemanager', 'func' => "fileDialogCallback")),
//        'callback' =>TRUE
    ),
));
?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('.remove_thumbnail').live('click', function () {
            $(this).parents('.profileSetting').find('.fileDialogCustom').val('');
            $(this).parents('.profileSetting').find('.block_callback_img').html('');
            //                        console.log('remove_thumbnail');
        });
    });


</script>