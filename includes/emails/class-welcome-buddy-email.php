<?php
/**
 * Welcome Buddy Class which is extended by specific email
 * template classes to add emails to BuddyPress.
 *
 * @class       BP_Welcome_Email
 * @version     1.0.0
 * @package     Welcome Buddy/Classes/Emails
 * @author      Sébastien Dumont
 * @extends     BP_Email
 */
if ( ! defined('ABSPATH')) {
	exit;
}

if (class_exists('BP_Email')) {
	return;
}

/**
 * BP_Email
 */
class BP_Email extends BP_Emails {

	/**
	 * Email method ID.
	 *
	 * @var String
	 */
	public $id;

	/**
	 * Email method title.
	 *
	 * @var string
	 */
	public $title;

	/**
	 * 'yes' if the method is enabled.
	 *
	 * @var string
	 */
	public $enabled;

	/**
	 * Description for the email.
	 *
	 * @var string
	 */
	public $description;

	/**
	 * Plain text template path.
	 *
	 * @var string
	 */
	public $template_plain;

	/**
	 * HTML template path.
	 *
	 * @var string
	 */
	public $template_html;

	/**
	 * Template path.
	 *
	 * @var string
	 */
	public $template_base;

	/**
	 * Recipients for the email.
	 *
	 * @var string
	 */
	public $recipient;

	/**
	 * Heading for the email content.
	 *
	 * @var string
	 */
	public $heading;

	/**
	 * Subject for the email.
	 *
	 * @var string
	 */
	public $subject;

	/**
	 * Email Type for the email.
	 *
	 * @var string
	 */
	public $email_type;

	/**
	 * Object this email is for.
	 *
	 * @var object
	 */
	public $object;

	/**
	 * Strings to find in subjects/headings.
	 *
	 * @var array
	 */
	public $find;

	/**
	 * Strings to replace in subjects/headings.
	 *
	 * @var array
	 */
	public $replace;

	/**
	 * Mime boundary (for multipart emails).
	 *
	 * @var string
	 */
	public $mime_boundary;

	/**
	 * Mime boundary header (for multipart emails).
	 *
	 * @var string
	 */
	public $mime_boundary_header;

	/**
	 * True when email is being sent.
	 *
	 * @var bool
	 */
	public $sending;

	/**
	 *  List of preg* regular expression patterns to search for,
	 *  used in conjunction with $replace.
	 *  https://raw.github.com/ushahidi/wp-silcc/master/class.html2text.inc
	 *
	 *  @var array $search
	 *  @see $replace
	 */
	public $plain_search = array(
		"/\r/", // Non-legal carriage return
		'/&(nbsp|#160);/i', // Non-breaking space
		'/&(quot|rdquo|ldquo|#8220|#8221|#147|#148);/i', // Double quotes
		'/&(apos|rsquo|lsquo|#8216|#8217);/i', // Single quotes
		'/&gt;/i', // Greater-than
		'/&lt;/i', // Less-than
		'/&#38;/i', // Ampersand
		'/&#038;/i', // Ampersand
		'/&amp;/i', // Ampersand
		'/&(copy|#169);/i', // Copyright
		'/&(trade|#8482|#153);/i', // Trademark
		'/&(reg|#174);/i', // Registered
		'/&(mdash|#151|#8212);/i', // mdash
		'/&(ndash|minus|#8211|#8722);/i', // ndash
		'/&(bull|#149|#8226);/i', // Bullet
		'/&(pound|#163);/i', // Pound sign
		'/&(euro|#8364);/i', // Euro sign
		'/&#36;/', // Dollar sign
		'/&[^&\s;]+;/i', // Unknown/unhandled entities
		'/[ ]{2,}/' // Runs of spaces, post-handling
	);

	/**
	 *  List of pattern replacements corresponding to patterns searched.
	 *
	 *  @var array $replace
	 *  @see $search
	 */
	public $plain_replace = array(
		'', // Non-legal carriage return
		' ', // Non-breaking space
		'"', // Double quotes
		"'", // Single quotes
		'>', // Greater-than
		'<', // Less-than
		'&', // Ampersand
		'&', // Ampersand
		'&', // Ampersand
		'(c)', // Copyright
		'(tm)', // Trademark
		'(R)', // Registered
		'--', // mdash
		'-', // ndash
		'*', // Bullet
		'£', // Pound sign
		'€', // Euro sign.
		'$', // Dollar sign
		'', // Unknown/unhandled entities
		' ' // Runs of spaces, post-handling
	);

	/**
	 * Constructor
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function __construct() {
		// Default template base if not declared in child constructor
		if (is_null($this->template_base)) {
			$this->template_base = WELCOME_BUDDY_FILE_PATH.'/templates/';
		}

		// Settings
		$this->heading     = $this->heading;
		$this->subject     = $this->subject;
		$this->email_type  = apply_filters('welcome_buddy_type', 'html');
		$this->enabled     = 'yes';

		// Find/replace
		$this->find['blogname']      = '{blogname}';
		$this->find['site-title']    = '{site_title}';
		$this->replace['blogname']   = $this->get_blogname();
		$this->replace['site-title'] = $this->get_blogname();
	} // END __construct()

	/**
	 * format_string function.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  mixed $string
	 * @return string
	 */
	public function format_string($string) {
		return str_replace(apply_filters('welcome_buddy_format_string_find', $this->find, $this), apply_filters('welcome_buddy_format_string_replace', $this->replace, $this), $string);
	} // END format_string()

	/**
	 * get_subject function.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function get_subject() {
		return apply_filters('welcome_buddy_subject_'.$this->id, $this->format_string($this->subject), $this->object);
	} // END get_subject()

	/**
	 * get_heading function.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function get_heading() {
		return apply_filters('welcome_buddy_heading_'.$this->id, $this->format_string($this->heading), $this->object);
	} // END get_heading()

	/**
	 * get_recipient function.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function get_recipient() {
		return apply_filters('welcome_buddy_recipient_'.$this->id, $this->recipient, $this->object);
	} // END get_recipient()

	/**
	 * get_headers function.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function get_headers() {
		return apply_filters('welcome_buddy_headers', "Content-Type: ".$this->get_content_type()."\r\n", $this->id, $this->object);
	} // END get_headers()

	/**
	 * get_attachments function.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string|array
	 */
	public function get_attachments() {
		return apply_filters('welcome_buddy_attachments', array(), $this->id, $this->object);
	} // END get_attachments()

	/**
	 * get_type function.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function get_email_type() {
		return $this->email_type && class_exists('DOMDocument') ? $this->email_type : 'plain';
	} // END get_email_type()

	/**
	 * get_content_type function.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function get_content_type() {
		switch ($this->get_email_type()) {
			case 'html' :
				return 'text/html';
			case 'multipart' :
				return 'multipart/alternative';
			default :
				return 'text/plain';
		}
	} // END get_content_type()

	/**
	 * Checks if this email is enabled and will be sent.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return bool
	 */
	public function is_enabled() {
		$enabled = $this->enabled == 'yes' ? true : false;

		return apply_filters('welcome_buddy_enabled_'.$this->id, $enabled, $this->object);
	} // END is_enabled()

	/**
	 * get_blogname function.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function get_blogname() {
		return wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	} // END get_blogname()

	/**
	 * get_content function.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function get_content() {
		$this->sending = true;

		if ($this->get_email_type() == 'plain') {
			$email_content = preg_replace($this->plain_search, $this->plain_replace, strip_tags($this->get_content_plain()));
		} else {
			$email_content = $this->get_content_html();
		}

		return wordwrap($email_content, 70);
	} // END get_content()

	/**
	 * Apply inline styles to dynamic content.
	 *
	 * @param string|null $content
	 * @return string
	 */
	public function style_inline($content) {
		// Make sure we only inline CSS for HTML emails.
		if (in_array($this->get_content_type(), array('text/html', 'multipart/alternative')) && class_exists('DOMDocument')) {

			// Get CSS styles
			ob_start();
			bp_email_get_template('email-styles.php');
			$css = apply_filters('welcome_buddy_styles', ob_get_clean());

			// Apply CSS styles inline for picky email clients.
			$emogrifier = new Emogrifier($content, $css);
			$content = $emogrifier->emogrify();
		}

		return $content;
	} // END style_inline()

	/**
	 * get_content_plain function.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function get_content_plain() {}

	/**
	 * get_content_html function.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function get_content_html() {}

	/**
	 * Get from name for email.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function get_from_name() {
		return wp_specialchars_decode(esc_html(apply_filters('welcome_buddy_from_name', $this->get_blogname())), ENT_QUOTES);
	} // END get_from_name()

	/**
	 * Get from email address.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function get_from_address() {
		return sanitize_email(apply_filters('welcome_buddy_from_address', $this->get_admin_email()));
	} // END get_from_address()

	/**
	 * Get admin email address.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function get_admin_email() {
		return sanitize_email(get_option('admin_email'));
	} // END get_admin_email()

	/**
	 * Send the email.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string $to
	 * @param  string $subject
	 * @param  string $message
	 * @param  string $headers
	 * @param  string $attachments
	 * @return bool
	 */
	public function send($to, $subject, $message, $headers = "Content-Type: text/html\r\n", $attachments = "") {
		add_filter('wp_mail_from', array($this, 'get_from_address'));
		add_filter('wp_mail_from_name', array($this, 'get_from_name'));
		add_filter('wp_mail_content_type', array($this, 'get_content_type'));

		$message = apply_filters('welcome_buddy_content', $this->style_inline($message));
		$return  = wp_mail($to, $subject, $message, $headers, $attachments);

		remove_filter('wp_mail_from', array($this, 'get_from_address'));
		remove_filter('wp_mail_from_name', array($this, 'get_from_name'));
		remove_filter('wp_mail_content_type', array($this, 'get_content_type'));

		return $return;
	} // END send()

} // END class
