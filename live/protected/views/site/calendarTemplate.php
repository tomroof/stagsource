<?php $curControollerId = Yii::app()->controller->action->id; ?>
<div class="block-title">
    <h2>Studio schedules</h2>

</div>
<div class="content-in">

    <ul class="tabs-studio_schedules">
        <li class="view_all item-studio_schedules-view-all <?php echo ($curControollerId == 'CalendarViewAll')?' active':''; ?>"><a href="<?php echo Yii::app()->createUrl('/site/CalendarViewAll') ;?>"><b>View<br /> All</b></a></li>
        <li class="item-studio_schedules-1 <?php echo ($curControollerId == 'CalendarMillennium')?' active':''; ?>"><a href="<?php echo Yii::app()->createUrl('/site/CalendarMillennium') ;?>"><b>Millennium Dance Complex</b><span>5113 Lankershim Blvd.<br /> North Hollywood, CA 91601</span></a></li>
        <li class="item-studio_schedules-2 <?php echo ($curControollerId == 'CalendarDebbie')?' active':''; ?>"><a href="<?php echo Yii::app()->createUrl('/site/CalendarDebbie') ;?>"><b>Debbie Reynolds Dance Studio</b><span>6514 Lankershim Blvd.<br /> North Hollywood, CA 91606</span></a></li>
        <li class="item-studio_schedules-3 <?php echo ($curControollerId == 'CalendarEdge')?' active':''; ?>"><a href="<?php echo Yii::app()->createUrl('/site/CalendarEdge') ;?>"><b>EDGE Performing Arts Center</b><span>1020 Cole Avenue, 4th floor<br /> Los Angeles, CA 90038</span></a></li>
        <li class="item-studio_schedules-4 <?php echo ($curControollerId == 'CalendarMovement')?' active':''; ?>"><a href="<?php echo Yii::app()->createUrl('/site/CalendarMovement') ;?>"><b>Movement Lifestyle</b><span>11105 Weddington St.<br /> North Hollywood, CA 91601</span></a></li>
    </ul>

    <div class="banner-studio_schedules">
        <div class="banner-studio_schedules-in">
            <a href="<?php echo $URL1 ;?>" target="_blank" ><img src="<?php echo Yii::app()->request->baseUrl . $Banner1 ?>" alt="" /></a>
        </div>
        <div class="banner-studio_schedules-in">
            <a href="<?php echo $URL2 ;?>" target="_blank"  ><img src="<?php echo Yii::app()->request->baseUrl . $Banner2 ?>" alt="" /></a>
        </div>
    </div>

    <div class="content-studio_schedules">
        <?php echo $calendar ?>
        <p class="studio_schedules_bottom_text">
            While StagSource strives to keep all calendared events up to date and correct, all calendared events are subject to change without notice and we cannot guarantee their<br /> accuracy. It is the users responsibility to independently verify such calendared dates. Any reliance you place on such information is therefore strictly at your own risk.
        </p>
    </div>
</div>
