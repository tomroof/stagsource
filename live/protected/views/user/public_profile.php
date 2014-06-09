<div class="wrap">
    <div class="main-content">
        <h2><span><b><?php echo User::getUserFullName($userModel) ?></b></span></h2>
        <div class="content-in">
            <form action="">
                <div class="sidebar">
                    <div class="sb-block-top">
                        <div class="sb-box-top">
                            <?php if ($userModel->id == Yii::app()->user->id) {
                             echo $userModel->getUserAvatar() ;
                            } else {
                                echo $userModel->getUserAvatar($userModel->id);
                            } ?>

                            <?php if ($userModel->id == Yii::app()->user->id) { ?>
                                <?php
                                echo CHtml::link(
                                        'Edit Profile', Yii::app()->createUrl('user/profile'), array('class' => 'but-big but-green but-profile')
                                )
                                ?>
                            <?php } else { ?>
                                <?php echo CHtml::link('Message', Yii::app()->createUrl('user/addmessage/', array('uid' => $userModel->id)), array('class' => 'but-big but-green')); ?>
                            <?php } ?>
                        </div>
                        <div class="sb-box-bot">
                            <span><?php echo User::getUserFullName($userModel) ?></span>
                            <p>     
                                <?php if ($userModel->city_id): ?>
                                    <?php echo $userModel->state_id ? $userModel->zipareas->city . ', ' . $userModel->state_id : '' ?>
                                <?php endif ?>
                            </p>	
                        </div>
                    </div>
                    <?php if($userModel->favorites_1):?>
                        <div class="sb-block">
                            <h5><span class="sport-team"></span>Proposal Ideas</h5>
                            <div class="sb-block-in">
                                <!--                            <p>Lorem ipsum dolor sit atest consectetur adipisicing elit:</p>-->
                                <ul>
                                    <?php echo $userModel->favorites_1; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif ?>
                    <?php if($userModel->favorites_2):?>
                        <div class="sb-block">
                            <h5><span class="sport-team"></span>The Bachelor Party</h5>
                            <div class="sb-block-in">
                                <!--                            <p>Lorem ipsum dolor sit atest consectetur adipisicing elit:</p>-->
                                <ul>
                                    <?php echo $userModel->favorites_2; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif ?>
                    <?php if($userModel->favorites_3):?>
                        <div class="sb-block">
                            <h5><span class="sport-team"></span>Wedding Locations</h5>
                            <div class="sb-block-in">
                                <!--                            <p>Lorem ipsum dolor sit atest consectetur adipisicing elit:</p>-->
                                <ul>
                                    <?php echo $userModel->favorites_3; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif ?>
                    <?php if($userModel->favorites_4):?>
                        <div class="sb-block">
                            <h5><span class="sport-team"></span>The Honeymoon</h5>
                            <div class="sb-block-in">
                                <!--                            <p>Lorem ipsum dolor sit atest consectetur adipisicing elit:</p>-->
                                <ul>
                                    <?php echo $userModel->favorites_4; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif ?>
                </div>

                <div class="center">
                    <ul class="block-tabs">
                        <li class="current comments">
                            <?php echo CHtml::link('Comments',Yii::app()->createUrl('user/PublicProfile',array('id'=>Yii::app()->request->getQuery('id'))))?>
                        </li>
                        <li class=" favorites">
                            <?php echo CHtml::link('Favorites',Yii::app()->createUrl('/user/favorites',array('id'=>Yii::app()->request->getQuery('id'))))?>
                        </li>
                    </ul>
                    <div class="center-in">
                        <?php
                        $this->widget('zii.widgets.CListView', array(
                            'dataProvider' => $userModel->userComments,
                            'itemView' => '_comments_list',
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