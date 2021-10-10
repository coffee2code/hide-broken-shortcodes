# TODO

The following list comprises ideas, suggestions, and known issues, all of which are in consideration for possible implementation in future releases.

***This is not a roadmap or a task list.*** Just because something is listed does not necessarily mean it will ever actually get implemented. Some might be bad ideas. Some might be impractical. Some might either not benefit enough users to justify the effort or might negatively impact too many existing users. Or I may not have the time to devote to the task.

* Add an action, `hide_broken_shortcodes_found_broken_shortcode`, that can be hooked for logging where broken shortcodes are encountered (though maybe it would just be easier to setup a cron process to go through all posts and directly check for broken shortcodes)
* (by request): add optional mode for tracking and reporting encountered broken shortcodes and what posts they were in
* Add donate to plugin row links
* Add Gutenberg support: modify shortcode block to denote that the shortcode it contains is broken, checking in real-time (delayed after last imput)
* Don't hide anything within code tags
* Add settings UI for inputting custom filters that the plugin should apply to (basically a UI for the `hide_broken_shortcodes_filters` filter)
* Merge `register_filters()` into `init()`

Feel free to make your own suggestions or champion for something already on the list (via the [plugin's support forum on WordPress.org](https://wordpress.org/support/plugin/hide-broken-shortcodes/) or on [GitHub](https://github.com/coffee2code/hide-broken-shortcodes/) as an issue or PR).
