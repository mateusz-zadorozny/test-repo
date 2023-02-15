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
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { Placeholder } from '@wordpress/components';

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
		setAttributes,
		attributes: { title, content },
	} = props;
        
	return (
        <section className="wp-block-create-block-open-positions-section" { ...blockProps }>
            <div className="container">
                <div className="row">
                    <div class="col-sm-12 col-lg-3">
                        <div class="open-positions__content-box">
                            <RichText
                                tagName="h2"
                                value={title}
                                className="open-positions__header"
                                allowedFormats={['core/bold', 'core/italic']}
                                onChange={(title) => setAttributes({title})}
                                placeholder={__('Insert block title here...')}
                                />
                            <RichText
                                tagName="p"
                                className="social__text"
                                value={content}
                                allowedFormats={['core/bold', 'core/italic']}
                                onChange={(content) => setAttributes({content})}
                                placeholder={__('Insert block content here...')}
                                />
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-8 offset-lg-1">
                    <Placeholder>
                        <div style={{backgroundColor: "#e7e7e7", padding: "56px 64px", display: "flex", justifyContent: "center", width: "100%"}}>
                            Job positions list
                        </div>
                    </Placeholder>
                    </div>
                </div>
            </div>
        </section>
	);
}
