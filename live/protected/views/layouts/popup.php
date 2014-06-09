<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html style="background: none;" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font/font.css" media="screen, projection" />

        <!--[if lt IE 9]>
            <link media="screen" type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style_ie.css" media="screen, projection" />
        <![endif]-->
        <script type="text/javascript" >
            var domain = "<?php echo $_SERVER['SERVER_NAME']; ?><?php echo Yii::app()->request->baseUrl; ?>";
        </script>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

        <?php Yii::app()->getClientScript()->registerCoreScript('jquery'); ?>
<!--        <script type="text/javascript" src="<?php // echo Yii::app()->request->baseUrl; ?>/framework/web/js/source/jquery.yiiactiveform.js"></script>-->
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.infieldlabel.min.js"></script>
        <script type="text/javascript" src="<?php  echo Yii::app()->request->baseUrl; ?>/js/functions_popap.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/vendors/fancybox/jquery.easing-1.3.pack.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/vendors/fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/vendors/fancybox/jquery.fancybox-1.3.2.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/vendors/fancybox/jquery.fancybox-1.3.2.css" media="screen" />

        <script type="text/javascript">
            $(function() {
                $('#fancybox-close').click(function() {
                    parent.$.fancybox.close();
                });
            });
        </script>

    </head>

    <body style="background: none;">
        <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
        <!-- <a id="fancybox-close" style="display: inline;"></a> -->
        <?php echo $content; ?>
    </body>
</html>
