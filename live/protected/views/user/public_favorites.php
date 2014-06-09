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
                            <!--                            <a class="btn light-big" href="#" title="">Message</a>-->

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

                    <?php if($userModel->sports_teams):?>
                        <div class="sb-block">
                            <h5><span class="sport-team"></span>Proposal Ideas</h5>
                            <div class="sb-block-in">
                                <!--                            <p>Lorem ipsum dolor sit atest consectetur adipisicing elit:</p>-->
                                <ul>
                                    <?php echo $userModel->sports_teams ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif ?>

                    <?php if($userModel->athletes):?>
                        <div class="sb-block">
                            <h5><span class="athletes"></span>The Bachelor Party</h5>
                            <div class="sb-block-in">
                                <!--                            <p>Lorem ipsum dolor sit atest consectetur adipisicing elit:</p>-->
                                <ul>
                                    <?php echo $userModel->athletes ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif ?>

                    <?php if($userModel->music):?>
                        <div class="sb-block">
                            <h5><span class="music"></span>Wedding Locations</h5>
                            <div class="sb-block-in">
                                <!--                            <p>Lorem ipsum dolor sit atest consectetur adipisicing elit:</p>-->
                                <ul>
                                    <?php echo $userModel->music ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif ?>

                    <?php if($userModel->movies):?>
                        <div class="sb-block">
                            <h5><span class="movies"></span>The Honeymoon</h5>
                            <div class="sb-block-in">
                                <!--                            <p>Lorem ipsum dolor sit atest consectetur adipisicing elit:</p>-->
                                <ul>
                                    <?php echo $userModel->movies ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif ?>

                </div>

                <div class="center">
                    <ul class="block-tabs">
                        <li class=" comments">
                            <?php echo CHtml::link('Comments',Yii::app()->createUrl('user/PublicProfile',array('id'=>Yii::app()->request->getQuery('id'))))?>
                        </li>
                        <li class="current favorites">
                            <?php echo CHtml::link('Favorites',Yii::app()->createUrl('/user/favorites',array('id'=>Yii::app()->request->getQuery('id'))))?>
                        </li>
                    </ul>
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