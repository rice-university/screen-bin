/* 
 * Initializations
 */
$(document).ready(function() {
	var image = new Image();

    image.onload = function() {
	    var height = image.height;
	    var width = image.width;
    
	    if(width > $(window).width()) {
	    	var scale_factor = $(window).width().toFixed(2) / width;

	    	//force overflow scroll
	    	$('#screenshot-image').css('width', width);
	    	$('#screenshot-image').css('height', height);
	    	$('#overflow-container').css('width', width);
	    } else {
	    	$('#screenshot-image').css('width', width);
	    	$('#screenshot-image').css('height', height);
	    	$('#screenshot-container').css('text-align', 'center');
	    }
    }

    image.src = $('#screenshot-image').attr('src');
});