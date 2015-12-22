<?php
/**
	 * Display notices in the WordPress admin.
	 *
	 * @since    1.0.0
	 * @author   Sébastien Dumont
	 * @category Admin
	 * @package  Welcome Buddy
	 * @license  GPL-2.0+
	 */

if ( ! defined('ABSPATH')) {
	exit;
}
// Exit if accessed directly

if ( ! class_exists('Welcome_Buddy_Admin_Notices')) {

/**
 * Class - Welcome_Buddy_Admin_Notices
 *
 * @since 1.0.0
 */
class Welcome_Buddy_Admin_Notices {

	/**
	 * Constructor
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action('admin_init', array($this, 'check_wp'));
		add_action('admin_init', array($this, 'add_notices'));
	} // END __construct()

	/**
	 * Checks if the plugin requirements have been met.
	 * If not, then a notice is displayed explaining what to do next.
	 *
	 * @since  1.0.0
	 * @access public
	 * @global $current_user
	 */
	public function add_notices() {
		global $current_user;

		if ( ! empty($_GET['hide_welcome_buddy_review_notice']) && current_user_can('install_plugins')) {
			// Add user meta
			add_user_meta($current_user->ID, 'welcome_buddy_hide_review_notice', '1', true);
		}

		// Is admin notice hidden?
		$hide_notice = get_user_meta($current_user->ID, 'welcome_buddy_hide_review_notice', true);

		// Check if we need to display the review plugin notice
		if (current_user_can('install_plugins') && empty($hide_notice)) {
			// Get installation date
			$datetime_install = self::get_install_date();
			$datetime_past    = new DateTime('-14 days');

			if ($datetime_past >= $datetime_install) {
				// 14 or more days ago, show admin notice
				add_action('admin_notices', array($this, 'plugin_review_notice'));
			}
		}
	} // END add_notices()

	/**
	 * Checks that the WordPress version meets the plugin requirement.
	 *
	 * @since  1.0.0
	 * @access public
	 * @global string $wp_version
	 * @return bool
	 */
	public function check_wp() {
		global $wp_version;

		if ( ! version_compare($wp_version, WELCOME_BUDDY_WP_VERSION_REQUIRE, '>=')) {
			add_action('admin_notices', array($this, 'requirement_wp_notice'));
			return false;
		}

		return true;
	} // END check_requirements()

	/**
	 * Get the install data
	 *
	 * @since  1.0.0
	 * @access private
	 * @return DateTime
	 */
	private function get_install_date() {
		$date_string = get_site_option('welcome_buddy_install_date', '');
		if (empty($date_string)) {
			// There is no install date. Add it now.
			$date_string = $this->insert_install_date();
		}

		return new DateTime($date_string);
	}

	/**
	 * Insert the install date of the plugin.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public static function insert_install_date() {
		$datetime_now = new DateTime();
		$date_string  = $datetime_now->format('Y-m-d');

		add_site_option('welcome_buddy_install_date', $date_string, '', 'no');

		return $date_string;
	}

	/**
	 * Show the WordPress requirement notice.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function requirement_wp_notice() {
		include('views/html-notice-requirement-wp.php');
	} // END requirement_wp_notice()

	/**
	 * Show the plugin review notice.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function plugin_review_notice() {
		include('views/html-notice-please-review.php');
	} // END plugin_review_notice()

} // END Welcome_Buddy_Admin_Notices class.

} // END if class exists.

return new Welcome_Buddy_Admin_Notices();
