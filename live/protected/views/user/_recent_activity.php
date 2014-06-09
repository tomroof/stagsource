<?php

if(isset($data->content_type))
    $this->renderPartial('_blockRecentActivity/createdContent', array('data' => $data, 'userModel' => $userModel));
elseif(isset($data->like_type))
    $this->renderPartial('_blockRecentActivity/favorite', array('data' => $data, 'userModel' => $userModel));
else
    $this->renderPartial('_blockRecentActivity/comment', array('data' => $data, 'userModel' => $userModel));


