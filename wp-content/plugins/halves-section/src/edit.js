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
import { useBlockProps, RichText, MediaUpload, InspectorControls, __experimentalLinkControlSearchInput as LinkControlSearchInput } from '@wordpress/block-editor';
import { Button, SelectControl, FontSizePicker } from '@wordpress/components';
import { useState } from '@wordpress/element';


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

    const {
        attributes: { backgroundImage, blockVariant, textPosition, title, content, backgroundColor, fontSize },
        setAttributes } = props;

    const fontSizes = [
        {
            name: __( 'Default' ),
            slug: 'default',
            size: 16,
        },
        {
            name: __( 'Large' ),
            slug: 'large',
            size: 20,
        },
        {
            name: __( 'Extra Large' ),
            slug: 'xlarge',
            size: 24,
        },
    ];
    const fallbackFontSize = 16;

    const setFontSize = (fontSize) => {
		setAttributes({ fontSize: fontSize });
	}
    
    const ParagraphFontSizePicker = () => {
    
        return (
            <FontSizePicker
                __nextHasNoMarginBottom
                fontSizes={ fontSizes }
                value={ fontSize }
                disableCustomFontSizes
                fallbackFontSize={ fallbackFontSize }
                onChange={(fontSize) => { setFontSize(fontSize) }}
            />
        );
    };

    const onSelectBackgroundImage = (media) => {
        return props.setAttributes({
            backgroundImage: media.url
        });
    }

    const setTextPosition = (textPosition) => {
        setAttributes({ textPosition: textPosition });
    }

    const suggestionsRender = (props) => (
        <div className="components-dropdown-menu__menu">
            {props.suggestions.map((suggestion, index) => {
                return (
                    <div onClick={() => props.handleSuggestionClick(suggestion)} className="components-button components-dropdown-menu__menu-item is-active has-text has-icon">{suggestion.title}</div>
                )
            })
            }
        </div>
    )

    const setBackgroundColor = (backgroundColor) => {
		setAttributes({ backgroundColor: backgroundColor });
	}

    const setBlockVariant = (blockVariant) => {
		setAttributes({ blockVariant: blockVariant });
	}


    let fontSizeClass = 'default';

    if (fontSize === 20) {
        fontSizeClass = 'medium';
    } else if (fontSize === 24) {
        fontSizeClass = 'large';
    }


    return (

        <section {...blockProps} className={`${textPosition} ${backgroundColor} ${blockVariant} halvesModule`}>
            {
                <InspectorControls key="setting">
                    <div id="halves-section-control">
                        <fieldset class="p-3">
                            <legend className="halves-section-control__label">
                                Background image
                            </legend>
                            <MediaUpload
                                onSelect={onSelectBackgroundImage}
                                allowedTypes="image"
                                className="fc-media-ID"
                                value={backgroundImage}
                                render={({ open }) => (
                                    <Button
                                        className={
                                            backgroundImage ? 'image-button' : 'button button-large mb-3'
                                        }
                                        onClick={open}
                                    >
                                        {!backgroundImage ? (
                                            __('Upload Image', 'app-section')
                                        ) : (
                                            <img
                                                class="fc-media-url"
                                                src={backgroundImage}
                                                alt={__(
                                                    'Upload Image',
                                                    'app-section'
                                                )}
                                            />
                                        )}
                                    </Button>
                                )}
                            />
                            {backgroundImage && (
                                <Button onClick={() => props.setAttributes({ backgroundImage: null })} >remove</Button>
                            )}
                        </fieldset>
                        <fieldset class="p-3">
                            <legend className="halves-section-control__label">
                                Block variant
                            </legend>
                            <SelectControl
                                value={blockVariant}
                                onChange={(blockVariant) => { setBlockVariant(blockVariant) }}
                                __nextHasNoMarginBottom
                            >
                                <option value="classic-img">Classic Image</option>
                                <option value="infographic">Infographic</option>
                            </SelectControl>
                        </fieldset>
                        <fieldset class="p-3">
                            <legend className="halves-section-control__label">
                                Background color
                            </legend>
                            <SelectControl

                                value={backgroundColor}
                                onChange={(backgroundColor) => { setBackgroundColor(backgroundColor) }}
                                __nextHasNoMarginBottom
                            >
                                <option value="white-bg">White</option>
                                <option value="lgrey-bg">Grey</option>
                            </SelectControl>
                        </fieldset>
                        <fieldset class="p-3">
                            <legend className="halves-section-control__label">
                                Text position
                            </legend>
                            <SelectControl

                                value={textPosition}
                                onChange={(textPosition) => { setTextPosition(textPosition) }}
                                __nextHasNoMarginBottom
                            >
                                <option value="left">left</option>
                                <option value="right">right</option>
                            </SelectControl>
                        </fieldset>
                        <fieldset className="p-3">
                            <legend className="halves-section-control__label">
                                Main Text Size
                            </legend>
                            <ParagraphFontSizePicker />
                        </fieldset>

                    </div>
                </InspectorControls>

            }
            <div className="container">
                <div className="row align-items-center">
                    <div className={`${blockVariant === 'infographic' ? 'col-sm-12 col-lg-4' : 'col-sm-12 col-lg-6'} halvesModule__img-container`}>
                        <img className="halvesModule__img img-fluid" src={backgroundImage} alt="image" />
                    </div>
                    <div className={`${blockVariant === 'infographic' ? 'col-sm-12 col-lg-8' : 'col-sm-12 col-lg-6'} halvesModule__content`}>
                        <div className="halvesModule__content-box">
                            <RichText
                                tagName="h2"
                                className="halvesModule__header"
                                value={title}
                                allowedFormats={['core/bold', 'core/italic']}
                                onChange={(title) => setAttributes({ title })}
                                placeholder={__('Insert block title here...')}
                            />
                            <RichText
                                tagName="p"
                                className={`halvesModule__desc ${fontSizeClass}`}
                                value={content}
                                allowedFormats={['core/bold', 'core/italic']}
                                onChange={(content) => setAttributes({ content })}
                                placeholder={__('Insert block content here...')}
                            />
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}
