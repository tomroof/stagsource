<?php
$comment_author = $data->user;
if ($data->model_name == 'ContentComments') {
    $contentComments = ContentComments::model()->findByPk($data->model_id);
    $content         = $contentComments->post;
    $created_at      = $contentComments->created_at;
    $content_content = $contentComments->content;
    $model           = $contentComments;
} else {
    $content    = Contents::model()->findByPk($data->model_id);
    $created_at = $content->created_at;
    if (!empty($content->content_excerpt)) {
        $content_content = $content->content_excerpt;
    } else {
        $content_content = $content->content_content;
    }
    $model = $content;
}
?>
<div class="block-comment">
    <table cellpadding="0" cellspacing="0">
        <tbody>
        <tr>
            <td>
                <div class="block-comment-img">
                    <div class="photo-avatar">
                        <?= $comment_author->getUserAvatar() ?>

                    </div>
                    <b><?php echo User::getUserFullName($comment_author) ?></b>
                    <?php if ($comment_author->city_id): ?>
                        <?php echo $comment_author->state_id ?
                            '<p><span>' . $comment_author->zipareas->city . '</span></p><p> '
                            . $comment_author->state_id . '</p>' : '' ?>
                    <?php endif ?>
                </div>
            </td>
            <td>
                <div class="block-comment-gray">
                    <span class="block-comment-arrow"> &nbsp; </span>

                    <div class="block-comment-top">
                        <p><b><a href="<?php echo Yii::app()->createUrl(
                                    '/user/PublicProfile/' . $comment_author->id
                                ) ?>"><?php echo User::getUserFullName($comment_author) ?></a></b> added <strong><a
                                    class="" href="<?= $content->permalink ?>"><?php echo $content->content_title ?></a>
                                to Favorites </strong></p>
                    </div>
                    <?php if (!empty($content_content)) { ?>
                        <div class="block-comment-center">
                            <blockquote>
                                <!--                                <h5><a href="-->
                                <?//= $content->permalink ?><!--">-->
                                <?php //echo $content->content_title ?><!--</a></h5>-->
                                <p><?php echo Functions::getPrewText($content_content, 300); ?></p>

                            </blockquote>
                        </div>
                    <?php } ?>

                    <div class="block-comment-bot">
                        <p><?php echo date('m/d/Y', strtotime($created_at)) ?> at  <?php echo date(
                                'h:i A',
                                strtotime($created_at)
                            ) ?></p>
                        <!--                            <div class="block-comment-bot-in"><img src="images/star-icon.png" alt="" /></div>-->
                        <div class="block-comment-bot-in">
                            <?php
                            $this->widget(
                                'application.modules.like.components.widgets.LikeWidget',
                                array(
                                     'model'        => $model,
                                     'type'         => 'like',
                                     'template'     => '<div class="count">{countLikes}</div><a href="javascript:void(0)"></a>',
                                     'containerTag' => 'div',
                                     'htmlOptions'  => array('class' => 'activity-block heart',)
                                )
                            );
                            ?>
                        </div>
                        <div class="block-comment-bot-in">
                            <?php
                            $this->widget(
                                'application.modules.like.components.widgets.LikeWidget',
                                array(
                                     'model'        => $model,
                                     'type'         => 'favorite',
                                     'template'     => '<div class="count">{countLikes}</div><a href="javascript:void(0)"></a>',
                                     'containerTag' => 'div',
                                     'htmlOptions'  => array('class' => 'activity-block plus',)
                                )
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