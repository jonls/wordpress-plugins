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

class PaypalDonate_Widget extends WP_Widget {
	function PaypalDonate_Widget() {
		$widget_ops = array('classname' => 'widget_donate', 'description' => __("Display PayPal Donate button"));
		parent::WP_Widget('paypal_donate', $name = 'Paypal Donate', $widget_ops);
	}

	function form($instance) {
		echo '<p><label for="'.$this->get_field_id('business').'">'.__("Business:").
			'<input class="widefat" id="'.$this->get_field_id('business').'" name="'.$this->get_field_name('business').
			'" type="text" value="'.$instance['business'].'"/></label></p>'.
			'<p><label for="'.$this->get_field_id('name').'">'.__("Name:").
			'<input class="widefat" id="'.$this->get_field_id('name').'" name="'.$this->get_field_name('name').
			'" type="text" value="'.$instance['name'].'"/></label></p>'.
			'<p><label for="'.$this->get_field_id('currency').'">'.__("Currency:").
			'<input class="widefat" id="'.$this->get_field_id('currency').'" name="'.$this->get_field_name('currency').
			'" type="text" value="'.$instance['currency'].'"/></label></p>'.
			'<p><label for="'.$this->get_field_id('text').'">'.__("Text:").
			'<input class="widefat" id="'.$this->get_field_id('text').'" name="'.$this->get_field_name('text').
			'" type="text" value="'.$instance['text'].'"/></label></p>';

	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['business'] = $new_instance['business'];
		$instance['name'] = $new_instance['name'];
		$instance['currency'] = $new_instance['currency'];
		$instance['text'] = $new_instance['text'];
		return $instance;
	}

	function widget($args, $instance) {
		if (!empty($instance['text'])) {
			echo '<p>'.wp_specialchars($instance['text']).'</p>';
		}
		echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">'.
			'<input type="hidden" name="cmd" value="_donations">'.
			'<input type="hidden" name="business" value="'.$instance['business'].'">'.
			'<input type="hidden" name="lc" value="GB">'.
			'<input type="hidden" name="item_name" value="'.$instance['name'].'">'.
			'<input type="hidden" name="currency_code" value="'.$instance['currency'].'">'.
			'<input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_SM.gif:NonHosted">'.
			'<input type="image" src="https://www.paypal.com/en_GB/i/btn/btn_donate_SM.gif"'.
			' border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">'.
			'<img alt="" border="0" src="https://www.paypal.com/da_DK/i/scr/pixel.gif" width="1" height="1">'.
			'</form>';
	}
}

function paypal_donate_init() {
	register_widget('PaypalDonate_Widget');
}
add_action( 'widgets_init', 'paypal_donate_init' );

