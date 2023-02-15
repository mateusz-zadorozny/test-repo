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
import { useBlockProps, RichText, MediaUpload, InspectorControls } from '@wordpress/block-editor';
import { Placeholder, PanelBody, PanelRow, RangeControl, FormToggle, Button, SelectControl } from '@wordpress/components';
import { useState } from '@wordpress/element';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import CountersItem from './counters-item';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit(props) {

	const { setAttributes, attributes: {
		title, content, backgroundImage, isMaskChecked, viewType, items
	}, isSelected } = props;


	const blockProps = useBlockProps()

	const onChangeTitle = title => setAttributes({ title })
	const onChangeContent = content => setAttributes({ content })
	const onChangeItemValue = (itemValue, id) => {
		const itemsToAdd = items.map(item => {
			if (item.dataId === id) {
				return { ...item, itemValue }
			}
			return item;
		})
		setAttributes({ items: itemsToAdd });

	}

	const onChangeItemLabel = (itemLabel, id) => {
		const itemsToAdd = items.map(item => {
			if (item.dataId === id) {
				return { ...item, itemLabel }
			}
			return item;
		})

		setAttributes({ items: itemsToAdd });

	}

	const onChangeImageLabel = (imageLabel, id) => {
		const itemsToAdd = items.map(item => {
			if (item.dataId === id) {
				return { ...item, imageLabel }
			}
			return item;
		})

		setAttributes({ items: itemsToAdd });

	}
	
	const onChangeItemButtonText = (itemButtonText, id) => {
		const itemsToAdd = items.map(item => {
			if (item.dataId === id) {
				return { ...item, itemButtonText }
			}
			return item;
		})

		setAttributes({ items: itemsToAdd });

	}
	
	const onChangeItemButtonURL = (itemButtonURL, id) => {
		const itemsToAdd = items.map(item => {
			if (item.dataId === id) {
				return { ...item, itemButtonURL }
			}
			return item;
		})

		setAttributes({ items: itemsToAdd });

	}

	const onDeleteCounter = (id) => {
		const newItems = items.filter(item => item.dataId !== id);
		const itemsToAdd = newItems.map((item, i) => ({ ...item, dataId: i }));
		setAttributes({ items: itemsToAdd });
	}

	const onAddCounter = () => {
		let index = 0;
		let itemsToAdd = [];
		if (!!items && items.length !== 0) {
			const maxIdIndex = items.length - 1;
			index = maxIdIndex + 1;
			itemsToAdd = [...items, { dataId: index, itemValue: '', itemLabel: '', itemImage: '', imageLabel: '', itemButtonText: '', itemButtonURL: '' }]
		} else {
			itemsToAdd = [{ dataId: index, itemValue: '', itemLabel: '', itemImage: '', imageLabel: '', itemButtonText: '', itemButtonURL: '' }]
		}

		setAttributes({ items: itemsToAdd })
	}


	const onSelectBackgroundImage = (media) => {
		return props.setAttributes({
			backgroundImage: media.url
		});
	};

	const onSelectItemImage = (itemImage, id) => {
		const itemsToAdd = items.map(item => {
			if (item.dataId === id) {
				if (null === itemImage) {
					return { ...item, itemImage: null }
				}
				return { ...item, itemImage: itemImage.url }
			}
			return item;
		})

		setAttributes({ items: itemsToAdd });

	}

	const setViewType = (viewType) => {
		setAttributes({ viewType: viewType });
	}


	const setMaskCheck = (state) => {
		setAttributes({ isMaskChecked: !state });
	}

	const MaskFormToggle = () => {
		const [ isChecked, setChecked ] = (isMaskChecked) ? useState( true ) : useState( false );
	
		const setCheckedExtended = (state) => {
			setChecked( ( state ) => ! state )
			setMaskCheck(isChecked)
		} 

		return (
			<FormToggle
				checked={ isChecked }
				onChange={ (isChecked) => setCheckedExtended(isChecked) }
			/>
		);
	};

	let contentSpecialClass = 'image-columns';
	if (viewType === 'charts') {
        contentSpecialClass = 'charts-columns';
    } else if (viewType === 'counters') {
        contentSpecialClass = 'counters-columns';
    }

	return (
		<section {...blockProps} >
			{
				<InspectorControls key="setting">
					<div id="main-slider-control">
						<fieldset className="p-3">
							<legend className="main-slider-control__label">
								Background image
							</legend>
							<MediaUpload
								onSelect={onSelectBackgroundImage}
								allowedTypes="image"
								className="fc-media-ID"
								value={backgroundImage}
								render={({ open }) => (
									<Button
										className={
											backgroundImage ? 'image-button' : 'button button-large mb-3'
										}
										onClick={open}
									>
										{!backgroundImage ? (
											__('Upload Image', 'cards-with-benefits')
										) : (
											<img
												className="fc-media-url"
												src={backgroundImage}
												alt={__(
													'Upload Image',
													'cards-with-benefits'
												)}
											/>
										)}
									</Button>
								)}
							/>
							{backgroundImage && (
								<Button onClick={() => props.setAttributes({ backgroundImage: null })} >remove</Button>
							)}
						</fieldset>
						<fieldset className="p-3">
							<legend className="counters-section-control__label">
								Use a mask over background image
							</legend>
							<MaskFormToggle
							/>
						</fieldset>
						<fieldset className="p-3">
							<legend className="counters-section-control__label">
								View type
							</legend>
							<SelectControl

								value={viewType}
								onChange={(viewType) => { setViewType(viewType) }}
								__nextHasNoMarginBottom
							>
								<option value="columns">columns</option>
								<option value="counters">counters</option>
								<option value="charts">charts</option>
							</SelectControl>
						</fieldset>
					</div>
				</InspectorControls>

			}
			
			<figure className={`${isMaskChecked ? 'mask-on' : 'mask-off'} counters-section-background`} style={{ backgroundImage: 'url(' + backgroundImage + ')' }} ></figure>
			<div className={`${contentSpecialClass} container`}>
				<div className="row">
					<div className="col-12 col-lg-6 col-xl-4 mb-xl-0">
						<RichText
							className="counters-section__title"
							tagName="h2"
							value={title}
							placeholder={'Add section title here..'}
							onChange={onChangeTitle}
						/>
					</div>
					<div className="col-xl-5 col-lg-6 mb-4 pe-lg-4">
						<RichText
							className="counters-section__content intro"
							tagName="p"
							placeholder={'Add section description here...'}

							value={content}
							onChange={onChangeContent}
						/>
					</div>
				</div>
				<div className="row">
					{!items || items.length === 0 ? (
						<Button variant={'secondary'} onClick={onAddCounter}>
							Add column
						</Button>
					) : (


						items.length !== 0 && items.map(counter => {

							return (
								<div className="col mt-4 mt-lg-5 counter-card">
									<div className="counters-section__items-list">

										<CountersItem
											key={counter.dataId}
											dataId={counter.dataId}
											itemValue={counter.itemValue}
											itemLabel={counter.itemLabel}
											itemButtonText={counter.itemButtonText}
											itemButtonURL={counter.itemButtonURL}
											itemsNumber={items.length}
											itemImage={counter.itemImage}
											imageLabel={counter.imageLabel}
											viewType={viewType}
											onChangeItemValue={onChangeItemValue}
											onChangeItemLabel={onChangeItemLabel}
											onChangeItemButtonText={onChangeItemButtonText}
											onChangeItemButtonURL={onChangeItemButtonURL}
											onDeleteCounter={onDeleteCounter}
											onAddCounter={onAddCounter}
											onSelectItemImage={onSelectItemImage}
											onChangeImageLabel={onChangeImageLabel}
										/>

										{counter.dataId == items.length - 1 && (
											<Button variant={'secondary'} className="mt-5" onClick={onAddCounter}>
												Add another column
											</Button>

										)}
									</div>
								</div>

							)
						})

					)}

				</div>
			</div>


		</section>
	);
}
