jQuery(function($) {
	var send_command = wp_optimize.send_command;

	/**
	 * Handle disable/enable post caching on a single post edit page.
	 */
	$('#wpo_disable_single_post_caching').change(function () {
		var checkbox = $(this),
			post_id = checkbox.data('id'),
			disable = checkbox.prop('checked');

		checkbox.prop('disabled', true);

		send_command('change_post_disable_caching', {
			post_id: post_id,
			disable: disable
		}, function (response) {
			if (response.result) {
				checkbox.prop('checked', response.disabled);
			}
		})
			.always(function () {
				checkbox.prop('disabled', false);
			});
	});

});