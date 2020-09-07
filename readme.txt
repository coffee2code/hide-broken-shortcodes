=== Hide Broken Shortcodes ===
Contributors: coffee2code
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6ARCFJ9TX3522
Tags: shortcode, shortcodes, content, post, page, coffee2code
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 2.5
Tested up to: 5.5
Stable tag: 1.9.2

Prevent broken shortcodes from appearing in posts and pages.


== Description ==

By default in WordPress, if the plugin that provides the functionality to handle any given shortcode is disabled, or if a shortcode is improperly defined in the content (such as with a typo), then the shortcode in question will appear on the site in its entirety, unprocessed by WordPress. At best this reveals unsightly code-like text to visitors and at worst can potentially expose information not intended to be seen by visitors.

This plugin prevents unhandled shortcodes from appearing in the content of a post or page. If the shortcode is of the self-closing variety, then the shortcode tag and its attributes are not displayed and nothing is shown in their place. If the shortcode is of the enclosing variety (an opening and closing tag bookend some text or markup), then the text that is being enclosed will be shown, but the shortcode tag and attributes that surround the text will not be displayed.

See the Filters section for more customization tips.

Links: [Plugin Homepage](https://coffee2code.com/wp-plugins/hide-broken-shortcodes/) | [Plugin Directory Page](https://wordpress.org/plugins/hide-broken-shortcodes/) | [GitHub](https://github.com/coffee2code/hide-broken-shortcodes/) | [Author Homepage](https://coffee2code.com)


== Installation ==

1. Install via the built-in WordPress plugin installer. Or download and unzip `hide-broken-shortcodes.zip` inside the plugins directory for your site (typically `wp-content/plugins/`)
2. Activate the plugin through the 'Plugins' admin menu in WordPress
3. Optionally filter 'hide_broken_shortcode' or 'hide_broken_shortcodes_filters' if you want to customize the behavior of the plugin


== Frequently Asked Questions ==

= Why am I still seeing a broken shortcode even with this plugin activated? =

By default, the plugin only tries to hide broken shortcodes appearing in post/page content, post/page excerpts, and widgets. It does not hide broken shortcodes that may appear in post/page titles, custom fields, menus, comments, etc.

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


== Hooks ==

The plugin is further customizable via two filters. Typically, code making use of filters should ideally be put into a mu-plugin or site-specific plugin (which is beyond the scope of this readme to explain).

**hide_broken_shortcode (filter)**

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

**hide_broken_shortcodes_filters (filter)**

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

= 1.9.2 (2020-09-06) =
* Change: Restructure unit test file structure
    * New: Create new subdirectory `phpunit/` to house all files related to unit testing
    * Change: Move `bin/` to `phpunit/bin/`
    * Change: Move `tests/bootstrap.php` to `phpunit/`
    * Change: Move `tests/` to `phpunit/tests/`
    * Change: Rename `phpunit.xml` to `phpunit.xml.dist` per best practices
* Change: Note compatibility through WP 5.5+

= 1.9.1 (2020-08-04) =
* New: Add TODO.md and move existing TODO list from top of main plugin file into it (and add items to it)
* Change: Add inline documentation for hooks
* Change: Use HTTPS for link to WP SVN repository in bin script for configuring unit tests
* Change: Note compatibility through WP 5.4+
* Change: Update links to coffee2code.com to be HTTPS
* Change: Tweak inline documentation formatting
* Unit tests:
    * New: Add test for `get_shortcode_regex()`
    * New: Add test for class name
    * Change: Remove unnecessary unregistering of hooks

= 1.9 (2019-12-09) =
* New: Add support for shortcodes with names as short as only one character in length (previous minimum was three characters)
* Change: Initialize plugin on `plugins_loaded` action instead of on load
* New: Add CHANGELOG.md file and move all but most recent changelog entries into it
* Unit tests:
    * Change: Update unit test install script and bootstrap to use latest WP unit test repo
    * New: Add additional test data that includes shortcodes using single quotes around their attribute values
    * Fix: Prevent theoretical warning about undefined variable
* Change: Note compatibility through WP 5.3+
* Change: Update copyright date (2020)
* Change: Update License URI to be HTTPS
* Change: Split paragraph in README.md's "Support" section into two

_Full changelog is available in [CHANGELOG.md](https://github.com/coffee2code/hide-broken-shortcodes/blob/master/CHANGELOG.md)._


== Upgrade Notice ==

= 1.9.2 =
Trivial update: Restructured unit test file structure and noted compatibility through WP 5.5+.

= 1.9.1 =
Trivial update: Added TODO.md file, updated a few URLs to be HTTPS, added more inline documentation, and noted compatibility through WP 5.4+.

= 1.9 =
Minor update: extended support to recognize shortcodes of 1 or 2 characters in length, tweaked plugin initialization, noted compatibility through WP 5.3+, created CHANGELOG.md to store historical changelog outside of readme.txt, and updated copyright date (2020)

= 1.8.2 =
Trivial update: noted compatibility through WP 4.9+, added README.md for GitHub, updated copyright date (2018), and other minor changes

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
