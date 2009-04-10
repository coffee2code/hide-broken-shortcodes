=== Hide Broken Shortcodes ===
Contributors: Scott Reilly
Donate link: http://coffee2code.com
Tags: shortcode, content, post, page
Requires at least: 2.5
Tested up to: 2.7.1
Stable tag: trunk
Version: 1.0

Prevent broken shortcodes from appearing in posts and pages.

== Description ==

Prevent broken shortcodes from appearing in posts and pages.

Shortcodes are a handy feature of WordPress allowing for a simple markup-like syntax to be used within post and page content, such that a handler function will replace the shortcode with desired content.  For instance, this:
    `[youtube id="abc" width="200"]`
might be replaced by a plugin to embed a YouTube video into the post with a width of 200.  Or:
    `[make_3d]Special News[/make_3d]`
might be used to make a three-dimensional image of the text contained in the shortcode tag, 'Special News'.

By default, if the plugin that provides the functionality to handle any given shortcode tag is disabled, or if a shortcode is improperly defined in the content (such as with a typo), then the shortcode in question appears on the blog in its entirety, unprocessed by WordPress.  At best this reveals unsightly code-like text to visitors and at worst can potentially expose information not intended for visitor's eyes.

This plugin prevents unhandled shortcodes from appearing in the content of a post or page. If the shortcode is of the self-closing variety (the first example above), then the shortcode tag and its attributes are not displayed and nothing is shown in their place.  If the shortcode is of the enclosing variety (the second example above), then the text that is being enclosed will be shown, but the shortcode tag and attributes that surround the text will not be displayed (e.g. in the second example above, "Special News" will still be displayed on the site).


== Installation ==

1. Unzip `hide-broken-shortcodes-v1.0.zip` inside the `/wp-content/plugins/` directory for your site
1. Activate the plugin through the 'Plugins' admin menu in WordPress

