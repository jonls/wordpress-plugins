<?php
/**
 * @package Paypal-Donate
 * @author Jon Lund Steffensen
 * @version 0.1
 */
/*
Plugin Name: Paypal-Donate
Plugin URI: http://wordpress.org/#
Description: Paypal donate shortcode
Author: Jon Lund Steffensen
Version: 0.1
Author URI: http://jonls.dk/
*/

function paypal_donate_shortcode_handler($atts, $content=null) {
	return '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">'.
		'<input type="hidden" name="cmd" value="_donations">'.
		'<input type="hidden" name="business" value="'.$atts['business'].'">'.
		'<input type="hidden" name="lc" value="GB">'.
		'<input type="hidden" name="item_name" value="'.$atts['name'].'">'.
		'<input type="hidden" name="currency_code" value="'.$atts['currency'].'">'.
		'<input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_SM.gif:NonHosted">'.
		'<input type="image" src="https://www.paypal.com/en_GB/i/btn/btn_donate_SM.gif"'.
		' border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">'.
		'<img alt="" border="0" src="https://www.paypal.com/da_DK/i/scr/pixel.gif" width="1" height="1">'.
		'</form>';
}
add_shortcode('paypal-donate', 'paypal_donate_shortcode_handler');
