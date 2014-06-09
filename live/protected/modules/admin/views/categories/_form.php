<?php
/* @var $this CategoriesController */
/* @var $model Categories */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'categories-form',
	'enableAjaxValidation'=>false,
         'htmlOptions'=>array('enctype'=>"multipart/form-data")
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
        <div class="row" style="width: 37%;">
		<?php echo $form->labelEx($model,'description',array('style'=>'float: none;')); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50 ,'class'=>'redactor')); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
        
       
        
        <div class="row block_callback">
              
                <div class="block_callback_img">
                    <?php if($model->category_img!=null){ ?>
                    <img src="<?php echo Yii::app()->createAbsoluteUrl($model->category_img) ?>" width="180" height="180"  alt="" >
                     <?php } ?>
                </div>
       
		<?php echo $form->labelEx($model,'category_img'); ?>
		<?php echo $form->textField($model,'category_img',array('class' => 'fileDialogCustom ', 'title' => 'fileimport')); ?>
		<?php echo $form->error($model,'category_img'); ?>
	</div>
        <?php if (!$model->isNewRecord) { ?>
            <div class="row">
                <?php echo $form->labelEx($model, 'permalink'); ?>
                <?php echo $form->textField($model, 'permalink', array('size' => 60, 'maxlength' => 255)); ?>
                <?php echo $form->error($model, 'permalink'); ?>
            </div>
        <?php } ?>


<!--	<div class="row">
		<?php echo $form->labelEx($model,'parent'); ?>
		<?php echo $form->textField($model,'parent'); ?>
		<?php echo $form->error($model,'parent'); ?>
	</div>-->

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>
<?php
$this->widget('ext.yiiext-imperavi-redactor-widget.ImperaviRedactorWidget', array(
    'selector' => '.redactor',
//    'options' => array('convertDivs' => false,
//               'imageUpload' => Yii::app()->createAbsoluteUrl('/admin/posts/imageupload'),
//	'buttons' => array(
//	    'html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'image',/* 'video',*/ 'table', 'link', '|', 'fontcolor', 'backcolor', '|', 'alignleft', 'aligncenter', 'alignright', 'justify', '|', 'horizontalrule'
//	),
//    ),
));
?>

</div><!-- form -->