/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
// import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, InspectorControls, MediaUpload, RichText, MediaPlaceholder, BlockControls } from '@wordpress/block-editor';
import { SelectControl, Placeholder, PanelBody, PanelRow, RangeControl, Button } from '@wordpress/components';
import { useState } from '@wordpress/element';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
/**
 * Internal dependencies
 */
import SliderImage from './slider-image';
import { Swiper, SwiperSlide } from 'swiper/react';
import { EffectFade, Pagination } from "swiper";
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit(props) {

	const ALLOWED_MEDIA_TYPES = ['image'];

	const blockProps = useBlockProps();

	const { attributes: {
	}, setAttributes, attributes: {
		images, contentType
	}, isSelected
            } = props;

	const onChangeTitle = (title, id) => {
		const newImages = images.map(image => {
			if (image.dataId === id) {
				return { ...image, title }
			}
			return image
		})

		setAttributes({
			images: newImages
		})
	}

	const onChangeContent = (content, id) => {
		const newImages = images.map(image => {
			if (image.dataId === id) {
				return { ...image, content }
			}
			return image
		})
		setAttributes({
			images: newImages
		})
	}

	const onChangeContentLink = (contentLink, id) => {
		const newImages = images.map(image => {
			if (image.dataId === id) {
				return { ...image, contentLink }
			}
			return image
		})
		setAttributes({
			images: newImages
		})
	}

	const onChangeContentLinkText = (contentLinkText, id) => {
		const newImages = images.map(image => {
			if (image.dataId === id) {
				return { ...image, contentLinkText }
			}
			return image
		})
		setAttributes({
			images: newImages
		})
	}
        
	const onChangeSearchButtonText = (searchButtonText, id) => {
		const newImages = images.map(image => {
			if (image.dataId === id) {
				return { ...image, searchButtonText }
			}
			return image
		})
		setAttributes({
			images: newImages
		})
	}
        
	const onChangeSearchInputPlaceholder = (searchInputPlaceholder, id) => {
		const newImages = images.map(image => {
			if (image.dataId === id) {
				return { ...image, searchInputPlaceholder }
			}
			return image
		})
		setAttributes({
			images: newImages
		})
	}

	const onRemove = (id) => {
		const imagesList = images.filter(image => image.dataId !== id);

		imagesList.map((item, i) => item.dataId = i);
		setAttributes({ images: imagesList })
	}


	const moveImage = (id, dir) => {
		const position = images.findIndex(image => image.dataId === id);
		const item = images[position];
		const newImages = images.filter(image => image.dataId !== id);
		newImages.splice(position + dir, 0, item);

		newImages.map((item, i) => item.dataId = i);

		setAttributes({
			images: newImages
		});
	}

	const setImageAttributes = (image) => {
		const maxIdIndex = images.length - 1;
		let index = maxIdIndex + 1;

		const sortedImages = [...images];
		sortedImages.map((item, i) => item.dataId = i);
		setAttributes({
			images: [
				...sortedImages,
				{
					dataId: index,
					url: image.url,
					alt: image.alt,
					title: "",
					content: "",
					contentLink: "",
				}
			],
		})
	}

	const setContentType = (contentType) => {
		setAttributes({contentType: contentType});
	}
	return (
                
		<section {...blockProps} className={`${blockProps.className} p-0`}>
			{
				<InspectorControls key="setting">
					<div id="main-slider-control" class="p-3">
						<fieldset>
							<legend className="main-slider-control__label">
								Content type
							</legend>
							<SelectControl
									
									value={ contentType }
									onChange={ ( contentType ) => { setContentType( contentType ) } }
									__nextHasNoMarginBottom
							>
									<option value="slider">Mainpage slider</option>
									<option value="subpage">Subpage intro</option>
									<option value="blog">Blog Search</option>
							</SelectControl>
						</fieldset>
						
					</div>
				</InspectorControls>
				
			}
			<div className="page-intro">
				<Swiper
					className="intro-slider"
					spaceBetween={0}
					slidesPerView={1}
					pagination={{ clickable: true }}
					modules={[EffectFade, Pagination]} 
					effect="fade"
				>
					{
						images.length !== 0 && images.map(image => (
							<SwiperSlide>
								<SliderImage
									key={image.dataId}
									dataId={image.dataId}
									url={image.url}
									alt={image.alt}
									title={image.title}
									content={image.content}
									contentType={contentType}
									contentLink={image.contentLink}
									contentLinkText={image.contentLinkText}
									searchButtonText={image.searchButtonText}
									searchInputPlaceholder={image.searchInputPlaceholder}
									imagesNumber={images.length}
									onRemoveHandler={onRemove}
									onChangeTitle={onChangeTitle}
									onChangeContent={onChangeContent}
									onChangeContentLink={onChangeContentLink}
									onChangeContentLinkText={onChangeContentLinkText}
									onMoveImage={moveImage}
									onChangeSearchButtonText={onChangeSearchButtonText}
									onChangeSearchInputPlaceholder={onChangeSearchInputPlaceholder}
								/>
							</SwiperSlide>
						))
					}
				</Swiper>
			</div>


			<div className="slider-controls d-flex justify-content-between">
				<div className="upload">
					<MediaUpload
						onSelect={setImageAttributes}
						allowedTypes={ALLOWED_MEDIA_TYPES}
						render={({ open }) => (
							<>
								<Button variant={'secondary'} onClick={open}>
									{images.length === 0
										? 'Upload section image'
										: 'Upload new slide'
									}
								</Button>
							</>
						)}
					/>
				</div>
				
			</div>

		</section>
	);
}



