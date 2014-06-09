<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.showPassword.min.js');

CHtml::$beforeRequiredLabel = '<span class="required">*</span>';
CHtml::$afterRequiredLabel = '';
?>
<script>
    $(function () {
        $(':password').showPassword({
            linkClass: 'link-show_password', //Class to use for the toggle link
            linkText: 'Show Password', //Text for the link
            showPasswordLinkText: 'Hide Password', //Text for the link when password is not masked
            showPasswordInputClass: 'password-showing' //Class for the text input that will show the password

        });
        $('.save').click(function () {
            $('#contact-info').submit();
        });
        $('body').on('click', '.proAccount', function () {
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                type: "get",
                success: function () {
                    window.location.reload();
                }
            });
            return false;
        });
    });
</script>
<!--===============================================================-->
<div class="wrap">

    <div class="main-content">
        <h2><span>My profile</span></h2>

        <div class="content-in">
            <?php echo CHtml::form('', 'post', array('class' => 'contact-info', 'id' => 'contact-info')); ?>
            <?php
            $this->widget(
                'application.components.ProfileSidebarWidget', array( 'model' => $userModel)
            );
            ?>
<div class="center">

    <?php
/*    if($userModel->pro_status != User::STATUS_USER_PRO) {*/?><!--
    <div class="block-pro_account">
        <?php /*
            if ($userModel->pro_status == User::STATUS_USER_NOT_PRO) {
                echo Chtml::link('Pro Account', Yii::app()->createUrl('/user/AjaxProRequest', array('id' => Yii::app()->user->getID())), array('class' => 'proAccount but-big but-green')); */?>
                <h4>Request a pro account</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, eiusmod tempor incididunt ut labore et dolore magna.</p>
            <?php /*}
            elseif ($userModel->pro_status == User::STATUS_USER_PRO_REQUEST) { */?>
                <h4>Request a pro account</h4>
                <p>Your request is considered</p>
        <?php /*} */?>
    </div>
    --><?php /*}*/ ?>

    <!-- <ul class="block-tabs">
        <li class="account current"><a href="#"><span>Account</span></a></li>
    </ul> -->
    <div class="center-in account">
        <button class="but-big but-red" type="submit">Save</button>
        <h3>Contact Information</h3>
        <div class="block-profile-line">
            <div class="block-profile-col">
                <!--                First Name-->

                <div class="control-group">
                    <?php echo CHtml::activeLabelEx($userModel, 'first_name') ?>
                    <?php echo CHtml::activeTextField($userModel, 'first_name') ?>
                    <?php echo CHtml::error($userModel, 'first_name') ?>
                </div>


                <!--                Last Name-->
                <div class="control-group">
                    <?php echo CHtml::activeLabelEx($userModel, 'last_name') ?>
                    <?php echo CHtml::activeTextField($userModel, 'last_name') ?>
                    <?php echo CHtml::error($userModel, 'last_name') ?>
                </div>
            </div>
            <div class="block-profile-col">
                <div class="control-group">
                    <?php echo CHtml::activeLabelEx($userModel, 'email') ?>
                    <?php echo CHtml::activeTextField($userModel, 'email') ?>
                    <?php echo CHtml::error($userModel, 'email') ?>
                </div>


                <div class="control-group sel-2">
                    <?php echo CHtml::activeLabelEx($userModel, 'state') ?>

                    <p class="label">
                        <?php
                        echo CHtml::activeDropDownList(
                            $userModel, 'state_id', CHtml::listData(
                                States::model()->findAllByAttributes(array('country_id' => 223)), 'state_code',
                                'state_name_en'
                            ), array('class' => 'sel', 'empty' => '- Select -', 'state_code' => 'state_code',
                                     'ajax'  => array('url'     => Yii::app()->createUrl('user/AjaxGetCityList'),
                                                      'success' => "function(html) {
                                                    $('#city_id').html(html);
                                                    $('#city_id').prev().text($('#city_id option:first').text());
                                                    $('#city_id').prev().html('<span></span>'+$('#city_id option:first').text());
                                                }", 'data' => 'js:{state_code : $(this).val()}',))
                        )
                        ?>
                    </p>

                    <?php echo CHtml::error($userModel, 'state_id'); ?>
                </div>

                <div class="control-group sel-2">
                    <div>
<!--                        --><?php
//                        echo CHtml::activeLabelEx(
//                            $userModel, 'city_id', array('label' => 'City:')
//                        );
//
//                        ?>
<!--                        <p class="label">-->
<!--                            --><?php
//                            echo CHtml::activeDropDownList(
//                                $userModel, 'city_id', $cityArray,
//                                array('class' => 'sel', 'id' => 'city_id', 'empty' => '- Select -')
//                            )
//
//                            ?>
<!--                        </p>-->
                        <?php echo CHtml::activeLabelEx($userModel, 'city') ?>
                        <p class="label">
                            <?php echo CHtml::activeTextField($userModel, 'city', array('style' => 'width:136px;')); ?>
                        </p>
                        <?php echo CHtml::error($userModel, 'city_id'); ?>
                    </div>

                </div>
            </div>
        </div>
        <?php echo CHtml::endForm(); ?>
        <h4>Change Password</h4>
        <div class="block-profile-line">
            <?php echo CHtml::form(); ?>
            <div class="block-change_password">
                <div class="block-profile-col">
                    <div class="control-group">
                        <label><span class="required">*</span>Enter Existing Password: </label>

                        <?php echo CHtml::activePasswordField($changePasswordModel, 'oldPassword'); ?>
                        <?php echo CHtml::error($changePasswordModel, 'oldPassword'); ?>

                    </div>
                </div>
                <div class="block-profile-col">
                    <div class="control-group">
                        <label><span class="required">*</span>Enter New Password:</label>
                        <?php echo CHtml::activePasswordField($changePasswordModel, 'passwd'); ?>
                        <?php echo CHtml::error($changePasswordModel, 'passwd'); ?>
                    </div>
                </div>
                 <button type="submit" class="but-big but-green" style="float:right;"> Change password</button>
            </div>
            <?php echo CHtml::endForm(); ?>
            <div class="box-account_bot">
                <div class="block-gray">
                    <table cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td>
                                <p>USERNAME:</p>
                                <span><?php echo User::getUserFullName($userModel) ?></span>
                            </td>
                            <td>
                                <p>MEMBER SINCE:</p>
                                        <span><?php
                                            $timestamp = strtotime($userModel->date_create);
                                            echo date('F d \, Y', $timestamp);
                                            ?>
                                        </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>ACCOUNT NUMBER:</p>
                                <span><?php echo $userModel->id ?></span>
                            </td>
                            <td>
                            <p>ACCOUNT TYPE:</p>
    									<span><?php
                                                     echo ($userModel->pro_status)?User::getTestTypesUserPro($userModel->pro_status):'Active';
                                            ?>
                                        </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
