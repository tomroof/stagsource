<script type="text/javascript">
    jQuery(document).ready(function(){       
        jQuery('#change-category').live('change',function(){
            change_filter(jQuery(this).val());
        });
        
        
    })
    
    
    function change_filter(filter_val)
    {
        //   alert('test');
        window.location.href='/user/messaging/mess_filter/'+ filter_val;
    }
    
</script>

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


                        <div class="block-pagination">
                            <div class="sort-pagination">
                                <p>View:</p>
                                <div class="sel-3">

                                    <?php
                                    echo CHtml::dropDownList('mess_filter', $mess_filter, User::getArrayMessFilter(), array(
                                        'class' => 'sel', 'id' => 'change-category'));
                                    ?>
                                </div>
                            </div>
                            <div class="pagination pagination-small">


                            </div>
                        </div>

                        <div id="messages_list_div" class="list-view">
                            <table class="tab-color" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <th><div>Sent</div></th>
                                <th><div>Message</div></th>
                                <th><div>Date/Time</div></th>
                                </tr>
                                <?php
                                $this->widget('zii.widgets.CListView', array(
                                    'dataProvider' => $dataProvider,
                                    'itemView' => '_mess_list', // refers to the partial view named '_post'
                                    'template' => '{pager}{items}',
                                    'emptyText' => '',
                                    'pager' => array(
                                        'cssFile' => false,
                                        'prevPageLabel' => '&nbsp;',
                                        'nextPageLabel' => '&nbsp;',
                                        'header' => '',
                                        'maxButtonCount' => '3',
                                    ),
                                     
                                ));
                                ?>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
