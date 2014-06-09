<div class="f-left <?php echo ($key=='1')?'f-left-2':'' ?>">
    <div class="img-wrap <?php echo ($data->is_checkedUser)?'active':''?>">
        <a href="#" class="poll_img">
            <img src="<?php echo $data->img ?>" alt="">
        </a>
    </div>
    <?php  echo Chtml::radioButton('poll[poll_item_id]', $data->is_checkedUser, array( 'class'=>'input_poll','value'=>$data->item_id, 'style'=>"display: none;")) ?>
    <p><?php echo $data->content ?></p>
</div>