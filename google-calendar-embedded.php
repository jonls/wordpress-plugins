<?php
/**
 * @package jonls.dk-Google-Calendar-Embedded
 * @author Jon Lund Steffensen
 * @version 0.1
 */
/*
Plugin Name: jonls.dk-Google-Calendar-Embedded
Plugin URI: http://wordpress.org/#
Description: Google Calendar embedding shortcode
Author: Jon Lund Steffensen
Version: 0.1
Author URI: http://jonls.dk/
*/

function google_calendar_embedded_shortcode_handler($atts, $content=null) {
	return '<iframe src="'.$atts['src'].'" style=" border-width:0 " width="'.$atts['width'].'" height="'.$atts['height'].'" frameborder="0" scrolling="no"></iframe>';
}
add_shortcode('google-calendar', 'google_calendar_embedded_shortcode_handler');