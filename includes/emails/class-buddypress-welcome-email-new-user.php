<?php
/**
 * New User Account
 *
 * An email sent to the user when they create an account.
 *
 * @class       BP_Email_New_Account
 * @version     1.0.0
 * @package     BuddyPress Welcome Email/Classes/Emails
 * @author      Sébastien Dumont
 * @extends     BP_Email
 */
if ( ! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if ( ! class_exists('BP_Email_New_Account')) {

  class BP_Email_New_Account extends BP_Email {

    public $user_name;

    public $user_login;

    public $user_email;

    public $user_pass;

    /**
     * Constructor
     */
    public function __construct() {
      $this->id = 'new_user_account';
      $this->title = __('New user account', 'buddypress-welcome-email');
      $this->description = __('New account emails are sent to the user when they sign up via the BuddyPress registration pages.', 'buddypress-welcome-email');

      $this->template_html  = 'new-user-account.php';
      $this->template_plain = 'plain/new-user-account.php';

      $this->subject = __('Welcome to {site_title}', 'buddypress-welcome-email');
      $this->heading = __('Welcome to {site_title}', 'buddypress-welcome-email');

      // Call parent constuctor
      parent::__construct();
    } // END __construct()

    /**
     * Trigger.
     *
     * This passes through the user id and password 
     * the user entered when registering.
     * The user id is checked that it exists before 
     * fetching additional user data to attach to the 
     * email before being sent.
     */
    public function trigger($user_id, $user_password) {
      if ($user_id) {
        $this->object     = new WP_User($user_id);

        $this->user_pass  = $user_password;
        $this->user_name  = stripslashes($this->object->user_name);
        $this->user_login = stripslashes($this->object->user_login);
        $this->user_email = stripslashes($this->object->user_email);
        $this->recipient  = $this->user_email;
      }

      if ( ! $this->is_enabled() || ! $this->get_recipient()) {
        return;
      }

      // Send email
      $this->send($this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments());
    } // END trigger()

    /**
     * Prepair the content for a html email.
     *
     * @access public
     * @return string
     */
    public function get_content_html() {
      ob_start();
      bp_email_get_template($this->template_html, array(
        'email_heading' => $this->get_heading(),
        'user_name'     => $this->user_name,
        'user_login'    => $this->user_login,
        'user_pass'     => $this->user_pass,
        'blogname'      => $this->get_blogname(),
        'sent_to_admin' => false,
        'plain_text'    => false
      ));
      return ob_get_clean();
    } // END get_content_html()

    /**
     * Prepair the content for a plain email.
     *
     * @access public
     * @return string
     */
    public function get_content_plain() {
      ob_start();
      bp_email_get_template($this->template_plain, array(
        'email_heading' => $this->get_heading(),
        'user_name'     => $this->user_name,
        'user_login'    => $this->user_login,
        'user_pass'     => $this->user_pass,
        'blogname'      => $this->get_blogname(),
        'sent_to_admin' => false,
        'plain_text'    => true
      ));
      return ob_get_clean();
    } // END get_content_plain()

  } // END class BP_Email_New_Account()

} // END if class exists

return new BP_Email_New_Account();
