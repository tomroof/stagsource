<ul class="block-tabs">
    <li <?php echo  ($this->action->id == 'RecentActivity')?'class="current"':''?>><?php echo CHtml::link('Recent Activity', Yii::app()->createUrl('user/RecentActivity')) ;?></a></li>
    <li <?php echo  ($this->action->id == 'comments')?'class="current"':''?>><?php echo CHtml::link('Comments (' . ContentComments::userCountComments(Yii::app()->user->getid()) . ')', Yii::app()->createUrl('user/comments')); ?></li>
     <li <?php echo  ($this->action->id == 'messaging')?'class="current"':''?>><?php echo CHtml::link('Messaging (' . Messages::notReadMessageCount(Yii::app()->user->getID()) . ')', Yii::app()->createUrl('user/messaging')); ?></li>
    <li <?php echo  ($this->action->id == 'favorites')?'class="current"':''?>><?php echo CHtml::link('Favorites (' . Like::userCountFavorites(Yii::app()->user->getid()) . ')', Yii::app()->createUrl('user/favorites')); ?></li>
<!--    <li class=""><a href="">Premium (3)</a></li>-->
</ul>