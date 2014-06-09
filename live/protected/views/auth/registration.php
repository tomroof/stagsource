<?php
    $this->pageTitle = 'Reagistration';
    $this->title = 'Registration';

    CHtml::$beforeRequiredLabel = '<span class="required">*</span>';
    CHtml::$afterRequiredLabel = '';
?>
<div id="block-sign_in" class="block-popup block-popup-signin">
    <div class="block-popup-in">
        <div class="title-popup-in">
            <h2>Register Today</h2>
        </div>
        <div class="block-popup-in-2">
            <?php if (Yii::app()->user->hasFlash('error')) { ?>
                <div class="flash-error">
                    <?php echo Yii::app()->user->getFlash('error'); ?>
                </div>
            <?php } elseif (Yii::app()->user->hasFlash('success')) { ?>
                <div class="flash-success">
                    <?php echo Yii::app()->user->getFlash('success'); ?>
                </div>
            <?php }; ?>

            <?php
            $this->renderPartial('_form', array('model' => $model));
            ?>
        </div>
    </div>
</div>