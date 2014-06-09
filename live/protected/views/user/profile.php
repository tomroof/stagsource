<script type="text/javascript">
    jQuery(function($){
        $("#fancy_iframe_user_delete").fancybox({
            "type": "iframe",
            "width": 608,
            "height": 400,
            "hideOnOverlayClick" : true,
            "autoScale" : false,
            "href": "<?php echo Yii::app()->createUrl('/user/ConfirmCloseAccount',array('id'=>Yii::app()->user->id)); ?>",
            "centerOnScroll" : false,
            "showCloseButton" : true
        });
    });

    $(function () {
        $('.saveAll').click(function () {
            $('.contact-info').submit();
        });
        $('body').on('click', '.link-delete', function () {
            $(this).parents('.box-img').remove();
            return false;


        });

    })
    function onComplateSlideshow(id, fileName, responseJSON) {
        if (responseJSON.image) {
            $('#slideshow img').attr('src', responseJSON.image);
            var clone = $(".hidden_slideshow_item").clone();
            clone.show();
            clone.removeClass('hidden_slideshow_item');
            clone.find('img').attr('src', responseJSON.image)
            clone.find('.hiddenFieldSlideshow').attr('value', responseJSON.image).removeAttr('disabled');
            $('.box-img-all').prepend(clone);
        }
    }
    ;
</script>
<div class="wrap">
<div class="main-content">
<h2><span>My profile</span></h2>

<div class="content-in">
<?php echo CHtml::form('', 'post', array('class' => 'contact-info', 'id' => 'contact-info')); ?>
<?php $this->widget('application.components.ProfileSidebarWidget', array('model' => $userModel)) ?>
<div class="center">
<div class="center-in block-profile">
<!-- <span class="text-required"><b class="required">*</b>Required</span> -->
<h4>Enter Your Information Below</h4>
<?php echo CHtml::errorSummary($userModel) ?>
<div class="block-profile-line">
<div class="block-profile-in">
<!--                                IMAGE-->
<div class="box-profile_image">
    <h5><b class="required">*</b>Upload Photo</h5>

    <div class="controls">
        <a href="#" class="photo-avatar" id="photo">
            <?php echo $userModel->getUserAvatar(Yii::app()->user->id) ?>
        </a>

        <div class="box-profile_image_in">
            <?php
            $this->widget(
                'ext.EAjaxUpload.EAjaxUpload',
                array(
                    'id' => 'uploadFile',
                    'config' => array(
                        'action' => Yii::app()->createUrl('/user/uploadAvatar', array('userId' => $userModel->id)),
                        'allowedExtensions' => array("jpg", "jpeg", "png"), //array("jpg","jpeg","gif","exe","mov" and etc...
                        'sizeLimit' => 10 * 1024 * 1024, // maximum file size in bytes
                        'minSizeLimit' => 10 * 1024, // minimum file size in bytes
                        'onComplete' => "js:function(id, fileName, responseJSON){ jQuery('#photo').html(responseJSON.image); }",
                    )
                )
            );
            ?>
            <!--                                            <button id="UserProfile_photo" class="btn btn-primary link-file">Browse</button>-->
            <!-- <div class="text-upload">
                <em>To request a Pro Account, visit</em>
                <a class="link-blue" href="<?php //echo Yii::app()->createUrl('/user/accountsettings') ?>">Account
                    Settings</a>
            </div> -->
        </div>
    </div>
    <div class="row-fluid" id="error"></div>
</div>
<div class="block-profile-line">
    <h5><b class="required">*</b>Profile Information</h5>

    <div class="block-profile-col">
        <div class="control-group">
            <p class="label">
                <?php echo CHtml::activeLabelEx($userModel, 'first_name') ?>
                <?php echo CHtml::activeTextField($userModel, 'first_name') ?>
            </p>
        </div>
        <div class="control-group">
            <p class="label">
                <?php echo CHtml::activeLabelEx($userModel, 'city') ?>
                <?php echo CHtml::activeTextField($userModel, 'city'); ?>
            </p>
        </div>
        <div class="control-group">
            <p class="label">
                <?php echo CHtml::activeLabelEx($userModel, 'email') ?>
                <?php echo CHtml::activeTextField($userModel, 'email'); ?>
            </p>
        </div>
    </div>
    <div class="block-profile-col">
        <div class="control-group">
            <p class="label">
                <?php echo CHtml::activeLabelEx($userModel, 'last_name') ?>
                <?php echo CHtml::activeTextField($userModel, 'last_name'); ?>
            </p>
        </div>
        <div class="control-group sel-4">
            <p class="label">
                <?php
                echo CHtml::activeDropDownList(
                    $userModel,
                    'state_id',
                    CHtml::listData(
                        States::model()->findAllByAttributes(array('country_id' => 223)),
                        'state_code',
                        'state_name_en'
                    ),
                    array(
                        'class' => 'sel',
                        'empty' => '- State -',
                        'state_code' => 'state_code',
                        'ajax' => array(
                            'url' => Yii::app()->createUrl('user/AjaxGetCityList'),
                            'success' => "function(html) {
                                                        $('#city_id').html(html);
                                                        $('#city_id').prev().text($('#city_id option:first').text());
                                                        $('#city_id').prev().html('<span></span>'+$('#city_id option:first').text());
                                                    }",
                            'data' => 'js:{state_code : $(this).val()}',
                        )
                    )
                )
                ?>
            </p>
        </div>
        <div class="control-group">
            <p class="label">
                <?php echo CHtml::activeLabelEx($userModel, 'zip') ?>
                <?php echo CHtml::activeTextField($userModel, 'zip') ?>
            </p>
        </div>
    </div>
</div>
<div class="block-profile-line">
    <h5>Favorites</h5>

    <div class="control-group">
        <p class="label">
            <?php echo CHtml::label('List your favorite proposal ideas...', 'User_favorites_1') ?>
            <?php echo CHtml::activeTextArea($userModel, 'favorites_1', array('cols' => "10", 'rows' => "10")); ?>
            <!--            <label for="textarea_favorites-1">List your favorite proposal ideas...</label>-->
            <!--            <textarea id="textarea_favorites-1" cols="10" rows="10"></textarea>-->
        </p>
    </div>
    <div class="control-group">
        <p class="label">
            <?php echo CHtml::label('List your favorite bachelor party destinations...', 'User_favorites_2') ?>
            <?php echo CHtml::activeTextArea($userModel, 'favorites_2', array('cols' => "10", 'rows' => "10")); ?>
            <!--            <label for="textarea_favorites-2">List your favorite bachelor party destinations...</label>-->
            <!--            <textarea id="textarea_favorites-2" cols="10" rows="10"></textarea>-->
        </p>
    </div>
    <div class="control-group">
        <p class="label">
            <?php echo CHtml::label('List your favorite wedding locations...', 'User_favorites_3') ?>
            <?php echo CHtml::activeTextArea($userModel, 'favorites_3', array('cols' => "10", 'rows' => "10")); ?>
            <!--            <label for="textarea_favorites-3">List your favorite wedding locations...</label>-->
            <!--            <textarea id="textarea_favorites-3" cols="10" rows="10"></textarea>-->
        </p>
    </div>
    <div class="control-group">
        <p class="label">
            <?php echo CHtml::label('List your favorite honeymoon destinations...', 'User_favorites_4') ?>
            <?php echo CHtml::activeTextArea($userModel, 'favorites_4', array('cols' => "10", 'rows' => "10")); ?>
            <!--            <label for="textarea_favorites-4">List your favorite honeymoon destinations...</label>-->
            <!--            <textarea id="textarea_favorites-4" cols="10" rows="10"></textarea>-->
        </p>
    </div>
</div>
<!-- <div class="block-profile-line">
    <div class="control-group">
        <p class="label">
            <?php // echo CHtml::label($userModel->getAttributeLabel('thoughts'), 'User_thoughts') ?>
            <?php // echo CHtml::activeTextArea($userModel, 'thoughts'); ?>
            <?php //echo CHtml::error($userModel, 'thoughts'); ?>
        </p>
    </div>
    <div class="control-group">
        <p class="label">
            <?php // echo CHtml::label('Enter URL', 'User_url') ?>
            <?php // echo CHtml::activeTextField($userModel, 'url'); ?>
            <?php //echo CHtml::error($userModel, 'url'); ?>
        </p>
    </div>
</div>
<div class="block-profile-line">
    <h5><b class="required">*</b>Resume</h5>

    <div class="control-group resume">
        <p class="label">
            <?php // echo CHtml::label('Paste your resume here...', 'User_resume') ?>
            <?php // echo CHtml::activeTextArea($userModel, 'resume'); ?>
            <?php //echo CHtml::error($userModel, 'resume'); ?>
        </p>
    </div>
</div>
<div class="block-profile-line">
    <h5>Profile Information</h5>

    <div class="block-profile-col">
        <div class="control-group">
            <p class="label">
                <?php // echo CHtml::activeLabelEx($userModel, 'first_name') ?>
                <?php // echo CHtml::activeTextField($userModel, 'first_name') ?>
                <?php //echo CHtml::error($userModel, 'first_name') ?>
            </p>
        </div>
        <div class="control-group sel-2">
            <p class="label">
                <?php
//                echo CHtml::activeDropDownList(
//                    $userModel, 'state_id', CHtml::listData(
//                        States::model()->findAllByAttributes(array('country_id' => 223)), 'state_code', 'state_name_en'
//                    ), array(
//                        'class' => 'sel',
//                        'empty' => '- State -',
//                        'state_code' => 'state_code',
//                        'ajax' => array('url' => Yii::app()->createUrl('user/AjaxGetCityList'),
//                            'success' => "function(html) {
//                                                        $('#city_id').html(html);
//                                                        $('#city_id').prev().text($('#city_id option:first').text());
//                                                        $('#city_id').prev().html('<span></span>'+$('#city_id option:first').text());
//                                                    }", 'data' => 'js:{state_code : $(this).val()}',))
//                )
                ?>
            </p>

            <?php //echo CHtml::error($userModel, 'state_id'); ?>
        </div>
        <div class="control-group sel-2">
            <div>
                <?php
                ?>
                <p class="label">
                    <?php
//                    echo CHtml::activeDropDownList(
//                        $userModel, 'city_id', $cityArray, array('class' => 'sel', 'id' => 'city_id', 'empty' => '- City -')
//                    )
                    ?>
                </p>
                <?php //echo CHtml::error($userModel, 'city_id'); ?>
            </div>
        </div>
        <div class="control-group">
        <p class="label">
        <?php //echo CHtml::activeLabelEx($userModel, 'zip') ?>
        <?php //echo CHtml::activeTextField($userModel, 'zip')  ?>
        <?php ////echo CHtml::error($userModel, 'studio_url')  ?>
        </p>
        </div>
        <div class="control-group">
            <p class="label">
                <?php //echo CHtml::activeLabelEx($userModel, 'agency_name') ?>
                <?php //echo CHtml::activeTextField($userModel, 'agency_name') ?>
                <?php //echo CHtml::error($userModel, 'agency_name')  ?>
            </p>
        </div>
        <div class="control-group">
            <p class="label">
                <?php //echo CHtml::activeLabelEx($userModel, 'studio_name') ?>
                <?php //echo CHtml::activeTextField($userModel, 'studio_name') ?>
                <?php //echo CHtml::error($userModel, 'studio_name')  ?>
            </p>
        </div>
    </div>
    <div class="block-profile-col">
        <div class="control-group">
            <p class="label">
                <?php //echo CHtml::activeLabelEx($userModel, 'last_name') ?>
                <?php //echo CHtml::activeTextField($userModel, 'last_name') ?>
                <?php //echo CHtml::error($userModel, 'last_name')  ?>
            </p>
        </div>
        <div class="control-group sel-4">
            <p class="label">
                <?php //echo CHtml::activeLabelEx($userModel, 'years_dencing') ?>
                <?php
                //echo CHtml::activeDropDownList($userModel, 'years_dencing', User::getYearsDencing(), array('class' => 'sel', 'empty' => $userModel->getattributelabel('years_dencing')))
                ?>
            </p>
            <?php //echo CHtml::error($userModel, 'years_dencing')  ?>
        </div>
        <div class="control-group">
            <p class="label">
                <?php //echo CHtml::activeLabelEx($userModel, 'agency_url') ?>
                <?php //echo CHtml::activeTextField($userModel, 'agency_url') ?>
                <?php //echo CHtml::error($userModel, 'agency_url')  ?>
            </p>
        </div>
        <div class="control-group">
            <p class="label">
                <?php //echo CHtml::activeLabelEx($userModel, 'studio_url') ?>
                <?php //echo CHtml::activeTextField($userModel, 'studio_url') ?>
                <?php //echo CHtml::error($userModel, 'studio_url')  ?>
            </p>
        </div>
    </div>
</div>
<div class="block-profile-line">
    <h5><b class="required">*</b>Profession</h5>
    <?php //echo CHtml::activeLabelEx($userModel, 'profession') ?>
    <div class="list-checkbox">
        <?php //echo CHtml::activeCheckBoxList($userModel, 'profession', User::getProfessionList()) ?>
        <?php //echo CHtml::error($userModel, 'profession')  ?>
    </div>
</div>
<div class="block-profile-line">
    <h5><b class="required">*</b>Dance Style</h5>
    <?php //echo CHtml::activeLabelEx($userModel, 'dence_style') ?>
    <div class="list-checkbox">
        <?php //echo CHtml::activeCheckBoxList($userModel, 'dence_style', User::getDanceStyleList()) ?>
        <?php //echo CHtml::error($userModel, 'dence_style')  ?>
    </div>
</div>
<div class="block-profile-line">
    <h5>Teaching Schedule</h5>

    <div class="control-group">
        <p class="label">
            <?php //echo CHtml::label('Enter your teaching schedule', 'User_teaching_schedule') ?>
            <?php //echo CHtml::activeTextArea($userModel, 'teaching_schedule', array('cols' => "10", 'rows' => "10")); ?>
            <?php //echo CHtml::error($userModel, 'teaching_schedule');  ?>
        </p>
    </div>
</div>
<div class="block-profile-line">
    <h5>Social Media Links</h5>

    <div class="block-profile-col">
        <div class="box-social_links box-social_links_w">
            <?php //echo CHtml::activeTextField($userModel, 'social_links_w') ?>
            <?php //echo CHtml::error($userModel, 'social_links_w')  ?>
        </div>
        <div class="box-social_links box-social_links_t">
            <?php //echo CHtml::activeTextField($userModel, 'social_links_t') ?>
            <?php //echo CHtml::error($userModel, 'social_links_t')  ?>
        </div>
        <div class="box-social_links box-social_links_f">

            <?php //echo CHtml::activeTextField($userModel, 'social_links_f') ?>
            <?php //echo CHtml::error($userModel, 'social_links_f')  ?>
        </div>
    </div>
    <div class="block-profile-col">
        <div class="box-social_links box-social_links_g">
            <?php //echo CHtml::activeTextField($userModel, 'social_links_g') ?>
            <?php //echo CHtml::error($userModel, 'social_links_g') ?>
        </div>
        <div class="box-social_links box-social_links_p">
            <?php //echo CHtml::activeTextField($userModel, 'social_links_p') ?>
            <?php //echo CHtml::error($userModel, 'social_links_p')  ?>
        </div>
        <div class="box-social_links box-social_links_i">
            <?php //echo CHtml::activeTextField($userModel, 'social_links_i') ?>
            <?php //echo CHtml::error($userModel, 'social_links_i')  ?>
        </div>
    </div>
</div>
<div class="block-profile-line">
    <h5>Upload Videos</h5>

    <div class="control-group">
        <div class="box-img">
        <img src="
        <?php //echo Yii::app()->request->baseUrl;  ?>/images/img-video.jpg" alt="" />
        <a class="link-delete" href="#">Delete</a>
        </div>
        <p class="label">
            <label for="video">Embed code or video URL</label>
            <textarea id="video" cols="10" rows="10"></textarea>
            <?php //echo CHtml::label('Embed code video', 'User_video') ?>
            <?php //echo CHtml::activetextArea($userModel, 'video', array('cols' => "10", 'rows' => "10")) ?>

        </p>
    </div>
</div>
<div class="block-profile-line">
    <h5>Add to Slideshow</h5>

    <div class="box-profile_image">
        <a href="#" class="photo-avatar" id="slideshow">
            <img src="<?php //echo Yii::app()->request->baseUrl; ?>/images/default_image_small.png" alt=""/>
            <?php //echo $userModel->getUserAvatar()  ?>
        </a>

        <div class="box-profile_image_in">
            <?php
//            $this->widget('ext.EAjaxUpload.EAjaxUpload', array(
//                'id' => 'uploadFile2',
//                'config' => array(
//                    'action' => Yii::app()->createUrl('/user/UploadSlideshowProfile', array('userId' => $userModel->id)),
//                    'allowedExtensions' => array("jpg", "jpeg", "png"), //array("jpg","jpeg","gif","exe","mov" and etc...
//                    'sizeLimit' => 10 * 1024 * 1024, // maximum file size in bytes
//                    'minSizeLimit' => 10 * 1024, // minimum file size in bytes
////                                                    'onComplete' => "js:function(id, fileName, responseJSON){  jQuery('#slideshow').html(responseJSON.image); }",
//                    'onComplete' => "js:function(id, fileName, responseJSON){ onComplateSlideshow(id, fileName, responseJSON) }",
////                                                    'onComplete' => "js:",
//                )));
            ?>
            <button id="UserProfile_photo" class="btn btn-primary link-file">Browse</button>
        </div>
    </div>
    <div class="row-fluid" id="error"></div>
    <div class="box-img hidden_slideshow_item" style="display: none">
        <img src="<?php //echo Yii::app()->request->baseUrl; ?>/images/default_image_small.png" alt=""/>
        <a class="link-delete" href="#">Delete</a>
        <?php //echo CHtml::hiddenField('User[slideshow][]', '', array('class' => 'hiddenFieldSlideshow', 'disabled' => 'disabled')) ?>
    </div>
    <div class="box-img-all">
        <?php //if (!empty($userModel->slideshow)) {
            //foreach ((array)$userModel->slideshow as $val) {
                ?>
                <div class="box-img">
                    <img src="<?php //echo $val ?>" alt=""/>
                    <a class="link-delete" href="#">Delete</a>
                    <?php //echo CHtml::hiddenField('User[slideshow][]', $val, array('class' => 'hiddenFieldSlideshow')) ?>
                </div>

            <?php
            //}
//        }
        ?>
        <div class="box-img">
        <img src="
        <?php //echo Yii::app()->request->baseUrl; ?>/images/img-slideshow-2.jpg" alt="" />
        <a class="link-delete" href="#">Delete</a>
        </div>
        <div class="box-img">
        <img src="
        <?php //echo Yii::app()->request->baseUrl; ?>/images/img-slideshow-3.jpg" alt="" />
        <a class="link-delete" href="#">Delete</a>
        </div>
        <div class="box-img">
        <img src="
        <?php //echo Yii::app()->request->baseUrl;  ?>/images/img-slideshow-1.jpg" alt="" />
        <a class="link-delete" href="#">Delete</a>
        </div>
        <div class="box-img">
        <img src="
        <?php //echo Yii::app()->request->baseUrl;  ?>/images/img-slideshow-2.jpg" alt="" />
        <a class="link-delete" href="#">Delete</a>
        </div>
        <div class="box-img">
        <img src="
        <?php //echo Yii::app()->request->baseUrl;  ?>/images/img-slideshow-3.jpg" alt="" />
        <a class="link-delete" href="#">Delete</a>
        </div>
        <div class="box-img">
        <img src="
        <?php //echo Yii::app()->request->baseUrl;  ?>/images/img-slideshow-1.jpg" alt="" />
        <a class="link-delete" href="#">Delete</a>
        </div>
    </div>
</div> -->
</div>
</div>
</div>
<div class="block-profile-bot">

    <button class="but-big but-red" type="submit"><span>Save Profile</span></button>
</div>
</div>
<?php echo CHtml::endForm(); ?>
</div>
</div>
</div>
