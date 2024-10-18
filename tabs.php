<?php
/**
 * Plugin Name:       Tabs
 * Description:       Tabs block created using the Interactivity API.
 * Version:           0.1.0
 * Requires at least: 6.6
 * Requires PHP:      7.2
 * Author:            djuric
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       tabs
 *
 * @package           tabs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers multiple block types from metadata loaded from a file.
 */
add_action(
	'init',
	function () {
		$build_dir = __DIR__ . '/build/blocks';

		if ( ! file_exists( $build_dir ) ) {
			return;
		}

		$block_json_files = glob( $build_dir . '/*/block.json' );

		foreach ( $block_json_files as $block_json_file ) {
			register_block_type( dirname( $block_json_file ) );
		}
	}
);

/**
 * Fix for Dashicons styles bug
 * See https://github.com/WordPress/gutenberg/issues/53528
 */
add_action(
	'enqueue_block_assets',
	function () {
		wp_enqueue_style( 'dashicons' );
	}
);
