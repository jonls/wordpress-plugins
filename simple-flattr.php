<?php
/**
 * @package Simple-Flattr
 * @author Jon Lund Steffensen
 * @version 0.3
 */
/*
Plugin Name: Simple-Flattr
Plugin URI: http://jonls.dk/
Description: Simple plugin for insertion of simple flattr button
Author: Jon Lund Steffensen
Version: 0.3
Author URI: http://jonls.dk/
*/

function simple_flattr_load_scripts_init_cb() {
	if (!is_admin()) {
		wp_enqueue_script('flattr', 'http://api.flattr.com/js/0.6/load.js?mode=auto', false, '0.6');
	}
}
add_action('init', 'simple_flattr_load_scripts_init_cb');

function simple_flattr_shortcode_handler($atts, $content=null) {
	$default_atts = null;
	$default_content = null;

	if (in_the_loop()) {
		$default_atts = array('url' => get_permalink(),
				      'title' => the_title('', '', 0));
		$default_content = ''; /* get_the_excerpt(); TODO f*cks up the share buttons, why?? */
	} else {
		$default_atts = array('url' => home_url(),
				      'title' => get_bloginfo('name'));
		$default_content = get_bloginfo('description');
	}

	$default_atts = wp_parse_args(array('uid' => null,
					    'category' => 'text',
					    'language' => null,
					    'tags' => null,
					    'button' => 'compact'),
				      $default_atts);

	$a = shortcode_atts($default_atts, $atts);
	$content = !is_null($content) ? $content : $default_content;

	$t = null;
	if (!is_feed()) {
		$t = '<a class="FlattrButton" style="display:none;"'.
			' title="'.$a['title'].'" href="'.$a['url'].'"';
		if (!is_null($a['language'])) $t .= ' lang="'.$a['language'].'"';
		if (!is_null($a['uid'])) $t .= ' data-flattr-uid="'.$a['uid'].'"';
		if (!is_null($a['category'])) $t .= ' data-flattr-category="'.$a['category'].'"';
		if (!is_null($a['tags'])) $t .= ' data-flattr-tags="'.$a['tags'].'"';
		if (!is_null($a['button'])) $t .= ' data-flattr-button="'.$a['button'].'"';
		$t .= '>';

		if (!is_null($content)) $t .= $content;
		$t .= '</a>';
	} else {
		$q = array('title' => $a['title'],
			   'url' => $a['url']);
		if (!is_null($a['language'])) $q['language'] = $a['language'];
		if (!is_null($a['uid'])) $q['user_id'] = $a['uid'];
		if (!is_null($a['category'])) $q['category'] = $a['category'];
		if (!is_null($a['tags'])) $q['tags'] = $a['tags'];
		if (!is_null($content)) ;
		$t = '<p><a href="https://flattr.com/submit/auto?'.build_query($q).'">'.
			'<img src="https://api.flattr.com/button/flattr-badge-large.png" alt="Flattr this!"/></a></p>';
	}

	return $t;
}
add_shortcode('flattr', 'simple_flattr_shortcode_handler');
