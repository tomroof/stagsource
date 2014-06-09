<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
            <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

        <script type="text/javascript" >
            var domain = "<?php echo $_SERVER['SERVER_NAME']; ?><?php echo Yii::app()->request->baseUrl; ?>";
        </script>

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
         <?php Yii::app()->getClientScript()->registerCoreScript('jquery'); ?>

        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/vendors/fancybox/jquery.easing-1.3.pack.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/vendors/fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/vendors/fancybox/jquery.fancybox-1.3.2.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/vendors/fancybox/jquery.fancybox-1.3.2.css" media="screen" />

    </head>

    <body>

        <div class="container" id="page">
            <div id="header">
                <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
                <?php if (Yii::app()->user->isGuest) 
                echo  CHtml::link('Sign in', Yii::app()->createAbsoluteUrl('/auth/LoginPopup'), array('class' => 'fancy_iframe'));
            else                
                 echo  CHtml::link('Logout', Yii::app()->createAbsoluteUrl('/auth/logout'))
                        ?>
            </div><!-- header -->

            <div id="mainMbMenu">
                <?php    $this->widget('application.components.FrontendMenuWidget', array(
                        'menu_key' => '_head',
                                'type' => 'list',
//                        'type' => 'list',
                        'link_class' => TRUE,
                        'show_title' => TRUE
                    )); ?>
            </div><!-- mainmenu -->
        

            <?php echo $content; ?>

            <div class="clear"></div>

            <div id="footer">
                Copyright &copy; <?php echo date('Y'); ?> TSN.<br/>
                All Rights Reserved.<br/>
            
            </div><!-- footer -->

        </div><!-- page -->
<!--<script>
            jQuery(function($) {
                var $rand = function(min/* max */, max) {
                    return Math.floor(arguments.length > 1 ? (max - min + 1) * Math.random() + min : (min + 1) * Math.random());
                };

                $('div').hover(function() {

                    $(this).css({
                        '-webkit-transform': 'rotate('+180+'deg)',
                        '-moz-transform': 'rotate('+180+'deg)',
                        '-o-transform': 'rotate('+180+'deg)',
                        '-ms-transform': 'rotate('+180+'deg)',
                        'transform': 'rotate('+180+'deg)'
                    })
                },function(){
                    $(this).css({
                        '-webkit-transform': 'rotate('+0+'deg)',
                        '-moz-transform': 'rotate('+0+'deg)',
                        '-o-transform': 'rotate('+0+'deg)',
                        '-ms-transform': 'rotate('+0+'deg)',
                        'transform': 'rotate('+0+'deg)'
                    })
                    })
            })
        </script>-->
    </body>

</html>
