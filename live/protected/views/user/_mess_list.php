<?php
$user_from = User::model()->findByPk($data->from_user_id);
?>
<tr class="<?php echo ($data->read_status == 0) ? '' : 'read'; ?>">
    <td>
        <div class="img-mes">
            <?php echo CHtml::link($user_from->getUserAvatar(), Yii::app()->createUrl('user/publicProfile/' . $user_from->id))
            ?>
        </div>
        <b><?php echo CHtml::link($user_from->first_name . ' ' . $user_from->last_name, Yii::app()->createUrl('user/publicProfile/' . $user_from->id)) ?></b>
        <p><?php if ($user_from->city_id): ?>
                <?php echo $user_from->state_id ? '' . $user_from->zipareas->city . ', ' . $user_from->state_id . '' : '' ?>
            <?php endif ?></p>
    </td>
    <td>
        <b><?php echo CHtml::link(strtoupper($data->title), Yii::app()->createUrl('user/message', array('mid' => $data->id))); ?></b>
        <p><?php echo CHtml::link(substr(strip_tags($data->content), 0, 35) . '...', Yii::app()->createUrl('user/message', array('mid' => $data->id))); ?></p>
    </td>
    <td>
        <b><?= date('F d, Y', strtotime($data->date)) ?></b>
        <p><?= date('g:i A', strtotime($data->date)) ?></p>
        <p></p>
    </td>
</tr>
