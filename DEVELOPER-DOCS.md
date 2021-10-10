# Developer Documentation

## Hooks

The plugin exposes a number of filters for hooking. Code using these filters should ideally be put into a mu-plugin or site-specific plugin (which is beyond the scope of this readme to explain).

### `hide_broken_shortcode` _(filter)_

The `hide_broken_shortcode` filter allows you to customize what, if anything, gets displayed when a broken shortcode is encountered. Your hooking function can be sent 3 arguments:

#### Arguments :

* **$default** _(string)_  : The default display text (what the plugin would display by default).
* **$shortcode** _(string)_: The name of the shortcode.
* The text bookended by opening and closing broken shortcodes, if present.

#### Example:

```php
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
```

### `hide_broken_shortcodes_filters` _(filter)_

The `hide_broken_shortcodes_filters` filter allows you to customize what filters to hook to find text with potential broken shortcodes. The three default filters are `the_content`, `the_excerpt`, and `widget_text`. Your hooking function will only be sent one argument: the array of filters.

Example:

```php
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
```
