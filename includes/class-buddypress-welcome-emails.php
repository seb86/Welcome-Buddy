<?php
/**
 * BuddyPress Welcome Email Class which handles the
 * sending on emails and email templates.
 *
 * @class    BP_Emails
 * @version  1.0.0
 * @package  BuddyPress Welcome Email/Classes/Emails
 * @category Class
 * @author   Sébastien Dumont
 */

if ( ! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (class_exists('BP_Emails')) {
	return;
}

class BP_Emails {

	/** @var array Array of email notification classes */
	public $emails;

	/** @var BP_Emails The single instance of the class */
	protected static $_instance = null;

	/**
	 * Main BP_Emails Instance
	 *
	 * Ensures only one instance of BP_Emails is loaded or can be loaded.
	 *
	 * @since  1.0.0
	 * @access public static
	 * @return BP_Emails Main instance
	 */
	public static function instance() {
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	} // END instance()

	/**
	 * Initiate the email
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public static function init_emails() {
		add_action('bp_core_signup_user', array(__CLASS__, 'send_email'), 10, 10);
	} // END init_emails()

	/**
	 * Init the mailer instance and call the notifications
	 * for the current filter.
	 *
	 * @since  1.0.0
	 * @access public
	 * @internal param array $args (default: array())
	 */
	public static function send_email() {
		self::instance();
		$args = func_get_args();
		do_action_ref_array(current_filter().'_notification', $args);
	} // END send_email()

	/**
	 * Constructor for the email class hooks in all
	 * emails that can be sent.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function __construct() {
		$this->init();

		// Email Header, Footer and content hooks
		add_action('buddypress_email_header', array($this, 'email_header'));
		add_action('buddypress_email_footer', array($this, 'email_footer'));

		// Hooks for sending emails during events
		add_action('bp_core_signup_user_notification', array($this, 'buddypress_new_user'), 10, 3);
	} // END __construct()

	/**
	 * Init email classes
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function init() {
		// Include email classes
		include_once('emails/class-buddypress-welcome-email.php');
		$email = new BP_Email();

		$this->emails['BP_Email_New_User'] = include('emails/class-buddypress-welcome-email-new-user.php');

		//$this->emails = $this->emails;

		// Include CSS inliner
		if ( ! class_exists('Emogrifier') && class_exists('DOMDocument')) {
			include_once('libraries/class-emogrifier.php');
		}
	} // END init()

	/**
	 * Get from name for email.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function get_from_name() {
		return wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	} // END get_from_name()

	/**
	 * Get blog name formatted for emails
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function get_blogname() {
		return wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	} // END get_blogname()

	/**
	 * Get from email address.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function get_from_address() {
		return get_option('admin_email');
	} // END get_from_address()

	/**
	 * Get the email header.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  mixed $email_heading heading for the email
	 */
	public function email_header($email_heading) {
		bp_email_get_template('email-header.php', array('email_heading' => $email_heading));
	} // END email_header()

	/**
	 * Get the email footer.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function email_footer() {
		bp_email_get_template('email-footer.php');
	} // END email_footer()

	/**
	 * Wraps a message in the buddypress email template.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  mixed  $email_heading
	 * @param  string $message
	 * @return string
	 */
	public function wrap_message($email_heading, $message) {
		// Buffer
		ob_start();

		do_action('buddypress_email_header', $email_heading);

		echo wpautop(wptexturize($message));

		do_action('buddypress_email_footer');

		// Get contents
		$message = ob_get_clean();

		return $message;
	} // END wrap_message()

	/**
	 * Send the email.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  mixed  $to
	 * @param  mixed  $subject
	 * @param  mixed  $message
	 * @param  string $headers (default: "Content-Type: text/html\r\n")
	 * @param  string $attachments (default: "")
	 * @return bool
	 */
	/*public function send($to, $subject, $message, $headers = "Content-Type: text/html\r\n", $attachments = "") {
		// Send
		return $email->send($to, $subject, $message, $headers, $attachments);
	} // END send()*/

	/**
	 * New account welcome email.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  int    $user_id
	 * @param  string $user_login
	 * @param  string $user_password
	 */
	public static function buddypress_new_user($user_id, $user_login = '', $user_password) {
		if (empty($user_id)) {
			$user_id = bp_loggedin_user_id();
		}

		if ( ! $user_id) {
			return;
		}

		$email = $this->emails['BP_Email_New_User'];
		$email->trigger($user_id, $user_password);
	} // END buddypress_new_user()

} // END class
