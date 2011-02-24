<?php
/**
 * @package Hide_Broken_Shortcodes
 * @author Scott Reilly
 * @version 1.3
 */
/*
Plugin Name: Hide Broken Shortcodes
Version: 1.3
Plugin URI: http://coffee2code.com/wp-plugins/hide-broken-shortcodes/
Author: Scott Reilly
Author URI: http://coffee2code.com
Description: Prevent broken shortcodes from appearing in posts and pages.

Compatible with WordPress 2.5+, 2.6+, 2.7+, 2.8+, 2.9+, 3.0+, 3.1+.

=>> Read the accompanying readme.txt file for instructions and documentation.
=>> Also, visit the plugin's homepage for additional information and updates.
=>> Or visit: http://wordpress.org/extend/plugins/hide-broken-shortcodes/

*/

/*
Copyright (c) 2009-2011 by Scott Reilly (aka coffee2code)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy,
modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR
IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

if ( !class_exists( 'c2c_HideBrokenShortcodes' ) ) :

class c2c_HideBrokenShortcodes {

	/**
	 * Class constructor: initializes class variables and adds actions and filters.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_filters' ) );
	}

	/**
	 * Register filters
	 */
	public static function register_filters() {
		$filters = (array) apply_filters( 'hide_broken_shortcodes_filters', array( 'the_content', 'widget_text' ) );
		foreach ( $filters as $filter )
			add_filter( $filter, array( __CLASS__, 'do_shortcode' ), 1001 ); // Do this after the built-in do_shortcode() operates, which is 11
	}

	/**
	 * Like WP's do_shortcode(), but doesn't return content immediately if no shortcodes exist.
	 *
	 * @param string $content The primary text to be processed for shortcodes
	 * @return string
	 */
	public static function do_shortcode( $content ) {
		$pattern = self::get_shortcode_regex();
		return preg_replace_callback( '/'.$pattern.'/s', array( __CLASS__, 'do_shortcode_tag' ), $content );
	}

	/**
	 * Like WP's get_shortcode_regex(), but matches for anything that looks like a shortcode
	 *
	 * @return string The regexp for finding shortcodes in a text
	 */
	public static function get_shortcode_regex() {
		$tagregexp = '[a-zA-Z_\-][0-9a-zA-Z_\-\+]{2,}';
		return '\[('.$tagregexp.')\b(.*?)(?:(\/))?\](?:(.+?)\[\/\1\])?';
	}

	/**
	 * Callback to handle each shortcode not replaced via the traditional shortcode system
	 *
	 * The actual replacement string used can be modified by filtering
	 * 'hide_broken_shortcode'.  By default this is the text between the
	 * opening/closing shortcode tags, or an empty string if there was no
	 * closing tag.
	 *
	 * @param string $m The preg_match result array for the unhandled shortcode.
	 * @return string The replacement string for the unhandled shortcode.  By default it is the text between the opening/closing shortcode tags, or an empty string if there is no closing tag.
	 */
	public static function do_shortcode_tag( $m ) {
		// If this code is executed, then the shortcode found is not being handled.
		// If text is being wrapped by opening and closing shortcode tag, show text. Otherwise, show nothing.
		$default_display = ( isset($m[4]) ? $m[4] : '' );
		// The filter is sending these arguments; apply_filters('hide_broken_shortcode', $default_display, $shortcode_name, $enclosed_text)
		return apply_filters( 'hide_broken_shortcode', $default_display, $m[1], $default_display );
	}

} // end c2c_HideBrokenShortcodes

c2c_HideBrokenShortcodes::init();

endif; // end if !class_exists()

?>