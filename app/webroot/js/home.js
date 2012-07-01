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
		          	showImageAsBackground(evt.target.result);
		        	
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

function showLoading() {
	$('.overlay').css('display','none');
	$('#loading-status-container').css('display','block');
};

function showScreenshotUrl(url) {
	$('.overlay').css('display','none');
	$('#screenshot-url').text(url);
	$('#url-container').css('display','block');
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
}

function handleScreenshotUploadFailure(xhr_response) {
	console.log(xhr_response);
}