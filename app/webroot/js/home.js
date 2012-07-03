/*
 * Initializations
 */
$(document).ready(function() {
	//bind event listener to all html objects on the page
	$('html').bind('paste', function(e) {
		var matchType = /image.*/
		var clipboardData = event.clipboardData;

		if (event.clipboardData.types[0] == 'Files') {
			for (i = 0; i < (event.clipboardData.items).length; i++) {
				var dataTransferItem = event.clipboardData.items[i];
				var file = dataTransferItem.getAsFile();

				var reader = new FileReader();
		        reader.onload = function(evt) {
		        	var img = new Image();
					img.src = evt.target.result;

					//show local image
		          	showImageInTag(evt.target.result);

		        	//show loading overlay
		        	showLoading();

		        	//send file in ajax file upload
		        	sendScreenshotForUpload(file);
		        };
		        reader.readAsDataURL(file);
			}
		}
	});
});

/*
 * Mouse listeners
 */
$(document).ready(function() {

});

function showImageAsBackground(url) {
	$('#screenshot-image').css('background-image','url("'+url+'")');
}

function showImageInTag(url) {
	var image_object = new Image();

	var container = $('#screenshot-image');
	var container_width = container.width();
	var container_height = container.height();
	var image = $('#screenshot-image-url');

    image_object.onload = function() {
	    var height = image_object.height;
	    var width = image_object.width;

	    if(width < container_width && height < container_height) {
	    	image.css('margin-left', (container_width - width)/2);
	    	image.css('margin-right', (container_width - width)/2);
	    	image.css('width', width);
	    	image.css('margin-top', (container_height - height)/2);
	    	image.css('margin-bottom', (container_height - height)/2);
	    	image.css('height', height);
	    } else { //width > container_width || height > container_height
	    	var scale_factor_height = container_height.toFixed(2) / height;
	    	var scale_factor_width = container_width.toFixed(2) / width;

	    	if(scale_factor_width > scale_factor_height) {
	    		image.css('margin-top', (container_height - height*scale_factor_height)/2);
		    	image.css('margin-bottom', (container_height - height*scale_factor_height)/2);
		    	image.css('height', height*scale_factor_height);
		    	image.css('margin-left', (container_width - width*scale_factor_height)/2);
		    	image.css('margin-right', (container_width - width*scale_factor_height)/2);
		    	image.css('width', width*scale_factor_height);
	    	} else {
	    		image.css('margin-top', (container_height - height*scale_factor_width)/2);
		    	image.css('margin-bottom', (container_height - height*scale_factor_width)/2);
		    	image.css('height', height*scale_factor_width);
		    	image.css('margin-left', (container_width - width*scale_factor_width)/2);
		    	image.css('margin-right', (container_width - width*scale_factor_width)/2);
		    	image.css('width', width*scale_factor_width);
	    	}

	    	//show tooltip
	    	$('#url-label').attr('data-original-title', 'Image scaled to fit view. Actual size: '+width+'x'+height);
	    	$('#url-label').tooltip({
				placement: 'right',
				trigger: 'hover'
			});
	    }
	}

    image_object.src = url;
	image.attr('src', url);
}

function showLoading() {
	$('.overlay').css('display','none');
	$('#loading-status-container').css('display','block');
};

function showScreenshotUrl(url) {
	$('.overlay').css('display','none');
	$('#screenshot-url').val(url);
	$('#url-container').css('display','block');
	$('#screenshot-url').select();
}

function sendScreenshotForUpload(file) {
	var api_url = '/pages/apiUploadScreenshot';

	var formData = new FormData();
    formData.append('data[Post][file]', file);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', api_url, true);
    xhr.onreadystatechange = function() {
        console.log(xhr);
        if (xhr.readyState == 4) {
            if (xhr.status == 200) { //success
                var upload_response_json = $.parseJSON(xhr.responseText);
                handleScreenshotUploadSuccess(upload_response_json);
            } else {
				handleScreenshotUploadFailure(xhr.responseText);
            }
        }
    };
    xhr.send(formData);
}

function handleScreenshotUploadSuccess(upload_response_json) {
	var screenshot_url = upload_response_json.screenshot_url;
	if (screenshot_url) {
		showScreenshotUrl(screenshot_url);
	}

	//swap out screenshot url
	$('#screenshot-image-url').attr('src', upload_response_json.hosted_url);

	//update total screenshot count
	$('#logo').children().attr('data-original-title', upload_response_json.num_total_screenshots + ' screenshots taken!');
	$('#logo').children().tooltip('show');
}

function handleScreenshotUploadFailure(xhr_response) {
	console.log(xhr_response);
}