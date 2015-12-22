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

echo sprintf(__("Welcome to %s. We thank you for joining the site.<br><br>Your username is <strong>%s</strong>.<br>Your password is <strong>%s</strong>.", 'welcome-buddy'), $blogname, $user_login, $user_pass)."\n\n";

echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

_e('Regards,', 'welcome-buddy')."\n".$blogname."\n.""<a href=".get_bloginfo('url')."">.get_bloginfo('url')."</a>"\n";
