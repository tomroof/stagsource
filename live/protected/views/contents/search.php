<div class="block-content-dark">
    <div class="wrap">
        <div class="main-content featured">
            <h2><span>search</span></h2>
            <div class="content-block-all">
<!--                <script>initflexslider();</script>-->
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



