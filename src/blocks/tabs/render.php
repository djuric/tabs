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

?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="tabs"
	<?php
	echo wp_interactivity_data_wp_context(
		[
			'tabs'        => $tabs,
			'activeTabId' => $active_tab_id,
		]
	);
	?>
	data-wp-router-region="<?php echo wp_unique_id( 'tabs-' ); ?>"
>
	<div class="wp-block-tabs-tabs__navigation">
		<template data-wp-each--tab="context.tabs" data-wp-each-key="context.tab.id">
			<div class="wp-block-tabs-tabs__navigation-item" data-wp-on--click="actions.open" data-wp-text="context.tab.label" data-wp-class--active="context.tab.isActive"></div>
		</template>
	</div>

	<div class="wp-block-tabs-tabs__content">
		<?php echo $content; ?>
	</div>

</div>
