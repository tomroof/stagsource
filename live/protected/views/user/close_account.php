<?php
CHtml::$beforeRequiredLabel = '<span class="required">*</span>';
CHtml::$afterRequiredLabel = '';
?>
<div id="block-sign_in" class="block-popup close_account">
    <div class="block-popup-in">
        <div class="title-popup-in">
            <h2>Close Account</h2>
        </div>
        <?php
            $form = $this->beginWidget('CActiveForm',
                array(
                    'id' => 'login-form',
                    'action' => Yii::app()->createUrl('/user/ConfirmCloseAccount'),
                )
            );
        ?>
            <div class="block-popup-in-2">
                <p><?php echo Settings::model()->getSettingValue('notification_user_confirm_close_account'); ?></p>
                <div class="block-popup-in-3">
                    <div class="line">
                        <input type="checkbox" name="close" value='<?php echo md5(Yii::app()->user->id); ?>'/>
                        <label class="f-none">YES. Close my account.</label>
                    </div>
                </div>
            </div>
            <div class="block-popup-bot">
                <?php echo CHtml::submitButton('Close Account', array('class' => 'but-big but-green')); ?>
            </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
