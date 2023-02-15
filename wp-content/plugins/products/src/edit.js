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
import { useBlockProps, RichText, __experimentalLinkControlSearchInput as LinkControlSearchInput } from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation, Pagination } from "swiper";
import 'swiper/css';
import 'swiper/css/pagination';
import imagePlaceholder from './image-placeholder.jpg';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit({ attributes: { title, contentLinkText, contentLink }, setAttributes }) {
    const blockProps = useBlockProps();

    const maxproducts = 10;

    const suggestionsRender = (props, onlyPostType, attributeName) => {

        var suggestions = props.suggestions;

        return (
            <div className="components-dropdown-menu__menu">
                {
                    suggestions.map((suggestion, index) => {
                        return (
                            <div onClick={() => props.handleSuggestionClick(suggestion)} className="components-button components-dropdown-menu__menu-item is-active has-text has-icon">{suggestion.title}</div>
                        )
                    })
                }
            </div>
        )
    }

    return (
        <section {...blockProps}>
            <div class="container">
                <div class="row">

                    <div class="col-12 col-lg-7 mb-5 mb-xl-0">
                        <RichText
                            tagName="h2"
                            value={title}
                            allowedFormats={['core/bold', 'core/italic']}
                            onChange={(title) => setAttributes({ title })}
                            placeholder={__('Insert block title here...')}
                        />
                    </div>

                    <div className="col-12 col-lg-5">
                        <div className="progress-pagination my-4"></div>
                    </div>

                    <Swiper
                        className="products-carousel my-5"
                        spaceBetween={24}
                        modules={[Pagination, Navigation]}
                        navigation={true}
                        pagination={{
                            type: "progressbar",
                            el: '.progress-pagination'
                        }}
                    >

                        {(() => {
                            let container = [];
                            for (var i = 0; i < 10; i++) {
                                container.push(
                                    <SwiperSlide>
                                        <div className="product-card">
                                            <figure className="product-image">
                                                <img src={imagePlaceholder} />
                                            </figure>
                                            <div className="product-card-content">
                                                <h3 className="mb-0">Starter kit</h3>
                                                <p className="product-price">kr 4,080.00</p>
                                            </div>
                                        </div>
                                    </SwiperSlide>)
                            }
                            return container;
                        })()}


                    </Swiper>

                    <div className="col-12 text-center">
                        <RichText
                            tagName="a"
                            className="products__content-link button secondary me-2"
                            placeholder={'Add link text'}
                            value={contentLinkText}
                            onChange={(contentLinkText) => setAttributes({ contentLinkText })}
                            type="button"
                        />
                        <div className="d-inline-block">
                            <LinkControlSearchInput
                                placeholder="Search button link here..."
                                className="products__content-link"
                                renderSuggestions={(props) => suggestionsRender(props)}
                                allowDirectEntry={true}
                                withURLSuggestion={false}
                                value={contentLink}
                                onChange={(contentLink) => setAttributes({ contentLink })}
                                withCreateSuggestion={false}
                            />
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}
