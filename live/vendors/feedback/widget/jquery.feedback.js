(function($) {

    $.fn.feedback = function(options){
        options = $.extend({
            duration: 500,
            easing: 'swing',
            position: 'right',
            inWidth: '-160px',
            outWidth: '-0px'
        }, options);

    $(this).each(function() {
       var feedbackContainer = $(this);
       var html;
       var animationOut;
       var animationIn;
       var status = 'in';
       html = '<div id="feedback">' +
                '<div id="feedback-body">' +
                '<p>We\'d love to get your feedback:</p>' +
                '<ul>' +
                '<li id="bug"><a class="iframe" href="http://'+domain+'/vendors/feedback/feedback.php?action=bug">Report a bug</a></li>' +
                '<li id="suggestion"><a class="iframe" href="http://'+domain+'/vendors/feedback/feedback.php?action=suggestion">Send an idea</a></li>' +
                '<li id="comment"><a class="iframe" href="http://'+domain+'/vendors/feedback/feedback.php?action=comment">Give us a comment</a></li>' +
                '</ul>' +
                '</div>' +
                '</div>';


       feedbackContainer.html(html);

       var feedback = $(this).find('#feedback');
       var feedbackBody = feedback.find('#feedback-body');
       if (options.position == 'right'){
           feedback.addClass('feedback-right');
           feedbackBody.addClass('feedback-body-right');
           animationOut = {right: options.outWidth};
           animationIn = {right: options.inWidth};
       } else if (options.position == 'left'){
           feedback.addClass('feedback-left');
           feedbackBody.addClass('feedback-body-left');
           animationOut = {left: options.outWidth};
           animationIn = {left: options.inWidth};
       }

       //popout/popback
       feedback.click(function(){
            if(status == 'in'){
                feedback.animate(animationOut,options.duration,options.easing);
                status = 'out';
            } else {
                feedback.animate(animationIn,options.duration,options.easing);
                status = 'in';
            }            
        });
        //close feedback if hyperlinks are clicked
        feedback.find('a').click(function(){
            $(feedback).animate(animationIn,options.duration,options.easing);
            status = 'in';
        });
        return this;
    });
    
    }
})(jQuery);

