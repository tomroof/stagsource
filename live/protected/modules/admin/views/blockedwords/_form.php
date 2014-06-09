<?php
/* @var $this BlackwordsController */
/* @var $model Blackwords */
/* @var $form CActiveForm */

//if(Yii::app()->user->hasFlash('message')){
//    echo '<pre>';
//    var_dump(Yii::app()->user->getFlash('message'));
//    echo '</pre>';
//    die();
//}

?>
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
                        <?php echo $form->labelEx($model, 'title'); ?>
                        <?php echo $form->textField($model, 'title', array('size' => 30, 'maxlength' => 30)); ?>

                    </div>

                    <div class="row">
                        <?php echo $form->labelEx($model, 'status'); ?>
                        <?php echo $form->dropDownList($model, 'status', Blockedwords::getStatuslist());
                        ?>

                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>

        <div class="oneThree">
            <div class="widget">
                <div class="header"><span><span class="ico gray window"></span>  Action & additional options   </span>
                </div>
                <div class="content">
                    <div class="row">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Publish' : 'Update', array('style' => ' margin: 0px; background-color: #9bc652; color: #ffffff;', 'class' => 'uibutton')); ?>
                    </div>
                    <div class="row">
                        <?php
                        Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                        $model->created_at=date('m/d/Y H:i:s', strtotime($model->created_at));
                        echo $form->labelEx($model, 'created_at');
                        $this->widget('CJuiDateTimePicker', array(
                            'model' => $model, //Model object
                            'attribute' => 'created_at', //attribute name
                            'value' =>$model->created_at,
                            'mode' => 'datetime', //use "time","date" or "datetime" (default)
                            'options' => array('dateFormat' => 'mm/dd/yy', 'timeFormat' => 'hh:mm:ss', 'showSecond' => true), // jquery plugin options
                            'language' => 'en-GB'
                        ));
                        ?>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

