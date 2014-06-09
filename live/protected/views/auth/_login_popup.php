<?php
    CHtml::$beforeRequiredLabel = '<span class="required">*</span>';
    CHtml::$afterRequiredLabel = '';
?>
<div id="block-sign_in" class="block-popup">
    <div class="block-popup-in">
        <div class="title-popup-in">
            <h2><?php echo Yii::t('popup_login', 'Sign In'); ?></h2>
        </div>
        <div class="block-popup-in-2">

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'login-form',
                'action' => Yii::app()->createUrl('/auth/LoginPopup'),
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));
            ?>
                <div class="base-form">

                    <?php echo $form->errorSummary($model); ?>
                    
                    <div class="row">
                        <?php echo $form->labelEx($model,'email'); ?>
                        <div class="inp-1"><?php echo $form->textField($model, 'email'); ?></div>
                    </div>
                    <div class="row">
                        <?php echo $form->labelEx($model,'password'); ?>
                        <div class="inp-1"><?php echo $form->passwordField($model, 'password'); ?></div>
                    </div>
                    <div class="row forgot-pass row-pad">
                        <div class="but-green"><?php echo CHtml::submitButton('Sign In'); ?><div class="but-green-in">&nbsp;</div></div>
                        <?php echo CHtml::link(Yii::t("UserModule.frontend", "Forgot Password?"), array('/auth/recoverypass'), array('class' => 'link-blue')); ?>
                    </div>
                    <div class="row row-pad">
                        <span>Don’t have an account? <?=  CHtml::link('Sign Up!', Yii::app()->createAbsoluteUrl('auth/registration'), array('class' => 'fancy_iframe_reg')); ?></span>
                    </div>
                    <div class="block-line">
                        <p>By sending, you agree to Career &amp; College Clubs’ <br /> <?php echo CHtml::link('Terms of Use', array('/static/static/viewPage', 'url' => 'terms-of-use'), array('target' => '_blank')); ?> and and <?php echo CHtml::link('Privacy Policy', array('/static/static/viewPage', 'url' => 'privacy-policy'), array('target' => '_blank')); ?></p>
                    </div>
                </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
