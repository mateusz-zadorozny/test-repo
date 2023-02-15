/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';


import Item from './item';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

import { Accordion, Card } from "react-bootstrap";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit(props) {
	const blockProps = useBlockProps();

	const {
		setAttributes,
		attributes: { title, content, items },
	} = props;

	const sortItems = (items, dataId) => {
		items.sort((a, b) => a.dataId - b.dataId);

		return items;
	}

	const onAddItem = () => {
		let index = 0;
		let itemsToAdd = [];
		if (!!items && items.length !== 0) {
			const maxIdIndex = items.length - 1;
			index = maxIdIndex + 1
			itemsToAdd = [...items, {
				dataId: index,
				title: '',
				content: ''
			}]
		} else {
			itemsToAdd = [{
				dataId: index,
				title: '',
				content: ''
			}]
		}
		itemsToAdd.sort((a, b) => a.dataId - b.dataId);
		setAttributes({ items: itemsToAdd })
	}

	const onChangeItemTitle = (title, id) => {
		const itemsToAdd = items.map(item => {
			if (item.dataId === id) {
				return { ...item, title: title }
			}
			return item;
		})
		setAttributes({ items: itemsToAdd })
	}

	const onChangeItemContent = (desc, id) => {
		const itemsToAdd = items.map(item => {
			if (item.dataId === id) {
				return { ...item, content: desc }
			}
			return item;
		})

		setAttributes({ items: itemsToAdd })
	}

	const onRemoveItem = (dataId) => {
		const filteredItems = items.filter(item => item.dataId !== dataId)

		const itemsToAdd = filteredItems.map((item, index) => {
			return {
				...item,
				dataId: index
			}
		});
		itemsToAdd.sort((a, b) => a.dataId - b.dataId);
		setAttributes({ items: itemsToAdd })
	}

	return (
		<section {...blockProps}>
			<div className="container">
				<div className="row">
					<div className="col-12 col-xl-3 mb-5 mb-xl-0">
						<div>
							<RichText
								tagName="h2"
								className="accordion-module__header"
								value={title}
								allowedFormats={['core/bold', 'core/italic']}
								onChange={(title) => setAttributes({ title })}
								placeholder={__('Insert block title here...')}
							/>
							<RichText
								tagName="p"
								className="accordion-module__text"
								value={content}
								allowedFormats={['core/bold', 'core/italic']}
								onChange={(content) => setAttributes({ content })}
								placeholder={__('Insert block content here...')}
							/>
						</div>
					</div>
					<div className="col-12 col-xl-8 offset-xl-1">

						{!items || items.length === 0 ? (
							<Button variant={'secondary'} onClick={onAddItem}>Add item</Button>
						) : (
							<div className="accordion">
								{items.length !== 0 && items.map(item => {
									return (
										<>
											<Item
												key={item.dataId}
												dataId={item.dataId}
												title={item.title}
												content={item.content}
												onChangeItemTitle={onChangeItemTitle}
												onChangeItemContent={onChangeItemContent}
												onRemoveItem={onRemoveItem}
											/>

											{item.dataId === items.length - 1 && (
												<Button variant={'secondary'} onClick={onAddItem}>Add another item</Button>
											)}
										</>
									)
								})}

							</div>
						)}

					</div>
				</div>
			</div>
		</section>
	);
}