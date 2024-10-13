$(document).ready(function() {

	// Select textarea contents on focus
	$('.fte-select-on-focus').on('focus', function() {
		$(this).select();
	});

	// Download export file when button is clicked
	$('.fte-export-button').on('click', function() {
		const name = $(this).data('fte-name');
		const text = $(this).siblings('.fte-select-on-focus').val();
		const $link = $(`<a href="data:text/plain;charset=utf-8,${encodeURIComponent(text)}" download="${name}.json" style="display:none"></a>`);
		$('body').append($link);
		$link[0].click();
		$link.remove();
	});

});
