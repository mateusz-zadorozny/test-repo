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
import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { Button, SelectControl } from '@wordpress/components';

import IconColumn from './icon-column';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
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
		attributes: { title, iconsColumns, backgroundColor }
	} = props;

	const onChangeTitle = (title) => setAttributes({ title })

	const onChangeIconColumnProperty = (propertyName, propertyValue, dataId) => {

		if (!iconsColumns || iconsColumns.length === 0) return;
		const iconsToAdd = iconsColumns.map(iconColumn => {
			if (iconColumn.dataId === dataId) {
				return {
					...iconColumn,
					...(propertyName === 'iconImage') && { iconImage: propertyValue },
					...(propertyName === 'text') && { text: propertyValue },
					...(propertyName === 'title') && { title: propertyValue },
				}
			}
			return iconColumn;
		})

		setAttributes({ iconsColumns: iconsToAdd })
	}

	const onAddIconColumn = () => {
		let indexOpinion = 0;
		let iconsToAdd = [];
		if (!!iconsColumns && iconsColumns.length !== 0) {
			const maxIdIndex = iconsColumns.length - 1;
			indexOpinion = maxIdIndex + 1
			iconsToAdd = [...iconsColumns, {
				dataId: indexOpinion,
				text: '',
				clientName: '',
				rate: 5
			}]
		} else {
			iconsToAdd = [{
				dataId: indexOpinion,
				text: '',
				clientName: '',
				rate: 5
			}]
		}
		iconsToAdd.sort((a, b) => a.dataId - b.dataId);
		setAttributes({ iconsColumns: iconsToAdd })
	}

	const onRemoveIconColumn = (dataId) => {
		const filteredOpinions = iconsColumns.filter(iconColumn => iconColumn.dataId !== dataId)

		const iconsToAdd = filteredOpinions.map((iconColumn, index) => {
			return {
				...iconColumn,
				dataId: index
			}
		});
		iconsToAdd.sort((a, b) => a.dataId - b.dataId);
		setAttributes({ iconsColumns: iconsToAdd })
	}

	const setBackgroundColor = (backgroundColor) => {
		setAttributes({ backgroundColor: backgroundColor });
	}

	return (
		<section {...blockProps} className={`${backgroundColor} wp-block-create-block-icons-columns`}>
			<InspectorControls key="setting">
				<div id="icons-columns-control">
					<fieldset class="p-3">
						<legend className="icons-columns-control__label">
							Background color
						</legend>
						<SelectControl

							value={backgroundColor}
							onChange={(backgroundColor) => { setBackgroundColor(backgroundColor) }}
							__nextHasNoMarginBottom
						>
							<option value="white-bg">White</option>
							<option value="lgrey-bg">Grey</option>
						</SelectControl>
					</fieldset>

				</div>
			</InspectorControls>
			<div className="container">
				<div className="icons-columns">
					<div className="row">
						<div className="col-12 col-xl-3 mb-5 mb-xl-0">
							<div className="icons-columns__content-box">
								<RichText
									tagName="h2"
									className="icons-columns__header"
									placeholder="Add title"
									value={title}
									onChange={(title) => setAttributes({ title })}
								/>
							</div>
						</div>
						<div className="col-12 col-xl-8 offset-xl-1">
							<div className="icons-columns__row row">
								{!iconsColumns || iconsColumns.length === 0 ? (
									<div className="col-4 py-5">
										<Button variant={'secondary'} onClick={onAddIconColumn}>Add column</Button>
									</div>
								) : (
									<>
										{iconsColumns.length !== 0 && iconsColumns.map(icon => {
											return (
												<>
													<IconColumn
														key={icon.dataId}
														dataId={icon.dataId}
														text={icon.text}
														iconImage={icon.iconImage ?? null}
														title={icon.title}
														onChangeIconColumnProperty={onChangeIconColumnProperty}
														onRemoveIconColumn={onRemoveIconColumn}
													/>
													{icon.dataId === iconsColumns.length - 1 && (
														<div className="col-4 py-5">
															<Button variant={'secondary'} onClick={onAddIconColumn}>Add another column</Button>
														</div>
													)}

												</>
											)
										})}
									</>
								)}
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	);
}
