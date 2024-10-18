/**
 * WordPress dependencies.
 */
import { useBlockProps, InnerBlocks } from "@wordpress/block-editor";

export default function Edit({ attributes, context }) {
  const blockProps = useBlockProps();

  return (
    <div {...blockProps}>
      <div className="wp-block-tabs-tab__content" hidden={context["tabs/activeTabId"] !== attributes.id}>
        <InnerBlocks />
      </div>
    </div>
  );
}
