

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array(
	'class' => 'grid_12 no-box',
	'autocomplete'=> 'off'
    ),
	));
?>

<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <?php echo $form->labelEx($model, 'email'); ?>
    <div style="margin-left: 197px; ">
	<?php echo $form->textField($model, 'email', array('size' => 20, 'maxlength' => 255)); ?>
	<?php echo $form->error($model, 'email'); ?>
    </div>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'passwd'); ?>
    <div style="margin-left: 197px; ">
	<?php echo $form->passwordField($model, 'passwd', array('size' => 20, 'maxlength' => 255)); ?>
	<?php echo $form->error($model, 'passwd'); ?>
    </div>
</div>

<!--<div class="row">
    <?php echo $form->labelEx($model, 'passwd2'); ?>
    <div style="margin-left: 197px; ">
	<?php echo $form->passwordField($model, 'passwd2', array('size' => 20, 'maxlength' => 255)); ?>
	<?php echo $form->error($model, 'passwd2'); ?>
    </div>
</div>-->

<div class="row">
    <?php echo $form->labelEx($model, 'firs_name'); ?>
    <div style="margin-left: 197px; ">
	<?php echo $form->textField($model, 'firs_name', array('size' => 20, 'maxlength' => 255)); ?>
	<?php echo $form->error($model, 'firs_name'); ?>
    </div>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'last_name'); ?>
    <div style="margin-left: 197px; ">
	<?php echo $form->textField($model, 'last_name', array('size' => 20, 'maxlength' => 255)); ?>
	<?php echo $form->error($model, 'last_name'); ?>
    </div>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'business_name'); ?>
    <div style="margin-left: 197px; ">
	<?php echo $form->textField($model, 'business_name', array('size' => 20, 'maxlength' => 255)); ?>
	<?php echo $form->error($model, 'business_name'); ?>
    </div>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'phone'); ?>
    <div style="margin-left: 197px; ">
	<?php echo $form->textField($model, 'phone'); ?>
	<?php echo $form->error($model, 'phone'); ?>
    </div>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'zip'); ?>
    <div style="margin-left: 197px; ">
	<?php echo $form->textField($model, 'zip', array('size' => 5, 'maxlength' => 5)); ?>
	<?php echo $form->error($model, 'zip'); ?>
    </div>
</div>

<div class="row">
    <?php echo $form->labelEx($model_countries, 'countryID'); ?>
    <div style="margin-left: 197px; ">
	<?php
	$model_countries->countryID = ($model->countryID) ?  $model->countryID : 223 ;
	echo $form->dropDownList($model_countries, 'countryID', CHtml::listData($countries->findAll(), 'countryID', 'country_name_en'), array('class' => 'sel'));
	?>
    </div>
</div>
<div class="row">
    <?php echo $form->labelEx($model_zones, 'zoneID'); ?>
    <div style="margin-left: 197px; ">
	<?php
	$model_zones->zoneID = ($model->zoneID) ?  $model->zoneID : 1 ;
	echo $form->dropDownList($model_zones, 'zoneID', CHtml::listData($zones, 'zoneID', 'zone_name_en'), array('class' => 'sel')); ?>
	<?php echo $form->error($model, 'zoneID'); ?>
    </div>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'city'); ?>
    <div style="margin-left: 197px; ">
	<?php echo $form->textField($model, 'city', array('size' => 20, 'maxlength' => 255)); ?>
	<?php echo $form->error($model, 'city'); ?>
    </div>
</div>

<?php if (Yii::app()->user->isAdmin() && Yii::app()->user->getID() != $model->id): ?>
    <div class="row">
	<?php echo $form->labelEx($model, 'type'); ?>
        <div style="margin-left: 197px; ">
	    <?php echo $form->dropDownList($model, 'type', array('1' => 'Admin', '3' => 'Advertiser', '2' => 'User')); ?>
        </div>
    </div>

    <div class="row">
	<?php echo $form->labelEx($model, 'status'); ?>
        <div style="margin-left: 197px; ">
	    <?php echo $form->dropDownList($model, 'status', array('0' => 'Enable', '1' => 'Disable')); ?>
        </div>
    </div>
<?php endif; ?>
<div class="actions">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
</div>

<?php $this->endWidget(); ?>

<!-- form -->