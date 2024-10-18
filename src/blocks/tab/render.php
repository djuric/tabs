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

wp_interactivity_state(
	'tabs',
	array(
		'isInternalTabActive' => function () {
			$context = wp_interactivity_get_context();

			return $context['activeTabId'] === $context['id'];
		},
	)
);

?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="tabs"
	<?php echo wp_interactivity_data_wp_context( [ 'id' => $attributes['id'] ] ); ?>
>
	<div class="wp-block-tabs-tab__content" data-wp-bind--hidden="!state.isInternalTabActive">
		<?php echo $content; ?>
	</div>

</div>
