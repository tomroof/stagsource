<div class="block-content-dark">
    <div class="wrap">
        <div class="main-content featured">
            <h2><span>Dancers</span></h2>
            <div class="content-block-all">
                <div class="block-dancers">
                    <!-- <b>Become a pro</b> -->
                    <a class="but-big but-red link-sign_in" href="<?php echo Yii::app()->createUrl('/auth/Registration')?>">register now</a>
                </div>
                <script>initflexslider();</script>
                <div class="row">
                    <?php
                    $this->widget('zii.widgets.CListView', array(
                        'dataProvider' => $dataProvider,
                        'itemView' => '_content_list',
                        'afterAjaxUpdate'=>'initflexslider',
                        'template' => '{items}<div class="pagination-block"><div class="pagination">{pager}</div></div>',
                        "ajaxUpdate"=>false,
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
</div>