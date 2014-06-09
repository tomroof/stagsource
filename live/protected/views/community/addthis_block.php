<div class="activity-block share">
    <div class="count">
        <span> 
            <a class="addthis_counter addthis_bubble_style"  layout="button_count" ></a>
        </span>
    </div>
    <!-- AddThis Button BEGIN -->
    <a class="addthis_button share-btn"
       addthis:url="<?php echo Yii::app()->createAbsoluteUrl('/community/view', array('c_id' => $data->id)) ?>"


       addthis:title="<?php echo $data->content_title; ?>" 
       addthis:description="<?= strip_tags($data->content_content) ?>"
       href="http://www.addthis.com/bookmark.php?v=300&amp;pubid=ra-50a0cd6c4f80d325">
<!--                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/share-black.png" alt="Bookmark and Share" style="border:0"/>-->
    </a>

    <script type="text/javascript">var
        addthis_config = {"data_track_addressbar":false,
            ui_use_css:true
        };

    </script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-50a0cd6c4f80d325"></script>
    <!-- AddThis Button END -->

</div>