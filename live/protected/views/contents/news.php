<div class="wrap">
    <div class="main-content">
        <div class="block-title"><h2>News</h2></div>
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