;(function($) {
    $.preloadImages = function(images, func) {        
        var i = 0;
        var cache = [];
        var loaded = 0;
        var num = images.length;
        
        for ( ; i < num; i++ ) (function(i) {
            var new_image = $('<img/>').attr('src', images[i]).load(function(){
                loaded++;
                
                if(loaded == num)
                {                                                
                    func();                   
                }
            });						
            cache.push(new_image);
        })(i);
        
        return true;
    };
    
    $.fn.imgSlider = function(images) {        
        if (!$(this).length || $(this).length>1) {            
            return this;
        }
        
        var direction = 'right';
        var e = this;
        var timeout_id = 0;
        var in_progress = false
        var i = 0;
        var num_slides = $(e).find('.holder > li').length;
        var slide_widths = $(e).find('.holder > li:first').width();
        var speed = 200;
        
        for ( ; i < num_slides; i++ ) (function(i) {            
            $(e).find('.holder > li').eq(i).css('background', 'url('+images[i]+') no-repeat');
        })(i);
        
        function slider_animate(new_dir)
        {
            clearTimeout(timeout_id);
            timeout_id = setTimeout(auto_animate, 5000);
            in_progress = true;
            
            var dir = direction;
            
            if(new_dir)
            {
                dir = new_dir;
            }
            
            if(dir == 'right')
            {
                var toMove = $(e).find('.holder').children('li:first');
                var oldMargin = $(toMove).css('margin-right');
                $(toMove).animate({'margin-left':'-'+slide_widths+'px', 'margin-right':'0px', 'opacity':0.3}, speed, null, function(){                    
                    $(this).appendTo($(this).parent()).css({'margin-left':'0px', 'margin-right':oldMargin, 'opacity':1});                    
                    in_progress = false;
                }); 
            }
            else
            {
                $(e).find('.holder').children('li:eq(2)').animate({'opacity':0.3}, speed, null, function(){$(this).css('opacity',1);});
                $(e).find('.holder').children('li:last').css('margin-left', '-'+slide_widths+'px').prependTo('.holder').animate({'margin-left':'0px'}, speed, null, function(){                        
                    in_progress = false;                    
                });                
            }
        }
        
        $(e).find('.holder > li').hover(function(){
            clearTimeout(timeout_id);            
            $(this).find('.caption').stop().fadeTo(500, 0.8);            
        },function(){
            $(this).find('.caption').stop().fadeTo(500, 0);            
            timeout_id = setTimeout(auto_animate, 3000);            
        });
        
        function auto_animate()
        {
            slider_animate('right');            
        }
        
        $(e).find('.next').click(function(){
            if(!in_progress)
            {
                slider_animate('right');
            }
            
            return false;
        });
        
        $(e).find('.prev').click(function(){
            if(!in_progress)
            {
                slider_animate('left');
            }
            
            return false;
        });
        
        timeout_id = setTimeout(auto_animate, 3000);        
      
        return true;
    };
})(jQuery);