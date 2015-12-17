<?php
/**
* Admin View: Admin WordPress Requirment Notice
*/

if ( ! defined('ABSPATH')) {
	exit;
}
// Exit if accessed directly
?>
<div id="message" class="error">
	<p><?php echo sprintf(__('Sorry, <strong>%s</strong> requires WordPress %s or higher. Please upgrade your WordPress setup.', 'buddypress-welcome-email'), 'BuddyPress Welcome Email', BP_WELCOME_EMAIL_WP_VERSION_REQUIRE); ?></p>
</div>
