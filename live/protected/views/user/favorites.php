<div class="wrap">
    <div class="main-content">
        <h2><span>My Dashboard</span></h2>
        <div class="content-in">
            <form action="">
                <?php
                $this->widget('application.components.ProfileSidebarWidget', array('active' => 'dashboard', 'model' => $userModel));
                ?>

                <div class="center">
                    <?php $this->renderPartial('block_tabs') ;?>
                    <div class="center-in">
                        <?php
                        $this->widget('zii.widgets.CListView', array(
                            'dataProvider' => $dataProvider,
                            'itemView' => '_blockRecentActivity/favorite',
                            'cssFile' => false,
                            'template' => '<div class="block-pagination"><div class="pagination pagination-small">{pager}</div></div>{items}',
                            'pager' => array(
                                'cssFile' => false,
                                'prevPageLabel' => '&nbsp;',
                                'nextPageLabel' => '&nbsp;',
                                'header' => '',
                                'maxButtonCount' => '3',
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
