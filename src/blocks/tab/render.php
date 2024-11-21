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

?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="tabs"
>
	<div class="wp-block-tabs-tab__content">
		<?php echo $content; ?>
	</div>

</div>
