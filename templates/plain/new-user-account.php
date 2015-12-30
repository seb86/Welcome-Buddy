<?php
/**
 * Welcome email for new registered users.
 *
 * @author  Sébastien Dumont
 * @package Welcome Buddy/Templates/Plain
 * @version 1.0.0
 */

if ( ! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

echo "= ".$email_heading." =\n\n";

echo sprintf(__("Welcome to %s. We thank you for joining the site.", 'welcome-buddy'), $blogname)."\n";

echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

echo sprintf(__('Your username is %s.', 'welcome-buddy'), $user_login)."\n\n";

echo sprintf(__('Your password is %s.', 'welcome-buddy'), $user_pass)."\n";

echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

_e('Regards,', 'welcome-buddy');

echo "\n".$blogname."\n";

$blogurl = get_bloginfo('url');

echo '<a href="'.$blogurl.'">'.$blogurl.'</a>';
