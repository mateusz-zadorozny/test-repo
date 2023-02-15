/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { __ } from '@wordpress/i18n';
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
		title, content, isMaskChecked, backgroundImage, viewType, items
	}
	} = props

	let contentSpecialClass = 'image-columns';
	if (viewType === 'charts') {
        contentSpecialClass = 'charts-columns';
    } else if (viewType === 'counters') {
        contentSpecialClass = 'counters-columns';
    }

	return (
		<section {...blockProps} className="wp-block-create-block-counters-section parallax-window" data-parallax="scroll" data-image-src={backgroundImage}>
			<figure className={`${isMaskChecked ? 'mask-on' : 'mask-off'} counters-section-background`}  style={{ backgroundImage: 'url(' + backgroundImage + ')' }} ></figure>
			<div className={`${contentSpecialClass} container`}>
				<div className="row">
					<div className="col-12 col-lg-6 col-xl-4 mb-xl-0">
						<RichText.Content
							className="counters-section__title"
							tagName="h2"
							value={title}
						/>
					</div>
					<div className="col-xl-5 col-lg-6 mb-4 pe-lg-4">
						<RichText.Content
							className="counters-section__content intro"
							tagName="p"
							value={content}
						/>
					</div>
				</div>

				<div className="row">
					{
						!!items && items.map(item => {
							let columnSpecialClass = (viewType === 'charts') ? 'smart-card-container' : '';

							let percentageValue = (viewType === 'charts') ? item.itemValue.replace('%', '') : 0;
							return (
								<div className="counters-section__items-list col">

									<div key={item.dataId} data-id={item.dataId} className={`${columnSpecialClass} mt-4 mt-lg-5`}>
										{(viewType === 'columns' && item.itemImage) && (
											<img
												className="mb-4 counters-section__items-image-url"
												src={item.itemImage}
												alt={__('Image', 'cards-with-benefits')}
											/>
										)}
										{(viewType === 'columns') && (
											<>
												<RichText.Content
													className="counters-section__item-value mb-2"
													tagName="h3"
													value={item.itemValue}
												/>
												<RichText.Content
													className="counters-section__item-label column-content"
													tagName="p"
													value={item.itemLabel}
												/>
												{(item.itemButtonText && item.itemButtonURL) && (
													<RichText.Content
														tagName="a"
														className="counters-section__item-button button white"
														href={item.itemButtonURL}
														value={item.itemButtonText}
														type="button"
													/>
												)}
											</>
										)}
										{(viewType === 'counters') && (
											<>
												<RichText.Content
													className="counters-section__item-value h1 mb-0"
													tagName="h2"
													value={item.itemValue}
												/>
												<RichText.Content
													className="counters-section__item-label intro"
													tagName="p"
													value={item.itemLabel}
												/>
											</>
										)}

										{(viewType === 'charts') && (
											<div className="smart-card">
												<div className="smart-card-img">
													<div className="smart-card-img-mainCircle">
														<div className="mkCharts" data-percent={percentageValue} data-size="154"></div>
														<div className="smart-card-chart-content">
															<img
																className='counters-section__items-image-url'
																src={item.itemImage}
																alt="icon" />
															<RichText.Content
																className="counters-section__item-image-label"
																tagName="p"
																value={item.imageLabel}
															/>
														</div>
													</div>
												</div>
												<div className="smart-card-text">
													<RichText.Content
														className="counters-section__item-value smart-card-text-big"
														tagName="p"
														placeholder="Add %"
														value={item.itemValue}
													/>
													<RichText.Content
														className="counters-section__item-label smart-card-text-small"
														tagName="p"
														placeholder="Add counter label"
														value={item.itemLabel}
													/>
												</div>
											</div>
										)}
									</div>
								</div>

							)
						})
					}
				</div>
			</div>


		</section>

	);
}
