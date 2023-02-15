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
import { useBlockProps, RichText, MediaUpload } from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import bgShape1 from '../assets/gradient-shape-blue-grey.svg';
import smarthubModel1 from '../assets/technology-smarthub-top.png';
import smarthubModel2 from '../assets/technology-smarthub-design-module.png';
import smarthubModelBoard from '../assets/technology-board.png';
import smarthubModel3 from '../assets/technology-expansion.png';
import smarthubModel4 from '../assets/technology-smarthub-double-model.png';
import columnImage1 from '../assets/technology-faster-processing.png';
import columnImage2 from '../assets/technology-2x-storage.jpg';
import columnImage3 from '../assets/technology-encrypted-communication.png';
import bgShape2 from '../assets/gradient-shape-blue-grey-2.svg';
import bgShape3 from '../assets/gradient-shape-blue-grey-3.svg';
import bgShape4 from '../assets/gradient-shape-blue-grey-4.svg';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit(props) {

	const {
        attributes: { sectionOneTitle, sectionOneContent, sectionTwoTitle, sectionTwoContent, sectionThreeTitle, sectionThreeContent, sectionColumnsOneTitle, sectionColumnsOneContent, sectionColumnsTwoTitle, sectionColumnsTwoContent, sectionColumnsThreeTitle, sectionColumnsThreeContent, sectionFourTitle, sectionFourContent, sectionFiveTitle, sectionFiveContent},
        setAttributes } = props;

	return (
		<section { ...useBlockProps() } className="technology-parallax-module" >
			<div className="container technology-parallax-module__container layer-above">
				<div className="technology-parallax-module__row left row">
					<div className="col-sm-12 col-lg-4 col-xl-3 technology-parallax-module__content">
						<RichText
							tagName="h2"
							value={sectionOneTitle}
							allowedFormats={['core/bold', 'core/italic']}
							onChange={(sectionOneTitle) => setAttributes({ sectionOneTitle })}
							placeholder={__('Insert block title here...')}
						/>
						<RichText
							tagName="p"
							className="medium"
							value={sectionOneContent}
							allowedFormats={['core/bold', 'core/italic']}
							onChange={(sectionOneContent) => setAttributes({ sectionOneContent })}
							placeholder={__('Insert block content here...')}
						/>
					</div>
					<div className="col-sm-12 col-lg-8 offset-xl-1">
						<figure className="technology-parallax-module__img add-lines bottom">
							<img className="technology-parallax-module__img--front" src={smarthubModel1} alt="Smarthub Model"/>
						</figure>
					</div>
				</div>
			</div>
			<div className="container technology-parallax-module__container">
				<div className="technology-parallax-module__row right row ">
					<div className="col-sm-12 col-lg-5 order-lg-2 technology-parallax-module__content ps-lg-5">
						<RichText
							tagName="h2"
							value={sectionTwoTitle}
							allowedFormats={['core/bold', 'core/italic']}
							onChange={(sectionTwoTitle) => setAttributes({ sectionTwoTitle })}
							placeholder={__('Insert block title here...')}
						/>
						<RichText
							tagName="p"
							className="medium"
							value={sectionTwoContent}
							allowedFormats={['core/bold', 'core/italic']}
							onChange={(sectionTwoContent) => setAttributes({ sectionTwoContent })}
							placeholder={__('Insert block content here...')}
						/>
					</div>
					<div className="col-sm-12 col-lg-7 order-lg-1">
						<figure className="technology-parallax-module__img">
							<img className="technology-parallax-module__img--front" src={smarthubModel2} alt="Smarthub Model"/>
							<img className="technology-parallax-module__img--mask left-bottom wide" src={bgShape1} alt="Background element"/>
						</figure>
					</div>
				</div>
			</div>
			<div className="container technology-parallax-module__container third">
				<div className="technology-parallax-module__row left row align-items-end">
					<div className="col-sm-12 col-lg-7 technology-parallax-module__content">
						<RichText
							tagName="h2"
							value={sectionThreeTitle}
							allowedFormats={['core/bold', 'core/italic']}
							onChange={(sectionThreeTitle) => setAttributes({ sectionThreeTitle })}
							placeholder={__('Insert block title here...')}
						/>
						<RichText
							tagName="p"
							className="large"
							value={sectionThreeContent}
							allowedFormats={['core/bold', 'core/italic']}
							onChange={(sectionThreeContent) => setAttributes({ sectionThreeContent })}
							placeholder={__('Insert block content here...')}
						/>
					</div>
					<div className="col-sm-12 col-lg-4 offset-lg-1">
						<figure className="technology-parallax-module__img">
							<img className="technology-parallax-module__img--front"  src={smarthubModelBoard} alt="Smarthub Board"/>
							<img className="technology-parallax-module__img--mask right-bottom" src={bgShape2}  alt="Background element"/>
						</figure>
					</div>
				</div>
			</div>
			<div className="container technology-parallax-module__container layer-above">
				<div className="technology-parallax-module__row image-columns row">
					<div className="col-sm-6 col-lg-4 technology-parallax-module__column">
						<figure className="technology-parallax-module__column-img">
							<img className="technology-parallax-module__column-img--front" src={columnImage1} alt="2x Faster Processing"/>
						</figure>
						<RichText
							tagName="h2"
							className="technology-parallax-module__column--title"
							value={sectionColumnsOneTitle}
							allowedFormats={['core/bold', 'core/italic']}
							onChange={(sectionColumnsOneTitle) => setAttributes({ sectionColumnsOneTitle })}
							placeholder={__('Insert block title here...')}
						/>
						<RichText
							tagName="p"
							className="medium"
							value={sectionColumnsOneContent}
							allowedFormats={['core/bold', 'core/italic']}
							onChange={(sectionColumnsOneContent) => setAttributes({ sectionColumnsOneContent })}
							placeholder={__('Insert block content here...')}
						/>
					</div>
					<div className="col-sm-6 col-lg-4 technology-parallax-module__column">
						<figure className="technology-parallax-module__column-img">
							<img className="technology-parallax-module__column-img--front" src={columnImage2} alt="2x Storage"/>
						</figure>
						<RichText
							tagName="h2"
							className="technology-parallax-module__column--title"
							value={sectionColumnsTwoTitle}
							allowedFormats={['core/bold', 'core/italic']}
							onChange={(sectionColumnsTwoTitle) => setAttributes({ sectionColumnsTwoTitle })}
							placeholder={__('Insert block title here...')}
						/>
						<RichText
							tagName="p"
							className="medium"
							value={sectionColumnsTwoContent}
							allowedFormats={['core/bold', 'core/italic']}
							onChange={(sectionColumnsTwoContent) => setAttributes({ sectionColumnsTwoContent })}
							placeholder={__('Insert block content here...')}
						/>
					</div>
					<div className="col-sm-6 col-lg-4 technology-parallax-module__column">
						<figure className="technology-parallax-module__column-img">
							<img className="technology-parallax-module__column-img--front" src={columnImage3} alt="Encrypted communication"/>
						</figure>
						<RichText
							tagName="h2"
							className="technology-parallax-module__column--title"
							value={sectionColumnsThreeTitle}
							allowedFormats={['core/bold', 'core/italic']}
							onChange={(sectionColumnsThreeTitle) => setAttributes({ sectionColumnsThreeTitle })}
							placeholder={__('Insert block title here...')}
						/>
						<RichText
							tagName="p"
							className="medium"
							value={sectionColumnsThreeContent}
							allowedFormats={['core/bold', 'core/italic']}
							onChange={(sectionColumnsThreeContent) => setAttributes({ sectionColumnsThreeContent })}
							placeholder={__('Insert block content here...')}
						/>
					</div>
				</div>
			</div>
			<div className="container technology-parallax-module__container">
				<div className="technology-parallax-module__row left row">
					<div className="col-sm-12 col-lg-4 technology-parallax-module__content">
						<RichText
							tagName="h2"
							value={sectionFourTitle}
							allowedFormats={['core/bold', 'core/italic']}
							onChange={(sectionFourTitle) => setAttributes({ sectionFourTitle })}
							placeholder={__('Insert block title here...')}
						/>
						<RichText
							tagName="p"
							className="medium"
							value={sectionFourContent}
							allowedFormats={['core/bold', 'core/italic']}
							onChange={(sectionFourContent) => setAttributes({ sectionFourContent })}
							placeholder={__('Insert block content here...')}
						/>
					</div>
					<div className="col-sm-12 col-lg-7 offset-lg-1">
						<figure className="technology-parallax-module__img add-lines left">
							<img className="technology-parallax-module__img--front"  src={smarthubModel3}  alt="Smarthub Model"/>
							<img className="technology-parallax-module__img--mask left-bottom" src={bgShape3} alt="Background element"/>
						</figure>
					</div>
				</div>
			</div>
			<div className="container technology-parallax-module__container">
				<div className="technology-parallax-module__row left row">
					<div className="col-sm-12 col-lg-4 offset-lg-1 technology-parallax-module__content order-lg-2">
						<RichText
							tagName="h2"
							value={sectionFiveTitle}
							allowedFormats={['core/bold', 'core/italic']}
							onChange={(sectionFiveTitle) => setAttributes({ sectionFiveTitle })}
							placeholder={__('Insert block title here...')}
						/>
						<RichText
							tagName="p"
							className="medium"
							value={sectionFiveContent}
							allowedFormats={['core/bold', 'core/italic']}
							onChange={(sectionFiveContent) => setAttributes({ sectionFiveContent })}
							placeholder={__('Insert block content here...')}
						/>
					</div>
					<div className="col-sm-12 col-lg-5 order-lg-1">
						<figure className="technology-parallax-module__img add-lines last">
							<img className="technology-parallax-module__img--front" src={smarthubModel4} alt="Smarthub Model"/>
							<img className="technology-parallax-module__img--mask right-bottom" src={bgShape4}  alt="Background element"/>
						</figure>
					</div>
				</div>
			</div>
		</section>
	);
}
