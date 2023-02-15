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
		title, content, contentLink, contentLinkText, backgroundImage, mobileBackgroundImage
	} } = props;

	const blockProps = useBlockProps()

	function onSelectBackgroundImage(media) {
		return props.setAttributes({
			backgroundImage: media.url
		});
	};

	function onSelectMobileBackgroundImage(media) {
		return props.setAttributes({
			mobileBackgroundImage: media.url
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
	return (
		<section {...blockProps} className="cta-full-section lgrey-bg">
				{
					<InspectorControls key="setting">
						<div id="cta-full-section-control">
							<fieldset class="p-3">
								<legend className="cta-full-section-control__label">
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
												__('Upload Image')
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
							<fieldset class="p-3">
								<legend className="cta-full-section-control__label">
									Mobile Background image
								</legend>
								<MediaUpload
									onSelect={onSelectMobileBackgroundImage}
									allowedTypes="image"
									className="fc-media-ID"
									value={mobileBackgroundImage}
									render={({ open }) => (
										<Button
											className={
												mobileBackgroundImage ? 'image-button' : 'button button-large mb-3'
											}
											onClick={open}
										>
											{!mobileBackgroundImage ? (
												__('Upload Image')
											) : (
												<img
													class="fc-media-url"
													src={mobileBackgroundImage}
													alt={__('Upload Image')}
												/>
											)}
										</Button>
									)}
								/>
								{mobileBackgroundImage && (
									<Button onClick={() => props.setAttributes({ mobileBackgroundImage: null })} >remove</Button>
								)}
							</fieldset>

						</div>
					</InspectorControls>

				}
                <div class="container">
					
                    <div class="row">
                        <div class="col-12 col-xl-4 cta-full-section__content">
                            <RichText
                                tagName="h2"
                                value={title}
                                allowedFormats={['core/bold', 'core/italic']}
                                onChange={(title) => setAttributes({ title })}
                                placeholder={__('Insert block title here...')}
                            />
                            <RichText
                                tagName="p"
                                className="content ps-0"
                                value={content}
                                allowedFormats={['core/bold', 'core/italic']}
                                onChange={(content) => setAttributes({ content })}
                                placeholder={__('Insert block content here...')}
                            />
                            <div className="me-2">
                                <RichText
                                    tagName="span"
                                    className="selected-articles__content-link button secondary"
                                    placeholder={'Add link text'}
                                    value={contentLinkText}
                                    onChange={(contentLinkText) => setAttributes({ contentLinkText })}
                                    type="button"
                                />
                            </div>
                            <div className="mt-2">
                                <LinkControlSearchInput
                                    placeholder="Search button link here..."
                                    className="selected-articles__content-link"
                                    renderSuggestions={(props) => suggestionsRender(props, false, '')}
                                    allowDirectEntry={true}
                                    withURLSuggestion={false}
                                    value={contentLink}
                                    onChange={(contentLink) => setAttributes({ contentLink })}
                                    withCreateSuggestion={false}
                                />
                            </div>

                        </div>
                        <div className="col-xl-8 col-12  pe-lg-4">
							{backgroundImage &&
								<figure class={`cta-full-section__background ${mobileBackgroundImage && 'd-none d-md-block'}`}>
									<img class="cta-full-section__image" src={backgroundImage} />
								</figure>
							}
							{mobileBackgroundImage &&
								<figure class="cta-full-section__background d-md-none">
									<img class="cta-full-section__image" src={mobileBackgroundImage} />
								</figure>
							}
                        </div>
                        
                    </div>
                </div>
            </section>
	);
}
