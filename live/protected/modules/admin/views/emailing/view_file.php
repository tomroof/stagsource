<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vladwork
 * Date: 15.05.13
 * Time: 13:27
 * To change this template use File | Settings | File Templates.
 */
?>
<h1>Edit Email notification : </h1>
<p><b>File name - <?php echo $fname; ?></b></p>
<div class="form-email-l">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'messages-form',
        'enableAjaxValidation' => false,
    ));

    echo CHtml::textArea('file_content', $tmp, array('rows' => 20, 'cols' => 150));

    $this->widget('ext.yiiext-imperavi-redactor-widget.ImperaviRedactorWidget', array(
        'selector' => '.redactor',
        'options' => array('convertDivs' => false,
        ),
    ));
    ?>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Save'); ?>
        <?php
        if($fname != 'contactForm.php')
           echo CHtml::link('Preview', Yii::app()->createUrl('/admin/emailing/PreviewEmailTemplate', array('fname' => $fname)), array('target'=>'_blank', 'class' => 'uibutton normal')); ?>
    </div>



    <?php $this->endWidget(); ?>
</div> <!-- form -->

<div class="file-list form-email-r">
    <h3>Select file:</h3>

    <?php
    $lang_ar = array_keys($files_in_dir);
    ?>

    <ul>
        <?php foreach ($files_in_dir as $namef) { ?>
            <li> <?php echo CHtml::link($namef, Yii::app()->createUrl('/admin/emailing/EditMessageNotification', array('fname' => $namef))); ?> </li>
        <?php
        }
        ?>
    </ul>

</div>