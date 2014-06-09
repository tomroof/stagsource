<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'validation',
    'enableAjaxValidation' => false,
        ));
?>


<?php // echo SettingsCHtml::settingstextArea('main_page_text', array('rows' => 6, 'cols' => 70), 'Text', 'Main page'); ?>

<?php echo SettingsCHtml::settingstextArea('notification_auth_recoverypass_sucsess', array('rows' => 6, 'cols' => 70), 'Success', 'Recovery Password Notification'); ?>

<?php echo SettingsCHtml::settingstextArea('notification_auth_recoverypass_failure', array('echo' => 'notification_textarea', 'rows' => 6, 'cols' => 70), 'Failure  ', 'Recovery Pass Notification'); ?>

<?php echo SettingsCHtml::settingstextArea('notification_auth_recoverypass_email_not_found', array('rows' => 6, 'cols' => 70, 'class' => 'notification_textarea'), 'Email is not found', '  Recovery Pass Notification '); ?>

<?php echo SettingsCHtml::settingstextArea('notification_user_confirm_close_account', array('rows' => 6, 'cols' => 70, 'class' => 'notification_textarea'), 'Close Account', 'Confirm Close Account'); ?>

<?php echo SettingsCHtml::settingstextArea('notification_contact_sucsess', array('rows' => 6, 'cols' => 70, 'class' => 'notification_textarea'), 'Success', 'Contact Notification '); ?>

<?php echo SettingsCHtml::settingstextArea('notification_user_profile_saved_sucsess', array('rows' => 6, 'cols' => 70, 'class' => 'notification_textarea'), 'SuccessUser Info Saved', 'User Profile Notification '); ?>


<?php echo SettingsCHtml::settingstextArea('notification_user_accountSettings_saved_sucsess', array('rows' => 6, 'cols' => 70, 'class' => 'notification_textarea'), 'Success Password Saved', 'User Account Settings Notification '); ?>

<?php echo SettingsCHtml::settingstextArea('notification_user_accountSettings_info_saved_sucsess', array('rows' => 6, 'cols' => 70, 'class' => 'notification_textarea'), 'Success Contact Information Saved', 'User Account Settings Notification '); ?>


<?php echo SettingsCHtml::settingstextArea('notification_newslatter_subscription_sucsess', array('rows' => 6, 'cols' => 70, 'class' => 'notification_textarea'), 'Success Subscribing', 'Newslatter Notification '); ?>

<?php echo SettingsCHtml::settingstextArea('notification_newslatter_already_subscribed', array('rows' => 6, 'cols' => 70, 'class' => 'notification_textarea'), 'Already Subscribed', 'Newslatter Notification '); ?>

<?php echo SettingsCHtml::settingstextArea('notification_admin_community_create', array('rows' => 6, 'cols' => 70, 'class' => 'notification_textarea'), 'Community Create', 'Admin Community Notification '); ?>

<?php echo SettingsCHtml::settingstextArea('notification_admin_community_update', array('rows' => 6, 'cols' => 70, 'class' => 'notification_textarea'), 'Community Update', 'Admin Community Notification '); ?>

<?php echo SettingsCHtml::settingstextArea('notification_admin_content_create', array('rows' => 6, 'cols' => 70, 'class' => 'notification_textarea'), 'Content Create', 'Admin Community Notification '); ?>

<?php echo SettingsCHtml::settingstextArea('notification_admin_content_update', array('rows' => 6, 'cols' => 70, 'class' => 'notification_textarea'), 'Content Update', 'Admin Community Notification '); ?>


<?php echo SettingsCHtml::settingstextArea('notification_admin_comments_update', array('rows' => 6, 'cols' => 70, 'class' => 'notification_textarea'), 'Comments Update', 'Admin Comments Notification '); ?>


<?php //echo SettingsCHtml::settingstextArea('notification_admin_celebrities_create', array('rows' => 6, 'cols' => 70, 'class' => 'notification_textarea'), 'Celebrities Create', 'Admin Celebrities Notification '); ?>
<!---->
<?php //echo SettingsCHtml::settingstextArea('notification_admin_celebrities_update', array('rows' => 6, 'cols' => 70, 'class' => 'notification_textarea'), 'Celebrities Update', 'Admin Celebrities Notification '); ?>


<?php echo SettingsCHtml::settingstextArea('notification_admin_settings_save', array('rows' => 6, 'cols' => 70, 'class' => 'notification_textarea'), 'Settings saved', 'Admin Settings Notification '); ?>


<?php echo SettingsCHtml::settingstextArea('notification_admin_email_error_subject', array('rows' => 6, 'cols' => 70, 'class' => 'notification_textarea'), 'Subject is Empty', 'Admin Email Notification '); ?>


<?php echo SettingsCHtml::settingstextArea('notification_admin_email_sucsess', array('rows' => 6, 'cols' => 70, 'class' => 'notification_textarea'), 'Success', 'Admin Email Notification '); ?>


<?php echo SettingsCHtml::settingstextArea('notification_admin_email_error_user', array('rows' => 6, 'cols' => 70, 'class' => 'notification_textarea'), 'User is Empty', 'Admin Email Notification '); ?>


<?php echo SettingsCHtml::settingstextArea('notification_admin_blockedwords_create', array('rows' => 6, 'cols' => 70, 'class' => 'notification_textarea'), 'Blocked Words Create', 'Admin Blocked Words Notification'); ?>
<?php echo SettingsCHtml::settingstextArea('notification_admin_blockedwords_update', array('rows' => 6, 'cols' => 70, 'class' => 'notification_textarea'), 'Blocked Words Update', 'Admin Blocked Words Notification'); ?>


<p><?php echo CHtml::submitButton('Save', array('style' => 'margin-top: 8px;')); ?></p>
<?php $this->endWidget(); ?>



