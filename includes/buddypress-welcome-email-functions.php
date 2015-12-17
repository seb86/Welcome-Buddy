<?php
/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *		yourtheme / $template_path / $template_name
 *		yourtheme / $template_name
 *		$default_path / $template_name
 *
 * @since  1.0.0
 * @access public
 * @param  string $template_name
 * @param  string $template_path (default: '')
 * @param  string $default_path (default: '')
 * @return string
 */
function bp_email_locate_template($template_name, $template_path = '', $default_path = '') {
	if ( ! $template_path) {
		$template_path = BP_WELCOME_EMAIL_TEMPLATE_PATH;
	}

	if ( ! $default_path) {
		$default_path = BP_WELCOME_EMAIL_FILE_PATH.'/templates/';
	}

	// Look within passed path within the theme - this is priority
	$template = locate_template(
		array(
			trailingslashit($template_path).$template_name,
			$template_name
		)
	);

	// Get default template
	if ( ! $template) {
		$template = $default_path.$template_name;
	}

	// Return what we found
	return apply_filters('buddypress_email_locate_template', $template, $template_name, $template_path);
} // END bp_email_locate_template()

/**
 * Get other templates (e.g. product attributes) passing attributes and including the file.
 *
 * @since  1.0.0
 * @access public
 * @param  string $template_name
 * @param  array  $args (default: array())
 * @param  string $template_path (default: '')
 * @param  string $default_path (default: '')
 */
function bp_email_get_template($template_name, $args = array(), $template_path = '', $default_path = '') {
	if ($args && is_array($args)) {
		extract($args);
	}

	$located = bp_email_locate_template($template_name, $template_path, $default_path);

	if ( ! file_exists($located)) {
		_doing_it_wrong(__FUNCTION__, sprintf('<code>%s</code> does not exist.', $located), BP_WELCOME_EMAIL_VERSION);
		return;
	}

	// Allow 3rd party plugin filter template file from their plugin
	$located = apply_filters('bp_email_get_template', $located, $template_name, $args, $template_path, $default_path);

	do_action('buddypress_email_before_template_part', $template_name, $template_path, $located, $args);

	include($located);

	do_action('buddypress_email_after_template_part', $template_name, $template_path, $located, $args);
} // END bp_email_get_template()

if ( ! function_exists('bp_rgb_from_hex')) {
	/**
	 * Hex darker/lighter/contrast functions for colours
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  mixed $color
	 * @return string
	 */
	function bp_rgb_from_hex($color) {
		$color = str_replace('#', '', $color);
		// Convert shorthand colors to full format, e.g. "FFF" -> "FFFFFF"
		$color = preg_replace('~^(.)(.)(.)$~', '$1$1$2$2$3$3', $color);

		$rgb      = array();
		$rgb['R'] = hexdec($color{0}.$color{1} );
		$rgb['G'] = hexdec($color{2}.$color{3} );
		$rgb['B'] = hexdec($color{4}.$color{5} );

		return $rgb;
	} // END bp_rgb_from_hex()
}

if ( ! function_exists('bp_hex_darker')) {
	/**
	 * Hex darker/lighter/contrast functions for colours
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  mixed $color
	 * @param  int   $factor (default: 30)
	 * @return string
	 */
	function bp_hex_darker($color, $factor = 30) {
		$base  = bp_rgb_from_hex($color);
		$color = '#';

		foreach ($base as $k => $v) {
			$amount      = $v / 100;
			$amount      = round($amount * $factor);
			$new_decimal = $v - $amount;

			$new_hex_component = dechex($new_decimal);
			if (strlen($new_hex_component) < 2) {
				$new_hex_component = "0".$new_hex_component;
			}
			$color .= $new_hex_component;
		}

		return $color;
	} // END bp_hex_darker()
}

if ( ! function_exists('bp_hex_lighter')) {
	/**
	 * Hex darker/lighter/contrast functions for colours
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  mixed $color
	 * @param  int $factor (default: 30)
	 * @return string
	 */
	function bp_hex_lighter($color, $factor = 30) {
		$base  = bp_rgb_from_hex($color);
		$color = '#';

		foreach ($base as $k => $v) {
			$amount      = 255 - $v;
			$amount      = $amount / 100;
			$amount      = round($amount * $factor);
			$new_decimal = $v + $amount;

			$new_hex_component = dechex($new_decimal);
			if (strlen($new_hex_component) < 2) {
				$new_hex_component = "0".$new_hex_component;
			}
			$color .= $new_hex_component;
		}

		return $color;
	} // END bp_hex_lighter()
}

if ( ! function_exists('bp_light_or_dark')) {
	/**
	 * Detect if we should use a light or dark colour on a background colour
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  mixed  $color
	 * @param  string $dark (default: '#000000')
	 * @param  string $light (default: '#FFFFFF')
	 * @return string
	 */
	function bp_light_or_dark($color, $dark = '#000000', $light = '#FFFFFF') {
		$hex = str_replace('#', '', $color);

		$c_r = hexdec(substr($hex, 0, 2));
		$c_g = hexdec(substr($hex, 2, 2));
		$c_b = hexdec(substr($hex, 4, 2));

		$brightness = (($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000;

		return $brightness > 155 ? $dark : $light;
	} // END bp_light_or_dark()
}

if ( ! function_exists('bp_format_hex')) {
	/**
	 * Format string as hex
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string $hex
	 * @return string
	 */
	function bp_format_hex($hex) {
		$hex = trim(str_replace('#', '', $hex));

		if (strlen($hex) == 3) {
			$hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
		}

		return $hex ? '#'.$hex : null;
	} // bp_format_hex()
}

/**
 * Send HTML emails.
 *
 * @since 1.0.0
 * @param mixed  $to
 * @param mixed  $subject
 * @param mixed  $message
 * @param string $headers (default: "Content-Type: text/html\r\n")
 * @param string $attachments (default: "")
 */
function bp_mail($to, $subject, $message, $headers = "Content-Type: text/html\r\n", $attachments = "") {
	$mailer = BuddyPress_Welcome_Email::mailer();

	$mailer->send($to, $subject, $message, $headers, $attachments);
} // END bp_mail()

/**
 * Preview email template
 *
 * @return string
 */
function bp_preview_email() {
	if (isset($_GET['preview_bp_email'])) {
		if ( ! wp_verify_nonce($_REQUEST['_wpnonce'], 'preview-email')) {
			wp_die('Security check');
		}

		// Load the mailer class
		$mailer = BuddyPress_Welcome_Email::mailer();

		$email_heading = __('Email Preview', 'buddypress-welcome-email');

		// Get the preview email content
		ob_start();

		include_once('views/html-email-template-preview.php');

		$message = ob_get_clean();

		// Create a new email
		$email = new BP_Email();

		// Wrap the content with the email template and then add styles
		$message = $email->style_inline($mailer->wrap_message($email_heading, $message));

		// Print the preview email
		echo $message;
		exit;
	}
}
add_action('init', 'bp_preview_email');