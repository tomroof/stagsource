<?php
/* @var $this ContentCommentsController */
/* @var $model ContentComments */
/* @var $form CActiveForm */
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
                    <div class="row">
                                <?php echo $form->labelEx($model, 'content'); ?>
                                <?php echo $form->textArea($model, 'content', array('rows' => 10, 'cols' => 100)); ?>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>

        <?php
        $this->renderpartial('_right_comment_block', array('model' => $model, 'form' => $form));
        ?>


        <div class="clear"></div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->


