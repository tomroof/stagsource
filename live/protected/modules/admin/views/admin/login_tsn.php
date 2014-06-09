<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
		<title><?php echo Yii::app()->name ?></title>
        <!--[if lt IE 9]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
<link href="<?= Yii::app()->theme->baseUrl; ?>/css/zice.style.css" rel="stylesheet" type="text/css" />
<link href="<?= Yii::app()->theme->baseUrl; ?>/css/icon.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?= Yii::app()->theme->baseUrl; ?>/components/tipsy/tipsy.css" media="all"/>
<style type="text/css">
html {
	background-image: none;
}
label.iPhoneCheckLabelOn span {
	padding-left:0px
}
#versionBar {
	background-color:#212121;
	position:fixed;
	width:100%;
	height:35px;
	bottom:0;
	left:0;
	text-align:center;
	line-height:35px;
	z-index:11;
	-webkit-box-shadow: black 0px 10px 10px -10px inset;
	-moz-box-shadow: black 0px 10px 10px -10px inset;
	box-shadow: black 0px 10px 10px -10px inset;
}
.copyright{
	text-align:center; font-size:10px; color:#CCC;
}
.copyright a{
	color:#A31F1A; text-decoration:none
}    
</style>
</head>
<body >
         
<div id="alertMessage"></div>
<div id="successLogin"></div>
<div class="text_success"><img src="<?= Yii::app()->theme->baseUrl; ?>/images/loadder/loader_green.gif"  alt="ziceAdmin" /><span>Please wait</span></div>

<div id="login" >
  <!-- <div class="ribbon"></div> -->
  <div class="inner">
      <div class="logo" ><img src="<?= Yii::app()->theme->baseUrl; ?>/images/logo/logo.png" height="50px" alt="ziceAdmin" /></div>
  <div class="formLogin">
      
      <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
      


          <div class="tip">
				<?php echo $form->textField($model,'email', array('id' => 'username_id', 'title' => 'Username')); ?>
          </div>
          <div class="tip">
			<?php echo $form->passwordField($model,'password', array('id' => 'password', 'title' => 'Password')); ?>

          <div class="loginButton">
              
              <p><?=  $form->errorSummary($model); ?></p>
            <div style="float:left; margin-left:-9px;">
				<input type="checkbox" id="on_off" name="remember" class="on_off_checkbox"  value="1" />
				<span class="f_help">Remember me</span>
			</div>
			<div style="float:right; padding:3px 0; margin-right:-12px;">
              <div> 
                <ul class="uibutton-group">
                   <li><?php echo CHtml::submitButton('Login', array('class' => 'uibutton normal')); ?></li>
<!--				   <li><a class="uibutton normal" href="#" id="forgetpass">forgetpass</a></li>-->

               </ul>
              </div>
			  
            </div>
			<div class="clear"></div>
		  </div>

<?php $this->endWidget(); ?>
  </div>
</div>
  <div class="clear"></div>
  <div class="shadow"></div>
</div>

<!--Login div-->
<div class="clear"></div>
<div id="versionBar" >
    <div class="copyright" > &copy; Copyright 2012  All Rights Reserved <span class="tip"><a  href="<?php echo Yii::app()->request->hostInfo; ?>" title="<?php echo Yii::app()->name ?>" ><?php echo Yii::app()->name ?></a> </span> </div>
  <!-- // copyright-->
</div>
<!-- Link JScript-->
<script type="text/javascript" src="<?= Yii::app()->theme->baseUrl; ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?= Yii::app()->theme->baseUrl; ?>/components/effect/jquery-jrumble.js"></script>
<script type="text/javascript" src="<?= Yii::app()->theme->baseUrl; ?>/components/ui/jquery.ui.min.js"></script>     
<script type="text/javascript" src="<?= Yii::app()->theme->baseUrl; ?>/components/tipsy/jquery.tipsy.js"></script>
<script type="text/javascript" src="<?= Yii::app()->theme->baseUrl; ?>/components/checkboxes/iphone.check.js"></script>
<script type="text/javascript" src="<?= Yii::app()->theme->baseUrl; ?>/js/login.js"></script>
</body>
</html>