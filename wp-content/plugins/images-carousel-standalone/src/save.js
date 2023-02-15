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
		title, content, backgroundImageURL, backgroundImageID
	}
	} = props

	return (
		<section { ...blockProps } className="carousel-gallery standalone">
			<div className="container">

				<div className="row title-row">
					<div className="col-xl-4 col-lg-6 pe-5">
						<RichText.Content
							className="carousel-gallery__title mt-0"
							tagName="h2"
							value={title}
						/>
					</div>
					<div className="col-xl-6 col-lg-6 offset-xl-1">
						<RichText.Content
							className="carousel-gallery__text intro mt-0"
							tagName="p"
							value={content}
						/>
					</div>
				</div>
					
			</div>
			<div className="swiper images-carousel">
				<div className="swiper-wrapper">
					
					{props.attributes.images.map((image, index) => (
						<div className="swiper-slide slider-image">
							<img class={image.subtype} key={index} src={image.url} data-mediaid={image.id} />
						</div>
					))}
				
				</div>
				<button class="carousel-button-prev shape-button"><i class="icon-chevron-left"></i></button>
                <button class="carousel-button-next shape-button"><i class="icon-chevron-right"></i></button>
			</div>

			<div className="container">
				<div className="slider-progress"></div>
			</div>

		</section>
	);
}
