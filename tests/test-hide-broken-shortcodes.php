<?php

class Hide_Broken_Shortcodes_Test extends WP_UnitTestCase {

	function setUp() {
		parent::setUp();

		add_shortcode( 'abcabc', array( $this, 'handle_shortcode' ) );
	}

	function tearDown() {
		parent::tearDown();

		remove_shortcode( 'abcabc' );

		remove_filter( 'hide_broken_shortcode',          array( $this, 'prevent_shortcode_hiding' ), 10, 3 );
		remove_filter( 'hide_broken_shortcodes_filters', array( $this, 'filter_the_title' ) );
	}


	/*
	 *
	 * DATA PROVIDERS
	 *
	 */


	function text_shortcode_without_content() {
		return array(
			array( 'This contains [unknown] shortcode.' ),
			array( 'This contains [unknown/] shortcode.' ),
			array( 'This contains [unknown aaa="dog"] shortcode.'),
			array( 'This contains [unknown aaa="dog" /] shortcode.'),
			array( 'This contains [unknown][/unknown] shortcode.'),
		);
	}

	function text_shortcode_with_content() {
		return array(
			array( 'This contains [unknown]abc[/unknown] shortcode.'),
			array( 'This contains [unknown aaa="emu"]abc[/unknown] shortcode.'),
		);
	}

	function default_filters() {
		return array(
			array( 'the_content' ),
			array( 'the_excerpt' ),
			array( 'widget_text' ),
		);
	}


	/*
	 *
	 * HELPER FUNCTIONS
	 *
	 */


	function handle_shortcode( $atts, $content = null ) {
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

	function prevent_shortcode_hiding( $default_display, $shortcode_name, $match_array ) {
		$shortcodes_not_to_hide = array( 'unknown' );
		if ( in_array( $shortcode_name, $shortcodes_not_to_hide ) ) {
			$display = $match_array[0];
		}
		return $display;
	}

	function filter_the_title( $filters ) {
		$filters[] = 'the_title';
		return $filters;
	}


	/*
	 *
	 * TESTS
	 *
	 */


	function test_version() {
		$this->assertEquals( '1.7', c2c_HideBrokenShortcodes::version() );
	}

	/**
	 * @dataProvider default_filters
	 */
	function test_hooks_default_filter( $filter ) {
		$this->assertEquals( 1001, has_filter( $filter, array( 'c2c_HideBrokenShortcodes', 'do_shortcode' ) ) );
	}

	/**
	 * @dataProvider text_shortcode_without_content
	 */
	function test_hooks_custom_filter( $text ) {
		$this->assertEquals( apply_filters( 'the_title', $text ), apply_filters( 'the_title', $text ) );

		add_filter( 'hide_broken_shortcodes_filters', array( $this, 'filter_the_title' ) );
		c2c_HideBrokenShortcodes::register_filters(); // Pretend the filter was added before plugin initialized.

		$this->assertEquals( 'This contains  shortcode.', apply_filters( 'the_title', $text ) );
	}

	function test_handled_shortcode_not_affected() {
		$this->assertEquals( 'hello (fox)', do_shortcode( 'hello [abcabc aaa="fox"]' ) );
		$this->assertEquals( '(fox)', trim( apply_filters( 'the_content', '[abcabc aaa="fox"]' ) ) );
		$this->assertEquals( '(hippo)hiphop(end)', trim( apply_filters( 'the_content', '[abcabc aaa="hippo"]hiphop[/abcabc]' ) ) );
	}

	/**
	 * @dataProvider text_shortcode_without_content
	 */
	function test_unhandled_shortcodes_without_content_get_hidden( $text ) {
		$this->assertEquals( 'This contains  shortcode.', apply_filters( 'widget_text', $text ) );
	}

	/**
	 * @dataProvider text_shortcode_with_content
	 */
	function test_unhandled_shortcodes_witb_content_get_hidden_but_content_remains( $text ) {
		$this->assertEquals( 'This contains abc shortcode.', apply_filters( 'widget_text', $text ) );
	}

	/**
	 * @dataProvider text_shortcode_without_content
	 */
	function test_filter_to_prevent_unhandled_shortcodes_from_getting_hidden( $text ) {
		add_filter( 'hide_broken_shortcode', array( $this, 'prevent_shortcode_hiding' ), 10, 3 );

		$this->assertEquals( $text, apply_filters( 'widget_text', $text ) );
	}

	/**
	 * @dataProvider text_shortcode_with_content
	 */
	function test_filter_to_prevent_unhandled_shortcodes_with_content_from_getting_hidden( $text ) {
		add_filter( 'hide_broken_shortcode', array( $this, 'prevent_shortcode_hiding' ), 10, 3 );

		$this->assertEquals( $text, apply_filters( 'widget_text', $text ) );
	}

}
