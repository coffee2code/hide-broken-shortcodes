=== Hide Broken Shortcodes ===
Contributors: coffee2code
Donate link: http://coffee2code.com/donate
Tags: shortcode, shortcodes, content, post, page, coffee2code
Requires at least: 2.5
Tested up to: 2.9.1
Stable tag: 1.1
Version: 1.1

Prevent broken shortcodes from appearing in posts and pages.

== Description ==

Prevent broken shortcodes from appearing in posts and pages.

Shortcodes are a handy feature of WordPress allowing for a simple markup-like syntax to be used within post and page content, such that a handler function will replace the shortcode with desired content.  For instance, this:
    `[youtube id="abc" width="200"]`
might be replaced by a plugin to embed a YouTube video into the post with a width of 200.  Or:
    `[make_3d]Special News[/make_3d]`
might be used to make a three-dimensional image of the text contained in the shortcode tag, 'Special News'.

By default, if the plugin that provides the functionality to handle any given shortcode tag is disabled, or if a shortcode is improperly defined in the content (such as with a typo), then the shortcode in question appears on the blog in its entirety, unprocessed by WordPress.  At best this reveals unsightly code-like text to visitors and at worst can potentially expose information not intended for visitors' eyes.

This plugin prevents unhandled shortcodes from appearing in the content of a post or page. If the shortcode is of the self-closing variety (the first example above), then the shortcode tag and its attributes are not displayed and nothing is shown in their place.  If the shortcode is of the enclosing variety (the second example above), then the text that is being enclosed will be shown, but the shortcode tag and attributes that surround the text will not be displayed (e.g. in the second example above, "Special News" will still be displayed on the site).

A filter is also available by the name of 'hide_broken_shortcode' that allows you to customize what, if anything, gets displayed when a broken shortcode is encountered.  Your hooking function can be sent 3 arguments:

* The default display text (what the plugin would display by default)
* The name of the shortcode
* The text bookended by opening and closing broken shortcodes, if present

Example:

	`add_filter('hide_broken_shortcode', 'hbs_handler', 10, 3);
	function hbs_handler($default, $tag, $content) {
		return ''; // Don't show the shortcode or text bookended by the shortcode
	}`

== Installation ==

1. Unzip `hide-broken-shortcodes.zip` inside the `/wp-content/plugins/` directory for your site (or install via the built-in WordPress plugin installer)
1. Activate the plugin through the 'Plugins' admin menu in WordPress
1. Optionally filter 'hide_broken_shortcode' if you want to customize the behavior of the plugin

== Changelog ==

= 1.1 =
* Create filter 'hide_broken_shortcode' to allow customization of the output for broken shortcodes
* Now also filter widget_text
* Add PHPDoc documentation
* Note compatibility with WP 2.9+
* Update copyright date

= 1.0 =
* Initial release