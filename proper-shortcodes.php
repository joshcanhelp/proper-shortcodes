<?php

/*
Plugin Name: PROPER Shortcodes
Plugin URI: http://theproperweb.com
Description: A collection of shortcodes that has proven useful
Version: 0.1
Author: PROPER Web Development
Author URI: http://theproperweb.com
License: GPL2
*/


/*=========================================
 * WordPress core functions ***************
 * ========================================
 */

/* Display base url of WordPress installation
 * @return: Returns WP function site_url()
 */
function proper_shortcode_site_url() {
	return site_url();
}
add_shortcode('p_site_url', 'proper_shortcode_site_url');


/* Display blog's tagline
 * @return: Returns WP function get_bloginfo() with args 'description'
 */
function proper_shortcode_tagline() {
	return get_bloginfo('description');
}
add_shortcode('p_tagline', 'proper_shortcode_tagline');


/* Display web location of style.css in current theme
 * @return: Returns WP function get_stylesheet_directory_uri()
 */
function proper_shortcode_template_url() {
	return get_stylesheet_directory_uri();
}
add_shortcode('p_template_url', 'proper_shortcode_template_url');


/*=========================================
 * Custom functions ***********************
 * ========================================
 */

/* List all documents attached
 * @param: $atts
 * @return: $output - attachments in ul format
 */
function proper_shortcode_list_documents($atts) {

	$pid = !empty( $atts['id'] ) ? $atts['id'] : get_the_id();

	$attachments = get_posts( array(
		'post_parent' => $pid,
		'post_type' => 'attachment',
		'order' => 'ASC',
		'orderby' => 'menu_order'
	) );

	if ( empty( $attachments ) ) return FALSE;

	// All allowed document types
	$allowed_types = array(
		'text/plain', 'text/csv', 'text/tab-separated-values', 'text/richtext', 'application/rtf', 'application/pdf', 'application/msword', 'application/vnd.ms-powerpoint', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.presentationml', 'application/vnd.openxmlformats-officedocument.spreadsheetml', 'application/zip'
	);

	$output = '
		<ul class="doc_link_list">';

	foreach ($attachments as $att) :

		if ( !in_array( $att->post_mime_type, $allowed_types) ) continue;

		$output .= '
			<li><a href="' . wp_get_attachment_url( $att->ID ) . '" target="_blank">' .
			$att->post_title . '</a>';

		// Takes this from the "Description" field in the media manager
		if ( !empty( $att->post_content ) ) {
			$output .= '<br><span class="doc_description">' . $att->post_content . '</span>';
		}

		$output .= '</li>';

	endforeach;

	$output .= '
		</ul>';

	return $output;
}
add_shortcode('p_list_docs', 'proper_shortcode_list_documents');



/*
 * Display the content of a field
 * @param: $atts
 * @return: meta field as string
 */
function proper_shortcode_field_display( $atts ) {
	global $post;
	return !empty( $atts['name'] ) ? get_post_meta($post->ID, $atts['name'], TRUE) : '';
}
add_shortcode('p_field', 'proper_shortcode_field_display');


/*
 * Returns a big box with custom width and classes
 * @return: content wrapped in divs
 */
function proper_shortcode_pullquote( $atts, $content = '' ) {

	$align_class = !empty($atts['direction']) && $atts['direction'] == 'left' ? 'alignleft' : 'alignright';
	$width = !empty($atts['width'])  ? intval($atts['width']) : 300;
	$font_size = !empty( $atts['font_size'] ) ? $atts['font_size'] : '1.2em';
	$line_height = !empty( $atts['line_height'] ) ? $atts['line_height'] : '1.5em';

	return '
	<div class="proper_pullquote ' . $align_class . '" style="width:' . $width . 'px; font-size: '. $font_size.'; line-height: '. $line_height .'">
		' . $content . '
	</div>';

}
add_shortcode( 'p_pullquote', 'proper_shortcode_pullquote' );



/*
 * Creates an unordered list of child pages
 * @return: $output - child pages wrapped in ul
 */
function proper_shortcode_list_child_pages( $atts ) {
	extract( shortcode_atts ( array (
			'parent_id' => ''
	), $atts ));

	// If identifier is not passed, set parent ID to current
	$parent_id = !empty( $atts['parent_id'] ) ? $atts['parent_id'] : get_the_ID();

	$pages_arr = get_posts( array (
		'posts_per_page' => -1,
		'post_type' => 'page',
		'post_status' => 'publish',
		'post_parent' => $parent_id,
		'orderyby' => 'menu_order',
		'order' => 'ASC'
	));

	if (empty($pages_arr)) $output = 'No child pages found!';
	else {

		$output = '
		<ul id="parent_id_' . $parent_id . '" class="sub_pages cf">';

		$last = count($pages_arr);
		$current = 1;

		foreach ($pages_arr as $obj1) {
			$add_class = FALSE;
			$class_to_add = '';

			$output .= '
			<li';

			// Prepare classes to add
			if (get_the_ID() == $obj1->ID) {
				$class_to_add .= 'current_page ';
				$add_class = TRUE;
			}
			if ($current == 1) {
				$class_to_add .= 'first_instance ';
				$add_class = TRUE;
			}
			if ($current == $last) {
				$class_to_add .= 'last_instance ';
				$add_class = TRUE;
			}

			if ($add_class) {
				// Remove last character (space)
				$class_to_add = substr($class_to_add, 0, -1);
				$output .= ' class="' . $class_to_add . '"';
			}

			$output .= '><a href="' . get_permalink($obj1->ID) . '">' . $obj1->post_title . '</a></li>';

			$current++;
		}

		$output .= '
		</ul>';
	}

	return $output;
}
add_shortcode('p_list_subpages', 'proper_shortcode_list_child_pages');


/*
 * Creates an unordered list of posts
 * @return: $output - post links wrapped in ul
 */
function proper_shortcode_post_list( $atts ) {

	// Merge defaults with incoming shortcode atts
	$args = shortcode_atts( array (
			'posts_per_page' => get_option('posts_per_page'),
			'offset' => ''
	), $atts );

	if ( !empty( $atts['category'] ) ) {
		// If the passed category is a number, set the category ID
		if ( is_numeric( $atts['category'] ) ) {
			$args['cat'] = intval( $atts['category'] );
		// Otherwise, assume it's a name
		} else {
			$args['category_name'] = $atts['category'];
		}
		unset( $args['category'] );
	}

	$posts_disp = get_posts($args);
	$output = '<p></p><strong>No posts to show...</strong></p>';

	if (!empty($posts_disp)) :

		$output = '
		<ul clasa="post_link_list">';

		foreach ($posts_disp as $post_it) :

			$the_link = get_permalink( $post_it->ID );
			$link_insert = '';

			$output .= '
			<li><a href="' . $the_link . '"' . $link_insert . '>' . apply_filters('the_title', $post_it->post_title) . '</a></li>
			';

		endforeach;

		$output .= '
		</ul>';
	endif;

	echo $output;
}
add_shortcode('p_post_list', 'proper_shortcode_post_list');