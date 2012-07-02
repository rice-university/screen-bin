/* 
 * Initializations
 */
$(document).ready(function() {
	$('#logo').children().tooltip({
		placement: 'right',
		title: 'requires Google Chrome'
	});

	$('#twitter').tooltip({
		placement: 'bottom',
		title: 'Follow me on Twitter!'
	});
});