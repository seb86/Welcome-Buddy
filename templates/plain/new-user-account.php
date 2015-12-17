<?php
/**
 * Welcome email for new registered users.
 *
 * @author  Sébastien Dumont
 * @package BuddyPress Welcome Email/Templates/Plain
 * @version 1.0.0
 */

if ( ! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

echo "= " . $email_heading . " =\n\n";

echo apply_filters('buddypress_welcome_email_text', sprintf(__("Welcome to %s. We thank you for joining the site.<br><br>Your username is <strong>%s</strong>.<br>Your password is <strong>%s</strong>.", 'buddypress-welcome-email'), $blogname, $user_login, $user_pass)) . "\n\n";

echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

echo apply_filters('buddypress_welcome_email_footer_text', __('Regards,', 'buddypress-welcome-email') . "\n" . $blogname . "\n");
