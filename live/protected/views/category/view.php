
<!--<div id="slider-home-all">-->
<!--    <div id="slider-home">-->
<!---->
<!--        --><?php
//        $home_slider1_images = Settings::model()->getSliderUnserialize('slider_home1');
//        if ($home_slider1_images != null) {
//            foreach ($home_slider1_images as $value) {
//                ?>
<!---->
<!--                <div class="slider-home-in">-->
<!--                    <a href="#"><img src="--><?php //echo Yii::app()->request->baseUrl; ?><!----><?php //echo $value['slider-info_image']; ?><!--" alt=""/></a>-->
<!---->
<!--                    <div style="z-index: 9999;" class="info-slider-home">-->
<!--                        <h1>--><?php //echo $value['slider-info_h1'] ;?><!--</h1>-->
<!--                    </div>-->
<!--                    <div class="bg-black">&nbsp;</div>-->
<!--                </div>-->
<!---->
<!--            --><?php
//            }
//        }
//        ?>
<!--    </div>-->
<!--    <a id="prev-sh" href="#"></a>-->
<!--    <a id="next-sh" href="#"></a>-->
<!--</div>-->
<div class="wrap">
    <div class="main-content featured">
        <h2><span><?php echo $category->name ?></span></h2>
        <div class="content-block-all">
            <div class="row">
                <script>initflexslider();</script>
                <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $dataProvider,
                    'afterAjaxUpdate'=>'initflexslider',
                    "ajaxUpdate"=>false,
                    'itemView' => '_content_list',
                    'template' => '{items}<div class="pagination-block"><div class="pagination">{pager}</div></div>',
                    'pager' => array(
                        'cssFile' => false,
                        'prevPageLabel' => '&nbsp;',
                        'nextPageLabel' => '&nbsp;',
                        'header' => '',
                        'maxButtonCount' => '3',
                    ),
                ));?>
            </div>
        </div>
    </div>
</div>



