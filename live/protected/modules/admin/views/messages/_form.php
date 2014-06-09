<?php
/* @var $this MessagesController */
/* @var $model Messages */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'messages-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

        <div class="row" style="width: 45%;">
		<?php echo $form->labelEx($model,'content',array('style'=>'float: none;')); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50,'class'=>'redactor')); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'from_user_id'); ?>
        <?php echo $form->dropDownList($model,'from_user_id',  CHtml::listData(User::model()->findAll(array('order'=>'email ASC')), 'id', 'fullFormat'),array('class'=>'fullWidth')); ?>
        <?php echo $form->error($model,'from_user_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'to_user_id'); ?>
        <?php echo $form->dropDownList($model,'to_user_id',CHtml::listData(User::model()->findAll(array('order'=>'email ASC')), 'id', 'fullFormat'),array('class'=>'fullWidth')); ?>
        <?php echo $form->error($model,'to_user_id'); ?>
    </div>
       
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('style'=>'margin-left: 165px;')); ?>
	</div>
     
         

<?php $this->endWidget(); ?>
<?php
$this->widget('ext.yiiext-imperavi-redactor-widget.ImperaviRedactorWidget', array(
    'selector' => '.redactor',
    'options' => array('convertDivs' => false,
   
//               'imageUpload' => Yii::app()->createAbsoluteUrl('/admin/posts/test'),
//      
//	'buttons' => array(
//	    /*'html', '|',*/ 'formatting', '|', 'bold', 'italic', 'deleted', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'image', 'video', 'link',  'table', 'link', '|', 'fontcolor', 'backcolor', '|', 'alignleft', 'aligncenter', 'alignright', 'justify', '|', 'horizontalrule'
//	),
    ),
));
?>
</div><!-- form -->
<script type="text/javascript" >
    jQuery(document).ready(function($){
//        $("#emailing_body").cleditor();
    })
</script>