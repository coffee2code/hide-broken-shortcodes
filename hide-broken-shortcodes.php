<?php
/**
 * @package Hide_Broken_Shortcodes
 * @author Scott Reilly
 * @version 1.1
 */
/*
Plugin Name: Hide Broken Shortcodes
Version: 1.1
Plugin URI: http://coffee2code.com/wp-plugins/hide-broken-shortcodes
Author: Scott Reilly
Author URI: http://coffee2code.com
Description: Prevent broken shortcodes from appearing in posts and pages.

Shortcodes are a handy feature of WordPress allowing for a simple markup-like syntax to be used within post and page content, such
that a handler function will replace the shortcode with desired content.  For instance, this:
	[youtube id="abc" width="200"]
might be replaced by a plugin to embed a YouTube video into the post with a width of 200.  Or:
	[make_3d]Special News[/make_3d]
might be used to make a three-dimensional image of the text contained in the shortcode tag, "Special News".

By default, if the plugin that provides the functionality to handle any given shortcode tag is disabled, or if
a shortcode is improperly defined in the content (such as with a typo), then the shortcode in question appears on the blog in its
entirety, unprocessed by WordPress.  At best this reveals unsightly code-like text to visitors and at worst can potentially expose
information not intended for visitor's eyes.

This plugin prevents unhandled shortcodes from appearing in the content of a post or page. If the shortcode is of the self-closing variety
(the first example above), then the shortcode tag and its attributes are not displayed and nothing is shown in their place.  If the
shortcode is of the enclosing variety (the second example above), then the text that is being enclosed will be shown, but the shortcode
tag and attributes that surround the text will not be displayed (e.g. in the second example above, "Special News" will still be
displayed on the site).

A filter is also available by the name of 'hide_broken_shortcode' that allows you to customize what, if anything, gets displayed when a
broken shortcode is encountered.  Your hooking function can be sent 3 arguments:
	* The default display text (what the plugin would display by default)
	* The name of the shortcode
	* The text bookended by opening and closing broken shortcodes, if present

Example:
	add_filter('hide_broken_shortcode', 'hbs_handler', 10, 3);
	function hbs_handler($default, $tag, $content) {
		return ''; // Don't show the shortcode or text bookended by the shortcode
	}

Compatible with WordPress 2.5+, 2.6+, 2.7+, 2.8+, 2.9+.

=>> Read the accompanying readme.txt file for more information.  Also, visit the plugin's homepage
=>> for more information and the latest updates

Installation:

1. Download the file http://coffee2code.com/wp-plugins/fix-broken-shortcodes.zip and unzip it into your 
/wp-content/plugins/ directory (or install via the built-in WordPress plugin installer).
2. Activate the plugin through the 'Plugins' admin menu in WordPress
3. Optionally filter 'hide_broken_shortcode' if you want to customize the behavior of the plugin

*/

/*
Copyright (c) 2009-2010 by Scott Reilly (aka coffee2code)

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

if ( !class_exists('HideBrokenShortcodes') ) :

class HideBrokenShortcodes {

	/**
	 * Class constructor: initializes class variables and adds actions and filters.
	 */
	function HideBrokenShortcodes() {
		add_filter('the_content', array(&$this, 'do_shortcode'), 12); // Do this after the built-in do_shortcode() operates, which is 11
		add_filter('widget_text', array(&$this, 'do_shortcode'), 12);
	}

	/**
	 * Like WP's do_shortcode(), but doesn't return content immediately if no shortcodes exist.
	 *
	 * @param string $content The primary text to be processed for shortcodes
	 * @return string
	 */
	function do_shortcode( $content ) {
		$pattern = $this->get_shortcode_regex();
		return preg_replace_callback('/'.$pattern.'/s', array(&$this, 'do_shortcode_tag'), $content);
	}

	/**
	 * Like WP's get_shortcode_regex(), but matches for anything that looks like a shortcode
	 *
	 * @return string The regexp for finding shortcodes in a text
	 */
	function get_shortcode_regex() {
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
	function do_shortcode_tag( $m ) {
		// If this code is executed, then the shortcode found is not being handled.
		// If text is being wrapped by opening and closing shortcode tag, show text. Otherwise, show nothing.
		$default_display = ( isset($m[4]) ? $m[4] : '' );
		// The filter is sending these arguments; apply_filters('hide_broken_shortcode', $default_display, $shortcode_name, $enclosed_text)
		return apply_filters('hide_broken_shortcode', $default_display, $m[1], $m[4]);
	}

} // end HideBrokenShortcodes

endif; // end if !class_exists()

if ( class_exists('HideBrokenShortcodes') )
	new HideBrokenShortcodes();

?>