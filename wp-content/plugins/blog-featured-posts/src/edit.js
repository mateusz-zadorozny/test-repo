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

import imagePlaceholder from './image-placeholder.jpg';
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
export default function Edit({ attributes: {
    firstArticle, firstArticleTitle, firstArticleLink,
    secondArticle, secondArticleTitle, secondArticleLink,
    thirdArticle, thirdArticleTitle, thirdArticleLink,
    fourthArticle, fourthArticleTitle, fourthArticleLink,
    fifthArticle, fifthArticleTitle, fifthArticleLink
}, setAttributes }) {

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
    const selectThirdArticle = (suggestion) => {
        setAttributes({
            thirdArticle: suggestion.id,
            thirdArticleTitle: suggestion.title,
            thirdArticleLink: suggestion.url,
        });
    }
    const selectFourthArticle = (suggestion) => {
        setAttributes({
            fourthArticle: suggestion.id,
            fourthArticleTitle: suggestion.title,
            fourthArticleLink: suggestion.url,
        });
    }
    const selectFifthArticle = (suggestion) => {
        setAttributes({
            fifthArticle: suggestion.id,
            fifthArticleTitle: suggestion.title,
            fifthArticleLink: suggestion.url,
        });
    }
    const suggestionsRender = (props, attributeName) => {

        var suggestions = props.suggestions;

        switch (attributeName) {
            case 'firstArticle':
                var handleOnClick = selectFirstArticle;
                break;
            case 'secondArticle':
                var handleOnClick = selectSecondArticle;
                break;
            case 'thirdArticle':
                var handleOnClick = selectThirdArticle;
                break;
            case 'fourthArticle':
                var handleOnClick = selectFourthArticle;
                break;
            case 'fifthArticle':
                var handleOnClick = selectFifthArticle;
                break;
            default:
                var handleOnClick = props.handleSuggestionClick;
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
        <section {...blockProps} className="blog-featured-posts">
            <div className="container">
                <div className="row">
                    <div className="col-md-6 pe-md-5">
                        <a href="#" class="post-card featured-post mb-4" style={{ backgroundImage: 'url(' + imagePlaceholder + ')' }}>
                            <div class="post-content py-2">
                                <p class="m-0 category-badge">Category</p>
                                <h3>
                                    {firstArticleTitle}
                                </h3>
                            </div>
                        </a>

                        <LinkControlSearchInput
                            placeholder="Search article link here..."
                            className="selected-articles__first"
                            renderSuggestions={(props) => suggestionsRender(props, 'firstArticle')}
                            allowDirectEntry={false}
                            withURLSuggestion={false}
                            value={firstArticleLink}
                            onChange={(firstArticleLink) => setAttributes({ firstArticleLink })}
                            withCreateSuggestion={false}
                        />
                    </div>
                    <div className="col-md-6">
                        <div className="row">
                            <div className="col-md-6">
                                <a href="#" class="post-card mb-4 d-block" >
                                    <figure class="post-image-wrapper">
                                        <img
                                            class="post-image"
                                            src={imagePlaceholder}
                                        />
                                    </figure>
                                    <div class="post-info py-2">
                                        <p class="m-0 category-badge">Category</p>
                                        <h3>
                                            {secondArticleTitle}
                                        </h3>
                                        <LinkControlSearchInput
                                            placeholder="Search article link here..."
                                            className="selected-articles__second"
                                            renderSuggestions={(props) => suggestionsRender(props, 'secondArticle')}
                                            allowDirectEntry={false}
                                            withURLSuggestion={false}
                                            value={secondArticleLink}
                                            onChange={(secondArticleLink) => setAttributes({ secondArticleLink })}
                                            withCreateSuggestion={false}
                                        />
                                    </div>
                                </a>
                            </div>
                            <div className="col-md-6">
                                <a href="#" class="post-card mb-4 d-block">
                                    <figure class="post-image-wrapper">
                                        <img
                                            class="post-image"
                                            src={imagePlaceholder}
                                        />
                                    </figure>
                                    <div class="post-info py-2">
                                        <p class="m-0 category-badge">Category</p>
                                        <h3>
                                            {thirdArticleTitle}
                                        </h3>
                                        <LinkControlSearchInput
                                            placeholder="Search article link here..."
                                            className="selected-articles__third"
                                            renderSuggestions={(props) => suggestionsRender(props, 'thirdArticle')}
                                            allowDirectEntry={false}
                                            withURLSuggestion={false}
                                            value={thirdArticleLink}
                                            onChange={(thirdArticleLink) => setAttributes({ thirdArticleLink })}
                                            withCreateSuggestion={false}
                                        />
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-md-6">
                                <a href="#" class="post-card mb-4 d-block">
                                    <figure class="post-image-wrapper">
                                        <img
                                            class="post-image"
                                            src={imagePlaceholder}
                                        />
                                    </figure>
                                    <div class="post-info py-2">
                                        <p class="m-0 category-badge">Category</p>
                                        <h3>
                                            {fourthArticleTitle}
                                        </h3>
                                        <LinkControlSearchInput
                                            placeholder="Search article link here..."
                                            className="selected-articles__fourth"
                                            renderSuggestions={(props) => suggestionsRender(props, 'fourthArticle')}
                                            allowDirectEntry={false}
                                            withURLSuggestion={false}
                                            value={fourthArticleLink}
                                            onChange={(fourthArticleLink) => setAttributes({ fourthArticleLink })}
                                            withCreateSuggestion={false}
                                        />
                                    </div>
                                </a>
                            </div>
                            <div className="col-md-6">
                                <a href="#" class="post-card mb-4 d-block">
                                    <figure class="post-image-wrapper">
                                        <img
                                            class="post-image"
                                            src={imagePlaceholder}
                                        />
                                    </figure>
                                    <div class="post-info py-2">
                                        <p class="m-0 category-badge">Category</p>
                                        <h3>
                                            {fifthArticleTitle}
                                        </h3>
                                        <LinkControlSearchInput
                                            placeholder="Search article link here..."
                                            className="selected-articles__fifth"
                                            renderSuggestions={(props) => suggestionsRender(props, 'fifthArticle')}
                                            allowDirectEntry={false}
                                            withURLSuggestion={false}
                                            value={fifthArticleLink}
                                            onChange={(fifthArticleLink) => setAttributes({ fifthArticleLink })}
                                            withCreateSuggestion={false}
                                        />
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}
