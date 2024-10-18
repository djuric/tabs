/**
 * WordPress dependencies.
 */
import { __ } from "@wordpress/i18n";
import { Button } from "@wordpress/components";
import { useBlockProps, InnerBlocks, RichText } from "@wordpress/block-editor";
import { withSelect, withDispatch } from "@wordpress/data";
import { createBlock } from "@wordpress/blocks";
import { useEffect } from "@wordpress/element";
import { compose } from "@wordpress/compose";

const generateUniqueId = (label, existingIds) => {
  let baseId = label.toLowerCase().replace(/[^a-z0-9]/g, '-');

  // Ensure the baseId is unique by appending a suffix if needed
  let uniqueId = baseId;
  let counter = 1;

  while (existingIds.includes(uniqueId)) {
      uniqueId = `${baseId}-${counter}`;
      counter++;
  }

  return uniqueId;
};

function Edit({
  clientId,
  attributes,
  setAttributes,
  innerBlocks,
  setInnerBlockAttributes,
  selectBlock,
  insertBlock,
}) {
  const blockProps = useBlockProps();

  useEffect(() => {
    const currentInnerBlockIds = innerBlocks.map((block) => block.attributes.id);
  
    // Newly added empty tab.
    const newInnerBlockWithoutId = innerBlocks.find(
      (block) => block.attributes.id === ""
    );

    if(newInnerBlockWithoutId) {
      const ublockid = generateUniqueId(newInnerBlockWithoutId.attributes.label, currentInnerBlockIds);

      setInnerBlockAttributes(newInnerBlockWithoutId.clientId, {
        attributes: {
          id: ublockid
        },
      });
    }
  }, [innerBlocks.length]);

  const openTab = (block) => {
    setAttributes({ activeTabId: block.attributes.id });
    if (block.innerBlocks.length === 0) {
      insertBlock(createBlock("core/paragraph"), null, block.clientId);
    }
  };

  const navItemClassName = "wp-block-tabs-tabs__navigation-item";

  return (
    <div {...blockProps}>
      <div className="wp-block-tabs-tabs__navigation">
        {innerBlocks.map((block, index) => (
          <RichText
            key={index}
            tagName="div"
            value={block.attributes.label}
            allowedFormats={[]}
            className={
              block.attributes.id === attributes.activeTabId
                ? `${navItemClassName} active`
                : navItemClassName
            }
            onChange={(label) =>
              setInnerBlockAttributes(block.clientId, {
                attributes: { label, id: generateUniqueId(label, innerBlocks.map((b) => b.attributes.id)) },
              })
            }
            onClick={() => openTab(block)}
          />
        ))}
        <div className={`${navItemClassName} ${navItemClassName}--add`}>
          <Button
            variant="tertiary"
            size="small"
            icon="plus"
            onClick={() => {
              insertBlock(
                createBlock("tabs/tab", {
                  label: __("Tab", "tabs"),
                }),
                innerBlocks.length,
                clientId
              );
              selectBlock(clientId);
            }}
          />
        </div>
      </div>
      <InnerBlocks />
    </div>
  );
}

export default compose([
  withSelect((select, props) => ({
    innerBlocks: select("core/block-editor").getBlocks(props.clientId),
  })),
  withDispatch((dispatch) => ({
    setInnerBlockAttributes: (clientId, attributes) =>
      dispatch("core/block-editor").updateBlock(clientId, attributes),
    insertBlock: (block, index, clientId) =>
      dispatch("core/block-editor").insertBlock(block, index, clientId),
    selectBlock: (clientId) =>
      dispatch("core/block-editor").selectBlock(clientId),
  })),
])(Edit);
