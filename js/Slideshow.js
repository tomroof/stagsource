var $$ = $.fn;

$$.extend({
  SplitID : function()
  {
    return this.attr('id').split('-').pop();
  },

  Slideshow : {
    Ready : function()
    {
      $('div.tmpSlideshowControl')
        .hover(
          function() {
            $(this).addClass('tmpSlideshowControlOn');
          },
          function() {
            $(this).removeClass('tmpSlideshowControlOn');
          }
        )
        .click(
          function() {
            $$.Slideshow.Interrupted = true;

            $('div.tmpSlide').hide();
            $('div.tmpSlideshowControl').removeClass('tmpSlideshowControlActive');

            $('div#tmpSlide-' + $(this).SplitID()).show()
            $(this).addClass('tmpSlideshowControlActive');
			$$.Slideshow.Interrupted = false;
		//	$(this).removeClass('tmpSlideshowControlActive');
			$$.Slideshow.Counter= $(this).SplitID();
			//alert( $(this).SplitID());
          }
        );

      this.Counter = 1;
      this.Interrupted = false;

      this.Transition();
    },

    Transition : function()
    {
      if (this.Interrupted) {
        return;
      }

      this.Last = this.Counter - 1;

      if (this.Last < 1) {
        this.Last = $("#slide_num").val();
      }

      $('div#tmpSlide-' + this.Last).fadeOut(
        'slow',
        function() {
          $('div#tmpSlideshowControl-' + $$.Slideshow.Last).removeClass('tmpSlideshowControlActive');
          $('div#tmpSlideshowControl-' + $$.Slideshow.Counter).addClass('tmpSlideshowControlActive');
          $('div#tmpSlide-' + $$.Slideshow.Counter).fadeIn('slow');

          $$.Slideshow.Counter++;
			var slidenum=$("#slide_num").val();

          if ($$.Slideshow.Counter > slidenum) {
            $$.Slideshow.Counter = 1;
          }

          setTimeout('$$.Slideshow.Transition();', 5000);
        }
      );
    }
  }
});

$(document).ready(


  function() {
    $$.Slideshow.Ready();
  }
);