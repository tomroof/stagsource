<?php

	
?>

<link rel="stylesheet" href="css/imgareaselect-default.css">
<link rel="stylesheet" href="css/imgareaselect-animated.css">

<script src="scripts/jquery.min.js"></script>
<script src="scripts/jquery.imgareaselect.js"></script>
<script src="scripts/jquery.imgareaselect.min.js"></script>
<script src="scripts/jquery.imgareaselect.pack.js"></script>

<script>
$(document).ready(function () {
  //$('#ladybug_ant').imgAreaSelect({ maxWidth: 200, maxHeight: 150, handles: true });
  //$('#my').imgAreaSelect({ aspectRatio: '4:3', handles: true });
  //$('#my').imgAreaSelect({ x1: 120, y1: 90, x2: 280, y2: 210 });
  
  
 /* $('<div><img src="Penguins.jpg" style="position: relative;" /><div>')
        .css({
            float: 'right',
            position: 'relative',
            overflow: 'hidden',
            width: '100px',
            height: '100px'
        })
        .insertAfter($('#my'));*/
		
		/*, onSelectEnd: function (img, selection) {
            $('input[name="x1"]').val(selection.x1);
            $('input[name="y1"]').val(selection.y1);
            $('input[name="x2"]').val(selection.x2);
            $('input[name="y2"]').val(selection.y2);            
        }
		
		aspectRatio: '1:1',
  */
  //$('#my').imgAreaSelect({x1: 120, y1: 90, x2: 280, y2: 210, handles: true, onSelectChange: preview});
  $('#my').imgAreaSelect({x1: 120, y1: 90, x2: 280, y2: 210, fadeSpeed:200, persistent: true, handles: true, onSelectChange: preview, onInit: preview});
  
  
  $('#saveThumb').click(function(){
            var x1 = $('#x1').val();
            var y1 = $('#y1').val();
            var x2 = $('#x2').val();
            var y2 = $('#y2').val();
            var w = $('#w').val();
            var h = $('#h').val();
            if (x1 == "" || y1 == "" || x2 == "" || y2 == "" || w == "" || h == "") {
                alert("You must make a selection first");
                return false;
            }
            else {
                return true;
            }
        });
		
});

function preview1(img, selection) {
    var scaleX = 100 / (selection.width || 1);
    var scaleY = 100 / (selection.height || 1);
  
    $('#my + div > img').css({
        width: Math.round(scaleX * 1200) + 'px',
        height: Math.round(scaleY * 800) + 'px',
        marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
        marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
    });
}

function preview(img, selection) {
    var original_height		= img.height;
	var original_width		= img.width;


    if (!selection.width || !selection.height)
        return;
    
    var scaleX = 150 / selection.width;
    var scaleY = 150 / selection.height;

    $('#preview img').css({
        width: Math.round(scaleX * original_width),
        height: Math.round(scaleY * original_height),
        marginLeft: -Math.round(scaleX * selection.x1),
        marginTop: -Math.round(scaleY * selection.y1)
    });

    $('#x1').val(selection.x1);
    $('#y1').val(selection.y1);
    $('#x2').val(selection.x2);
    $('#y2').val(selection.y2);
    $('#w').val(selection.width);
    $('#h').val(selection.height);     
}

</script>



<div class="container demo">
  <div style="float: left; width: 50%;">
    <p class="instructions">
      Click and drag on the image to select an area. 
    </p>
 
    <div class="frame" style="margin: 0 0.3em; width: 500px; height: 400px;">
      <img id="my" src="Penguins.jpg" />
	</div> 
  </div>

   <div style="float: right; width: 23%;">
    <p style="font-size: 110%; font-weight: bold; padding-left: 0.8em;">
      Selection Preview
    </p>
  
    <div class="frame"  style="margin: 0 1em; width: 100px; height: 100px; float:left">
      <div id="preview" style="width: 150px; height: 150px; overflow: hidden;">
        <img src="Penguins.jpg" style="width: 150px; height: 150px;" />
      </div>
    </div>
	


<form action="crop.php" method="post">
<table style="margin-top: 12em; padding-left: 0.8em;">
      <thead>
        <tr>
          <th colspan="2" style="font-size: 110%; font-weight: bold; text-align: left; padding-left: 0.1em;">
            Coordinates &amp; Dimensions
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td ><b>X<sub>1</sub>:</b></td>
 		      <td ><input type="text" name="x1" id="x1" value="120" /></td>
 		      
        </tr>
        <tr>
          <td><b>Y<sub>1</sub>:</b></td>
          <td><input type="text" name="y1" id="y1" value="90" /></td>
        </tr>
        <tr>
          <td><b>X<sub>2</sub>:</b></td>
          <td><input type="text" name="x2" id="x2" value="280" /></td>
        </tr>
        <tr>
          <td><b>Y<sub>2</sub>:</b></td>
          <td><input type="text" name="y2" id="y2" value="210" /></td>
        </tr>
		<tr>
		<td><b>Width:</b></td>
   		    <td><input type="text" name="w" value="160" id="w" /></td>
		</tr>
		<tr>
		<td><b>Height:</b></td>
          <td><input type="text" name="h" id="h" value="120" /></td>
		 </tr>
		 
		 <tr>
		  <td></td>
          <td></td>
		 </tr>
		  <tr>
		  <td></td>
          <td></td>
		 </tr>
		 
		 <tr>
		  <td></td>
          <td><input type="submit" name="submit" id="saveThumb" value="Svae Thumbnail" /></td>
		 </tr>
      </tbody>
    </table>
	
    <input type='hidden' name='filename'  id ="filename" value='Penguins.jpg' />
  
  
    </form>
	
	<p style="font-size: 110%; font-weight: bold; padding-left: 0.8em;">
      Created Thumbnail
    </p>
  
    <div class="frame"  style="margin: 0 1em;  float:left">
      <div style=" overflow: hidden;">
        <img src="thumbnail.jpg"  />
      </div>
    </div>
	
	
	</div>
	</div>
	
	