<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => false,
        )
);
?>

<div class="block-popup-in-3">
    <big><span>Like Us</span></big>
    <div class="fb-like" data-href="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" id="registr_fb_button"></div>
    <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>" data-via="<?php echo Yii::app()->name ?>"  id="registr_tweet_button">Tweet</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
    <!--    <img src="<?php // echo Yii::app()->request->baseUrl;   ?>/images/block-sign_in-fb.png" alt=""/>-->
    <!--    <img src="<?php // echo Yii::app()->request->baseUrl; ?>/images/block-sign_in-tweet.png" alt=""/>-->
    <big><span>Sign Up</span></big>
    <?php
    echo CHtml::link(
            'Facebook Login', Yii::app()->facebook->getLoginUrl(
                    array('scope' => 'email,
                            publish_actions', 'redirect_uri' => Yii::app()->createAbsoluteUrl('auth/LoginPopup'))
            ), array('class' => 'btn fb-btn', 'onclick' => 'window.parent.$.fancybox.close(); window.parent.location.href = this.href')
    )
    ?>
    <!--    <a class="btn fb-btn" href="#" title="">Facebook Sign Up</a>-->
    <big><span>OR</span></big>

    <p class="register-error"><?php echo $form->errorSummary($model); ?></p>

    <div class="line">
        <?php echo $form->labelEx($model, 'first_name'); ?>
        <div class="inp-3 label">
            <!-- <label for="User_first_name">First Name</label> -->
            <?php echo $form->textField($model, 'first_name', array('size' => 20, 'maxlength' => 255)); ?>
        </div>
    </div>
    <div class="line">
        <?php echo $form->labelEx($model, 'last_name'); ?>
        <div class="inp-3">
            <?php echo $form->textField($model, 'last_name', array('size' => 20, 'maxlength' => 255)); ?>
        </div>
    </div>
    <div class="line">
        <?php echo $form->labelEx($model, 'email'); ?>

        <div class="inp-3">
            <?php echo $form->textField($model, 'email', array('size' => 20, 'maxlength' => 255)); ?>
        </div>
    </div>
    <div class="line">
        <?php echo $form->labelEx($model, 'confirm_email'); ?>

        <div class="inp-3">
            <?php echo $form->textField($model, 'confirm_email', array('size' => 20, 'maxlength' => 255)); ?>
        </div>
    </div>
    <div class="line">
        <?php echo $form->labelEx($model, 'passwd'); ?>

        <div class="inp-4">
            <?php echo $form->passwordField($model, 'passwd', array('size' => 20, 'maxlength' => 255)); ?>
        </div>
        <div class="block-progress password-strong">
            <span id="status">
                <span id="complexityLabel">Strength</span>
                <span id="complexity"></span>
            </span>
<!--										<span id="progressbar">
                    <span id="progress" style="width:0%;"></span>
            </span>-->
        </div>
    </div>
</div>

</div>
<div class="block-popup-bot">
    <?php echo CHtml::submitButton('Register', array('class' => 'but-big but-green')); ?>
<!--    <input class="btn light-big" type="submit" value="Register"/>-->
    <a href="javascript:void(0)" id="already_account9087">Already Have An Account?</a>

</div>
<?php $this->endWidget(); ?>


<script type="text/javascript">
    jQuery(function ($) {
        $('#User_passwd').keyup(function () {
            val = $('#User_passwd').val();
            $.ajax({
                type: "POST",
                url: "/auth/PassStrong",
                data: "password=" + val,
                success: function (html) {
                    $("#status").html(html);
                }
            });
        });
        
        $('#already_account9087').click(function(){
            var aLogin = $( "#show_login", window.parent.document );
            $('#fancybox-close').trigger('click');
            aLogin[0].click();
        })
    })
    ;
</script>

