<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <title><?php echo $this->pageTitle ?></title>
        <!--        <meta property="fb:app_id"          content="1234567890" /> -->
        <?php
        ?>

        <!--    --><?php //Yii::app()->getClientScript()->registerCoreScript('jquery');          ?>

        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/vendors/fancybox/jquery.fancybox-1.3.2.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/flexslider.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/global.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font/font.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/cusel.css" type="text/css"/>
        <!--[if lt IE 9]>
            <link media="screen" type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles_ie.css"/>
        <![endif]-->
        <!--    <script type="text/javascript" src="-->
        <?php //echo Yii::app()->request->baseUrl; ?><!--/js/jquery-1.8.2.js"></script>-->
        <?php Yii::app()->getClientScript()->registerCoreScript('jquery.ui'); ?>
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css') ?>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.infieldlabel.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom-form-elements.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/cusel.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jScrollPane.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.mousewheel.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/vendors//fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/vendors/fancybox/jquery.fancybox-1.3.2.js"></script>

        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/slides.min.jquery.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.flexslider-min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.carouFredSel-6.0.4-packed.js" type="text/javascript"></script>
        <script type="text/javascript">
            function openItem($item) {
                $item.find('img[src*="-grey"]').stop().fadeTo(1500, 0);
                $item.addClass('selected');
                $item.stop().animate({
                    height: 405
                });
                jQuery('body').css('backgroundColor', $item.css('backgroundColor'));
            }

            jQuery(function ($) {
                $('#slider-home').carouFredSel({
                    circular: true,
                    infinite: false,
                    width: '100%',
                    height: 405,
                    items: {
                        visible:3,
                        minimum:1
                    },
                    auto: true,
                    prev: '#prev-sh',
                    next: '#next-sh',
                    scroll: {
                        items: 1,
                        duration: 1000,
                        easing: 'quadratic',
                        onBefore: function (data) {
                            data.items.old.find('img[src*="-grey"]').stop().fadeTo(500, 1);
                            data.items.old.removeClass('selected');
                            data.items.old.stop().animate({
                                height: 430
                            });
                            $('body').css('backgroundColor', '#ddd');
                        },
                        onAfter: function (data) {
                            openItem(data.items.visible.eq(1));
                        }
                    },
                    onCreate: function (data) {
                        openItem(data.items.eq(1));
                    }
                });

                //                $(window).load(function() {
                initflexslider();
                //                });

            });

            function initflexslider() {
                $('.flexslider').flexslider({
                    animation: "slide",
                    controlNav: "thumbnails",
                    animationLoop: false,
                    slideshow: false
                });
            }
        </script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/functions.js"></script>


        <script type="text/javascript">var switchTo5x=true;</script>
        <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
        <script type="text/javascript">stLight.options({publisher: "e0ce4108-d273-4cdd-a512-5e481503e37b", doNotHash: false, doNotCopy: false, onhover: false, hashAddressBar: false});</script>

        <script type="text/javascript">
            $(document).ready(function(){
                $('.center-content-block iframe, .content-block iframe').each(function(){
                    var url = $(this).attr("src");
                    var char = "?";
                    if(url.indexOf("?") != -1){
                        var char = "&";
                    }

                    $(this).attr("src",url+char+"wmode=transparent");
                });
            });
        </script>
    </head>
    <body style="min-width: 1024px;" <?php
        // var_dump(Yii::app()->controller->action->id);
        if ((Yii::app()->controller->action->id === 'error')) {
            echo ' id="error-page" ';
        }
        if ((Yii::app()->controller->action->id === 'index')) {
            echo ' id="home-page" ';
        }
        if ((Yii::app()->controller->id === 'user' || strtolower(Yii::app()->controller->action->id) === 'contact')) {
            echo ' class="bg-light" ';
        }
        ?>>
        <div id = "fb-root"></div>
        <script type="text/javascript" >(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-44891628-1', 'stagsource.com');
  ga('send', 'pageview');

</script>

        <?php if (Yii::app()->user->isGuest) { ?>
            <div class="header-top-hide-login" style="<?php echo isset($_GET['login']) ? 'display: block;' : 'display: none;' ?>">
                <div class="wrap">
                    <div class="header-top-block">
                        <?php
                        $form = $this->beginWidget(
                                'CActiveForm', array('id' => 'login-form', 'action' => '/auth/login',
                            'enableClientValidation' => true,
                            'clientOptions' => array('validateOnSubmit' => true,),
                                )
                        );
                        ?>

                        <p class="label">
                            <?php echo $form->labelEx($this->login_form, 'email'); ?>
                            <?php echo $form->textField($this->login_form, 'email'); ?>
                            <?php echo $form->error($this->login_form, 'email'); ?>
                        </p>


                        <p class="label">
                            <?php echo $form->labelEx($this->login_form, 'password'); ?>
                            <?php echo $form->passwordField($this->login_form, 'password'); ?>
                            <?php echo $form->error($this->login_form, 'password'); ?>
                        </p>

                        <?php
                        echo CHtml::ajaxSubmitButton(
                                'Login', array('/auth/login'), array(
                            'success' => 'js:function(data){
            if(data == "true")
               window.location.href = "/";
            else {
;                                    $("#login-form").html(data);

                                    if ($.isFunction($.fn.inFieldLabels)) {
                                    $("p.label label").inFieldLabels({
            fadeOpacity: 0
        });
    };};
    }',
                                ), array('class' => "but-big but-green")
                        );
                        ?>
                        <?php $this->endWidget(); ?>
                    </div>
                    <div class="header-top-block">

                        <!--                    <a class="btn fb-btn" href="#" title="">Facebook Login</a>-->

                        <div class="forgot-pass">
                            <p>Forgot password?</p>
                            <a href="<?php echo Yii::app()->createUrl('/auth/recoverypass'); ?>" class="link-sign_in" title="">Click here</a>
                        </div>
                    </div>
                    <a class="header-top-close" href="#" title=""></a>
                </div>
            </div> <?php } ?>
        <div id="header">
            <div class="header-top">
                <div class="centered">
                    <?php if (Yii::app()->user->isGuest) { ?>
                        <div class="block-logged block-logged_out">
                            <ul>
                                <!--                                <li><a class="link-facebook_login" href="#">Facebook Login</a></li>-->

                                <li><?php
                    echo CHtml::link(
                            'Facebook Login', Yii::app()->facebook->getLoginUrl(
                                    array('scope' => 'email, publish_actions', 'redirect_uri' => Yii::app()->createAbsoluteUrl('auth/login'))
                            ), array('class' => 'link-facebook_login')
                    )
                        ?></li>
                                <li><a class="link-sign_in" href="<?php echo Yii::app()->createUrl('/auth/Registration'); ?>"><span>Join</span></a></li>
                                <li><a href="#" id="show_login" ><span>Sign In</span></a></li>
                            </ul>
                        </div>
                    <?php } ?>
                    <?php if (!Yii::app()->user->isGuest) { ?>
                        <div class="block-logged block-logged_in">
                            <ul>
                                <li>
                                    <ul class="nav-social">
                                        <li class="email">
                                            <a href="#" title="">&nbsp;</a>
                                            <div class="sub-nav">
                                                <?php
                                                $this->widget('application.components.widgets.NewslatterWidget', array(
                                                        'location' => 'header',
                                                         'name'=>'email_header',
                                                    ));
                                                ?>
                                            </div>
                                        </li>
                                        <li class="fb"><a target="_blank" href="<?php echo Settings::getSettingValue('facebook'); ?>" title="">&nbsp;</a></li>
                                        <li class="twitter"><a target="_blank" href="<?php echo Settings::getSettingValue('twitter'); ?>" title="">&nbsp;</a></li>
                                        <li class="instagram"><a target="_blank" href="<?php echo Settings::getSettingValue('instagram'); ?>" title="">&nbsp;</a></li>
                                        <li class="googleplus"><a target="_blank" href="<?php echo Settings::getSettingValue('googleplus'); ?>" title="">&nbsp;</a></li>
                                        <li class="pinterest"><a target="_blank" href="<?php echo Settings::getSettingValue('pinterest'); ?>" title="">&nbsp;</a></li>
                                        <li class="youtube"><a target="_blank" href="<?php echo Settings::getSettingValue('youtube'); ?>" title="">&nbsp;</a></li>
                                    </ul>
                                </li>
                                <li class="submenu profile-img-icon">
                                    <a href="<?php echo Yii::app()->createUrl('/user/RecentActivity'); ?>">
                                        <?php echo Yii::app()->user->getUserAvatar(); ?>
                                        <span>More</span>
                                    </a>
                                    <ul>
                                        <li><a href="<?php echo Yii::app()->createUrl('/user/profile') ?>">Profile</a></li>
                                        <li><a href="<?php echo Yii::app()->createUrl('/user/RecentActivity') ?>">Dashboard</a></li>
                                        <li><a href="<?php echo Yii::app()->createUrl('/auth/logout') ?>">Log Out</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    <?php } ?>
                    <div class="block-filter">
                        <form action="" method="post">
                            <div>
                                <label>Filter</label>

                                <div class="lineSel">
                                    <?php
                                    echo CHtml::DropDownList(
                                        'filter',
                                        Yii::app()->request->requestUri,
                                        array(
                                            Yii::app()->createUrl('/Contents/Search') => 'View All',
                                            Yii::app()->createUrl('/Contents/Search', array('type_search[]' => Contents::TYPE_ARTICLE)) => 'Articles',
                                            Yii::app()->createUrl('/Contents/Search', array('type_search[1]' => Contents::TYPE_POLL, 'type_search[2]' => Contents::TYPE_PICTURE_POLL)) => 'Polls',
                                            Yii::app()->createUrl('/Contents/Search', array('type_search[]' => Contents::TYPE_PRODUCT)) => 'Products',
                                            Yii::app()->createUrl('/Contents/Search', array('type_search[]' => Contents::TYPE_QUOTE)) => 'Quotes',
                                            Yii::app()->createUrl('/Contents/Search', array('type_search[]' => Contents::TYPE_IMAGE)) => 'Pictures',
                                            Yii::app()->createUrl('/Contents/Search', array('type_search[]' => Contents::TYPE_SLIDESHOW_ALBUM)) => 'Slideshow',
                                            Yii::app()->createUrl(
                                                '/Contents/Search',
                                                array('type_search[1]' => Contents::TYPE_TWITTER, 'type_search[2]' => Contents::TYPE_FACEBOOK, 'type_search[3]' => Contents::TYPE_INSTAGRAM)
                                            ) => 'Social Media',
                                        ),
                                        array(
                                            'id' => "filter",
                                            'options' => array(
                                                Yii::app()->createUrl('/Contents/Search') => array('class' => "item-filter"),
                                                Yii::app()->createUrl(
                                                    '/Contents/Search',
                                                    array('type_search[]' => Contents::TYPE_ARTICLE)
                                                ) => array('addTags' => "<span class='item-filter-1'></span>"),
                                                Yii::app()->createUrl(
                                                    '/Contents/Search',
                                                    array('type_search[1]' => Contents::TYPE_POLL, 'type_search[2]' => Contents::TYPE_PICTURE_POLL)
                                                ) => array('addTags' => "<span class='item-filter-2'></span>"),
                                                Yii::app()->createUrl(
                                                    '/Contents/Search',
                                                    array('type_search[]' => Contents::TYPE_PRODUCT)
                                                ) => array('addTags' => "<span class='item-filter-7'></span>"),
                                                Yii::app()->createUrl('/Contents/Search', array('type_search[]' => Contents::TYPE_QUOTE)) => array('addTags' => "<span class='item-filter-3'></span>"),
                                                Yii::app()->createUrl('/Contents/Search', array('type_search[]' => Contents::TYPE_IMAGE)) => array('addTags' => "<span class='item-filter-4'></span>"),
                                                Yii::app()->createUrl(
                                                    '/Contents/Search',
                                                    array('type_search[]' => Contents::TYPE_SLIDESHOW_ALBUM)
                                                ) => array('addTags' => "<span class='item-filter-5'></span>"),
                                                Yii::app()->createUrl(
                                                    '/Contents/Search',
                                                    array('type_search[1]' => Contents::TYPE_TWITTER, 'type_search[2]' => Contents::TYPE_FACEBOOK, 'type_search[3]' => Contents::TYPE_INSTAGRAM)
                                                ) => array('addTags' => "<span class='item-filter-6'></span>"),
                                            )
                                        )
                                    )
                                    ?>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/images/logo.png'), Yii::app()->homeUrl, array('id' => 'logo')) ?>
                </div>
            </div>
            <div class="header-bot">
                <div class="centered">
                    <div class="block-search">
                        <?php echo CHtml::beginForm('/Contents/Search', 'get'); ?>
                        <div>
                            <div class="sub-s">
                                <?php echo CHtml::submitButton('', array('name' => '')); ?><input type="submit" value="" />
                            </div>
                            <p class="label">
                                <label for="mes">Search</label>
                                <?php echo CHtml::textField('search_keyword', (string) Yii::app()->request->getQuery('search_keyword'), array('id' => 'mes')); ?>
                            </p>
                        </div>
                        <?php echo CHtml::endForm(); ?>
                    </div>
                    <ul class="nav">
                        <?php
                        $controller_name = Yii::app()->getController()->getId();
                        $get_url = Yii::app()->request->getQuery('url');
                        $action_name = Yii::app()->getController()->getAction()->getId();
                        ?>
                        <li<?php echo (strtolower($controller_name) == 'category' && strtolower($action_name) == 'view' && strtolower($get_url) == 'proposal') ? ' class="active"' : '' ?>>
                            <a href="<?php echo Yii::app()->createUrl('/category/view/proposal'); ?>">
                                <span>The Proposal</span>
                            </a>
                        </li>
                        <li<?php echo (strtolower($controller_name) == 'category' && strtolower($action_name) == 'view' && strtolower($get_url) == 'bachelor_party') ? ' class="active"' : '' ?>>
                            <a href="<?php echo Yii::app()->createUrl('/category/view/bachelor_party'); ?>">
                                <span>Bachelor Party</span>
                            </a>
                        </li>
                        <li<?php echo (strtolower($controller_name) == 'category' && strtolower($action_name) == 'view' && strtolower($get_url) == 'big_day') ? ' class="active"' : '' ?>>
                            <a href="<?php echo Yii::app()->createUrl('/category/view/big_day') ?>">
                                <span>Big Day</span>
                            </a>
                        </li>
                        <li<?php echo (strtolower($controller_name) == 'category' && strtolower($action_name) == 'view' && strtolower($get_url) == 'style') ? ' class="active"' : '' ?>>
                            <a href="<?php echo Yii::app()->createUrl('/category/view/style') ?>">
                                <span>Style</span>
                            </a>
                        </li>
                        <li<?php echo (strtolower($controller_name) == 'category' && strtolower($action_name) == 'view' && strtolower($get_url) == 'groomsmen') ? ' class="active"' : '' ?>>
                            <a href="<?php echo Yii::app()->createUrl('/category/view/groomsmen') ?>">
                                <span>Groomsmen</span>
                            </a>
                        </li>
                        <li class="submenu community<?php echo (strtolower($controller_name) == 'community' || strtolower($action_name) == 'community') ? ' active' : '' ?>">
                            <a href="<?php echo Yii::app()->createUrl('/community') ?>">
                                <span>Community</span>
                            </a>
                            <ul>
                                <?php foreach (ContentCategories::model()->findAll() as $category) { ?>
                                    <li>
                                        <?php echo CHtml::link($category->name, Yii::app()->createUrl('/category/community/' . $category->permalink), array()); ?>
                                    </li>
                                <? } ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="content">
            <!-- <?php if (!empty($this->breadcrumbs)) { ?>
                                                    <div class="breadcrumbs-block">
                <?php
                $this->widget(
                        'zii.widgets.CBreadcrumbs', array('links' => $this->breadcrumbs, 'tagName' => 'ul',
                    'htmlOptions' => array('class' => 'breadcrumbs breadcrumb'),
                    'separator' => '',
                    'homeLink' => '<li><a href="/" title="">Home</a></li>',
                    'inactiveLinkTemplate' => '<li class="active">{label}</li>',
                        )
                );
                ?>
                                                    </div>
            <?php } ?> -->

            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <script>
                $(function() {
                    $.fancybox({
                        "autoDimensions": false,
                        "width": 608,
                        "height": 'auto',
                        "type": 'inline',
                        "centerOnScroll": true,
                        "hideOnContentClick": false,
                        'href': '#block-notice'
                    });
                });
                </script>
                <div style="position: absolute; left: -9999px;">
                    <div id="block-notice" class="block-popup">
                        <div class="block-popup-in">
                            <div class="title-popup-in">
                                <h2>Notification</h2>
                            </div>
                            <div class="block-popup-in-2">
                                <?php echo Yii::app()->user->getFlash('success'); ?>
                                <div class="block-line">
                                    <div class="but-orange">
                                        <a href="javascript:;" class="popup_button" onclick="$.fancybox.close()">Close</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php echo $content; ?>
        </div>
        <div id="footer">
            <div class="wrap">
                <div class="footer-top">
                    <div class="footer-block">
                        <h6>Hot Topics</h6>
                        <ul><?php foreach (Contents::getHotTopics(5) as $content) { ?>
                                <li>
                                    <?php
                                    if ($content->content_type == Contents::TYPE_INSTAGRAM || $content->content_type == Contents::TYPE_FACEBOOK || $content->content_type == Contents::TYPE_TWITTER) {
                                        echo CHtml::link(Functions::getPrewText($content->content_title, 30), $content->content_source, array('target' => '_blank'));
                                    } else {
                                        echo CHtml::link(Functions::getPrewText($content->content_title, 30), $content->permalink);
                                    }
                                    ?>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="footer-block">
                        <h6>Recent Posts</h6>
                        <ul>
                            <?php foreach (Contents::getRecentPosts(5) as $content) { ?>
                                <li>
                                    <?php
                                    if ($content->content_type == Contents::TYPE_INSTAGRAM || $content->content_type == Contents::TYPE_FACEBOOK || $content->content_type == Contents::TYPE_TWITTER) {
                                        echo CHtml::link(Functions::getPrewText($content->content_title, 27), $content->content_source, array('target' => '_blank'));
                                    } else {
                                        echo CHtml::link(Functions::getPrewText($content->content_title, 27), $content->permalink);
                                    }
                                    ?>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="footer-block">
                        <h6>The Team</h6>
                        <?php
                        $this->widget('application.components.FrontendMenuWidget', array(
                            'menu_key' => '_footer',
                            'type' => 'list',
//                                                                                   'link_class' => true,
                            'show_title' => true,
                            'class' => ''
                        ));
                        ?>
                    </div>
                    <div class="footer-block">
                        <h6>Your Turn</h6>
                        <p>Subscribe</p>
                        <?php
                        $this->widget('application.components.widgets.NewslatterWidget');
                        ?>
                        <p>Connect</p>
                        <ul class="f-share">
                            <?php
                            $link = Settings::getSettingValue('facebook');
                            if (!empty($link)) {
                                ?>
                                <li><a href="<?php echo $link ?>" title="" target="_blank"></a></li>
                            <?php } ?>
                            <?php
                            $link = Settings::getSettingValue('twitter');
                            if (!empty($link)) {
                                ?>
                                <li class="twitter" ><a href="<?php echo $link ?>" title="" target="_blank"></a></li>
                            <?php } ?>
                            <?php
                            $link = Settings::getSettingValue('instagram');
                            if (!empty($link)) {
                                ?>
                                <li class="instagram" ><a href="<?php echo $link ?>" title="" target="_blank"></a></li>
                            <?php } ?>
                            <!--
                            <?php
                            $link = Settings::getSettingValue('pinterest');
                            if (!empty($link)) {
                                ?>
                                <li class="pinterest" ><a href="<?php echo $link ?>" title="" target="_blank"></a></li>
                            <?php } ?>
                            <?php
                            $link = Settings::getSettingValue('googleplus');
                            if (!empty($link)) {
                                ?>
                                <li class="googleplus" ><a href="<?php echo $link ?>" title="" target="_blank"></a></li>
                            <?php } ?>
                            <?php
                            $link = Settings::getSettingValue('tumblr');
                            if (!empty($link)) {
                                ?>
                                <li class="tumblr" ><a href="<?php echo $link ?>" title="" target="_blank"></a></li>
                            <?php } ?>    <?php
                            $link = Settings::getSettingValue('vimeo');
                            if (!empty($link)) {
                                ?>
                                <li class="vimeo" ><a href="<?php echo $link ?>" title="" target="_blank"></a></li>
                            <?php } ?>-->
                        </ul>
                    </div>
                </div>
                <div class="footer-bot">
                    <p><?php echo Settings::getSettingValue('copyright'); ?> <?php echo CHtml::link('Designed by', 'http://ccg.la', array('target' => '_blank')); ?>
                        <?php echo CHtml::link('<img  src="' . Yii::app()->request->baseUrl . '/images/footer-ccg.png" alt=""/>', 'http://ccg.la', array('target' => '_blank')); ?>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
