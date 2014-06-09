<!-- full width -->
<div class="widget">
    <div class="header"><span><span class="ico gray stats_pie"></span> Registered by Category</span>

    </div><!-- End header -->
    <div class="content ">

<!--       <div class="oneThree">
                                 <div class="shoutcutBox"><strong><?php // echo $total_spec; ?></strong> <em>All Users</em> </div>
                             <div class="breaks"><span></span></div>
                                 // breaks 
                           
                                <div class="breaks"><span></span></div>
                                 // breaks 

								<br/><br/>
                            </div>-->

<div class="twoOne">

        <table class="chart-pie">
            <thead>
                <tr>
                    <th></th>
                    <?php
                    foreach ($array_not_null_spec as $item) {
                        $count = $model_spec_rel->countByAttributes(array('specialization_id' => $item)); ?>

                    <th style="color : #aed741;"><?php echo Yii::app()->db->createCommand()
    ->select('title')
    ->from('tbl_specializations')
    ->where('id=:id', array(':id'=>$item))
    ->queryScalar();?> (<?= $count; ?>)</th>
                    <?php }  ?>


           
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th></th>
                        <?php
                    foreach ($array_not_null_spec as $item) {
                        $count = $model_spec_rel->countByAttributes(array('specialization_id' => $item)); ?>
                        <td><?= $count; ?></td>
                    <?php }  ?>
                    
      
                </tr>
            </tbody>
        </table>
</div>
        <div class="chart-pie-shadow" ></div>

<div class="clear"></div>
    </div><!-- End content -->
</div><!-- End full width -->

<div class="widget">
                    <div class="header"><span><span class="ico  gray spreadsheet"></span> Registered by Category Table </span>

						</div><!-- End header -->


<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'message-grid',
    'dataProvider' => $model_spec->search(),
    'htmlOptions' => array('class' => 'grid-view buttons-hovered'),
   'filter' => $model_spec,
    'columns' => array(
        array(
            'name'=>'id',
            'htmlOptions'=>array('width'=>'5%'),
            
        ),
        'title',
        array(
            'header' => 'Total used ',
            'value' => '$data->getCountSpecUse($data->id)',
            'filter' => false,
        ),
    ),
   'ajaxUpdate' => true
));

?>
</div>
				