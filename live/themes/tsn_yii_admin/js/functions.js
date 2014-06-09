//menu open
jQuery(document).ready(function ($) {
    $('a[href="' + window.location.pathname + '"]').parents('li.limenu').addClass('select');


    var item = $('#sortable1').children();

    $('#sortable1').on("sortbeforestop", function (event, ui) {
        ui.item.parent().children().first().removeClass('menu-dept_1')

        // ui.item.parent().children().first().next().removeClass('menu-dept-2')

        if (!$.isEmptyObject(ui.position)) {
            var position = ui.position.left
            if (position >= 270 && position <= 350)
                ui.item.removeClass().addClass('menu-dept_1')

            if (position >= 370 && position <= 450 && (ui.item.prev().hasClass('menu-dept_1') || ui.item.prev().hasClass('menu-dept_2')  ))
                ui.item.removeClass('menu-dept_1').addClass('menu-dept_2')

            if (position <= 250)
                ui.item.removeClass().addClass('menu-dept_0')
        }


    })


    setTimeout(function () {
        $('#sflash').hide();
    }, 4000);

    //---------------- remove thumbnail -----------------------
    $('.remove_thumbnail').click(function(){
        $('.block_callback_img img').attr('src','/images/no_thumbnail.jpg').attr('alt','no_thumbnail');
        //        $('.block_callback_img img').hide();
        $('#Contents_content_thumbnail').val('');
    });
    
    $('.a_remove_thumbnail').click(function(){
        $(this).parent().prev().attr('src', '/images/no_thumbnail.jpg').attr('alt','no_thumbnail');
        $(this).prev().children().attr('value', '');
    });
//---------------- end remove thumbnail -----------------------

});

function repeatable(object) {
    var template = $('<textarea>').attr({
        'name': 'Contents[content_content][]',
        'class': 'content_content_tinymce',
        'rows': 10,
        'cols': 50

    });
    var deleteSelfButton = $('<input>').attr({
        'class': 'uibutton special top-space',
        'value': 'Remove Block',
        'onclick': 'js:$(this).parent().remove();return false;',
        'type':"button"
    });
    var container = $('<div/>').attr({
        'class': 'newContentBlock row'
    });
    $(object).before(container.prepend(template, deleteSelfButton));

    RepeatInitTiny_mce();
}
function RepeatInitTiny_mce(){
    tinymce.init({
        selector: ".content_content_tinymce:last",
        plugins : 'advhr, advimage, advlink, advlist, autolink, autoresize, autosave, contextmenu, directionality, iespell, inlinepopups, insertdatetime, nonbreaking, pagebreak, paste, preview, print, searchreplace, spellchecker, style, tabfocus, table, visualblocks, visualchars, wordcount, xhtmlxtras',
        file_browser_callback : "customFileBrowserCallback",
        theme_advanced_buttons1 : "image, | ,formatselect,fontselect,|,fontsizeselect,|,undo,redo,|,code,|,help", //preview,cut,copy,paste,pastetext, print,|,pasteword,|,search,replace,|,,removeformat,cleanup,|,,ltr,rtl,|
        theme_advanced_buttons2 : "forecolor,backcolor, |,bold,italic,underline,strikethrough,|,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,hr,|,link,unlink",
        autoresize_max_height : 600,
        width : 875,
        theme_advanced_resizing : true,
        theme_advanced_resizing_use_cookie : false
    });
}
function SingleInitTiny_mce(){
    tinymce.init({
        selector: ".content_content_tinymce",
        plugins : 'advhr, advimage, advlink, advlist, autolink, autoresize, autosave, contextmenu, directionality, iespell, inlinepopups, insertdatetime, nonbreaking, pagebreak, paste, preview, print, searchreplace, spellchecker, style, tabfocus, table, visualblocks, visualchars, wordcount, xhtmlxtras',
        file_browser_callback : "customFileBrowserCallback",
        theme_advanced_buttons1 : "image, | ,formatselect,fontselect,|,fontsizeselect,|,undo,redo,|,code,|,help", //preview,cut,copy,paste,pastetext, print,|,pasteword,|,search,replace,|,,removeformat,cleanup,|,,ltr,rtl,|
        theme_advanced_buttons2 : "forecolor,backcolor, |,bold,italic,underline,strikethrough,|,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,hr,|,link,unlink",
        autoresize_max_height : 600,
        width : '100%',
        theme_advanced_resizing : true,
        theme_advanced_resizing_use_cookie : false
    });
}

function customFileBrowserCallback(field_name, url, type, win) {
    aFieldName = field_name, aWin = win;
    if ($("#elfinder").length == 0) {

        $("body").append($("<div/>").attr("id", "elfinder"));
        var elFinder = $("#elfinder").elfinder({
            //            url: "<?php echo Yii::app()->theme->baseUrl; ?>/components/elfinder/connectors/php/connector-fileimport.php",
            url: "../../../../themes/tsn_yii_admin/components/elfinder/connectors/php/connector-fileimport.php",
            dialog: {
                width: 700, 
                modal: true, 
                title: "File manager", 
                zIndex: 900001
            }, // open in dialog window
            editorCallback: function(url) {
                aWin.document.forms[0].elements[aFieldName].value = url;
            },
            closeOnEditorCallback: true
        });
    } else {
        alert('dhfgajkdgfka');
        $("#elfinder").elfinder("open");
    }
}

function repeatableCelebrity(object) {

    var label = $('<label for="Contents_content_celebrity_id">Vendor</label>');

    var template = $('<input>').attr({
        'name': 'Contents[content_celebrity_name][]',
        'class': 'content_celebrity_name',
        'type':'text'
    });

    var hiddenField = $('<input>').attr({
        'name': 'Contents[content_vendor_id][]',
        'class': 'content_celebrity_id',
        'type':'hidden'
    });
        
    var deleteSelfButton = $('<input>').attr({
        'class': 'uibutton special left-space',
        'value': 'Remove',
        'onclick': 'js:$(this).parent().remove();return false;',
        'type':"button"
        
    });
    var container = $('<div/>').attr({
        'class': 'newContentBlock row repeatable-row'
    });
    $(object).before(container.prepend(label,template,hiddenField, deleteSelfButton));
    celebritiesAutoComplite();
}
function repeatableEvent(object) {

    var label = $('<label for="Contents_content_celebrity_id">Event</label>');

    var template = $('<input>').attr({
        'name': 'Contents[content_event_name][]',
        'class': 'content_event_name',
        'type':'text'
    });

    var hiddenField = $('<input>').attr({
        'name': 'Contents[content_event_id][]',
        'class': 'content_event_id',
        'type':'hidden'
    });

    var deleteSelfButton = $('<input>').attr({
        'class': 'uibutton special left-space',
        'value': 'Remove',
        'onclick': 'js:$(this).parent().remove();return false;',
        'type':"button"

    });
    var container = $('<div/>').attr({
        'class': 'newContentBlock row repeatable-row-event'
    });
    $(object).before(container.prepend(label,template,hiddenField, deleteSelfButton));
    eventAutoComplite();
}