<div class="block-content-gray">
    <div class="wrap">
        <div class="block-content-in celebrity-top-block">
            <div class="connect-block-all">
                <div class="connect-block">
                    <b>Connect</b>
                    <ul class="f-share">
                        <?php
                        $arrayCssClass = array('web'=>'web','fb'=>'fb','twitter'=>'twitter','instagram'=>'instagram','g-plus'=>'g-plus','youtube'=>'youtube');
                        foreach($content->content_celebrity_social_links as $key=>$val){
                            if(!empty($val)){ ?>
                        <li class="<?php echo $arrayCssClass[$key] ?>"><?php echo CHtml::link('&nbsp;', $val, array('target' => '_blank')); ?></li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                </div>
                <?php
                $this->widget(
                    'application.modules.like.components.widgets.LikeWidget', array('model' => $content,
                        'type' => 'fans',
//                        'template' => '<div class="count">{countLikes}</div><a href="javascript:void(0)"></a>',
                        'template' => '<a class="but-big but-green" href="javascript:void(0)">Be a fan!</a><span class="but-big box-fans"><b>{countLikes}</b> Fans</span>',
                        'containerTag' => 'div',
                        'htmlOptions' => array('class' => '',))
                );
                ?>
            </div>
            <div class="content-info-all">
                <div class="content-img">
                    <div class="content-in-img">
                        <a title=""><?php echo  CHtml::image($content->getImageSrc(),'df',array('style'=>'width: 185px;')); ?></a>
                        <?php if (!empty($content->content_is_premium)) {
                            if ($content->content_is_premium == '1') {
                                echo '<div class="pro-black">&nbsp;</div>';
                            } elseif ($content->content_is_premium == '2') {
                                echo '<div class="pro-white">&nbsp;</div>';
                            }
                        }?>
                    </div>
                </div>
                <div class="content-info">
                    <h2><?php echo $content->content_title ?></h2>
                    <span><?php echo $content->content_sub_title; ?></span>
                </div>
                <p><?php echo $content->content_content ?></p>
            </div>
            <?php
            $LinkTags = ContentTag::getLinkTags($content->id);
            if (!empty($LinkTags)) {
                ?>
                <div class="block-tags">
                    <span>Tags</span>
                    <?php echo $LinkTags?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="wrap">
    <div class="main-content featured">
        <h2><span>Featured</span></h2>
        <div class="content-block-all">
            <div class="row">
                <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $dataProvider,
                    'itemView' => '_content_list',
                    'afterAjaxUpdate' => 'initflexslider',
                    'template' => '{items}<div class="pagination-block"><div class="pagination">{pager}</div></div>',
                    'pager' => array(
                        'cssFile' => false,
                        'prevPageLabel' => '&nbsp;',
                        'nextPageLabel' => '&nbsp;',
                        'header' => '',
                        'maxButtonCount' => '3',
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</div>

