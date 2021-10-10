# Changelog

## 1.9.4 _(2021-10-09)_
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

## 1.9.3 _(2021-04-18)_
* Change: Note compatibility through WP 5.7+
* Change: Update copyright date (2021)

## 1.9.2 _(2020-09-06)_
* Change: Restructure unit test file structure
    * New: Create new subdirectory `phpunit/` to house all files related to unit testing
    * Change: Move `bin/` to `phpunit/bin/`
    * Change: Move `tests/bootstrap.php` to `phpunit/`
    * Change: Move `tests/` to `phpunit/tests/`
    * Change: Rename `phpunit.xml` to `phpunit.xml.dist` per best practices
* Change: Note compatibility through WP 5.5+

## 1.9.1 _(2020-08-04)_
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

## 1.9 _(2019-12-09)_
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

## 1.8.2 _(2018-06-29)_
* New: Bail early if text doesn't contain a square bracket (and thus no shortcodes)
* New: Add README.md
* New: Add unit tests for square brackets in HTML comments
* New: Add GitHub link to readme
* Change: Minor whitespace tweaks to unit test bootstrap
* Change: Add item to FAQ
* Change: Rename readme.txt section from 'Filters' to 'Hooks'
* Change: Modify formatting of hook name in readme to prevent being uppercased when shown in the Plugin Directory
* Change: Note compatibility through WP 4.9+
* Change: Update copyright date (2018)

## 1.8.1 _(2017-02-08)_
* Change: Default `WP_TESTS_DIR` to `/tmp/wordpress-tests-lib` rather than erroring out if not defined via environment variable.
* Change: Enable more error output for unit tests.
* Change: Add more unit tests.
* Change: Note compatibility through WP 4.7+.
* Change: Miscellaneous readme.txt improvements.
* Change: Minor code documentation reformatting.
* Change: Update copyright date (2017).
* New: Add LICENSE file.

## 1.8 _(2016-05-21)_
* Bugfix: Don't attempt to hide shortcodes (or what may look like shortcodes) appearing within HTML tags.
* New: Add unit test to ensure shortcode escape notation is not hidden by the plugin.
* Change: Prevent web invocation of unit test bootstrap.php.
* Change: Note compatibility through WP 4.5+.

## 1.7.1 _(2016-01-27)_
* Change: Register hooks during `plugins_loaded` instead of `init`.
* New: Add support for language packs:
    * Define 'Text Domain' header attribute.
    * Load textdomain.
* New: Create empty index.php to prevent files from being listed if web server has enabled directory listings.
* Change: Note compatibility through WP 4.4+.
* Change: Explicitly declare methods in unit tests as public.
* Change: Update copyright date (2016).

## 1.7 _(2015-04-02)_
* Enhancement: Filter `the_excerpt` by default as well
* Update: Add more unit tests
* Update: Note compatibility through WP 4.2+
* Update: Add inline documentation to examples in readme.txt
* Update: Minor inline documentation tweaks (spacing, formatting)

## 1.6.3 _(2015-02-14)_
* Add trivial unit test for plugin version
* Note compatibility through WP 4.1+
* Update copyright date (2015)

## 1.6.2 _(2014-08-30)_
* Minor plugin header reformatting
* Minor code reformatting (bracing)
* Change documentation links to wp.org to be https
* Note compatibility through WP 4.0+
* Add plugin icon

## 1.6.1 _(2013-12-29)_
* Add unit tests
* Note compatibility through WP 3.8+
* Update copyright date (2014)
* Minor readme.txt tweaks
* Change donate link
* Add banner

## 1.6
* Update regex to allow hyphens in shortcode names (syncing changes made in WP 3.5)
* Add check to prevent execution of code if file is directly accessed
* Note compatibility through WP 3.5+
* Update copyright date (2013)

## 1.5
* Recursively hide nested broken shortcodes
* Re-license as GPLv2 or later (from X11)
* Add 'License' and 'License URI' header tags to readme.txt and plugin file
* Remove ending PHP close tag
* Note compatibility through WP 3.4+
* Fix error in example code in readme.txt

## 1.4
* Update `get_shortcode_regex()` and `do_shortcode_tag()` to support shortcode escape syntax
* NOTE: The preg match array sent via the `hide_broken_shortcode` filter has changed and requires you to update any code that hooks it
* Add `version()` to return plugin version
* Note compatibility through WP 3.3+
* Add Frequently Asked Questions section to readme.txt
* Add link to plugin directory page to readme.txt
* Update copyright date (2012)

## 1.3.1
* Note compatibility through WP 3.2+
* Minor code formatting changes (spacing, variable removal)
* Fix plugin homepage and author links in description in readme.txt

## 1.3
* Switch from object instantiation to direct class invocation
* Explicitly declare all functions public static
* Note compatibility through WP 3.1+
* Update copyright date (2011)

## 1.2
* Allow customization of the filters the plugin applies to via the `hide_broken_shortcodes_filters` filter
* Change `do_shortcode` filter priority from 12 to 1001 (to avoid incompatibility with Preserve Code Formatting, and maybe others)
* Move registering filters into `register_filters()`
* Rename class from `HideBrokenShortcodes` to `c2c_HideBrokenShortcodes`
* Store plugin instance in global variable, `$c2c_hide_broken_shortcodes`, to allow for external manipulation
* Note compatibility with WP 3.0+
* Minor code reformatting (spacing)
* Add Filters and Upgrade Notice sections to readme.txt
* Remove all header documentation and instructions from plugin file (all that and more are in readme.txt)
* Remove trailing whitespace from header docs

## 1.1
* Create filter `hide_broken_shortcode` to allow customization of the output for broken shortcodes
* Now also filter widget_text
* Add PHPDoc documentation
* Note compatibility with WP 2.9+
* Update copyright date

## 1.0
* Initial release
