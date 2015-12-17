<?php
/**
 * BuddyPress Welcome Email Admin.
 *
 * @since    1.0.0
 * @author   Sébastien Dumont
 * @category Admin
 * @package  BuddyPress Welcome Email
 * @license  GPL-2.0+
 */

if ( ! defined('ABSPATH')) {
	exit;
}
// Exit if accessed directly

if ( ! class_exists('BuddyPress_Welcome_Email_Admin')) {

/**
 * Class - BuddyPress_Welcome_Email_Admin
 *
 * @since 1.0.0
 */
class BuddyPress_Welcome_Email_Admin {

	/**
	 * Constructor
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function __construct() {
		// Actions
		add_action('init', array($this, 'includes'), 10);

		// Filters
		add_filter('plugin_row_meta', array($this, 'plugin_row_meta'), 10, 2);
	} // END __construct()

	/**
	 * Plugin row meta links
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array  $input already defined meta links
	 * @param  string $file  plugin file path and name being processed
	 * @return array  $input
	 */
	public function plugin_row_meta($input, $file) {
		if (plugin_basename(BP_WELCOME_EMAIL_FILE) !== $file) {
			return $input;
		}

		$links = array(
			'<a href="'.wp_nonce_url(site_url('?preview_bp_email=true'), 'preview-email').'" target="_blank">'.__('Preview Email', 'buddypress-welcome-email').'</a>',
		);

		$input = array_merge($input, $links);

		return $input;
	} // END plugin_row_meta()

	/**
	 * Include any classes we need within admin.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function includes() {
		include('class-buddypress-welcome-email-admin-notices.php'); // Plugin Notices
	} // END includes()

} // END class

} // END if class exists

return new BuddyPress_Welcome_Email_Admin();
