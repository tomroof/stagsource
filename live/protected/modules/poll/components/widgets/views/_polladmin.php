<?php
/**
 * Created by JetBrains PhpStorm.
 * User: spiritvoin
 * Date: 10.06.13
 * Time: 16:37
 * To change this template use File | Settings | File Templates.
 */
?>
<div class="_poll_item_default" style="display: none">
    <?php $this->render('_poll_item', array('model' => $model_new)); ?>
</div>

<div class="poll_item">
    <?php
    foreach ($model as $key => $val) {
        $this->render('_poll_item', array('model' => $val));
    }
    ?>
</div>
<div class="add_poll">
    <?php echo CHtml::link('add poll item', '#', array('class' => 'add_poll_item uibutton')); ?>
</div>



