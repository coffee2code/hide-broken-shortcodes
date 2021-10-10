<?php

defined( 'ABSPATH' ) or die();

class Hide_Broken_Shortcodes_Test extends WP_UnitTestCase {

	public function setUp() {
		parent::setUp();

		add_shortcode( 'abcabc', array( $this, 'handle_shortcode' ) );
		add_shortcode( 'b',      array( $this, 'handle_shortcode' ) );
	}

	public function tearDown() {
		parent::tearDown();

		remove_shortcode( 'abcabc' );
		remove_shortcode( 'b' );
	}


	//
	//
	// DATA PROVIDERS
	//
	//


	public function text_shortcode_without_content() {
		return array(
			array( 'This contains [unknown] shortcode.' ),
			array( 'This contains [unknown/] shortcode.' ),
			array( 'This contains [unknown aaa="dog"] shortcode.'),
			array( 'This contains [unknown aaa="dog" /] shortcode.'),
			array( 'This contains [unknown aaa=\'dog\' /] shortcode.'),
			array( 'This contains [unknown][/unknown] shortcode.'),
			array( 'This contains [tp][/tp] shortcode.'),
			array( 'This contains [i][/i] shortcode.'),
		);
	}

	public function text_shortcode_with_content() {
		return array(
			array( 'This contains [unknown]abc[/unknown] shortcode.'),
			array( 'This contains [unknown aaa="emu"]abc[/unknown] shortcode.'),
			array( 'This contains [unknown aaa=\'emu\']abc[/unknown] shortcode.'),
			array( 'This contains [tp]abc[/tp] shortcode.'),
			array( 'This contains [i]abc[/i] shortcode.'),
		);
	}

	public function default_filters() {
		return array(
			array( 'the_content' ),
			array( 'the_excerpt' ),
			array( 'widget_text' ),
		);
	}


	//
	//
	// HELPER FUNCTIONS
	//
	//


	public function handle_shortcode( $atts, $content = null ) {
		$defaults = array(
			'aaa' => 'cat',
			'bbb' => '',
		);
		$atts = shortcode_atts( $defaults, $atts );

		$ret = '(' . $atts['aaa'];
		if ( $atts['bbb'] )
			$ret .= "," . $atts['bbb'];
		$ret .= ')';

		if ( $content )
			$ret .= $content . '(end)';

		return $ret;
	}

	public function prevent_shortcode_hiding( $default_display, $shortcode_name, $match_array ) {
		$shortcodes_not_to_hide = array( 'i', 'tp', 'unknown' );
		$display = '';
		if ( in_array( $shortcode_name, $shortcodes_not_to_hide ) ) {
			$display = $match_array[0];
		}
		return $display;
	}

	public function filter_the_title( $filters ) {
		$filters[] = 'the_title';
		return $filters;
	}


	//
	//
	// TESTS
	//
	//


	public function test_class_exists() {
		$this->assertTrue( class_exists( 'c2c_HideBrokenShortcodes' ) );
	}

	public function test_version() {
		$this->assertEquals( '1.9.4', c2c_HideBrokenShortcodes::version() );
	}

	/**
	 * @dataProvider default_filters
	 */
	public function test_hooks_default_filter( $filter ) {
		$this->assertEquals( 1001, has_filter( $filter, array( 'c2c_HideBrokenShortcodes', 'do_shortcode' ) ) );
	}

	public function test_hooks_plugins_loaded() {
		$this->assertEquals( 10, has_action( 'plugins_loaded', array( 'c2c_HideBrokenShortcodes', 'init' ) ) );
	}


	/**
	 * @dataProvider text_shortcode_without_content
	 */
	public function test_hooks_custom_filter( $text ) {
		$this->assertEquals( apply_filters( 'the_title', $text ), apply_filters( 'the_title', $text ) );

		add_filter( 'hide_broken_shortcodes_filters', array( $this, 'filter_the_title' ) );
		c2c_HideBrokenShortcodes::register_filters(); // Pretend the filter was added before plugin initialized.

		$this->assertEquals( 'This contains  shortcode.', apply_filters( 'the_title', $text ) );
	}

	public function test_handled_shortcode_not_affected() {
		$this->assertEquals( 'hello (fox)', do_shortcode( 'hello [abcabc aaa="fox"]' ) );
		$this->assertEquals( '(fox)', trim( apply_filters( 'the_content', '[abcabc aaa="fox"]' ) ) );
		$this->assertEquals( '(hippo)hiphop(end)', trim( apply_filters( 'the_content', '[abcabc aaa="hippo"]hiphop[/abcabc]' ) ) );

		$this->assertEquals( 'hello (fox)', do_shortcode( 'hello [b aaa="fox"]' ) );
		$this->assertEquals( '(fox)', trim( apply_filters( 'the_content', '[b aaa="fox"]' ) ) );
		$this->assertEquals( '(hippo)hiphop(end)', trim( apply_filters( 'the_content', '[b aaa="hippo"]hiphop[/b]' ) ) );
	}

	public function test_shortcode_escape_notation_not_affected() {
		$text     = 'Use [[shortcode]] like so.';
		$expected = 'Use [shortcode] like so.';

		$this->assertEquals( wpautop( $expected ), apply_filters( 'the_content', $text ) );
	}

	public function test_does_not_affect_bracket_usage_within_html_tags() {
		$html = array(
			'<input type="text" name="hello[world]" />',
			'<input type="text" name="hello[\'world\']" />',
			"<input type='text' name='hello[\"world\"]' />",
			"<span class='example' title='What if cart[qty] were here?'>Test</span>",
			'<span class="example" title="What if cart[\'qty\'] were here?">Test</span>',
			'<span class="example" title="What if cart[\"qty\"] were here?">Test</span>',
			'<span class="example" title="What if cart[qty name="yes"] were here?">Test</span>',
			"If this <cat[qty]>.",
		);

		foreach ( $html as $h ) {
			$this->assertEquals( wpautop( $h ), apply_filters( 'the_content', $h ) );
		}
	}

	public function test_does_not_affect_bracketed_integers() {
		$html = array(
			'See [1] for more info.',
			'There are [45] here.',
			'There are [ 16 ] here.',
		);

		foreach ( $html as $h ) {
			$this->assertEquals( wpautop( $h ), apply_filters( 'the_content', $h ) );
		}
	}

	public function test_does_not_affect_bracketed_quoted_strings() {
		$html = array(
			'Code example of $cat["name"]',
			'Code example of $cat[ "name" ]',
			"Give it a name of cart[{\$cart_item_key}]['qty']",
			"Give it a name of cart[ {\$cart_item_key} ][ 'qty' ]",
		);

		foreach ( $html as $h ) {
			$this->assertEquals( wpautop( wptexturize( $h ) ), apply_filters( 'the_content', $h ) );
		}
	}

	public function test_does_not_affect_bracketed_variable() {
		$html = array(
			'Code example of [$cat].',
			'Give it a name of $cart[ $cat_food ]',
		);

		foreach ( $html as $h ) {
			$this->assertEquals( wpautop( $h ), apply_filters( 'the_content', $h ) );
		}
	}

	public function test_does_not_affect_empty_brackets() {
		$html = array(
			'Code example of [].',
			"Give it a name of cart[{\$cart_item_key}][]",
		);

		foreach ( $html as $h ) {
			$this->assertEquals( wpautop( $h ), apply_filters( 'the_content', $h ) );
		}
	}

	public function test_does_not_affect_html_comments() {
		$html = array(
			'<![CDATA[Some text]]>',
			'<!-- This is [some] text -->',
		);

		foreach ( $html as $h ) {
			$this->assertEquals( wpautop( $h ), apply_filters( 'the_content', $h ) );
		}
	}

	/**
	 * @dataProvider text_shortcode_without_content
	 */
	public function test_unhandled_shortcodes_without_content_get_hidden( $text ) {
		$this->assertEquals( 'This contains  shortcode.', apply_filters( 'widget_text', $text ) );
	}

	/**
	 * @dataProvider text_shortcode_with_content
	 */
	public function test_unhandled_shortcodes_witb_content_get_hidden_but_content_remains( $text ) {
		$this->assertEquals( 'This contains abc shortcode.', apply_filters( 'widget_text', $text ) );
	}

	/**
	 * @dataProvider text_shortcode_without_content
	 */
	public function test_filter_to_prevent_unhandled_shortcodes_from_getting_hidden( $text ) {
		add_filter( 'hide_broken_shortcode', array( $this, 'prevent_shortcode_hiding' ), 10, 3 );

		$this->assertEquals( $text, apply_filters( 'widget_text', $text ) );
	}

	/**
	 * @dataProvider text_shortcode_with_content
	 */
	public function test_filter_to_prevent_unhandled_shortcodes_with_content_from_getting_hidden( $text ) {
		add_filter( 'hide_broken_shortcode', array( $this, 'prevent_shortcode_hiding' ), 10, 3 );

		$this->assertEquals( $text, apply_filters( 'widget_text', $text ) );
	}

	/*
	 * get_shortcode_regex()
	 */

	// This is primarily just to test that the regex isn't unintentionally tweaked
	// in such a way that isn't caught by other tests.
	public function test_get_shortcode_regex() {
		$expected = '(?!<.*)\[(\[?)([a-zA-Z_\-][0-9a-zA-Z_\-\+]*)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)(?![^<>]*>)';

		$this->assertEquals( $expected, c2c_HideBrokenShortcodes::get_shortcode_regex() );
	}
}
