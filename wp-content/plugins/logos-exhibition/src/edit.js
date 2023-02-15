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
import { useBlockProps, RichText, InspectorControls, MediaUpload } from '@wordpress/block-editor';
import { Button, SelectControl } from '@wordpress/components';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import Icon from './icon';


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
		attributes: { backgroundColor, title, icons }
	} = props;

	const onChangeTitle = (title) => setAttributes({ title })

	const setBackgroundColor = (backgroundColor) => {
		setAttributes({ backgroundColor: backgroundColor });
	}

	const ALLOWED_MEDIA_TYPES = ['image'];
	const onRemove = (id) => {
		const iconsList = icons.filter(image => image.dataId !== id);

		iconsList.map((item, i) => item.dataId = i);
		setAttributes({ icons: iconsList })
	}


	const moveImage = (id, dir) => {
		const position = icons.findIndex(image => image.dataId === id);
		const item = icons[position];
		const newIcons = icons.filter(image => image.dataId !== id);
		newIcons.splice(position + dir, 0, item);

		newIcons.map((item, i) => item.dataId = i);

		setAttributes({
			icons: newIcons
		});
	}

	const setIconAttributes = (icon) => {
		const maxIdIndex = icons.length - 1;
		let index = maxIdIndex + 1;
		const sortedIcons = [...icons];
		sortedIcons.map((item, i) => item.dataId = i);
		setAttributes({
			icons: [
				...sortedIcons,
				{
					dataId: index,
					url: icon.url,
					alt: icon.alt,
					link: "",
				}
			],
		})
	}

	return (
		<section {...blockProps} className={`${backgroundColor} logos-exhibition-section`}>
			<InspectorControls key="setting">
				<div id="logos-exhibition-section-control">
					<fieldset className="p-3">
						<legend className="logos-exhibition-section-control__label">
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
				<div className="row">
					<div className="col-sm-12">
						<RichText
							tagName="h2"
							className="h3"
							placeholder="Add block header"
							value={title}
							onChange={(title) => onChangeTitle(title)}
						/>

						<div className="logos-wrapper">
							{

								icons && icons.length !== 0 && icons.map(icon => (

									<Icon
										key={icon.dataId}
										dataId={icon.dataId}
										url={icon.url}
										alt={icon.alt}
										title={icon.title}
										iconsNumber={icons.length}
										onRemoveHandler={onRemove}
										onMoveImage={moveImage}
									/>
								))
							}

							<div className="upload">
								<MediaUpload
									onSelect={setIconAttributes}
									allowedTypes={ALLOWED_MEDIA_TYPES}
									render={({ open }) => (
										<div>
											<Button variant={'secondary'} onClick={open}>
												{icons.length === 0
													? 'Upload logo'
													: 'Upload new logo'
												}
											</Button>
										</div>
									)}
								/>
							</div>
						</div>
					</div>

				</div>
			</div>
		</section>
	);
}
