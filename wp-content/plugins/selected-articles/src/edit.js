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
import { useBlockProps, InspectorControls, RichText, __experimentalLinkControlSearchInput as LinkControlSearchInput } from '@wordpress/block-editor';
import { SelectControl } from '@wordpress/components';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import imagePlaceholder from './image-placeholder.jpg';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit({ attributes: { title, subtitle, backgroundColor, contentLinkText, contentLink, firstArticle, firstArticleTitle, firstArticleLink, secondArticle, secondArticleTitle, secondArticleLink }, setAttributes }) {

    const blockProps = useBlockProps();
    const selectFirstArticle = (suggestion) => {
        setAttributes({
            firstArticle: suggestion.id,
            firstArticleTitle: suggestion.title,
            firstArticleLink: suggestion.url,
        });
    }
    const selectSecondArticle = (suggestion) => {
        setAttributes({
            secondArticle: suggestion.id,
            secondArticleTitle: suggestion.title,
            secondArticleLink: suggestion.url,
        });
    }

    const setBackgroundColor = (backgroundColor) => {
		setAttributes({ backgroundColor: backgroundColor });
	}

    const suggestionsRender = (props, onlyPostType, attributeName) => {

        var suggestions = props.suggestions,
            handleOnClick = props.handleSuggestionClick;

        if (onlyPostType) {

            suggestions = suggestions.filter((suggestion) => {
                return suggestion.type === 'post';
            })
            if (attributeName === 'firstArticle') {
                handleOnClick = selectFirstArticle;
            }
            else {
                handleOnClick = selectSecondArticle;
            }
        }

        return (
            <div className="components-dropdown-menu__menu">

                {

                    suggestions.map((suggestion, index) => {
                        return (
                            <div onClick={() => handleOnClick(suggestion)} className="components-button components-dropdown-menu__menu-item is-active has-text has-icon">{suggestion.title}</div>
                        )
                    })
                }
            </div>
        )
    }
    return (
        <section className={`${backgroundColor} wp-block-create-block-selected-articles`} {...blockProps}>
            <InspectorControls key="setting">
                <div id="icons-columns-control">
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
                        </SelectControl>
                    </fieldset>

                </div>
            </InspectorControls>
            <div class="container">
                <div class="row">
                    <div class="col-12 col-xl-3 mb-5 mb-xl-0">
                        <RichText
                            tagName="h2"
                            value={title}
                            allowedFormats={['core/bold', 'core/italic']}
                            onChange={(title) => setAttributes({ title })}
                            placeholder={__('Insert block title here...')}
                        />
                        <RichText
                            tagName="p"
                            className="subtitle ps-0"
                            value={subtitle}
                            allowedFormats={['core/bold', 'core/italic']}
                            onChange={(subtitle) => setAttributes({ subtitle })}
                            placeholder={__('Insert block content here...')}
                        />
                        <div className="me-2">
                            <RichText
                                tagName="span"
                                className="selected-articles__content-link button secondary"
                                placeholder={'Add link text'}
                                value={contentLinkText}
                                onChange={(contentLinkText) => setAttributes({ contentLinkText })}
                                type="button"
                            />
                        </div>
                        <div className="mt-2">
                            <LinkControlSearchInput
                                placeholder="Search button link here..."
                                className="selected-articles__content-link"
                                renderSuggestions={(props) => suggestionsRender(props, false, '')}
                                allowDirectEntry={true}
                                withURLSuggestion={false}
                                value={contentLink}
                                onChange={(contentLink) => setAttributes({ contentLink })}
                                withCreateSuggestion={false}
                            />
                        </div>

                    </div>
                    <div className="col-xl-4 col-sm-6 offset-xl-1 mb-4 pe-lg-4">
                        <div class="post-card mb-4 d-block" data-id="{firstArticle}">
                            <figure class="post-image-wrapper">
                                <img class="post-image" src={imagePlaceholder} />
                            </figure>
                            <div class="post-info py-2">
                                <h3>{firstArticleTitle}</h3>
                                <LinkControlSearchInput
                                    placeholder="Search button link here..."
                                    className="selected-articles__first"
                                    renderSuggestions={(props) => suggestionsRender(props, true, 'firstArticle')}
                                    allowDirectEntry={false}
                                    withURLSuggestion={false}
                                    value={firstArticleLink}
                                    onChange={(firstArticleLink) => setAttributes({ firstArticleLink })}
                                    withCreateSuggestion={false}
                                />
                            </div>
                        </div>
                    </div>
                    <div className="col-xl-4 col-sm-6 mb-4 ps-lg-4">
                        <div class="post-card mb-4 d-block" data-id="{secondArticle}">
                            <figure class="post-image-wrapper">
                                <img class="post-image" src={imagePlaceholder} />
                            </figure>
                            <div class="post-info py-2">
                                <h3>{secondArticleTitle}</h3>
                                <LinkControlSearchInput
                                    placeholder="Search button link here..."
                                    className="selected-articles__second"
                                    renderSuggestions={(props) => suggestionsRender(props, true, 'secondArticle')}
                                    allowDirectEntry={false}
                                    withURLSuggestion={false}
                                    value={secondArticleLink}
                                    onChange={(secondArticleLink) => setAttributes({ secondArticleLink })}
                                    withCreateSuggestion={false}
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    );
}
