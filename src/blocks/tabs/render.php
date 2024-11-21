<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

$first_tab_id  = $block->parsed_block['innerBlocks'][0]['attrs']['id'];
$active_tab_id = ! empty( $_GET['tab'] ) ? $_GET['tab'] : $first_tab_id;

$tabs = [];

foreach ( $block->parsed_block['innerBlocks'] as $innerblock ) {
	$tabs[] = [
		'id'       => $innerblock['attrs']['id'],
		'label'    => $innerblock['attrs']['label'] ?? __( 'Tab', 'tabs' ),
		'isActive' => $innerblock['attrs']['id'] === $active_tab_id,
	];
}

$tab_content = array_filter(
	$block->parsed_block['innerBlocks'],
	function ( $innerblock ) use ( $active_tab_id ) {
		return $innerblock['attrs']['id'] === $active_tab_id;
	}
);

?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="tabs"
	<?php
	echo wp_interactivity_data_wp_context(
		[
			'tabs' => $tabs,
		]
	);
	?>
	data-wp-router-region="<?php echo wp_unique_id( 'tabs-' ); ?>"
>
	<div class="wp-block-tabs-tabs__navigation">
		<?php foreach ( $tabs as $tab ) : ?>
			<div data-wp-on--click="actions.open" class="<?php echo $tab['isActive'] ? 'wp-block-tabs-tabs__navigation-item active' : 'wp-block-tabs-tabs__navigation-item'; ?>" data-id="<?php echo $tab['id']; ?>"><?php echo $tab['label']; ?></div>
		<?php endforeach; ?>
	</div>

	<div class="wp-block-tabs-tabs__content">
		<?php echo render_block( array_pop( $tab_content ) ); ?>
	</div>

</div>
