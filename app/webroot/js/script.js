/*
 * Initializations
 */
$(document).ready(function() {
	$('#logo').children().tooltip({
		placement: 'right',
		title: $('#logo').attr('total-shots')+' screenshots taken!',
		trigger: 'manual'
	});
	$('#logo').children().tooltip('show');

	$('#twitter').tooltip({
		placement: 'bottom',
		title: 'Follow me on Twitter!'
	});
});