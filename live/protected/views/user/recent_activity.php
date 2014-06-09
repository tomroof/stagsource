<div class="wrap">
    <div class="main-content">
        <h2><span>My Dashboard</span></h2>

        <div class="content-in">
            <?php echo CHtml::form('/user/RecentActivity', 'get', array('id' => 'form_filter1')); ?>
            <!--            <form action="">-->
            <?php
            $this->widget('application.components.ProfileSidebarWidget', array('active' => 'dashboard', 'model' => $userModel));
            ?>

            <div class="center">
                <?php $this->renderPartial('block_tabs'); ?>
                <div class="center-in">
                        <div class="sort-pagination">
                            <p>Category:</p>

                            <div class="sel-3">
                                <?php echo CHtml::dropDownList('category', (Yii::app()->request->getQuery('category'))?Yii::app()->request->getQuery('category'):'', array('topics' => 'Topics', 'favorites' => 'Favorites', 'comments' => 'Comments'),
                                    array('class' => 'sel', 'id' => 'change-category', 'empty' => '- All -'));?>
                            </div>
                        </div>
                        <?php
                        $this->widget('zii.widgets.CListView', array(
                             'ajaxUpdate' => false,
                            'dataProvider' => $dataProvider,
                            'itemView' => '_recent_activity',
                            'cssFile' => false,
                            'template' => '<div class="block-pagination"><div class="pagination pagination-small">{pager}</div></div>{items}',
                            'viewData' => array('userModel' => $userModel),
//                            'enableSorting'=>true,
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
                <?php echo CHtml::endForm(); ?>
                <!--            </form>-->
            </div>
        </div>
    </div>
    <script>
        $('#change-category').live('change', function () {
            $('#form_filter1').submit();
        });
    </script>