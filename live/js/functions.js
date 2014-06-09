jQuery(function ($) {

    //	$('.link-create-topic').fancybox({
    //		"autoDimensions": false,
    //        "width": 608,
    //        "height": 'auto',
    //        "type": 'inline',
    //        "centerOnScroll": false,
    //        "hideOnContentClick": false,});

    if ($.isFunction($.fn.inFieldLabels)) {
        $(".label label").inFieldLabels({
            fadeOpacity: 0
        });
    };

    var params = {
        changedEl: ".lineSel select",
        visRows: 8,
        scrollArrows: true
    }
    cuSel(params);
    $('#filter').on('change',function(){
        window.location.href=$(this).val();
    });

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
        if ($(".header-top-hide-login").is(":hidden")){
            $(".header-top-hide-login").effect("blind", {
                direction: 'vertical', 
                mode: 'show'
            }, 1000);
        }
    });
    $(".header-top-close").click(function () {
        $(".header-top-hide-login").effect("blind", {
            direction: 'vertical', 
            mode: 'hide'
        }, 800);
    });



    $('#slides').slides({
        //        preload: true,
        preloadImage: 'img/loading.gif'//,
    //        play: 5000,
    //        pause: 2500,
    //        hoverPause: true
    });

    if($(".flexslider-home").length > 0){
        $('.flexslider-home').flexslider({
          animation: "fade",
          controlNav: false,
          start: function(slider){
            $('body').removeClass('loading');
          }
        });
    }


    //------------------------------start filter--------------------------
    $('body').on('click','.filter',function(){

        if($(this).parent().hasClass('active')){
            $(this).parent().removeClass('active');
            $(this).next().click();
            if($(this).next().next().hasClass('header_checkbox_picture_poll')) {
                $(this).next().next().click();
                $(this).next().next().next().click();
            }
        }else{
            $(this).parent().addClass('active')
            $(this).next().click();
            if($(this).next().next().hasClass('header_checkbox_picture_poll')) {
                $(this).next().next().click();
                $(this).next().next().next().click();
            }
        }
        $('#form_filter').submit();

        return false;
    });
    //------------------------------ end filter--------------------------
	
    //------------------------------ SlideShow PetailsPage--------------------------
    $('#carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 84,
        itemMargin: 0,
        //   reverse:true,
        asNavFor: '#slider'
    });
    $('#carousel2').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 84,
        itemMargin: 0,
        //reverse:true,
        asNavFor: '#slider2'
    });
    $('#carousel3').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 84,
        itemMargin: 0,
        //  reverse:true,
        asNavFor: '#slider3'
    });
	   
    $('#slider').flexslider({
        slideshow: false,
        animation: "slide",
        controlNav: false,
        directionNav:false,
        animationLoop: true,
        sync: "#carousel",
        //reverse:true,
        slideshowSpeed: 4000
    });
    $('#slider2').flexslider({
        animation: "slide",
        controlNav: false,
        directionNav:false,
        animationLoop: true,
        sync: "#carousel2",
        // reverse:true,
        slideshowSpeed: 4000
    });
    $('#slider3').flexslider({
        slideshow: false,
        animation: "slide",
        controlNav: false,
        directionNav:false,
        animationLoop: true,
        sync: "#carousel3",
        reverse:true,
        slideshowSpeed: 4000
    });
    
    $('.link_comment_sign_up').click(function() {
        $("#show_login").trigger('click');
    })
	
});

  




 
