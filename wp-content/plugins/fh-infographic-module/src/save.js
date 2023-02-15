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
		title, content, backgroundImage, mainImage
	}
	} = props

	return (
		<section {...blockProps} className="infographic-module parallax-window" data-parallax="scroll" data-image-src={backgroundImage}>
			<figure className="infographic-module-background" style={{ backgroundImage: 'url(' + backgroundImage + ')' }} ></figure>
			<div class="container">
				<div class="row">
					<div class="col-12 col-xl-4 infographic-module__content">
						{title &&
							<RichText.Content
								className="mt-0"
								tagName="h2"
								value={title}
							/>
						}
						{title &&
							<RichText.Content
								className="medium"
								tagName="p"
								value={content}
							/>
						}
					</div>
					<div className="col-xl-8 col-12 pe-lg-4">
						{backgroundImage &&
							<figure className="infographic-module__main-image-wrapper">
								<img className="infographic-module__image" src={mainImage} alt="photo"/>
							</figure>
						}
					</div>
				</div>
			</div>
		</section>
	);
}
