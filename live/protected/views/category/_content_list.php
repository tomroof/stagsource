<!--Attention!-->
<!--Boxes are numbered according to the meter clistview-->

<?php 
$size = Contents::get_size_type();
?>
<?php $this->renderPartial('application.views.contents._contents_blocks.'.$data->content_type.'/'.$size[++$index], array('data' => $data)); ?>

<!--Attention!-->
<!--Boxes are numbered according to the meter clistview-->