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
import { Button } from '@wordpress/components';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import Product from './product';

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

    const {
        attributes: { title, content, contentLinkText, contentLink, products },
        setAttributes } = props;

    const suggestionsRender = (props) => {
        var suggestions = props.suggestions,
            handleOnClick = props.handleSuggestionClick;

        return (
            <div className="components-dropdown-menu__menu">
                {
                    suggestions.map((suggestion, index) => {
                        return (
                            <div onClick={() => handleOnClick(suggestion)} className="components-button components-dropdown-menu__menu-product is-active has-text has-icon">{suggestion.title}</div>
                        )
                    })
                }
            </div>
        )
    }
    const onAddItem = () => {
        let index = 0;
        let productsToAdd = [];
        if (!!products && products.length !== 0) {
            const maxIdIndex = products.length - 1;
            index = maxIdIndex + 1
            productsToAdd = [...products, {
                dataId: index,
                title: '',
                image: '',
                logo: '',
                linkUrl: ''
            }]
        } else {
            productsToAdd = [{
                dataId: index,
                title: '',
                image: '',
                logo: '',
                linkUrl: ''
            }]
        }
        productsToAdd.sort((a, b) => a.dataId - b.dataId);
        setAttributes({ products: productsToAdd })
    }

    const onSelectItemImage = (itemImage, id) => {
        const itemsToAdd = products.map(item => {
            if (item.dataId === id) {
                if (null === itemImage) {
                    return { ...item, image: null }
                }
                return { ...item, image: itemImage.url }
            }
            return item;
        })

        setAttributes({ products: itemsToAdd });

    }

    const onSelectItemLogo = (itemImage, id) => {
        const itemsToAdd = products.map(item => {
            if (item.dataId === id) {
                if (null === itemImage) {
                    return { ...item, logo: null }
                }
                return { ...item, logo: itemImage.url }
            }
            return item;
        })

        setAttributes({ products: itemsToAdd });

    }
    const onSelectItemLink = (link, id) => {
        const itemsToAdd = products.map(item => {
            if (item.dataId === id) {
                if (null === link) {
                    return { ...item, linkUrl: null }
                }
                return { ...item, linkUrl: link }
            }
            return item;
        })

        setAttributes({ products: itemsToAdd });

    }

    const onRemove = (id) => {
        const productsList = products.filter(image => image.dataId !== id);

        productsList.map((item, i) => item.dataId = i);
        setAttributes({ products: productsList })
    }


    const onMoveProduct = (id, dir) => {
        const position = products.findIndex(product => product.dataId === id);
        const item = products[position];
        const newIcons = products.filter(product => product.dataId !== id);
        newIcons.splice(position + dir, 0, item);

        newIcons.map((item, i) => item.dataId = i);

        setAttributes({
            products: newIcons
        });
    }

    const onChangeItemTitle = (title, id) => {
        const itemsToAdd = products.map(item => {
            if (item.dataId === id) {
                if (null === title) {
                    return { ...item, title: null }
                }
                return { ...item, title }
            }
            return item;
        })

        setAttributes({ products: itemsToAdd });
    }
    return (
        <section className="wp-block-create-block-products-cards-module"  {...blockProps}>
            <div className="container">
                <div className="productCards">
                    <div className="row">
                        <div className="col-sm-12 col-lg-3">
                            <div className="productCards__content">
                                <RichText
                                    tagName="h2"
                                    className="productCards__header"
                                    value={title}
                                    allowedFormats={['core/bold', 'core/italic']}
                                    onChange={(title) => setAttributes({ title })}
                                    placeholder={__('Insert block title here...')}
                                />
                                <RichText
                                    tagName="p"
                                    className="productCards__text mobile-hide"
                                    value={content}
                                    allowedFormats={['core/bold', 'core/italic']}
                                    onChange={(content) => setAttributes({ content })}
                                    placeholder={__('Insert block content here...')}
                                />
                                <div className="me-2">
                                    <RichText
                                        tagName="a"
                                        className="button secondary mobile-hide"
                                        placeholder={'Add link text'}
                                        value={contentLinkText}
                                        onChange={(contentLinkText) => setAttributes({ contentLinkText })}
                                        type="button"
                                    />
                                </div>
                                <div className="mt-2">
                                    <LinkControlSearchInput
                                        placeholder="Search button link here..."
                                        className="productCards__content-link"
                                        renderSuggestions={(props) => suggestionsRender(props, false, '')}
                                        allowDirectEntry={true}
                                        withURLSuggestion={false}
                                        value={contentLink}
                                        onChange={(contentLink) => setAttributes({ contentLink })}
                                        withCreateSuggestion={false}
                                    />
                                </div>
                            </div>
                        </div>
                        <div className="col-sm-12 col-lg-8 offset-lg-1">
                            <div className="productCards__row row">
                                {!products || products.length === 0 ? (
                                    <Button variant={'secondary'} onClick={onAddItem}>
                                        Add product card
                                    </Button>
                                ) : (


                                    products && products.length !== 0 && products.map(product => {

                                        return (
                                            <>
                                                <div className="col-4 col-sm-12 col-lg-4 productCards__col mb-4">
                                                    <Product
                                                        key={product.dataId}
                                                        dataId={product.dataId}
                                                        image={product.image}
                                                        logo={product.logo}
                                                        title={product.title}
                                                        linkUrl={product.linkUrl}
                                                        iconsNumber={product.length}
                                                        onRemoveHandler={onRemove}
                                                        onMoveProduct={onMoveProduct}
                                                        onSelectItemImage={onSelectItemImage}
                                                        onSelectItemLogo={onSelectItemLogo}
                                                        onSelectItemLink={onSelectItemLink}
                                                        onChangeItemTitle={onChangeItemTitle}
                                                    />
                                                </div>
                                                {product.dataId === products.length - 1 && (
                                                    <div className="col-4 col-sm-12 col-lg-4 productCards__col mb-4">
                                                        <div className="productCards__card add-new">
                                                            <Button variant={'secondary'} onClick={onAddItem}>Add another product</Button>
                                                        </div>
                                                    </div>
                                                )}
                                            </>
                                        )
                                    })

                                )}
                            </div>
                            <a className="button secondary mobile-visible mt-4" href={contentLink}>
                                {contentLinkText}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}

