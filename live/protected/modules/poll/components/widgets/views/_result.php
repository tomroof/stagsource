<div class="line">
    <span class="label"><?php echo $data->content ?></span>
    <span class="content-block-item-progress">
		<span class="progress-percent progress-full"><?php echo $data->getpercentage($sum) ?> %</span>
		<span class="progress" style="width:<?php echo $data->getpercentage($sum) ?>%"></span>
	</span>
</div>