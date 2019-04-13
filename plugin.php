<?php
/**
 * Plugin Name: The Events Calendar Extension: Add Venue/Location to Month View Tooltip
 * Plugin URI: https://thetechsurge.com/
 * Description: Add the event venue/location to the tooltip that is displayed on hover over in the month view of the claendar.
 * Author: Michael Weiner
 * Author URI: https://thetechsurge.com/
 * Version: 1.0.0
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Exit plugin if it is being accessed directlu
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Call 'trive_filter_template_paths' to add an additional directory to look for template overrides
function tribe_filter_template_paths ( $file, $template ) {
	// Set the path for the event system to look for additional overrides
	$custom_file_path = ABSPATH . 'wp-content/plugins/tribe-ext-venue-tooptip/tribe-events/' . $template;

	// If the event system does not find any template overrides in the directory specified --> use the default template files
	if ( !file_exists($custom_file_path) ) {
		return $file; // Return the original file
	}

	// If the event system does find any template overrides in the directory specified --> use the new template override
	return $custom_file_path;
}

add_filter( 'tribe_events_template', 'tribe_filter_template_paths', 10, 2 ); // Call the function created to check for additional overrides