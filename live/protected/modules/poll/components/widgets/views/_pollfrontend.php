<div class="line">
    <?php  echo Chtml::radioButton('poll[poll_item_id]', $data->is_checkedUser, array('class' => 'styled', 'value'=>$data->item_id)) ?>
    <span class="label"><?php echo $data->content ?></span>
</div>