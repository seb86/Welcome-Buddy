<?php
/**
 * Email Header
 *
 * @author  Sébastien Dumont
 * @package BuddyPress Welcome Email/Templates
 * @version 1.0.0
 */

if ( ! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
?>
<!DOCTYPE html>
<html dir="<?php echo is_rtl() ? 'rtl' : 'ltr'?>">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo get_bloginfo('name', 'display'); ?></title>
  </head>
  <body <?php echo is_rtl() ? 'rightmargin' : 'leftmargin'; ?>="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
    <div id="wrapper" dir="<?php echo is_rtl() ? 'rtl' : 'ltr'?>">
      <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
        <tr>
          <td align="center" valign="top">
            <?php
            if (apply_filters('buddypress_email_show_header_image', true)) {
              echo '<div id="template_header_image">';
              echo '<p style="margin-top:0;margin-bottom:0;">';
              if (apply_filters('buddypress_email_link_header_image', true)) { echo '<a href="'.get_bloginfo('url').'">'; }
              echo '<img src="'.esc_url(apply_filters('buddypress_email_header_image', NULL)).'" alt="'.get_bloginfo('name', 'display').'" />';
              if (apply_filters('buddypress_email_link_header_image', true)) { echo '</a>'; }
              echo '</p>';
              echo '</div>';
            }
            ?>
            <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container">
              <tr>
                <td align="center" valign="top">
                  <?php if ( ! empty($email_heading)) { ?>
                  <!-- Header -->
                  <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header">
                    <tr>
                      <td id="header_wrapper">
                        <h1><?php echo $email_heading; ?></h1>
                      </td>
                    </tr>
                  </table>
                  <!-- End Header -->
                  <?php } ?>
                </td>
              </tr>
              <tr>
                <td align="center" valign="top">
                  <!-- Body -->
                  <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
                  <tr>
                    <td valign="top" id="body_content">
                      <!-- Content -->
                      <table border="0" cellpadding="20" cellspacing="0" width="100%">
                        <tr>
                          <td valign="top">
                            <div id="body_content_inner">