<?php
/*
 * Plugin Name:       BuddyPress Welcome Email
 * Plugin URI:        http://www.sebastiendumont.com
 * Description:       This provides a welcome email once a new user has registered using BuddyPress.
 * Version:           1.0.0
 * Author:            Sébastien Dumont
 * Author URI:        http://www.sebastiendumont.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       buddypress-welcome-email
 * Domain Path:       languages
 * Network:           false
 *
 * BuddyPress Welcome Email is distributed under the terms of the
 * GNU General Public License as published by the Free Software Foundation,
 * either version 2 of the License, or any later version.
 *
 * BuddyPress Welcome Email is distributed in the hope that it will
 * be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with BuddyPress Welcome Email.
 * If not, see <http://www.gnu.org/licenses/>.
 *
 * @package BuddyPress_Welcome_Email
 * @author  Sébastien Dumont
 */
if ( ! defined('ABSPATH')) {
	exit;
}
// Exit if accessed directly

if ( ! class_exists('BuddyPress_Welcome_Email')) {

/**
 * Main BuddyPress Welcome Email Class
 *
 * @since 1.0.0
 */
final class BuddyPress_Welcome_Email {

	/**
	 * The single instance of the class
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    object
	 */
	private static $_instance = null;

	/**
	 * Path to the includes directory
	 * @var string
	 */
	private $include_path = '';

	/**
	 * Main BuddyPress Welcome Email Instance
	 *
	 * Ensures only one instance of BuddyPress Welcome Email is loaded or can be loaded.
	 *
	 * @since  1.0.0
	 * @access public static
	 * @see    BuddyPress_Welcome_Email()
	 * @return BuddyPress Welcome Email instance
	 */
	public static function instance() {
		if (is_null(self::$_instance)) {
			self::$_instance = new BuddyPress_Welcome_Email;
			self::$_instance->setup_constants();
			self::$_instance->includes();
			self::$_instance->load_plugin_textdomain();
			self::$_instance->init_hooks();
		}
		return self::$_instance;
	} // END instance()

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong(__FUNCTION__, __('Cheatin’ huh?', 'buddypress-welcome-email'), BP_WELCOME_EMAIL_VERSION);
	} // END __clone()

	/**
	 * Disable unserializing of the class
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong(__FUNCTION__, __('Cheatin’ huh?', 'buddypress-welcome-email'), BP_WELCOME_EMAIL_VERSION);
	} // END __wakeup()

	/**
	 * Constructor
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function __construct() {
		// Auto-load classes on demand
		if (function_exists("__autoload")) {
			spl_autoload_register("__autoload");
		}

		spl_autoload_register(array($this, 'autoload'));

		$this->include_path = untrailingslashit(plugin_dir_path(__FILE__)).'/includes/';
	} // END __construct()

	/**
	 * Auto-load BuddyPress Welcome Email classes on demand to reduce memory consumption.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  mixed $class
	 * @return void
	 */
	public function autoload($class) {
		$path  = '';
		$file  = strtolower('class-'.str_replace('_', '-', $class)).'.php';

		if (strpos($class, 'buddypress_welcome_email_admin') === 0) {
			$path = $this->include_path . 'admin/';
		}

		if ( ! empty($path) && is_readable($path.$file) ) {
			include_once($path.$file);
		}
	} // END autoload()

	/**
	 * Initialize hooks
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function init_hooks() {
		add_action('init', array('BP_Emails', 'init_emails'));
	} // END init_hooks()

	/**
	 * Setup Constants
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function setup_constants() {
		$this->define('BP_WELCOME_EMAIL_VERSION', '1.0.0');
		$this->define('BP_WELCOME_EMAIL_FILE', __FILE__);
		$this->define('BP_WELCOME_EMAIL_SLUG', 'buddypress-welcome-email');

		$this->define('BP_WELCOME_EMAIL_URL_PATH', untrailingslashit(plugins_url('/', __FILE__)));
		$this->define('BP_WELCOME_EMAIL_FILE_PATH', untrailingslashit(plugin_dir_path(__FILE__)));
		$this->define('BP_WELCOME_EMAIL_TEMPLATE_PATH', apply_filters('buddypress_email_template_path', 'buddypress_emails/'));

		$this->define('BP_WELCOME_EMAIL_WP_VERSION_REQUIRE', '4.0');
	} // END setup_constants()

	/**
	 * Define constant if not already set.
	 *
	 * @param  string $name
	 * @param  string|bool $value
	 * @access private
	 * @since  1.0.0
	 */
	private function define($name, $value) {
		if ( ! defined($name)) {
			define($name, $value);
		}
	} // END define()

	/**
	 * Include required files.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function includes() {
		include_once('includes/buddypress-welcome-email-functions.php');
		include_once('includes/class-buddypress-welcome-emails.php');

		if( is_admin() ) {
			include_once('includes/admin/class-buddypress-welcome-email-admin.php');
		}
	} // END includes()

	/**
	 * Load Localisation files.
	 *
	 * Note: the first-loaded translation file overrides any
	 * following ones if the same translation is present.
	 *
	 * @since  1.0.0
	 * @access public
	 * @filter buddypress_welcome_email_languages_directory
	 * @filter plugin_locale
	 * @return void
	 */
	public function load_plugin_textdomain() {
		// Set filter for plugin's languages directory
		$lang_dir = dirname(plugin_basename(BP_WELCOME_EMAIL_FILE)).'/languages/';
		$lang_dir = apply_filters('buddypress_welcome_email_languages_directory', $lang_dir);

		// Traditional WordPress plugin locale filter
		$locale = apply_filters('plugin_locale', get_locale(), 'buddypress-welcome-email');
		$mofile = sprintf('%1$s-%2$s.mo', 'buddypress-welcome-email', $locale);

		// Setup paths to current locale file
		$mofile_local  = $lang_dir.$mofile;
		$mofile_global = WP_LANG_DIR.'/buddypress-welcome-email/'.$mofile;

		if (file_exists($mofile_global)) {
			// Look in global /wp-content/languages/buddypress-welcome-email/ folder
			load_textdomain('buddypress-welcome-email', $mofile_global);
		} else if (file_exists($mofile_local)) {
			// Look in local /wp-content/plugins/buddypress-welcome-email/languages/ folder
			load_textdomain('buddypress-welcome-email', $mofile_local);
		} else {
			// Load the default language files
			load_plugin_textdomain('buddypress-welcome-email', false, $lang_dir);
		}
	} // END load_plugin_textdomain()

	/**
	 * Email Class.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return BP_Emails
	 */
	public static function mailer() {
		return BP_Emails::instance();
	} // END mailer()

} // END BuddyPress_Welcome_Email()

} // END class exists 'BuddyPress_Welcome_Email'

/**
 * This runs the plugin if the required PHP version has been met.
 */
function run_buddypress_welcome_email() {
	return BuddyPress_Welcome_Email::instance();
} // END run_buddypress_welcome_email()

// Fetch the Php version checker.
if ( ! class_exists('WP_Update_Php')) {
	require_once('wp-update-php/wp-update-php.php');
}
$updatePhp = new WP_Update_Php(
	array(
		'name' => 'BuddyPress Welcome Email',
		'textdomain' => 'buddypress-welcome-email'
	),
	array(
		'minimum_version' => '5.3.0',
		'recommended_version' => '5.4.7'
	)
);

// If the miniumum version of PHP required is available then run the plugin.
if ($updatePhp->does_it_meet_required_php_version()) {
	add_action('plugins_loaded', 'run_buddypress_welcome_email', 20);
}
