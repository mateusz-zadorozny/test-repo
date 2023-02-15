/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { Swiper, SwiperSlide } from 'swiper/react';
import { EffectFade, Pagination } from "swiper";
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';

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

        const { attributes: {
            }, setAttributes, attributes: {
                    images, contentType
            }, isSelected
                } = props;

	const blockProps = useBlockProps.save({
		className: `${props.attributes.contentType} p-0`,
	});
        
	return (
		<section {...blockProps}>
			<div className="page-intro intro_content_type">

				<div className="swiper intro-slider">
					<div className="swiper-wrapper">

						{
							images.length !== 0 && images.map((item, i) => {
								return (
									<div key={item.dataId} className="swiper-slide main-slider__item intro-slide">
										<figure className="intro-background-image">
											<img src={item.url} alt={item.alt} data-id={item.dataId} />
										</figure>
										<div className="intro-content">
											<div className="row">
												<div className="shape-content col-6">
													{item.title &&
														(
														 (item.dataId == 0) ? 
																	
															<RichText.Content
																tagName="h1"
																className="intro-content-title h1"
																value={item.title}
															/>
															:
															<RichText.Content
																tagName="h2"
																className="intro-content-title h1"
																value={item.title}
															/>
														)
													}
													{item.content &&
														(
															<RichText.Content
																className="intro"
																tagName="p"
																value={item.content}
															/>
														)
													}
													{(contentType !== 'blog') && item.contentLinkText && item.contentLink &&
														(
															<RichText.Content
																tagName="a"
																className="main-slider__content-link button primary"
																href={item.contentLink}
																value={item.contentLinkText}
																type="button"
															/>
														)
													}
													{(contentType === 'blog') &&
														(
															<div className="blog-search-group">
																<div className="form-group pe-4">
																	<input type="text" className="blog-search-input blog-search-input-placeholder" placeholder={item.searchInputPlaceholder} />
																</div>
                                                                                                                                <button className="button white">
                                                                                                                                <RichText.Content
                                                                                                                                        tagName="span"
                                                                                                                                        className="blog-search-button"
                                                                                                                                        value={item.searchButtonText}
                                                                                                                                />
                                                                                                                                </button>
															</div>
														)
													}
												</div>
											</div>
										</div>
									</div>
								)
							}
							)}

					</div>
					<div className="swiper-pagination"></div>
				</div>

			</div>
		</section>
	);
}
