<?php
/**
 * @package jonls.dk-Shortcode-Widget
 * @author Jon Lund Steffensen
 * @version 0.1
 */
/*
Plugin Name: jonls.dk-Shortcode-Widget
Plugin URI: http://wordpress.org/#
Description: Use shortcodes in widgets.
Author: Jon Lund Steffensen
Version: 0.1
Author URI: http://jonls.dk/
*/

if (!is_admin()) add_filter('widget_text', 'do_shortcode', 11);
