<?php
/**
* Admin View: Admin Review Notice
*/

if ( ! defined('ABSPATH')) {
	exit;
}
// Exit if accessed directly

$current_user = wp_get_current_user();
?>
<div id="message" class="updated">
	<p><?php _e(sprintf(__('Hi <b>%s</b>, you\'ve been using <b>%s</b> for some time now, and I hope you\'re happy with it. I would really appreciate it if you gave it a quick review!', 'buddypress-welcome-email'), $current_user->display_name, 'BuddyPress Welcome Email')); ?></p>
	<p class="submit"><a href="https://wordpress.org/support/view/plugin-reviews/buddypress-welcome-email?filter=5#postform" target="_blank" class="button-primary"><?php _e('Yes, take me there!', 'buddypress-welcome-email'); ?></a> - <a href="<?php echo esc_url(add_query_arg('hide_buddypress_welcome_email_review_notice', 'true')); ?>" class="skip button-primary"><?php _e('Already have :)', 'buddypress-welcome-email'); ?></a></p>
</div>
