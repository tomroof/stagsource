<div class="sidebar">
    <div class="sb-block-top">
        <div class="sb-box-top">
            <?php echo $this->model->userAvatar ?>
                <?php
//            $content_model =Contents::model()->findByAttributes(array('dancer_author'=>$this->model->id));
//            if(!empty($content_model)){
                echo CHtml::link(
                    'Profile', Yii::app()->createUrl('user/PublicProfile', array('id' => Yii::app()->user->id)),
                    array('class' => 'but-big but-green')
                );
//            }else{
//                echo CHtml::link(
//                    'Edit Profile', Yii::app()->createUrl('user/profile'), array('class' => 'but-big but-green but-profile')
//                );
//            }
                ?>
        </div>
        <div class="sb-box-bot">
            <span><?php echo CHtml::tag('p', array(), User::getUserFullName($this->model)) ?></span>
            <p>
                <?php if ($this->model->city_id): ?>
                    <?php echo $this->model->state_id ? $this->model->zipareas->city . ', ' . $this->model->state_id : '' ?>
                <?php endif ?>

            </p>
        </div>
    </div>
    <div class="sb-block dashboard-menu">
        <h5>Dashboard</h5>

        <div class="sb-block-in">
            <ul class="menu-sid ">
                <li class="sb-icon1 <?php echo
                Yii::app()->controller->action->id == 'RecentActivity' ? 'active' : '' ?>">
                    <?php echo CHtml::link('My Dashboard', Yii::app()->createUrl('user/RecentActivity')); ?>
                </li>
                <li class="sb-icon2 <?php echo Yii::app()->controller->action->id == 'profile' ? 'active' : '' ?>">
                    <?php echo CHtml::link('My Profile', Yii::app()->createUrl('user/profile')); ?>
                </li>
                <li class="sb-icon3 <?php echo Yii::app()->controller->action->id == 'calendar' ? 'active' : '' ?>">
                    <?php echo CHtml::link('Calendar', Yii::app()->createUrl('user/calendar')); ?>
                </li>
                <li class="sb-icon4 <?php echo
                Yii::app()->controller->action->id == 'accountsettings' ? 'active' : '' ?>">
                    <?php echo CHtml::link('Account Settings', Yii::app()->createUrl('user/accountsettings')); ?>
                </li>
                <li class="sb-icon5 <?php echo
                Yii::app()->controller->action->id == 'InviteFriends' ? 'active' : '' ?>">
                    <?php echo CHtml::link('Invite Friends', Yii::app()->createUrl('user/InviteFriends')); ?>
                </li>
            </ul>
        </div>
    </div>
</div>
