<?php $comment_author = $data->author; ?>
<div class="block-comment block-comment-white">
    <table cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td>
                    <div class="block-comment-img">
                        <div class="photo-avatar">
                            <?php
                            echo CHtml::link($comment_author->getUserAvatar(), Yii::app()->createUrl('user/publicProfile/' . $comment_author->id))
//                                  echo $comment_author->getUserAvatar();
                            ?>
                        </div>
                        <b><?php echo User::getUserFullNameById($comment_author->id) ?></b>
                        <?php if ($comment_author->city_id): ?>
                            <?php echo $comment_author->state_id ? '<p><span>' . $comment_author->zipareas->city . '</span></p><p> ' . $comment_author->state_id . '</p>' : '' ?>
                        <?php endif ?>
                    </div>
                </td>
                <td>
                    <div class="block-comment-gray">
                        <span class="block-comment-arrow"> &nbsp; </span>
                        <div class="block-comment-center">
                            <blockquote>
                                <span>
                                    <?php
                                    echo CHtml::link(
                                        User::getUserFullNameById($comment_author->id), Yii::app()->createUrl('user/publicProfile/' . $comment_author->id)
                                    )
//                                    echo User::getUserFullNameById($comment_author->id);
                                    ?></a> wrote:
                                </span>
                                <?= $data->content ?>
                            </blockquote>
                        </div>
                        <div class="block-comment-bot">
                            <p><?= date('m/d/Y', strtotime($data->created_at)) ?> at  <?= date('h:i A', strtotime($data->created_at)) ?></p>
                            <?php if (!Yii::app()->user->isGuest): ?>
                                <div class="activity-block">
                                    <?php
                                    $this->widget('application.components.widgets.SpamButtonWidget', array(
                                        'model' => 'ContentComments',
                                        'model_id' => $data->id,
                                    ))
                                    ?>
                                </div>
                            <?php endif; ?>
                            <div class="block-comment-bot-in">
                                <div class="activity-block share">
                                    <div class="count">
                                        <span>
                                            <a class="addthis_counter addthis_bubble_style"  layout="button_count" ></a>
                                        </span>
                                    </div>
                                    <!-- AddThis Button BEGIN -->
                                    <!--    sdfsdf-->
                                    <a class="addthis_counter  share-btn addthis_button"></a>
                                    <!--    sdfsdsdfsf-->
                                    <script type="text/javascript">var
                                            addthis_config = {"data_track_addressbar":false,
                                                ui_use_css:true
                                            };
                                    </script>
                                    <script type="text/javascript" src="//s7.addthis.com/js/250/addthis_widget.js#pubid=ra-50a0cd6c4f80d325"></script>
                                    <!-- AddThis Button END -->
                                </div>
                            </div>
                            <div class="block-comment-bot-in">
                                <?php
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