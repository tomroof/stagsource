<div class="block-comment">
    <table cellpadding="0" cellspacing="0">
        <tbody>
        <tr>
            <td>
                <div class="block-comment-img">
                    <div class="photo-avatar">
                        <?php
                        echo CHtml::link(
                            $userModel->getUserAvatar(), Yii::app()->createUrl('user/publicProfile/' . $userModel->id)
                        )
                        ?>
                    </div>
                    <b><?php echo User::getUserFullName($userModel) ?></b>
                    <?php if ($userModel->city_id): ?>
                        <?php echo $userModel->state_id ? '<p><span>' . $userModel->zipareas->city . '</span></p><p> ' . $userModel->state_id . '</p>' : '' ?>
                    <?php endif ?>
                </div>
            </td>
            <td>
                <div class="block-comment-gray">
                    <span class="block-comment-arrow"> &nbsp; </span>

<!--                    <div class="block-comment-img-in"><a href="#"><img src="/images/block-comment-img.png" alt=""/></a>-->
<!--                    </div>-->
                    <div class="block-comment-top">
                        <p><b><a href="<?php echo Yii::app()->createUrl('user/publicProfile/' . $userModel->id); ?>"><?php echo User::getUserFullName($userModel) ?></a></b> commented on <strong><a class="" href="<?php echo $data->post->permalink; ?>"><?php echo $data->post->content_title ;?></a></strong></p>
                    </div>
                    <?php if (!empty($data->content)) { ?>
                        <div class="block-comment-center">
                            <blockquote>
                                <span><a href="<?php echo Yii::app()->createUrl('user/publicProfile/' . $userModel->id); ?>"><?php echo User::getUserFullName(
                                            $userModel
                                        ) ?></a> wrote:</span> <?php echo Functions::getPrewText($data->content,300);?>
                            </blockquote>
                        </div>
                    <?php } ?>
                    <div class="block-comment-bot">
                        <p><?= date('m/d/Y', strtotime($data->created_at)) ?>
                            at  <?= date('h:i A', strtotime($data->created_at)) ?></p>
                        <div class="block-comment-bot-in">
                            <div class="activity-block share">
                                <div class="count">
                                        <span>
                                            <a class="addthis_counter addthis_bubble_style" layout="button_count"></a>
                                        </span>
                                </div>
                                <a class="addthis_button share-btn"
                                   href="http://www.addthis.com/bookmark.php?v=300&amp;pubid=ra-50a0cd6c4f80d325">
                                </a>
                                <script type="text/javascript">var
                                        addthis_config = {"data_track_addressbar": false,
                                            ui_use_css: true
                                        };
                                </script>
                                <script type="text/javascript"
                                        src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-50a0cd6c4f80d325"></script>
                            </div>
                        </div>
                        <div class="block-comment-bot-in"> <?php
                            $this->widget(
                                'application.modules.like.components.widgets.LikeWidget', array('model' => $data,
                                    'type' => 'like',
                                    'template' => '<div class="count">{countLikes}</div><a href="javascript:void(0)"></a>',
                                    'containerTag' => 'div',
                                    'htmlOptions' => array('class' => 'activity-block heart',))
                            );
                            ?>
                        </div>
                        <div class="block-comment-bot-in">
                            <?php
                            $this->widget(
                                'application.modules.like.components.widgets.LikeWidget', array('model' => $data,
                                    'type' => 'favorite',
                                    'template' => '<div class="count">{countLikes}</div><a href="javascript:void(0)"></a>',
                                    'containerTag' => 'div',
                                    'htmlOptions' => array('class' => 'activity-block plus',))
                            );
                            ?>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
