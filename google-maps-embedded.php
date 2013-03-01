<?php
/**
 * @package jonls.dk-Google-Maps-Embedded
 * @author Jon Lund Steffensen
 * @version 0.1
 */
/*
Plugin Name: jonls.dk-Google-Maps-Embedded
Plugin URI: http://wordpress.org/#
Description: Google Maps embedding shortcode
Author: Jon Lund Steffensen
Version: 0.1
Author URI: http://jonls.dk/
*/

function google_maps_embedded_shortcode_handler($atts, $content=null) {
	return '<iframe width="'.$atts['width'].'" height="'.$atts['height'].'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"'.
		' src="http://maps.google.dk/?ie=UTF8&amp;t=h&amp;ll='.$atts['ll'].'&amp;spn='.$atts['spn'].'&amp;z='.$atts['z'].'&amp;output=embed">'.
		'</iframe><br/>'.
		'<small><a href="http://maps.google.dk/?ie=UTF8&amp;t=h&amp;ll='.$atts['ll'].'&amp;spn='.$atts['spn'].'&amp;z='.$atts['z'].'&amp;source=embed"'.
		' style="color:#0000FF;text-align:left">Vis stort kort</a></small>';
}
add_shortcode('google-maps', 'google_maps_embedded_shortcode_handler');