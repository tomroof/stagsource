<div class="impression-block-soc">
    <span class='st_facebook_hcount' displayText='Facebook' st_url="<?php echo Yii::app()->createAbsoluteUrl('/contents/view/' . $data->id) ?>" st_title="<?= $data->content_title ?>"  st_image="" st_summary="<?= strip_tags($data->content_content) ?>" ></span>
    <span class='st_twitter_hcount' displayText='Tweet' st_url="<?php echo Yii::app()->createAbsoluteUrl('/contents/view/' . $data->id) ?>" st_title="<?= $data->content_title ?>"  st_image="" st_summary="<?= strip_tags($data->content_content) ?>" ></span>
    <span class='st_email_custom' displayText='Email'  st_url="<?php echo Yii::app()->createAbsoluteUrl('/contents/view/' . $data->id) ?>" st_title="<?= $data->content_title ?>"   st_image="" st_summary="<?= strip_tags($data->content_content) ?>" >
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mail-icon.png" alt=""/></span>
    <span class='st_fblike_hcount' displayText='Facebook Like' st_url="<?php echo Yii::app()->createAbsoluteUrl('/contents/view/' . $data->id) ?>" st_title="<?= $data->content_title ?>"  st_image="" st_summary="<?= strip_tags($data->content_content) ?>" ></span>
    <span class='st_twitterfollow_hcount' displayText='Twitter Follow' st_url="<?php echo Yii::app()->createAbsoluteUrl('/contents/view/' . $data->id) ?>" st_title="<?= $data->content_title ?>"  st_image="" st_summary="<?= strip_tags($data->content_content) ?>" ></span>
    
    <!-- <?php if (!empty($data->content_source)) { ?>
        <p><span>Source: </span><?php echo CHtml::link($data->content_source,$data->content_source,array("target"=>"_blank"))?></p>
    <?php } ?> -->
</div>