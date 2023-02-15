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
import { useBlockProps, RichText, MediaUpload, InspectorControls, __experimentalLinkControlSearchInput as LinkControlSearchInput } from '@wordpress/block-editor';
import { Placeholder, PanelBody, PanelRow, RangeControl, Button } from '@wordpress/components';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import imagePlaceholder from './image-placeholder.jpg';

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
			firstProduct, firstProductBackgroundImage, firstProductTitle, firstProductExcerpt, firstProductLink, 
			secondProduct, secondProductBackgroundImage, secondProductTitle, secondProductExcerpt, secondProductLink 
	} } = props;

	const blockProps = useBlockProps();

	const selectFirstProduct = (suggestion) => {
		console.log(suggestion);
		setAttributes ({
			firstProduct: suggestion.id,
			firstProductTitle: suggestion.title,
			firstProductExcerpt: suggestion.excerpt,
			firstProductLink: suggestion.url,
		});
	}
	const selectSecondProduct = (suggestion) => {
		setAttributes ({
			secondProduct: suggestion.id,
			secondProductTitle: suggestion.title,
			secondProductExcerpt: suggestion.excerpt,
			secondProductLink: suggestion.url,
		});
	}
	const suggestionsRender = (props, onlyPostType, attributeName) => {
	   
		var suggestions = props.suggestions,
			handleOnClick = props.handleSuggestionClick;
			
		if (onlyPostType) {
			
			suggestions = suggestions.filter((suggestion) => {
				return suggestion.type === 'product';
			})
			if (attributeName === 'firstProduct') {
				handleOnClick = selectFirstProduct;
			} 
			else {
				handleOnClick = selectSecondProduct;
			}
		}
		
		return (
			<div className="components-dropdown-menu__menu">
				{
					suggestions.map((suggestion, index) => {
						return (
							<div onClick={() => handleOnClick(suggestion)} className="components-button components-dropdown-menu__menu-item is-active has-text has-icon">{suggestion.title}</div>
						)
					})
				}
			</div>
		)
	}

	const onSelectFirstBackgroundImage = (media) => {
		setAttributes({
			firstProductBackgroundImage: media.url,
		});
	};
	const onSelectSecondBackgroundImage = (media) => {
		setAttributes({
			secondProductBackgroundImage: media.url,
		});
	};

	return (
		<section { ...blockProps }>
			{
				<InspectorControls key="setting">
					<div id="main-slider-control">
						<fieldset class="p-3">
							<legend className="main-slider-control__label">
								First Product - Background image
							</legend>
							<MediaUpload
								onSelect={onSelectFirstBackgroundImage}
								allowedTypes="image"
								className="fc-media-ID"
								value={firstProductBackgroundImage}
								render={({ open }) => (
									<Button
										className={
											firstProductBackgroundImage ? 'image-button' : 'button button-large mb-3'
										}
										onClick={open}
									>
										{!firstProductBackgroundImage ? (
											__('Upload Image', 'cards-with-benefits')
										) : (
											<img
												class="fc-media-url"
												src={firstProductBackgroundImage}
												alt={__(
													'Upload Image',
													'cards-with-benefits'
												)}
											/>
										)}
									</Button>
								)}
							/>
							{firstProductBackgroundImage && (
								<Button onClick={() => props.setAttributes({ firstProductBackgroundImage: null })} >remove</Button>
							)}
						</fieldset>
						<fieldset class="p-3">
							<legend className="main-slider-control__label">
								Second Product - Background image
							</legend>
							<MediaUpload
								onSelect={onSelectSecondBackgroundImage}
								allowedTypes="image"
								className="fc-media-ID"
								value={secondProductBackgroundImage}
								render={({ open }) => (
									<Button
										className={
											secondProductBackgroundImage ? 'image-button' : 'button button-large mb-3'
										}
										onClick={open}
									>
										{!secondProductBackgroundImage ? (
											__('Upload Image', 'cards-with-benefits')
										) : (
											<img
												class="fc-media-url"
												src={secondProductBackgroundImage}
												alt={__(
													'Upload Image',
													'cards-with-benefits'
												)}
											/>
										)}
									</Button>
								)}
							/>
							{secondProductBackgroundImage && (
								<Button onClick={() => props.setAttributes({ secondProductBackgroundImage: null })} >remove</Button>
							)}
						</fieldset>

					</div>
				</InspectorControls>

			}
			<div className="container">
				<div className="row">
					<div className="col-lg-7">
						<div className="featured-product">
							<div className="row featured-product__content">
								<div className="col-sm-12 col-lg-8 col-xl-7 featured-product__content-col">
									<div className="featured-product__content-col--item">
										<span class="h3 mb-2">Choose featured product</span>
										<h2 className="featured-product__title mb-0 mt-3">
											{firstProductTitle}
											<LinkControlSearchInput
												placeholder="Search button link here..."
												className="selected-products__first"
												renderSuggestions={(props) => suggestionsRender(props, true, 'firstProduct')}
												allowDirectEntry={false}
												withURLSuggestion={false}
												value={firstProductLink}
												onChange={(firstProductLink) => setAttributes({ firstProductLink })}
												withCreateSuggestion={false}
											/>
										</h2>
										<p className="featured-product__text">{firstProductExcerpt}</p>
									</div>
								</div>
								<div className="col-sm-12 col-lg-4 col-xl-5 featured-product__bg-container" style={{backgroundImage: 'url(' + firstProductBackgroundImage + ')'}}>
									<img className="featured-product__photo" src={imagePlaceholder} />
								</div>
							</div>
						</div>
					</div>
					<div className="col-lg-5">
						<div className="featured-product small">
							<div className="row featured-product__content">
								<div className="col-sm-12 col-lg-8 col-xl-7 featured-product__content-col">
									<div className="featured-product__content-col--item">
										<span class="h3 mb-2">Choose featured product</span>
										<h2 className="featured-product__title mb-0 mt-3">
											{secondProductTitle}
											<LinkControlSearchInput
												placeholder="Search button link here..."
												className="selected-products__second"
												renderSuggestions={(props) => suggestionsRender(props, true, 'secondProduct')}
												allowDirectEntry={false}
												withURLSuggestion={false}
												value={secondProductLink}
												onChange={(secondProductLink) => setAttributes({ secondProductLink })}
												withCreateSuggestion={false}
											/>
										</h2>
										<p className="featured-product__text">{secondProductExcerpt}</p>
									</div>
								</div>
								<div className="col-sm-12 col-lg-4 col-xl-5 featured-product__bg-container" style={{backgroundImage: 'url(' + secondProductBackgroundImage + ')'}}>
									<img className="featured-product__photo" src={imagePlaceholder} />
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	);
}
