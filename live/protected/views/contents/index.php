<?php
$home_slider1_images = Settings::model()->getSliderUnserialize('slider_home1');
if ($home_slider1_images != null) {
    ?>
    <div id="slider-home-all">
        <div class="flexslider-home">
            <ul class="slides">
                <?php
                foreach ($home_slider1_images as $key => $value) {
                    ?>
                    <li>
                          <img src="<?php echo Yii::app()->baseUrl ?><?php echo $value['slider-info_image']; ?>" alt=""/>
                        <div class="info-slides">
                            <div class="info-slides-in">
                                <b><?php echo $value['slider-info_h1']; ?></b>
                                <strong><?php echo $value['slider-info_h1_2']; ?></strong>
                                <!--<a class="but-big but-red link-sign_in" href="<?php /*echo $value['slider-info_url']; */?>"><?php /*echo $value['slider-info_button']; */?></a>-->
                                <a class="but-big but-red link-sign_in" href="<?php echo Yii::app()->createUrl('/auth/Registration'); ?>">Sign Up</a>
                                <?php
                                echo CHtml::link(
                                    'Facebook Login', Yii::app()->facebook->getLoginUrl(
                                        array('scope' => 'email, publish_actions', 'redirect_uri' => Yii::app()->createAbsoluteUrl('auth/login'))
                                    ), array('class' => 'but-big but-blue')
                                )
                                ?>
<!--                                <a class="but-big but-gray" href="--><?php //echo $value['slider-info_url_2']; ?><!--">--><?php //echo $value['slider-info_button_2']; ?><!--</a>-->
                            </div>
                        </div>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
<?php } ?>
<div class="wrap">
    <div class="main-content">
        <div class="block-title"><h2>Featured</h2></div>
        <div class="content-block-all">
            <div class="row">
                <script>initflexslider();</script>
                <?php
                $this->widget(
                    'zii.widgets.CListView',
                    array(
                        'dataProvider' => $dataProvider,
                        'afterAjaxUpdate' => 'initflexslider',
                        "ajaxUpdate" => false,
                        'itemView' => '_content_list',
                        'template' => '{items}<div class="pagination-block"><div class="pagination">{pager}</div></div>',
                        'pager' => array(
                            'cssFile' => false,
                            'prevPageLabel' => '&nbsp;',
                            'nextPageLabel' => '&nbsp;',
                            'header' => '',
                            'maxButtonCount' => '3',
                        ),
                    )
                );?>
            </div>
        </div>
    </div>
</div>
