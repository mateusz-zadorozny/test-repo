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
		title, content, contentLink, contentLinkText, backgroundImage, mobileBackgroundImage
	}
	} = props

	return (
		<section {...blockProps} className="cta-full-section lgrey-bg">
			<div class="container">
				<div class="row">
					<div class="col-12 col-xl-4 cta-full-section__content">
						{title &&
							<RichText.Content
								className="mt-0"
								tagName="h2"
								value={title}
							/>
						}
						{title &&
							<RichText.Content
								className="intro"
								tagName="p"
								value={content}
							/>
						}
						{(contentLinkText && contentLink) &&
							<a href={contentLink} className="cta-banner__content-link button secondary" type="button"><span>{contentLinkText}</span></a>
						}
					</div>
					<div className="col-xl-8 col-12 pe-lg-4">
						{backgroundImage &&
							<figure className={`cta-full-section__background ${mobileBackgroundImage && 'd-none d-md-block'}`}>
								<img className="cta-full-section__image" src={backgroundImage} alt="photo"/>
							</figure>
						}
						{mobileBackgroundImage &&
							<figure className="cta-full-section__background d-md-none">
								<img className="cta-full-section__image" src={mobileBackgroundImage} alt="photo"/>
							</figure>
						}
					</div>
				</div>
			</div>
		</section>
	);
}
