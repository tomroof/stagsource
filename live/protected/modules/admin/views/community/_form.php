<?php
/* @var $this CommunityController */
/* @var $model Contents */
/* @var $form CActiveForm */
?>
<script>
    $(function() {
        celebritiesAutoComplite()
    });
    
    function celebritiesAutoComplite(){
        var projects =[<?php echo Celebrities::getlistdate_json() ?>];
        jQuery('.repeatable-row').each(function()
        {
            var element =  jQuery(this);
            element.children('.content_celebrity_name').autocomplete({
                minLength: 0,
                source: projects,
                focus: function( event, ui ) {
                    element.children( ".content_celebrity_name" ).val( ui.item.label );
                    return false;
                },
                select: function( event, ui ) {
                    element.children( ".content_celebrity_name" ).val( ui.item.label );
                    element.children( ".content_celebrity_id" ).val( ui.item.value );
                    return false;
                }
            })
        })
    }
</script>
<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'contents-form',
        'enableAjaxValidation' => false,
            ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <div class="widgets">
        <div class="twoOne">
            <div class="widget">
                <div class="header"><span><span class="ico gray window"></span>  Main Information   </span></div>
                <div class="content">
                    <div class="row">
                        <?php echo $form->errorSummary($model); ?>
                        <?php echo $form->labelEx($model, 'content_title'); ?>
                        <?php echo $form->textField($model, 'content_title'); ?>
                    </div>

                    <?php
                    $this->renderpartial('_repeatable_content', array('model' => $model, 'form' => $form));
                    ?>
                    <div class="row">
                        <div class="block_callback">
                            <?php echo $form->labelEx($model, 'content_thumbnail'); ?>
                            <div class="row-in">
                                <div class="block_callback_img">
                                    <?php if ($model->content_thumbnail != null) { ?>
                                        <img
                                            src="<?php echo Yii::app()->createAbsoluteUrl($model->content_thumbnail) ?>"
                                            width="180" alt="avatar">
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
                    <?php $this->widget('application.modules.seopack.components.SeopackAdminWidget', array('model' => $model)); ?>
                    <div class="clear"></div>
                </div>
            </div>
        </div>

        <?php
        $this->renderpartial('_right_community_block', array('model' => $model, 'form' => $form, 'array_category' => $array_category));
        ?>

        <div class="clear"></div>
    </div>

    <?php $this->endWidget(); ?>


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

</div><!-- form -->