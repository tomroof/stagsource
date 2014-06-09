<div class="wrap">
    <div class="main-content static-pages">
        <h2><span><?php echo $data->title?></span></h2>
        <div class="content-in">
            <?php if ($data->sidebar_enable == Page::SIDEBAR_ENABLED) { ?>
                <div class="sidebar">
                    <div class="sb-block dashboard-menu">
                        <h5>Dashboard</h5>

                        <div class="sb-block-in">
                            <?php  $this->widget(
                                'application.components.FrontendMenuWidget',
                                array(
                                     'menu_key' => '_sidebarMenu',
                                     'type' => 'list',
                                     'show_title' => true,
                                     'link_class' => true,
                                     'class'=>''
                                )
                            );
                            ?>
<!--                            <ul>-->
<!--                                <li class="sb-icon8"><a href="--><?php //echo Yii::app()->createUrl('/page/about'); ?><!--"-->
<!--                                                        title="">About Us</a></li>-->
<!--                                <li class="sb-icon9 active"><a-->
<!--                                        href="--><?php //echo Yii::app()->createUrl('/page/contact_us'); ?><!--" title="">Contact-->
<!--                                        Us</a></li>-->
<!--                                <li class="sb-icon12"><a href="#" title="">FAQ's</a></li>-->
<!--                                <li class="sb-icon13"><a href="--><?php //echo Yii::app()->createUrl('/page/who-we-are') ;?><!--" title="">Who We Are</a></li>-->
<!--                                <li class="sb-icon14"><a href="--><?php //echo Yii::app()->createUrl('/page/what-we-do') ;?><!--" title="">What We Do</a></li>-->
<!--                                <li class="sb-icon15"><a href="#" title="">Terms</a></li>-->
<!--                                <li class="sb-icon16"><a href="#" title="">Privacy</a></li>-->
<!--                            </ul>-->
                        </div>
                    </div>
                </div>
            <?php }; ?>
            <div class="center">
                <div class="center-in block-contact">
                    <?php
                    echo $data->content;
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>