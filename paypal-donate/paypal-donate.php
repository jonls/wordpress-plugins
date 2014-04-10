<?php
/**
 * @package jonls.dk-Paypal-Donate
 * @author Jon Lund Steffensen
 * @version 0.2
 */
/*
Plugin Name: jonls.dk-Paypal-Donate
Plugin URI: http://wordpress.org/#
Description: Paypal donate shortcode
Author: Jon Lund Steffensen
Version: 0.2
Author URI: http://jonls.dk/
*/

global $paypal_donate_db_version;
$paypal_donate_db_version = '1';


function paypal_donate_load_scripts_init_cb() {
    global $wp;
    $wp->add_query_var('paypal_donate_widget');
    $wp->add_query_var('paypal_donate_info');
    $wp->add_query_var('paypal_donate_name');
    $wp->add_query_var('paypal_donate_currency');
}
add_action('init', 'paypal_donate_load_scripts_init_cb');


function paypal_donate_shortcode_handler($atts, $content=null) {
    $info = isset($atts['info']) ? $atts['info'] : 'count';
    $code = $atts['business'];
    $name = $atts['name'];
    $currency = $atts['currency'];

    return '<iframe src="'.site_url().'/?paypal_donate_widget='.urlencode($code).
        '&paypal_donate_name='.urlencode($name).'&paypal_donate_currency='.urlencode($currency).
        '&paypal_donate_info='.urlencode($info).'" width="150" height="24" '.
        'frameborder="0" scrolling="no" title="PayPal Donate" border="0" '.
        'marginheight="0" marginwidth="0" allowtransparency="true"></iframe>';
}
add_shortcode('paypal-donate', 'paypal_donate_shortcode_handler');


/* Generate widget */
function paypal_donate_generate_widget() {
    global $wpdb;

    /* Generate widget when flag is set */
    if (!get_query_var('paypal_donate_widget')) return;

    $code = get_query_var('paypal_donate_widget');
    $info = get_query_var('paypal_donate_info');
    $name = get_query_var('paypal_donate_name');
    $currency = get_query_var('paypal_donate_currency');

    $table_name = $wpdb->prefix.'paypal_donate_ipn';

    echo '<!doctype html>'.
        '<html><head>'.
        '<meta charset="utf-8"/>'.
        '<title>Paypal Donate Widget</title>'.
        '<link rel="stylesheet" href="'.plugins_url('style.css', __FILE__).'"/>'.
        '</head><body marginwidth="0" marginheight="0">';

    echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">'.
		'<input type="hidden" name="cmd" value="_donations"/>'.
		'<input type="hidden" name="business" value="'.$code.'"/>'.
		'<input type="hidden" name="lc" value="GB"/>'.
		'<input type="hidden" name="item_name" value="'.$name.'"/>'.
		'<input type="hidden" name="currency_code" value="'.$currency.'"/>'.
		'<input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_SM.gif:NonHosted"/>'.
		'<button id="button" name="submit" type="submit">PayPal</button>';

    /* Add count button inside form */
    if ($info == 'count') {
        $count = $wpdb->get_var($wpdb->prepare('SELECT IFNULL(COUNT(*), 0) FROM '.$table_name.
                                               ' WHERE code = %s AND'.
                                               ' YEAR(ctime) = YEAR(NOW())', $code));
        echo '<button id="counter" type="submit" name="submit">'.$count.'</button>';
    }

    echo '</form>';
    echo '</body></html>';
    exit;
}
add_action('template_redirect', 'paypal_donate_generate_widget');


/* Create database on activation */
function paypal_donate_install() {
    global $wpdb;
    global $paypal_donate_db_version;

    $table_name = $wpdb->prefix.'paypal_donate_ipn';

    $sql = "CREATE TABLE $table_name (
  id VARCHAR(32) NOT NULL,
  ctime TIMESTAMP NOT NULL,
  amount DECIMAL(20) NOT NULL,
  currency VARCHAR(3) NOT NULL,
  code VARCHAR(50) NOT NULL,
  UNIQUE KEY id (id),
  KEY code (code, ctime)
);";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    add_option('paypal_donate_db_version', $paypal_donate_db_version);
}
register_activation_hook(__FILE__, 'paypal_donate_install');
