import { RichText } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';


const Item = ({ dataId, title, content, onChangeItemTitle, onChangeItemContent, onRemoveItem }) => {
    return (
        <div className="accordion__item open-accordion-item" data-id={`contactBlock-${dataId}`}>
            <RichText
                tagName="div"
                placeholder="Add item title"
                className="accordion__item-main"
                value={title}
                onChange={(title) => onChangeItemTitle(title, dataId)}
            />
            <RichText
                tagName="p"
                className="accordion__item-content mb-0"
                placeholder="Add block content"
                value={content}
                onChange={(content) => onChangeItemContent(content, dataId)}
            />
            <Button
                onClick={() => onRemoveItem(dataId)}
                className="removeBtn components-button mt-2 mb-2 me-2"
                variant={'secondary'}
                isDestructive
                icon="no-alt"
            >
                Remove Item
            </Button>
        </div>
    )
}

export default Item;