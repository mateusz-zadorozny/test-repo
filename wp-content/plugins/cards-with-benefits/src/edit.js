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
import { RichText, InspectorControls, MediaUpload, useBlockProps, __experimentalLinkControlSearchInput as LinkControlSearchInput } from '@wordpress/block-editor';
import { SelectControl, Button, FontSizePicker } from '@wordpress/components';

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
const Edit = (props) => {
    const {
        attributes: {
            title, mainContent, optionColumns, fontSize, backgroundColor,
            fcMediaID, fcMediaURL, fcContentTitle, fcContent, fcLink, fcLinkText, fcfBenefitIcon, fcfBenefitTitle, fcfBenefit, fcsBenefitIcon, fcsBenefitTitle, fcsBenefit,
            fsMediaID, fsMediaURL, fsContentTitle, fsContent, fsLink, fsfBenefitIcon, fsfBenefitTitle, fsfBenefit, fssBenefitIcon, fssBenefitTitle, fssBenefit,
            ftMediaID, ftMediaURL, ftContentTitle, ftContent, ftLink, ftfBenefitIcon, ftfBenefitTitle, ftfBenefit, ftsBenefitIcon, ftsBenefitTitle, ftsBenefit
        },
        setAttributes,
    } = props;

    const blockProps = useBlockProps();


    function onSelectFCImage(media) {
        return props.setAttributes({
            fcMediaURL: media.url,
            fcMediaID: media.id,
        });
    };

    function onSelectFSImage(media) {
        return props.setAttributes({
            fsMediaURL: media.url,
            fsMediaID: media.id,
        });
    };
    function onSelectFTImage(media) {
        return props.setAttributes({
            ftMediaURL: media.url,
            ftMediaID: media.id,
        });
    };

    function onSelectFcsBenefitIcon(media) {
        return props.setAttributes({
            fcsBenefitIcon: media.url
        });
    };
    function onSelectFcfBenefitIcon(media) {
        return props.setAttributes({
            fcfBenefitIcon: media.url
        });
    };

    function onSelectFssBenefitIcon(media) {
        return props.setAttributes({
            fssBenefitIcon: media.url
        });
    };
    function onSelectFsfBenefitIcon(media) {
        return props.setAttributes({
            fsfBenefitIcon: media.url
        });
    };
    function onSelectFtsBenefitIcon(media) {
        return props.setAttributes({
            fstsBenefitIcon: media.url
        });
    };
    function onSelectFtfBenefitIcon(media) {
        return props.setAttributes({
            ftfBenefitIcon: media.url
        });
    };

    const setOptionColumns = (optionColumns) => {
        setAttributes({ optionColumns: optionColumns });
    }

    const setBackgroundColor = (backgroundColor) => {
		setAttributes({ backgroundColor: backgroundColor });
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

    let columnClass = 'col-12';

    if (optionColumns === "two-col") {
        columnClass = 'col-12 col-sm-6';
    } else if (optionColumns === "three-col") {
        columnClass = 'col-12 col-sm-6 col-lg-4';
    }

    const fontSizes = [
        {
            name: __('Default'),
            slug: 'default',
            size: 16,
        },
        {
            name: __('Large'),
            slug: 'large',
            size: 20,
        },
        {
            name: __('Extra Large'),
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
                fontSizes={fontSizes}
                value={fontSize}
                disableCustomFontSizes
                fallbackFontSize={fallbackFontSize}
                onChange={(fontSize) => { setFontSize(fontSize) }}
            />
        );
    };

    let fontSizeClass = 'default';

    if (fontSize === 20) {
        fontSizeClass = 'medium';
    } else if (fontSize === 24) {
        fontSizeClass = 'large';
    }


    return (
        <section {...blockProps} className={`wp-block-create-block-cards-with-benefits ${backgroundColor}`}>

            {
                <InspectorControls key="setting">
                    <div id="columns-control">
                        <fieldset className="p-3">
                            <legend className="columns-control__label">
                                Choose layout
                            </legend>
                            <SelectControl

                                value={optionColumns}
                                onChange={(optionColumns) => { setOptionColumns(optionColumns) }}
                                __nextHasNoMarginBottom
                            >
                                <option value="one-col">1 column</option>
                                <option value="two-col">2 columns</option>
                                <option value="three-col">3 columns</option>
                            </SelectControl>
                        </fieldset>
                        <fieldset class="p-3">
                            <legend className="icons-columns-control__label">
                                Background color
                            </legend>
                            <SelectControl

                                value={backgroundColor}
                                onChange={(backgroundColor) => { setBackgroundColor(backgroundColor) }}
                                __nextHasNoMarginBottom
                            >
                                <option value="white-bg">White</option>
                                <option value="lgrey-bg">Grey</option>
                                <option value="lblue-bg">Light Blue</option>
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

            <div className={`${optionColumns} container`}>
                <div className="row">
                    <div className="col-12 col-xl-3 mb-4 mb-xl-0">
                        <RichText
                            tagName="h2"
                            value={title}
                            className="mt-0"
                            allowedFormats={['core/bold', 'core/italic']}
                            onChange={(title) => setAttributes({ title })}
                            placeholder={__('Insert block title here...')}
                        />
                        <RichText
                            tagName="p"
                            className={`mainContent ${fontSizeClass}`}
                            value={mainContent}
                            allowedFormats={['core/bold', 'core/italic']}
                            onChange={(mainContent) => setAttributes({ mainContent })}
                            placeholder={__('Insert block content here...')}
                        />
                    </div>
                    <div className="col-12 col-xl-8 offset-xl-1">
                        <div className="row">
                            <div className={`${columnClass} mb-4 pe-lg-4`}>
                                <div className="d-inline-block">
                                    <LinkControlSearchInput
                                        placeholder="Search button link here..."
                                        className="fc-content-link"
                                        renderSuggestions={(props) => suggestionsRender(props)}
                                        allowDirectEntry={false}
                                        withURLSuggestion={false}
                                        value={fcLink}
                                        onChange={(fcLink) => setAttributes({ fcLink })}
                                        withCreateSuggestion={false}
                                    />
                                </div>
                                <MediaUpload
                                    onSelect={onSelectFCImage}
                                    allowedTypes="image"
                                    className="fc-media-ID"
                                    value={fcMediaID}
                                    render={({ open }) => (
                                        <Button
                                            className={
                                                fcMediaID ? 'image-button' : 'button mb-3'
                                            }
                                            onClick={open}
                                        >
                                            {!fcMediaID ? (
                                                __('Upload Image', 'cards-with-benefits')
                                            ) : (
                                                <figure className="mb-4 card-column__figure">
                                                    <img
                                                        className="fc-media-url"
                                                        src={fcMediaURL}
                                                        alt={__(
                                                            'Upload Image',
                                                            'cards-with-benefits'
                                                        )}
                                                    />
                                                </figure>
                                            )}
                                        </Button>
                                    )}
                                />
                                {fcMediaURL && (
                                    <Button onClick={() => props.setAttributes({ fcMediaURL: null, fcMediaID: null })} >remove</Button>
                                )}
                                <RichText
                                    tagName="h3"
                                    className="fc-content-title"
                                    value={fcContentTitle}
                                    onChange={(fcContentTitle) => setAttributes({ fcContentTitle })}
                                    placeholder={__('Insert title here...')}
                                    preserveWhiteSpace
                                    __unstablePastePlainText
                                />
                                <RichText
                                    tagName="p"
                                    className="fc-content"
                                    value={fcContent}
                                    allowedFormats={['core/bold', 'core/italic']}
                                    onChange={(fcContent) => setAttributes({ fcContent })}
                                    placeholder={__('Insert column content here...')}
                                    preserveWhiteSpace
                                    __unstablePastePlainText
                                />

                                <div className="benefits-row mt-5">
                                    <div className="benefit-column">
                                        <MediaUpload
                                            onSelect={onSelectFcfBenefitIcon}
                                            allowedTypes="image"
                                            value={fcfBenefitIcon}
                                            render={({ open }) => (
                                                <Button
                                                    className={
                                                        fcfBenefitIcon ? 'image-button' : 'button small mb-3'
                                                    }
                                                    onClick={open}
                                                >
                                                    {!fcfBenefitIcon ? (
                                                        __('Upload Image', 'cards-with-benefits')
                                                    ) : (
                                                        <img
                                                            className="fcf-benefit-icon"
                                                            width="24"
                                                            src={fcfBenefitIcon}
                                                            alt={__(
                                                                'Upload Image',
                                                                'cards-with-benefits'
                                                            )}
                                                        />


                                                    )}
                                                </Button>
                                            )}
                                        />
                                        {fcfBenefitIcon && (
                                            <Button onClick={() => props.setAttributes({ fcfBenefitIcon: null })} >remove</Button>
                                        )}
                                        <RichText
                                            tagName="h4"
                                            className="fcf-benefit-title"
                                            value={fcfBenefitTitle}
                                            allowedFormats={['core/bold', 'core/italic']}
                                            onChange={(fcfBenefitTitle) => setAttributes({ fcfBenefitTitle })}
                                            placeholder={__('Insert title here...')}
                                            
                                        />
                                        <RichText
                                            tagName="p"
                                            className="fcf-benefit"
                                            value={fcfBenefit}
                                            allowedFormats={['core/bold', 'core/italic', 'core/link']}
                                            onChange={(fcfBenefit) => setAttributes({ fcfBenefit })}
                                            placeholder={__('Insert column content here...')}
                                            
                                        />
                                    </div>
                                    <div className="benefit-column">

                                        <MediaUpload
                                            onSelect={onSelectFcsBenefitIcon}
                                            allowedTypes="image"
                                            value={fcsBenefitIcon}
                                            render={({ open }) => (
                                                <Button
                                                    className={
                                                        fcsBenefitIcon ? 'image-button' : 'button small mb-3'
                                                    }
                                                    onClick={open}
                                                >
                                                    {!fcsBenefitIcon ? (
                                                        __('Upload Image', 'cards-with-benefits')
                                                    ) : (
                                                        <img
                                                            className="fcs-benefit-icon"
                                                            width="24"
                                                            src={fcsBenefitIcon}
                                                            alt={__(
                                                                'Upload Image',
                                                                'cards-with-benefits'
                                                            )}
                                                        />
                                                    )}
                                                </Button>
                                            )}
                                        />
                                        {fcsBenefitIcon && (
                                            <Button onClick={() => props.setAttributes({ fcsBenefitIcon: null })} >remove</Button>
                                        )}
                                        <RichText
                                            tagName="h4"
                                            className="fcs-benefit-title"
                                            value={fcsBenefitTitle}
                                            onChange={(fcsBenefitTitle) => setAttributes({ fcsBenefitTitle })}
                                            placeholder={__('Insert title here...')}
                                            
                                        />
                                        <RichText
                                            tagName="p"
                                            className="fcs-benefit"
                                            value={fcsBenefit}
                                            allowedFormats={['core/bold', 'core/italic', 'core/link']}
                                            onChange={(fcsBenefit) => setAttributes({ fcsBenefit })}
                                            placeholder={__('Insert column content here...')}
                                            
                                        />
                                    </div>

                                </div>


                            </div>
                            {(optionColumns == 'two-col' || optionColumns == 'three-col') &&
                                (
                                    <div className={`${columnClass} mb-4 ps-lg-4`}>
                                        <div className="d-inline-block">
                                            <LinkControlSearchInput
                                                placeholder="Search button link here..."
                                                className="fs-content-link"
                                                renderSuggestions={(props) => suggestionsRender(props)}
                                                allowDirectEntry={false}
                                                withURLSuggestion={false}
                                                value={fsLink}
                                                onChange={(fsLink) => setAttributes({ fsLink })}
                                                withCreateSuggestion={false}
                                            />
                                        </div>
                                        <MediaUpload
                                            onSelect={onSelectFSImage}
                                            allowedTypes="image"
                                            value={fsMediaID}
                                            render={({ open }) => (
                                                <Button
                                                    className={
                                                        fsMediaID ? 'image-button' : 'button mb-3'
                                                    }
                                                    onClick={open}
                                                >
                                                    {!fsMediaID ? (
                                                        __('Upload Image', 'cards-with-benefits')
                                                    ) : (
                                                        <figure className="mb-4 card-column__figure">
                                                            <img
                                                                className="fs-media-url"
                                                                src={fsMediaURL}
                                                                alt={__(
                                                                    'Upload Image',
                                                                    'cards-with-benefits'
                                                                )}
                                                            />
                                                        </figure>
                                                    )}
                                                </Button>
                                            )}
                                        />
                                        {fsMediaURL && (
                                            <Button onClick={() => props.setAttributes({ fsMediaURL: null })} >remove</Button>
                                        )}
                                        <RichText
                                            tagName="h3"
                                            className="fs-content-title"
                                            value={fsContentTitle}
                                            onChange={(fsContentTitle) => setAttributes({ fsContentTitle })}
                                            placeholder={__('Insert title here...')}
                                            preserveWhiteSpace
                                            __unstablePastePlainText
                                        />
                                        <RichText
                                            tagName="p"
                                            className="fs-content"
                                            value={fsContent}
                                            allowedFormats={['core/bold', 'core/italic']}
                                            onChange={(fsContent) => setAttributes({ fsContent })}
                                            placeholder={__('Insert column content here...')}
                                            preserveWhiteSpace
                                            __unstablePastePlainText
                                        />

                                        <div className="benefits-row mt-5">
                                            <div className="benefit-column">
                                                <MediaUpload
                                                    onSelect={onSelectFsfBenefitIcon}
                                                    allowedTypes="image"
                                                    value={fsfBenefitIcon}
                                                    render={({ open }) => (
                                                        <Button
                                                            className={
                                                                fsfBenefitIcon ? 'image-button' : 'button small mb-3'
                                                            }
                                                            onClick={open}
                                                        >
                                                            {!fsfBenefitIcon ? (
                                                                __('Upload Image', 'cards-with-benefits')
                                                            ) : (
                                                                <img
                                                                    className="fsf-benefit-icon"
                                                                    width="24"
                                                                    src={fsfBenefitIcon}
                                                                    alt={__(
                                                                        'Upload Image',
                                                                        'cards-with-benefits'
                                                                    )}
                                                                />
                                                            )}
                                                        </Button>
                                                    )}
                                                />
                                                {fsfBenefitIcon && (
                                                    <Button onClick={() => props.setAttributes({ fsfBenefitIcon: null })} >remove</Button>
                                                )}
                                                <RichText
                                                    tagName="h4"
                                                    className="fsf-benefit-title"
                                                    value={fsfBenefitTitle}
                                                    onChange={(fsfBenefitTitle) => setAttributes({ fsfBenefitTitle })}
                                                    placeholder={__('Insert title here...')}
                                                   
                                                />
                                                <RichText
                                                    tagName="p"
                                                    className="fsf-benefit"
                                                    value={fsfBenefit}
                                                    allowedFormats={['core/bold', 'core/italic', 'core/link']}
                                                    onChange={(fsfBenefit) => setAttributes({ fsfBenefit })}
                                                    placeholder={__('Insert column content here...')}
                                                    
                                                />
                                            </div>
                                            <div className="benefit-column">
                                                <MediaUpload
                                                    onSelect={onSelectFssBenefitIcon}
                                                    allowedTypes="image"
                                                    value={fssBenefitIcon}
                                                    render={({ open }) => (
                                                        <Button
                                                            className={
                                                                fssBenefitIcon ? 'image-button' : 'button small mb-3'
                                                            }
                                                            onClick={open}
                                                        >
                                                            {!fssBenefitIcon ? (
                                                                __('Upload Image', 'cards-with-benefits')
                                                            ) : (
                                                                <img
                                                                    className="fss-benefit-icon"
                                                                    width="24"
                                                                    src={fssBenefitIcon}
                                                                    alt={__(
                                                                        'Upload Image',
                                                                        'cards-with-benefits'
                                                                    )}
                                                                />
                                                            )}
                                                        </Button>
                                                    )}
                                                />
                                                {fssBenefitIcon && (
                                                    <Button onClick={() => props.setAttributes({ fssBenefitIcon: null })} >remove</Button>
                                                )}
                                                <RichText
                                                    tagName="h4"
                                                    className="fss-benefit-title"
                                                    value={fssBenefitTitle}
                                                    onChange={(fssBenefitTitle) => setAttributes({ fssBenefitTitle })}
                                                    placeholder={__('Insert title here...')}
                                                    
                                                />
                                                <RichText
                                                    tagName="p"
                                                    className="fss-benefit"
                                                    value={fssBenefit}
                                                    allowedFormats={['core/bold', 'core/italic', 'core/link']}
                                                    onChange={(fssBenefit) => setAttributes({ fssBenefit })}
                                                    placeholder={__('Content...')}
                                                />
                                            </div>
                                        </div>
                                    </div>
                                )
                            }
                            {(optionColumns == 'three-col') &&
                                (
                                    <div className={`${columnClass} mb-4 ps-lg-4`}>
                                        <div className="d-inline-block">
                                            <LinkControlSearchInput
                                                placeholder="Search button link here..."
                                                className="ft-content-link"
                                                renderSuggestions={(props) => suggestionsRender(props)}
                                                allowDirectEntry={false}
                                                withURLSuggestion={false}
                                                value={ftLink}
                                                onChange={(ftLink) => setAttributes({ ftLink })}
                                                withCreateSuggestion={false}
                                            />
                                        </div>
                                        <MediaUpload
                                            onSelect={onSelectFTImage}
                                            allowedTypes="image"
                                            value={ftMediaID}
                                            render={({ open }) => (
                                                <Button
                                                    className={
                                                        ftMediaID ? 'image-button' : 'button mb-3'
                                                    }
                                                    onClick={open}
                                                >
                                                    {!ftMediaID ? (
                                                        __('Upload Image', 'cards-with-benefits')
                                                    ) : (
                                                        <figure className="mb-4 card-column__figure">
                                                            <img
                                                                className="ft-media-url"
                                                                src={ftMediaURL}
                                                                alt={__(
                                                                    'Upload Image',
                                                                    'cards-with-benefits'
                                                                )}
                                                            />
                                                        </figure>
                                                    )}
                                                </Button>
                                            )}
                                        />
                                        {ftMediaURL && (
                                            <Button onClick={() => props.setAttributes({ ftMediaURL: null })} >remove</Button>
                                        )}
                                        <RichText
                                            tagName="h3"
                                            className="ft-content-title"
                                            value={ftContentTitle}
                                            onChange={(ftContentTitle) => setAttributes({ ftContentTitle })}
                                            placeholder={__('Insert title here...')}
                                            preserveWhiteSpace
                                            __unstablePastePlainText
                                        />
                                        <RichText
                                            tagName="p"
                                            className="ft-content"
                                            value={ftContent}
                                            allowedFormats={['core/bold', 'core/italic']}
                                            onChange={(ftContent) => setAttributes({ ftContent })}
                                            placeholder={__('Insert column content here...')}
                                            preserveWhiteSpace
                                            __unstablePastePlainText
                                        />

                                        <div className="benefits-row mt-5">
                                            <div className="benefit-column">
                                                <MediaUpload
                                                    onSelect={onSelectFtfBenefitIcon}
                                                    allowedTypes="image"
                                                    value={ftfBenefitIcon}
                                                    render={({ open }) => (
                                                        <Button
                                                            className={
                                                                ftfBenefitIcon ? 'image-button' : 'button small mb-3'
                                                            }
                                                            onClick={open}
                                                        >
                                                            {!ftfBenefitIcon ? (
                                                                __('Upload Image', 'cards-with-benefits')
                                                            ) : (
                                                                <img
                                                                    className="fsf-benefit-icon"
                                                                    width="24"
                                                                    src={ftfBenefitIcon}
                                                                    alt={__(
                                                                        'Upload Image',
                                                                        'cards-with-benefits'
                                                                    )}
                                                                />
                                                            )}
                                                        </Button>
                                                    )}
                                                />
                                                {ftfBenefitIcon && (
                                                    <Button onClick={() => props.setAttributes({ ftfBenefitIcon: null })} >remove</Button>
                                                )}
                                                <RichText
                                                    tagName="h4"
                                                    className="ftf-benefit-title"
                                                    value={ftfBenefitTitle}
                                                    onChange={(ftfBenefitTitle) => setAttributes({ ftfBenefitTitle })}
                                                    placeholder={__('Insert title here...')}
                                                    
                                                />
                                                <RichText
                                                    tagName="p"
                                                    className="ftf-benefit"
                                                    value={ftfBenefit}
                                                    allowedFormats={['core/bold', 'core/italic', 'core/link']}
                                                    onChange={(ftfBenefit) => setAttributes({ ftfBenefit })}
                                                    placeholder={__('Insert column content here...')}
                                                    
                                                />
                                            </div>
                                            <div className="benefit-column">
                                                <MediaUpload
                                                    onSelect={onSelectFtsBenefitIcon}
                                                    allowedTypes="image"
                                                    value={ftsBenefitIcon}
                                                    render={({ open }) => (
                                                        <Button
                                                            className={
                                                                ftsBenefitIcon ? 'image-button' : 'button small mb-3'
                                                            }
                                                            onClick={open}
                                                        >
                                                            {!ftsBenefitIcon ? (
                                                                __('Upload Image', 'cards-with-benefits')
                                                            ) : (
                                                                <img
                                                                    className="fts-benefit-icon"
                                                                    width="24"
                                                                    src={ftsBenefitIcon}
                                                                    alt={__(
                                                                        'Upload Image',
                                                                        'cards-with-benefits'
                                                                    )}
                                                                />
                                                            )}
                                                        </Button>
                                                    )}
                                                />
                                                {ftsBenefitIcon && (
                                                    <Button onClick={() => props.setAttributes({ ftsBenefitIcon: null })} >remove</Button>
                                                )}
                                                <RichText
                                                    tagName="h4"
                                                    className="fts-benefit-title"
                                                    value={ftsBenefitTitle}
                                                    onChange={(ftsBenefitTitle) => setAttributes({ ftsBenefitTitle })}
                                                    placeholder={__('Insert title here...')}
                                                    
                                                />
                                                <RichText
                                                    tagName="p"
                                                    className="fts-benefit"
                                                    value={ftsBenefit}
                                                    allowedFormats={['core/bold', 'core/italic', 'core/link']}
                                                    onChange={(ftsBenefit) => setAttributes({ ftsBenefit })}
                                                    placeholder={__('Content...')}
                                                    
                                                />
                                            </div>
                                        </div>
                                    </div>
                                )
                            }
                        </div>
                    </div>
                </div>
            </div>

        </section>
    );
}


export default Edit;