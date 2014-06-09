<div class="breadcrumbs-block">
    <ul class="breadcrumbs breadcrumb">
        <li><a href="/" title="">Home</a></li>
        <li class="active">Invite Friends</li>
    </ul>
</div>
<div class="wrap">
    <div class="main-content">
        <h2><span><?php echo Yii::t("UserModule.frontend", "Invite Friends"); ?></span></h2>
        <div class="content-in">
            <form action="">
                <?php
                $this->widget('application.components.ProfileSidebarWidget', array('model' => $userModel));
                ?>

                <div class="center">
                    <div class="center-in">
                        <div class="block-profile">

                            <script src="http://connect.facebook.net/en_US/all.js"></script>
                            <script>
                                FB.init({
                                    appId:'<?php echo Yii::app()->params['facebook']['appId'] ?>',
                                    cookie:false,
                                    status:true,
                                    xfbml:true
                                });

                                function FacebookInviteFriends()
                                {
                                    FB.ui({
                                            method: 'apprequests',
                                            message: ' '
//                        display:'dialog'
                                        }
                                        // requestCallback
                                    );
                                }
<!--                            <script>-->
<!--                                FB.init({-->
<!--                                    appId:'--><?php //echo Yii::app()->params['facebook']['appId'] ?><!--'-->
<!--                                    ,cookie:true-->
<!--                                    ,status:true-->
<!--                                    ,xfbml:true-->
<!--                                });-->
<!---->
<!--                                function FacebookInviteFriends()-->
<!--                                {-->
<!--                                    FB.ui({-->
<!--                                        method: 'apprequests',-->
<!--                                        message: 'Your Message dialog',-->
<!--                                        display:'dialog'-->
<!--                                    }-->
<!--                                    requestCallback-->
<!--                                );-->
<!--                                }-->
<!--                                function requestCallback(e){-->
<!--                                    var csrfToken = "--><?//= Yii::app()->request->csrfToken; ?><!--";-->
<!--                                    var url ="--><?php //echo $this->createUrl('/user/AjaxInviteFriends'); ?><!--";-->
<!--                                    user_id = "--><?php //echo Yii::app()->user->id; ?><!--";-->
<!--                                    user_facebook_id = (FB.getAuthResponse() || {}).userID;-->
<!--                                    $.ajax({-->
<!--                                        url:url ,-->
<!--                                        type:'POST',-->
<!--                                        data:{-->
<!--                                            '--><?//= Yii::app()->request->csrfTokenName; ?><!--':csrfToken,-->
<!--                                            facebook_request:{-->
<!--                                                user_id:user_id,-->
<!--                                                requestTo:e.to,-->
<!--                                                user_facebook_id:user_facebook_id-->
<!---->
<!--                                            }-->
<!--                                        }-->
<!--                                    })-->
<!--                                    .success(function(data) {-->
//                                        $('#result').html('<h2>'+data+'</h2>');
<!--                                        console.log(data);-->
<!--                                    }).error(function(data){-->
<!--                                        alert('Error response :( ');-->
<!--                                    })-->
<!--                                }-->

                                //$('#invitefriends').on('click',function()
                                //{
                                // console.log(requestCallback);
                                //})
                            </script>



                            <div id="fb-root"></div>
                            <div id="result">
                            </div>
                            <?php
                            if ($userModel->service != 'facebook') {
                                $invites = unserialize($userModel->service);
                            } else {
                                $invites = false;
                            }
                            if ($invites && count($invites) >= 10 && $userModel->service != 'facebook'):
                                ?>
                                <h2>You have  used this promotion.</h2>

                            <?php else : ?>
                                <div class="box-invite_friends" style="text-align: center;">
                                    <a href='#' onclick="FacebookInviteFriends();" id="invitefriends">
                                        <!--Invite 10 Clients and Receive a <span>One Year Free</span> Premium Membership!-->
                                        INVITE FRIENDS
                                    </a>
                                </div>
                            <?php endif; ?>


                            <script type='text/javascript'>
                                if (top.location!= self.location)
                                {
                                    top.location = self.location
                                }
                            </script>

                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>