<div class="widget">
                    <div class="header"><span><span class="ico  gray spreadsheet"></span> Registered by Category Table </span>

						</div><!-- End header -->


<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'message-grid',
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'grid-view buttons-hovered'),
   'filter' => $model,
    'columns' => array(
        array(
            'name'=>'id',
            'htmlOptions'=>array('width'=>'5%'),
            
        ),
        'title',
        array(
            'header' => 'Total used ',
            'value' => '$data->getCountResurcesUse($data->id)',
        ),
    ),
   'ajaxUpdate' => true
));

?>
</div>
				