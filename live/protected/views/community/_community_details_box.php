<?php
$array_index = array(
    '0' => '1',
    '1' => '4',
    '2' => '12',
    '3' => '2',
    '4' => '12',
    '5' => '2',
    '6' => '1',
    '7' => '4',
    '8' => '9'
 );
$this->renderPartial('_community_blocks/block_index_' . $array_index[$index], array('data' => $data));
?>