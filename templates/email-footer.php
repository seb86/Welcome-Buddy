<?php
/**
 * Email Footer
 *
 * @author  Sébastien Dumont
 * @package BuddyPress Welcome Email/Templates/Emails
 * @version 1.0.0
 */

if ( ! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
?>
                            </div>
                            <td>
                          </tr>
                        </table>
                        <!-- End Content -->
                      </td>
                    <tr>
                  </table>
                  <!-- End Body -->
                </td>
              </tr>
              <tr>
                <td align="center" valign="top">
                  <!-- Footer -->
                  <table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
                    <tr>
                      <td valign="top">
                        <table border="0" cellpadding="10" cellspacing="0" width="100%">
                          <tr>
                            <td colspan="2" valign="middle" id="credit"><?php echo wpautop(wp_kses_post(wptexturize(apply_filters('buddypress_welcome_email_footer_text', sprintf(__('- %s', 'buddypress-welcome-email'), wp_specialchars_decode(get_option('blogname'), ENT_QUOTES)))))); ?></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                  <!-- End Footer -->
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>

    </div>

  </body>

</html>