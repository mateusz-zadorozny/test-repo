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
import { useBlockProps, RichText, InspectorControls, MediaUpload } from '@wordpress/block-editor';
import { Button, SelectControl, FontSizePicker } from '@wordpress/components';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import SocialCard from './card';
import arrow from '../assets/Arrow.svg'
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
		attributes: { backgroundColor, title, content, fontSize, socialCardsBlock }
	} = props;

	const onChangeTitle = (title) => setAttributes({ title })
	const onChangeContent = (content) => setAttributes({ content })

	const setBackgroundColor = (backgroundColor) => {
		setAttributes({ backgroundColor: backgroundColor });
	}

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

	let fontSizeClass = 'default';

    if (fontSize === 20) {
        fontSizeClass = 'medium';
    } else if (fontSize === 24) {
        fontSizeClass = 'large';
    }

	const onChangeSocialCardsProperty = (propertyName, propertyValue, socialCardId) => {

		if (!socialCardsBlock || socialCardsBlock.length === 0) return;
		const socialCardsToAdd = socialCardsBlock.map(socialCard => {
			if (socialCard.socialCardId === socialCardId) {
				return {
					...socialCard,
					...(propertyName === 'iconImage') && { iconImage: propertyValue },
					...(propertyName === 'socialURL') && { socialURL: propertyValue },
					...(propertyName === 'title') && { title: propertyValue },
					...(propertyName === 'text') && { text: propertyValue },
				}
			}
			return socialCard;
		})

		setAttributes({ socialCardsBlock: socialCardsToAdd })
	}

	const onRemoveSocialCard = (socialCardId) => {
		const filteredSocialCards = socialCardsBlock.filter(socialCard => socialCard.socialCardId !== socialCardId)

		const socialCardsToAdd = filteredSocialCards.map((socialCard, index) => {
			return {
				...socialCard,
				socialCardId: index
			}
		});
		socialCardsToAdd.sort((a, b) => a.socialCardId - b.socialCardId);
		setAttributes({ socialCardsBlock: socialCardsToAdd })
	}


	const onAddSocialCards = () => {
		let indexSocialCards = 0;
		let socialCardsToAdd = [];
		if (!!socialCardsBlock && socialCardsBlock.length !== 0) {
			const maxIdIndex = socialCardsBlock.length - 1;
			indexSocialCards = maxIdIndex + 1
			socialCardsToAdd = [...socialCardsBlock, {
				socialCardId: indexSocialCards,
				socialURL: '',
				title: '',
				text: '',
			}]
		} else {
			socialCardsToAdd = [{
				socialCardId: indexSocialCards,
				socialURL: '',
				title: '',
				text: '',
			}]
		}
		socialCardsToAdd.sort((a, b) => a.socialCardId - b.socialCardId);
		setAttributes({ socialCardsBlock: socialCardsToAdd })
	}

	return (
	<section {...blockProps} className={`${backgroundColor} social-media-section`}>
		<InspectorControls key="setting">
			<div id="social-media-section-control">
				<fieldset className="p-3">
					<legend className="social-media-section-control__label">
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
				<fieldset className="p-3">
					<legend className="social-media-control__label">
						Main Text Size
					</legend>
					<ParagraphFontSizePicker />
				</fieldset>

			</div>
		</InspectorControls>
		<div className="container">
			<div className="row">
				<div className="col-sm-12 col-lg-3">
					<div className="social-media__content-box">
						<RichText
							tagName="h2"
							className="social-media__header"
							placeholder="Add block header"
							allowedFormats={ [ 'core/bold', 'core/italic' ] }
							value={title}
							onChange={(title) => onChangeTitle(title)}
						/>
						<RichText
							tagName="p"
							className={`social__text ${fontSizeClass}`}
							placeholder="Add block header"
							allowedFormats={ [ 'core/bold', 'core/italic' ] }
							value={content}
							onChange={(content) => onChangeContent(content)}
						/>
					</div>
				</div>
				<div className="col-sm-12 col-lg-8 offset-lg-1">
					<div className="social-media-banner">

						{socialCardsBlock.length !== 0 && socialCardsBlock.map(socialCard => {
							return (
								<>
									<SocialCard
										key={socialCard.socialCardId}
										dataId={socialCard.socialCardId}
										socialURL={socialCard.socialURL}
										title={socialCard.title}
										text={socialCard.text}
										iconImage={socialCard.iconImage ?? null}
										onChangeSocialCardsProperty={onChangeSocialCardsProperty}
										onRemoveSocialCard={onRemoveSocialCard}
									/>
								</>
							)
						})}
						<div className="social-media-banner__content-card col-4">
							<div className="social-media-banner__content-card--item">
								<Button variant={'secondary'} onClick={onAddSocialCards}>Add card</Button>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
    </section>
	);
}
