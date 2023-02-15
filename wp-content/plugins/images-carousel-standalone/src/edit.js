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
import { useBlockProps, RichText, MediaUpload, MediaUploadCheck, MediaPlaceholder, BlockControls, BlockIcon } from '@wordpress/block-editor';
import { ToolbarButton, ToolbarGroup, Button} from "@wordpress/components";
import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation, Pagination } from "swiper";
import 'swiper/css';
import 'swiper/css/pagination';

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

	const { setAttributes, attributes: {
		title, content, backgroundImageURL, backgroundImageID
	} } = props;

	function onSelectBackgroundImage(media) {
        return props.setAttributes({
            backgroundImageURL: media.url,
            backgroundImageID: media.id,
        });
	};

	const hasImages = props.attributes.images.length > 0;

	return (
		<section {...blockProps}  className={`${blockProps.className} carousel-gallery standalone`}>

			<BlockControls>
				<ToolbarGroup>
					<MediaUploadCheck>
						<MediaUpload
							multiple
							gallery
							addToGallery={true}
							onSelect={(newImages) =>
								props.setAttributes({ images: newImages })}
							allowedTypes={["image"]}
							value={props.attributes.images.map((image) => image.id)}
							render={({ open }) => (
								<ToolbarButton onClick={open}>
									{__("Edit Gallery", "scrollable-gallery")}
								</ToolbarButton>)}
						/>
					</MediaUploadCheck>
				</ToolbarGroup>
			</BlockControls>


			<Swiper
					className="carousel-gallery"
					spaceBetween={24}
					slidesPerView={'auto'}
					pagination={{
						type: "progressbar",
						el: ".carousel-gallery .slider-progress"
					  }}
					navigation={true}
					modules={[Pagination, Navigation]}
				>

					{hasImages && (
						<figure className="scrollable-gallery-inner-container">
							{props.attributes.images.map((image, index) => (
								<SwiperSlide className="slider-image">
									<img class={image.subtype} key={index} src={image.url} />
								</SwiperSlide>
							))}
						</figure>
					)}
					{!hasImages && (
						<MediaPlaceholder
							multiple
							gallery
							icon={<BlockIcon icon="format-gallery" />}
							labels={{
								title: "Scrollable Gallery",
								instructions: "Create an awesome scrollable gallery.",
							}}
							onSelect={(newImages) => props.setAttributes({ images: newImages })}
						/>
					)}
					<div className="container">
						<div className="slider-progress"></div>
					</div>
			</Swiper>

		</section>
	);
}
