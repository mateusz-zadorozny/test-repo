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
import { useBlockProps, RichText, MediaUpload, InspectorControls} from '@wordpress/block-editor';
import { Button } from '@wordpress/components';

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
		title, content, mainImage, backgroundImage
	} } = props;

	const blockProps = useBlockProps()

	function onSelectBackgroundImage(media) {
		return props.setAttributes({
			backgroundImage: media.url
		});
	};

	function onSelectMainImage(media) {
		return props.setAttributes({
			mainImage: media.url
		});
	};


	return (
		<section {...blockProps} className="infographic-module">
				{
					<InspectorControls key="setting">
						<div id="infographic-module-control">
							<fieldset className="p-3">
								<legend className="infographic-module-control__label">
									Main infographic image
								</legend>
								<MediaUpload
									onSelect={onSelectMainImage}
									allowedTypes="image"
									className="fc-media-ID"
									value={mainImage}
									render={({ open }) => (
										<Button
											className={
												mainImage ? 'image-button' : 'button button-large mb-3'
											}
											onClick={open}
										>
											{!mainImage ? (
												__('Upload Image')
											) : (
												<img
													className="fc-media-url"
													src={mainImage}
													alt={__('Upload Image')}
												/>
											)}
										</Button>
									)}
								/>
								{mainImage && (
									<Button onClick={() => props.setAttributes({ mainImage: null })} >remove</Button>
								)}
							</fieldset>
							<fieldset className="p-3">
								<legend className="infographic-module-control__label">
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
													className="fc-media-url"
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

						</div>
					</InspectorControls>

				}

				<figure className="infographic-module-background" style={{ backgroundImage: 'url(' + backgroundImage + ')' }} ></figure>

                <div className="container">
					
                    <div className="row">
                        <div className="col-12 col-xl-4 infographic-module__content">
                            <RichText
                                tagName="h2"
                                value={title}
                                allowedFormats={['core/bold', 'core/italic']}
                                onChange={(title) => setAttributes({ title })}
                                placeholder={__('Insert block title here...')}
                            />
                            <RichText
                                tagName="p"
                                className="content ps-0 medium"
                                value={content}
                                allowedFormats={['core/bold', 'core/italic']}
                                onChange={(content) => setAttributes({ content })}
                                placeholder={__('Insert block content here...')}
                            />
                        </div>
                        <div className="col-xl-8 col-12 pe-lg-4">
							{mainImage &&
								<figure className="infographic-module__main-image-wrapper">
									<img className="infographic-module__image" src={mainImage} />
								</figure>
							}
							
                        </div>
                        
                    </div>
                </div>
            </section>
	);
}
