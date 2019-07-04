<?php
/**
 * Plugin Name: Display Event Locations for The Events Calendar
 * Plugin URI: https://thetechsurge.com/
 * Description: Add the event venue/location to the tooltip that is displayed on hover over in the month view of the claendar when using The Events Calenar or The Events Calendar Pro by Modern Tribe.
 * Author: Michael Weiner
 * Author URI: https://thetechsurge.com/
 * Version: 1.0.1
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Exit plugin if it is being accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Establish directory paths for the template overrides to be used the The Events Calendar Plugin already installed separately by the user
// deltec_ is the custom prefix used for all classes and functions within the plugin


// Call 'deltec_trive_filter_template_paths' to add additional directory paths to look for template overrides
// tribe_events_template() comes from the Modern Tribe The Events Calendar Plugin installed on the site
function deltec_tribe_filter_template_paths ( $file, $template ) {

	// Set the path for the event system to look for additional overrides for events created with the classic editor for the standard and pro version of The Events Calendar
	$deltec_custom_file_path = plugin_dir_path( __FILE__ ) . 'tribe-events/' . $template;
	$deltec_custom_file_path_pro = plugin_dir_path( __FILE__ ) . 'tribe-events/' . $template;

	// Set the path for the event system to look for additional overrides for events created with the block editor for the standard and pro version of The Events Calendar
	$deltec_custom_file_path_block = plugin_dir_path( __FILE__ ) . 'tribe/events/' . $template;
	$deltec_custom_file_path_block_pro = plugin_dir_path( __FILE__ ) . 'tribe/events/' . $template;

	// If the event system does not find any template overrides in the directory specified --> return the default template files
	if ( !file_exists($deltec_custom_file_path) ) {
		return $file;
	}
	if ( !file_exists($deltec_custom_file_path_pro) ) {
		return $file;
	}
	if ( !file_exists($deltec_custom_file_path_block) ) {
		return $file;
	}
	if ( !file_exists($deltec_custom_file_path_block_pro) ) {
		return $file;
	}

	// If the event system does find any template overrides in any of the directories specified --> return the new template override
	return $deltec_custom_file_path;
	return $deltec_custom_file_path_pro;
	return $deltec_custom_file_path_block;
	return $deltec_custom_file_path_block_pro;
}

add_filter( 'tribe_events_template', 'deltec_tribe_filter_template_paths', 10, 2 ); // Call the function created to check for additional overrides


// Add function & hook to add additional information to the array of data used for the template
function deltec_tribe_template_data_array ( $json, $event, $additional ){
	$venue = tribe_get_venue_id($event);
	if ($venue){
		$json['venue'] = $venue;
		$json['venue_link'] = tribe_get_venue_link($venue, false);
		$json['venue_title'] = tribe_get_venue($venue);
	}
	return $json;
}
add_filter( 'tribe_events_template_data_array', 'deltec_tribe_template_data_array', 10, 3 );
