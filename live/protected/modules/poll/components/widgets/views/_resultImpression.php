<?php
/**
 * Created by JetBrains PhpStorm.
 * User: spiritvoin
 * Date: 19.06.13
 * Time: 13:50
 * To change this template use File | Settings | File Templates.
 */
?>
<a href="#" class="impression-box <?php echo ($data->is_checkedUser)?'checked':''?>">
    <b><?php echo $data->getpercentage($sum) ?><span>%</span></b>
    <?php  echo Chtml::radioButton('poll[poll_item_id]', $data->is_checkedUser, array('value'=>$data->item_id,'style'=>'display: none;','class'=>'input_poll' )) ?>
    <span class="impress"><?php echo $data->content ?></span>
    <span class="marked"></span>
</a>