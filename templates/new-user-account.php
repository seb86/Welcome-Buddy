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
?>

<?php do_action('buddypress_email_header', $email_heading); ?>

<p><?php printf(__("Welcome to %s. We thank you for joining the site.", 'buddypress-welcome-email'), esc_html($blogname)); ?></p>

<p><?php printf(__("Your username is <strong>%s</strong>.", 'buddypress-welcome-email'), esc_html($user_login)) ?></p>

<p><?php printf(__("Your password is <strong>%s</strong>.", 'buddypress-welcome-email'), esc_html($user_pass)); ?></p>

<p><?php _e('Regards,', 'buddypress-welcome-email'); ?></p>

<p><?php echo $blogname; ?><br><?php echo '<a href="'.get_bloginfo('url').'">'.get_bloginfo('url').'</a>'; ?></p>

<?php do_action('buddypress_email_footer'); ?>
