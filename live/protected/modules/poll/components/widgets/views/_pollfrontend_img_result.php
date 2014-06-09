<style>
    .picture-poll-block-big .img-wrap:hover {border-color: #802483;}
    .picture-poll-block-big .img-wrap.active:hover {border-color: #fff;}
</style>
<div class="f-left <?php echo ($key=='1')?'f-left-2':'' ?>">
    <div class="img-wrap <?php echo ($data->getpercentage($sum) > 50) ? 'active' : '' ?> ">
        <img src="<?php echo $data->img ?>" alt="" />
    </div>
    <p><?php echo $data->content ?></p>
    <span class="content-block-item-progress">
        <span class="progress-percent progress-full"><?php echo $data->getpercentage($sum) ?> %</span>
        <span class="progress" style="width:<?php echo $data->getpercentage($sum) ?>%"></span>
    </span>
</div>
