jQuery(function($) {
                                
    if ($.isFunction($.fn.inFieldLabels)) {
        $(".label label").inFieldLabels({
            fadeOpacity: 0
        });
    };

    $('.link-sign_in').fancybox({

        "width": 608,
        "height": 1050,
        "type": 'iframe',
        'autoScale' : false,
        "hideOnOverlayClick": false,
        'centerOnScroll' : false
    });

    $('#community_create').fancybox({

        "width": 608,
        "height": 1050,
        "type": 'iframe',
        'autoScale' : false,
        "hideOnOverlayClick": false,
        'centerOnScroll' : false
    });

    $("#show_login").click(function () {
        if ($(".header-top").is(":hidden")){
            $(".header-top").effect("blind", {
                direction: 'vertical', 
                mode: 'show'
            }, 1000);
        }
    });
    $(".header-top-close").click(function () {
        $(".header-top").effect("blind", {
            direction: 'vertical', 
            mode: 'hide'
        }, 800);
    });

    //------------------------------start filter--------------------------    
    $('body').on('click','.filter',function(){
        if($(this).parent().hasClass('active')){
            $(this).parent().removeClass('active');
            $(this).next().click();
        }else{
            $(this).parent().addClass('active')
            $(this).next().click();
        }
        $('#form_filter').submit();

        return false;
    });
});