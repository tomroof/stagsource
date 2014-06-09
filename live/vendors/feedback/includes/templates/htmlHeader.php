<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Feedback</title>
        <link type="text/css" href="feedback.css" rel="stylesheet" />

        <!-- include jQuery -->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                rebind();
            });

            function rebind(){
                $('.submit').bind('click', function() {
                    $('.submit').attr('value','Loading...');
                    var post = $('form').serialize();
                    $.post('<?php print htmlspecialchars($_SERVER['REQUEST_URI'],ENT_QUOTES); ?>',post,function(data){
                        var insert = $(data).filter('#main').html();
                      $('#main').html(insert);
                      $('.error_message').hide();
                      $('.error_message').slideDown(400);
                      window.scrollTo(0,0);
                      rebind();
                    })
                    return false;
                });
            }
        </script>       
            <!--[if IE]>
                <link type="text/css" href="feedback_ie.css" rel="stylesheet" />
            <![endif]-->
    </head>

    <body>