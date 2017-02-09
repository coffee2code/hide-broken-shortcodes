=== Hide Broken Shortcodes ===
Contributors: coffee2code
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6ARCFJ9TX3522
Tags: shortcode, shortcodes, content, post, page, coffee2code
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 2.5
Tested up to: 4.7
Stable tag: 1.8.1

Prevent broken shortcodes from appearing in posts and pages.


== Description ==

By default in WordPress, if the plugin that provides the functionality to handle any given shortcode is disabled, or if a shortcode is improperly defined in the content (such as with a typo), then the shortcode in question will appear on the site in its entirety, unprocessed by WordPress. At best this reveals unsightly code-like text to visitors and at worst can potentially expose information not intended to be seen by visitors.

This plugin prevents unhandled shortcodes from appearing in the content of a post or page. If the shortcode is of the self-closing variety, then the shortcode tag and its attributes are not displayed and nothing is shown in their place. If the shortcode is of the enclosing variety (an opening and closing tag bookend some text or markup), then the text that is being enclosed will be shown, but the shortcode tag and attributes that surround the text will not be displayed.

See the Filters section for more customization tips.

Links: [Plugin Homepage](http://coffee2code.com/wp-plugins/hide-broken-shortcodes/) | [Plugin Directory Page](https://wordpress.org/plugins/hide-broken-shortcodes/) | [Author Homepage](http://coffee2code.com)


== Installation ==

1. Install via the built-in WordPress plugin installer. Or download and unzip `hide-broken-shortcodes.zip` inside the plugins directory for your site (typically `wp-content/plugins/`)
2. Activate the plugin through the 'Plugins' admin menu in WordPress
3. Optionally filter 'hide_broken_shortcode' or 'hide_broken_shortcodes_filters' if you want to customize the behavior of the plugin


== Frequently Asked Questions ==

= How can I type out a shortcode in a post so that it doesn't get processed by WordPress or hidden by this plugin? =

If you want want a shortcode to appear as-is in a post (for example, you are trying to provide an example of how to use a shortcode), can use the shortcode escaping syntax, which is built into WordPress, by using two opening brackets to start the shortcode, and two closing brackets to close the shortcode:

* `[[some_shortcode]]`
* `[[an_example style="yes"]some text[/an_example]]`

The shortcodes will appear in your post (but without the double brackets).

= How can I prevent certain broken shortcodes from being hidden? =

Assuming you want to allow the broken shortcodes 'abc' and 'gallery' to be ignored by this plugin (and therefore not hidden if broken), you can include the following in your theme's functions.php file or in a site-specific plugin:

`
/**
 * Permit certain shortcodes to appear as broken without being hidden.
 *
 * @param string $display        The text to display in place of the broken shortcode.
 * @param string $shortcode_name The name of the shortcode.
 * @param array  $m              The regex match array for the shortcode.
 * @return string
 */
function allowed_broken_shortcodes( $display, $shortcode_name, $m ) {
	$shortcodes_not_to_hide = array( 'abc', 'gallery' );
	if ( in_array( $shortcode_name, $shortcodes_not_to_hide ) ) {
		$display = $m[0];
	}
	return $display;
}
add_filter( 'hide_broken_shortcode', 'allowed_broken_shortcodes', 10, 3 );
`

= Does this plugin include unit tests? =

Yes.


== Filters ==

The plugin is further customizable via two filters. Typically, code making use of filters should ideally be put into a mu-plugin or site-specific plugin (which is beyond the scope of this readme to explain).

= hide_broken_shortcode =

The 'hide_broken_shortcode' filter allows you to customize what, if anything, gets displayed when a broken shortcode is encountered. Your hooking function can be sent 3 arguments:

Arguments :

* $default (string): The default display text (what the plugin would display by default)
* $shortcode (string): The name of the shortcode
* The text bookended by opening and closing broken shortcodes, if present

Example:

`
/**
 * Don't show broken shortcodes or the content they wrap.
 *
 * @param string $default   The text to display in place of the broken shortcode.
 * @param string $shortcode The name of the shortcode.
 * @param array  $m         The regex match array for the shortcode.
 * @return string
 */
function hbs_handler( $default, $shortcode, $m ) {
	return ''; // Don't show the shortcode or text bookended by the shortcode
}
add_filter( 'hide_broken_shortcode', 'hbs_handler', 10, 3 );
`

= hide_broken_shortcodes_filters =

The 'hide_broken_shortcodes_filters' filter allows you to customize what filters to hook to find text with potential broken shortcodes. The three default filters are 'the_content', 'the_excerpt', and 'widget_text'. Your hooking function will only be sent one argument: the array of filters.

Example:

`
/**
 * Make Hide Broken Shortcodes also filter 'the_title'.
 *
 * @param  array $filters_array The filters the plugin will handle.
 * @return array
 */
function hbs_filter( $filters_array ) {
	$filters_array[] = 'the_title'; // Assuming you've activated shortcode support in post titles
	return $filters_array;
}
add_filter( 'hide_broken_shortcodes_filters', 'hbs_filter' );
`


== Changelog ==

= 1.8.1 (2017-02-08) =
* Change: Default `WP_TESTS_DIR` to `/tmp/wordpress-tests-lib` rather than erroring out if not defined via environment variable.
* Change: Enable more error output for unit tests.
* Change: Add more unit tests.
* Change: Note compatibility through WP 4.7+.
* Change: Miscellaneous readme.txt improvements.
* Change: Minor code documentation reformatting.
* Change: Update copyright date (2017).
* New: Add LICENSE file.

= 1.8 (2016-05-21) =
* Bugfix: Don't attempt to hide shortcodes (or what may look like shortcodes) appearing within HTML tags.
* New: Add unit test to ensure shortcode escape notation is not hidden by the plugin.
* Change: Prevent web invocation of unit test bootstrap.php.
* Change: Note compatibility through WP 4.5+.

= 1.7.1 (2016-01-27) =
* Change: Register hooks during 'plugins_loaded' instead of 'init'.
* New: Add support for language packs:
    * Define 'Text Domain' header attribute.
    * Load textdomain.
* New: Create empty index.php to prevent files from being listed if web server has enabled directory listings.
* Change: Note compatibility through WP 4.4+.
* Change: Explicitly declare methods in unit tests as public.
* Change: Update copyright date (2016).

= 1.7 (2015-04-02) =
* Enhancement: Filter 'the_excerpt' by default as well
* Update: Add more unit tests
* Update: Note compatibility through WP 4.2+
* Update: Add inline documentation to examples in readme.txt
* Update: Minor inline documentation tweaks (spacing, formatting)

= 1.6.3 (2015-02-14) =
* Add trivial unit test for plugin version
* Note compatibility through WP 4.1+
* Update copyright date (2015)

= 1.6.2 (2014-08-30) =
* Minor plugin header reformatting
* Minor code reformatting (bracing)
* Change documentation links to wp.org to be https
* Note compatibility through WP 4.0+
* Add plugin icon

= 1.6.1 (2013-12-29) =
* Add unit tests
* Note compatibility through WP 3.8+
* Update copyright date (2014)
* Minor readme.txt tweaks
* Change donate link
* Add banner

= 1.6 =
* Update regex to allow hyphens in shortcode names (syncing changes made in WP 3.5)
* Add check to prevent execution of code if file is directly accessed
* Note compatibility through WP 3.5+
* Update copyright date (2013)

= 1.5 =
* Recursively hide nested broken shortcodes
* Re-license as GPLv2 or later (from X11)
* Add 'License' and 'License URI' header tags to readme.txt and plugin file
* Remove ending PHP close tag
* Note compatibility through WP 3.4+
* Fix error in example code in readme.txt

= 1.4 =
* Update get_shortcode_regex() and do_shortcode_tag() to support shortcode escape syntax
* NOTE: The preg match array sent via the 'hide_broken_shortcode' filter has changed and requires you to update any code that hooks it
* Add version() to return plugin version
* Note compatibility through WP 3.3+
* Add Frequently Asked Questions section to readme.txt
* Add link to plugin directory page to readme.txt
* Update copyright date (2012)

= 1.3.1 =
* Note compatibility through WP 3.2+
* Minor code formatting changes (spacing, variable removal)
* Fix plugin homepage and author links in description in readme.txt

= 1.3 =
* Switch from object instantiation to direct class invocation
* Explicitly declare all functions public static
* Note compatibility through WP 3.1+
* Update copyright date (2011)

= 1.2 =
* Allow customization of the filters the plugin applies to via the 'hide_broken_shortcodes_filters' filter
* Change do_shortcode filter priority from 12 to 1001 (to avoid incompatibility with Preserve Code Formatting, and maybe others)
* Move registering filters into register_filters()
* Rename class from 'HideBrokenShortcodes' to 'c2c_HideBrokenShortcodes'
* Store plugin instance in global variable, $c2c_hide_broken_shortcodes, to allow for external manipulation
* Note compatibility with WP 3.0+
* Minor code reformatting (spacing)
* Add Filters and Upgrade Notice sections to readme.txt
* Remove all header documentation and instructions from plugin file (all that and more are in readme.txt)
* Remove trailing whitespace from header docs

= 1.1 =
* Create filter 'hide_broken_shortcode' to allow customization of the output for broken shortcodes
* Now also filter widget_text
* Add PHPDoc documentation
* Note compatibility with WP 2.9+
* Update copyright date

= 1.0 =
* Initial release


== Upgrade Notice ==

= 1.8.1 =
Trivial update: noted compatibility through WP 4.7+, added more unit tests, updated unit test bootstrap, minor documentation tweaks, updated copyright date

= 1.8 =
Bugfix release: no longer attempt to hide shortcodes (or what looks like shortcodes) within HTML tags (fixes compatibility with WooCommerce, among others); verified compatibility through WP 4.5+.

= 1.7.1 =
Trivial update: improved support for localization, minor unit test tweaks, verified compatibility through WP 4.4+, and updated copyright date (2016)

= 1.7 =
Minor update: also filter excerpts by default; noted compatibility through WP 4.2+

= 1.6.3 =
Trivial update: noted compatibility through WP 4.1+ and updated copyright date (2015)

= 1.6.2 =
Trivial update: noted compatibility through WP 4.0+; added plugin icon.

= 1.6.1 =
Trivial update: added unit tests; noted compatibility through WP 3.8+

= 1.6 =
Recommended minor update: updated regex used to parse shortcodes to allow for hyphens in shortcode names; noted compatibility through WP 3.5+

= 1.5 =
Recommended minor update: recursively hide nested broken shortcodes; noted compatibility through WP 3.4+; explicitly stated license

= 1.4 =
Minor update: support shortcode escaping syntax; noted compatibility through WP 3.3+. BE AWARE: An incompatible change has been made in third argument sent to 'hide_broken_shortcode' filter.

= 1.3.1 =
Trivial update: noted compatibility through WP 3.2+ and minor code formatting changes (spacing)

= 1.3 =
Minor update: slight implementation modification; updated copyright date; other minor code changes.

= 1.2 =
Minor update. Highlights: added hooks for customization; renamed class; re-prioritized hook to avoid conflict with other plugins; verified WP 3.0 compatibility.
