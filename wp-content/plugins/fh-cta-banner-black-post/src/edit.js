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
 import { useBlockProps, RichText, MediaUpload, InspectorControls, __experimentalLinkControlSearchInput as LinkControlSearchInput, PlainText } from '@wordpress/block-editor';
 import { Placeholder, PanelBody, PanelRow, RangeControl, Button, SelectControl, FontSizePicker, FormToggle } from '@wordpress/components';
 import { useState } from '@wordpress/element';

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
	const { setAttributes, attributes: {
		title, contentLink, contentLinkText, backgroundImage, colorVariant, fontSize, isFormShortCodeChecked, formShortCode
	} } = props;

	const blockProps = useBlockProps();

	function onSelectBackgroundImage(media) {
		return props.setAttributes({
			backgroundImage: media.url
		});
	};

	const suggestionsRender = (props) => (
        <div className="components-dropdown-menu__menu">
            {props.suggestions.map((suggestion, index) => {
                return (
                    <div onClick={() => props.handleSuggestionClick(suggestion)} className="components-button components-dropdown-menu__menu-item is-active has-text has-icon">{suggestion.title}</div>
                )
            })
            }
        </div>
    )

	const setColorVariant = (colorVariant) => {
		setAttributes({ colorVariant: colorVariant });
	}

	const fontSizes = [
        {
            name: __('Default'),
            slug: 'default',
            size: 16,
        },
        {
            name: __('Large'),
            slug: 'large',
            size: 20,
        },
        {
            name: __('Extra Large'),
            slug: 'xlarge',
            size: 24,
        },
    ];
    const fallbackFontSize = 16;

    const setFontSize = (fontSize) => {
        setAttributes({ fontSize: fontSize });
    }

    const ParagraphFontSizePicker = () => {

        return (
            <FontSizePicker
                __nextHasNoMarginBottom
                fontSizes={fontSizes}
                value={fontSize}
                disableCustomFontSizes
                fallbackFontSize={fallbackFontSize}
                onChange={(fontSize) => { setFontSize(fontSize) }}
            />
        );
    };

    let fontSizeClass = 'default';

    if (fontSize === 20) {
        fontSizeClass = 'medium';
    } else if (fontSize === 24) {
        fontSizeClass = 'large';
    }

	const setUseFormShortCode = (state) => {
		setAttributes({ isFormShortCodeChecked: !state });
	}


	const MaskFormToggle = () => {
		const [ isChecked, setChecked ] = (isFormShortCodeChecked) ? useState( true ) : useState( false );
	
		const setCheckedExtended = (state) => {
			setChecked( ( state ) => ! state )
			setUseFormShortCode(isChecked)
		} 

		return (
			<FormToggle
				checked={ isChecked }
				onChange={ (isChecked) => setCheckedExtended(isChecked) }
			/>
		);
	};

	return (
		<section {...blockProps} className={`${colorVariant} cta-banner-black-section cta-banner-post`} >

			{
				<InspectorControls key="setting">
					<div id="cta-banner-control">
						<fieldset class="p-3">
                            <legend className="icons-columns-control__label">
								Color variant
                            </legend>
                            <SelectControl

                                value={colorVariant}
                                onChange={(colorVariant) => { setColorVariant(colorVariant) }}
                                __nextHasNoMarginBottom
                            >
                                <option value="dark">Dark</option>
                                <option value="light">Light</option>
                            </SelectControl>
                        </fieldset>
						<fieldset className="p-3">
							<legend className="counters-section-control__label">
								Use form short code
							</legend>
							<MaskFormToggle
							/>
						</fieldset>
						<fieldset class="p-3">
							<legend className="counters-section-control__label">
								Form short code
							</legend>
							<PlainText
								tagName="form"
								placeholder="Add form short code"
								value={formShortCode}
								onChange={(formShortCode) => setAttributes({ formShortCode: formShortCode })}
							/>
						</fieldset>
						<fieldset class="p-3">
							<legend className="cta-banner-control__label">
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
												class="fc-media-url"
												src={backgroundImage}
												alt={__('Upload Image')}
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
                            <legend className="halves-section-control__label">
                                Main Text Size
                            </legend>
                            <ParagraphFontSizePicker />
                        </fieldset>

					</div>
				</InspectorControls>

			}
			<div className="cta-banner cta-banner-black">
				<div className="row cta-banner__content">
					<div className="col-sm-12 col-lg-8 col-xl-7 cta-banner__content-col">
						<div className="cta-banner__content-col--item">
							<RichText
								tagName="h2"
								value={title}
								allowedFormats={['core/bold', 'core/italic']}
								onChange={(title) => setAttributes({ title })}
								placeholder={__('Insert block title here...')}
								className="cta-banner__title mt-0"
							/>
							{formShortCode && isFormShortCodeChecked && (
								<Placeholder
									isColumnLayout
								>
									<div style={{ backgroundColor: "#e7e7e7", padding: "10px 64px", display: "flex", justifyContent: "center" }}>
										Form
									</div>
								</Placeholder>
							)}
							{!isFormShortCodeChecked && (<><div className={`${colorVariant == 'dark' ? 'white' : 'secondary'} me-2 button`}>
								<RichText
									tagName="span"
									className="cta-banner__content-link"
									placeholder={'Add link text'}
									value={contentLinkText}
									onChange={(contentLinkText) => setAttributes({ contentLinkText })}
									type="button"
								/>
							</div>
							<div className="mt-2">
								<LinkControlSearchInput
									placeholder="Search button link here..."
									className="cta-banner__content-link"
									renderSuggestions={(props) => suggestionsRender(props, false, '')}
									allowDirectEntry={true}
									withURLSuggestion={false}
									value={contentLink}
									onChange={(contentLink) => setAttributes({ contentLink })}
									withCreateSuggestion={false}
								/>
							</div></>)}
							{isFormShortCodeChecked && !formShortCode && (
								<p>Add form short code in sidebar to display form</p>
							)}
						</div>
					</div>
					<div className="col-sm-12 col-lg-4 col-xl-5 cta-banner__bg-container">
						<img className="cta-banner__bg" src={backgroundImage} alt="photo"/>
					</div>
				</div>
			</div>
		</section>
	);
}
