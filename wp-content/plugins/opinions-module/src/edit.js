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
import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { Button, SelectControl } from '@wordpress/components';
import OpinionCard from './opinion-card';

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
		attributes: { backgroundColor, title, opinionsBlock }
	} = props;

	const onChangeTitle = (title) => setAttributes({ title })

	const onChangeOpinionProperty = (propertyName, propertyValue, opinionId) => {

		if (!opinionsBlock || opinionsBlock.length === 0) return;
		const opinionsToAdd = opinionsBlock.map(opinion => {
			if (opinion.opinionId === opinionId) {
				return {
					...opinion,
					...(propertyName === 'clientImage') && { clientImage: propertyValue },
					...(propertyName === 'clientName') && { clientName: propertyValue },
					...(propertyName === 'text') && { text: propertyValue },
					...(propertyName === 'rate') && { rate: propertyValue },
				}
			}
			return opinion;
		})

		setAttributes({ opinionsBlock: opinionsToAdd })
	}

	const onAddOpinion = () => {
		let indexOpinion = 0;
		let opinionsToAdd = [];
		if (!!opinionsBlock && opinionsBlock.length !== 0) {
			const maxIdIndex = opinionsBlock.length - 1;
			indexOpinion = maxIdIndex + 1
			opinionsToAdd = [...opinionsBlock, {
				opinionId: indexOpinion,
				text: '',
				clientName: '',
				rate: 5
			}]
		} else {
			opinionsToAdd = [{
				opinionId: indexOpinion,
				text: '',
				clientName: '',
				rate: 5
			}]
		}
		opinionsToAdd.sort((a, b) => a.opinionId - b.opinionId);
		setAttributes({ opinionsBlock: opinionsToAdd })
	}

	const onRemoveOpinion = (opinionId) => {
		const filteredOpinions = opinionsBlock.filter(opinion => opinion.opinionId !== opinionId)

		const opinionsToAdd = filteredOpinions.map((opinion, index) => {
			return {
				...opinion,
				opinionId: index
			}
		});
		opinionsToAdd.sort((a, b) => a.opinionId - b.opinionId);
		setAttributes({ opinionsBlock: opinionsToAdd })
	}

	const setBackgroundColor = (backgroundColor) => {
        setAttributes({ backgroundColor: backgroundColor });
    }


	return (
		<section {...blockProps} className={`${backgroundColor} OpinionsModule__section`}>
			<InspectorControls key="setting">
				<div id="OpinionsModule-control">
					<fieldset className="p-3">
						<legend className="OpinionsModule-control__label">
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
			<div className="container">
				<div className="OpinionsModule">
					<div className="row">
						<div className="col-12 col-xl-3 mb-5 mb-xl-0">
							<div className="OpinionsModule__content-box">
								<RichText
									tagName="h2"
									className="OpinionsModule__header"
									placeholder="Add block header"
									value={title}
									onChange={(title) => onChangeTitle(title)}
								/>
							</div>
						</div>
						<div className="col-12 col-xl-8 offset-xl-1">
							<div className="OpinionsModule__row row">
								{opinionsBlock.length !== 0 && opinionsBlock.map(opinion => {
									return (
										<>
											<OpinionCard
												key={opinion.opinionId}
												dataId={opinion.opinionId}
												text={opinion.text}
												clientImage={opinion.clientImage ?? null}
												clientName={opinion.clientName}
												rate={opinion.rate}
												onChangeOpinionProperty={onChangeOpinionProperty}
												onRemoveOpinion={onRemoveOpinion}
											/>
										</>
									)
								})}
								<div className="OpinionsModule__content-card col-4 col-sm-6 col-lg-4">
									<div className="OpinionsModule__content-card--item">
										<Button variant={'secondary'} onClick={onAddOpinion}>Add review</Button>
									</div>
								</div>

							</div>
						</div>

					</div>
				</div>
			</div>
		</section>
	);
}
