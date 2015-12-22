<?php
/**
 * Email Styles
 *
 * @author  Sébastien Dumont
 * @package Welcome Buddy/Templates
 * @version 1.0.0
 */

if ( ! defined('ABSPATH')) {
	exit;
}
// Exit if accessed directly

// Load colours
$bg                 = apply_filters('welcome_buddy_background_color', '#eeeeee');
$body               = apply_filters('welcome_buddy_body_background_color', '#fdfdfd');
$body_text_colour   = apply_filters('welcome_buddy_body_text_color', '#505050');
$base               = apply_filters('welcome_buddy_base_color', '#c1403b');
$base_text          = bp_light_or_dark($base, '#202020', '#ffffff');
$text_colour        = apply_filters('welcome_buddy_text_color', '#505050');
$link_colour        = apply_filters('welcome_buddy_link_color', '#214cce');
$header_text_colour = apply_filters('welcome_buddy_header_text_color', '#ffffff');
$footer_text_colour = apply_filters('welcome_buddy_footer_text_color', '#202020');

$bg_darker_10    = bp_hex_darker($bg, 10);
$body_darker_10  = bp_hex_darker($body, 10);
$base_lighter_20 = bp_hex_lighter($base, 20);
$base_lighter_40 = bp_hex_lighter($base, 40);
$text_lighter_20 = bp_hex_lighter($text_colour, 20);

// Appearance
$header_font_size         = apply_filters('welcome_buddy_header_font_size', '30');
$footer_font_size         = apply_filters('welcome_buddy_footer_font_size', '12');
$template_rounded_corners = apply_filters('welcome_buddy_rounded_corners', '6');
$template_shadow          = apply_filters('welcome_buddy_box_shadow_spread', '1');
$template_width           = apply_filters('welcome_buddy_width', '600');
// !important; is a gmail hack to prevent styles being stripped if it doesn't like something.
?>
#wrapper {
    background-color: <?php echo esc_attr($bg); ?>;
    margin: 0;
    padding: 70px 0 70px 0;
    -webkit-text-size-adjust: none !important;
    width: 100%;
}

#template_container,
#template_header,
#template_body,
#template_footer {
    width: <?php echo esc_attr($template_width); ?>px;
}

#template_container {
    box-shadow: 0 1px 4px rgba(0,0,0,0.1) !important;
    background-color: <?php echo esc_attr($body); ?>;
    border: 1px solid <?php echo esc_attr($bg_darker_10); ?>;
    border-radius: 3px !important;
}

#template_header {
    background-color: <?php echo esc_attr($base); ?>;
    border-radius: 3px 3px 0 0 !important;
    color: <?php echo esc_attr($base_text); ?>;
    border-bottom: 0;
    font-weight: bold;
    line-height: 100%;
    vertical-align: middle;
    font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
}

#template_header h1 {
    color: <?php echo esc_attr($header_text_colour); ?>;
    font-size: <?php echo esc_attr($header_font_size); ?>px;
    text-shadow: 0 1px 0 <?php echo esc_attr($header_text_colour); ?>;
}

#template_body div a,
#template_body table td a {
    color: <?php echo esc_attr($link_colour); ?>;
}

#template_footer td {
    padding: 0;
    -webkit-border-radius: 6px;
}

#template_footer p {
    color: <?php echo esc_attr($font_text_colour); ?>;
    line-height: 1.5;
    font-size: <?php echo esc_attr($font_size); ?>px;
}

#template_footer #credit {
    border:0;
    color: <?php echo esc_attr($base_lighter_40); ?>;
    font-family: Arial;
    font-size:12px;
    line-height:125%;
    text-align:center;
    padding: 0 48px 48px 48px;
}

#body_content {
    background-color: <?php echo esc_attr($body); ?>;
}

#body_content table td {
    padding: 48px;
}

#body_content table td td {
    padding: 12px;
}

#body_content table td th {
    padding: 12px;
}

#body_content p {
    margin: 0 0 16px;
}

#body_content_inner {
    color: <?php echo esc_attr($text_lighter_20); ?>;
    font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
    font-size: 14px;
    line-height: 150%;
    text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

#body_content_inner table {
    border-collapse: collapse; width:100%;
}

#body_content_inner table td, 
#body_content_inner table th {
    border-color: <?php echo esc_attr($body_text_colour); ?>
    border-width: 1px;
    border-style:solid;
    text-align:left;
}

.td {
    color: <?php echo esc_attr($text_lighter_20); ?>;
    border: 1px solid <?php echo esc_attr($body_darker_10); ?>;
}

.text {
    color: <?php echo esc_attr($text_colour); ?>;
    font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
}

.link {
    color: <?php echo esc_attr($base); ?>;
}

#header_wrapper {
    padding: 36px 48px;
    display: block;
}

h1 {
    color: <?php echo esc_attr($base); ?>;
    font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
    font-size: 30px;
    font-weight: 300;
    line-height: 150%;
    margin: 0;
    text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
    text-shadow: 0 1px 0 <?php echo esc_attr($base_lighter_20); ?>;
    -webkit-font-smoothing: antialiased;
}

h2 {
    color: <?php echo esc_attr($base); ?>;
    display: block;
    font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
    font-size: 18px;
    font-weight: bold;
    line-height: 130%;
    margin: 16px 0 8px;
    text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

h3 {
    color: <?php echo esc_attr($base); ?>;
    display: block;
    font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
    font-size: 16px;
    font-weight: bold;
    line-height: 130%;
    margin: 16px 0 8px;
    text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

a {
    color: <?php echo esc_attr($base); ?>;
    font-weight: normal;
    text-decoration: underline;
}

img {
    border: none;
    display: inline;
    font-size: 14px;
    font-weight: bold;
    height: auto;
    line-height: 100%;
    outline: none;
    text-decoration: none;
    text-transform: capitalize;
}
<?php
