<?php

if (!defined('ABSPATH')) die('No direct access allowed');

/**
 * All cache commands that are intended to be available for calling from any sort of control interface (e.g. wp-admin, UpdraftCentral) go in here. All public methods should either return the data to be returned, or a WP_Error with associated error code, message and error data.
 */
class WP_Optimize_Cache_Commands_Premium extends WP_Optimize_Cache_Commands {

	/**
	 * Command to disable caching for the selected post
	 *
	 * @param {array} $params ['post_id' => (int), 'disable' => (bool)]
	 * @return array
	 */
	public function change_post_disable_caching($params) {
		$meta_key = '_wpo_disable_caching';

		if (!isset($params['post_id'])) {
			return array(
				'result' => false,
				'messages' => array(),
				'errors' => array(
					__('No post was indicated.', 'wp-optimize')
				)
			);
		}

		$post_id = $params['post_id'];
		$disable = isset($params['disable']) && ('false' != $params['disable']);

		if ($disable) {
			update_post_meta($post_id, $meta_key, $disable);
		} else {
			delete_post_meta($post_id, $meta_key);
		}

		$disable_caching = get_post_meta($post_id, $meta_key, true);

		if ($disable_caching) {
			WPO_Page_Cache::delete_single_post_cache($post_id);
		}

		return array(
			'result' => true,
			'disabled' => (bool) $disable_caching,
		);
	}
}
