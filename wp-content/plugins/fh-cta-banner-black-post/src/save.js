/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
 import { useBlockProps, RichText } from '@wordpress/block-editor';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {WPElement} Element to render.
 */
 export default function save(props) {
	const blockProps = useBlockProps.save()

	const { attributes: {
		title, contentLink, contentLinkText, backgroundImage, colorVariant, fontSize, isFormShortCodeChecked, formShortCode
	}
	} = props

	let fontSizeClass = 'default';

    if (fontSize === 20) {
        fontSizeClass = 'medium';
    } else if (fontSize === 24) {
        fontSizeClass = 'large';
    }

	return (
		<section {...blockProps} className={`${colorVariant} cta-banner-black-section cta-banner-post`}>
			<div className="cta-banner cta-banner-black">
				<div className="row cta-banner__content">
					<div className="col-sm-12 col-xl-8 col-xxl-7 cta-banner__content-col">
						{(!isFormShortCodeChecked || !formShortCode) && (<div className="cta-banner__content-col--item">
							<RichText.Content
								className="cta-banner__title mt-0"
								tagName="h2"
								value={title}
							/>
							<a href={contentLink} className={`${colorVariant == 'dark' ? 'white' : 'secondary'} cta-banner__content-link button `} type="button"><span>{contentLinkText}</span></a>
						</div>)}
						{isFormShortCodeChecked && formShortCode && (
							<div className="cta-banner__content-col--item">
							<RichText.Content
								className="cta-banner__title mt-0"
								tagName="h2"
								value={title}
							/>
							{formShortCode}
							
						</div>
						)}
					</div>
					<div className="col-sm-12 d-none d-xl-flex col-xl-4 col-xxl-5 cta-banner__bg-container">
						<img className="cta-banner__bg" src={backgroundImage} alt="photo"/>
					</div>
				</div>
			</div>
		</section>
	);
}
