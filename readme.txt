=== Hide Broken Shortcodes ===
Contributors: coffee2code
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6ARCFJ9TX3522
Tags: shortcode, shortcodes, content, post, page, coffee2code
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 2.5
Tested up to: 5.8
Stable tag: 1.9.4

Prevent broken shortcodes from appearing in posts and pages.


== Description ==

By default in WordPress, if the plugin that provides the functionality to handle any given shortcode is disabled, or if a shortcode is improperly defined in the content (such as with a typo), then the shortcode in question will appear on the site in its entirety, unprocessed by WordPress. At best this reveals unsightly code-like text to visitors and at worst can potentially expose information not intended to be seen by visitors.

This plugin prevents unhandled shortcodes from appearing in the content of a post or page. If the shortcode is of the self-closing variety, then the shortcode tag and its attributes are not displayed and nothing is shown in their place. If the shortcode is of the enclosing variety (an opening and closing tag bookend some text or markup), then the text that is being enclosed will be shown, but the shortcode tag and attributes that surround the text will not be displayed.

See the Filters section for more customization tips.

Links: [Plugin Homepage](https://coffee2code.com/wp-plugins/hide-broken-shortcodes/) | [Plugin Directory Page](https://wordpress.org/plugins/hide-broken-shortcodes/) | [GitHub](https://github.com/coffee2code/hide-broken-shortcodes/) | [Author Homepage](https://coffee2code.com)


== Installation ==

1. Install via the built-in WordPress plugin installer. Or install the plugin code inside the plugins directory for your site (typically `/wp-content/plugins/`).
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


== Developer Documentation ==

Developer documentation can be found in [DEVELOPER-DOCS.md](https://github.com/coffee2code/hide-broken-shortcodes/blob/master/DEVELOPER-DOCS.md). That documentation covers the hooks provided by the plugin.

As an overview, these are the hooks provided by the plugin:

* `hide_broken_shortcode`          : Customizes what, if anything, gets displayed when a broken shortcode is encountered.
* `hide_broken_shortcodes_filters` : Customizes what filters to hook to find text with potential broken shortcodes.


== Changelog ==

= 1.9.4 (2021-10-09) =
* New: Add DEVELOPER-DOCS.md and move hooks documentation into it
* Change: Note compatibility through WP 5.8+
* Change: Tweak installation instruction
* Change: Tweak TODO entry
* Unit tests:
    * Change: Restructure unit test directories
        * Change: Move `phpunit/` into `tests/`
        * Change: Move `phpunit/bin` into `tests/`
    * Change: Remove 'test-' prefix from unit test file
    * Change: In bootstrap, store path to plugin file constant
    * Change: In bootstrap, add backcompat for PHPUnit pre-v6.0

= 1.9.3 (2021-04-18) =
* Change: Note compatibility through WP 5.7+
* Change: Update copyright date (2021)

= 1.9.2 (2020-09-06) =
* Change: Restructure unit test file structure
    * New: Create new subdirectory `phpunit/` to house all files related to unit testing
    * Change: Move `bin/` to `phpunit/bin/`
    * Change: Move `tests/bootstrap.php` to `phpunit/`
    * Change: Move `tests/` to `phpunit/tests/`
    * Change: Rename `phpunit.xml` to `phpunit.xml.dist` per best practices
* Change: Note compatibility through WP 5.5+

_Full changelog is available in [CHANGELOG.md](https://github.com/coffee2code/hide-broken-shortcodes/blob/master/CHANGELOG.md)._


== Upgrade Notice ==

= 1.9.4 =
Trivial update: added DEVELOPER-DOCS.md, noted compatibility through WP 5.8+, and minor reorganization and tweaks to unit tests

= 1.9.3 =
Trivial update: noted compatibility through WP 5.7+ and updated copyright date (2021)

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
