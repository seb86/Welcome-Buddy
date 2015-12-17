<?php
/**
 * Welcome email for new registered users.
 *
 * @author  Sébastien Dumont
 * @package BuddyPress Welcome Email/Templates
 * @version 1.0.0
 */

if ( ! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

do_action('buddypress_welcome_email_header', $email_heading);

echo apply_filters('buddypress_welcome_email_text', '<p>' . sprintf(__("Welcome to %s. We thank you for joining the site.<br><br>Your username is <strong>%s</strong>.<br>Your password is <strong>%s</strong>.", 'buddypress-welcome-email'), esc_html($blogname), esc_html($user_login), esc_html($user_pass))) . '</p>';

echo apply_filters('buddypress_welcome_email_footer_text', '<p>' . __('Regards,', 'buddypress-welcome-email') . "</p>\n<p>" . $blogname . "</p>\n");

do_action('buddypress_welcome_email_footer');
