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
	<p><?php echo sprintf(__('Sorry, <strong>%s</strong> requires WordPress %s or higher. Please upgrade your WordPress setup.', 'welcome-buddy'), 'Welcome Buddy', WELCOME_BUDDY_WP_VERSION_REQUIRE); ?></p>
</div>
