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

import PartnersItem from './partners-item';

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

	const { setAttributes, attributes: {
		title, partnersList, partnerLink
	} } = props;


	const onAddPartner = () => {
		let partnersToAdd = [];
		if (partnersList.length) {
			const nextIndex = partnersList.length;
			partnersToAdd = [
				...partnersList,
				{
					id: nextIndex,
					partnerId: null,
					partnerTitle: '',
					partnerLink: '',
					link: null
				}
			]
		} else {
			partnersToAdd = [{
				id: 0,
				partnerId: null,
				partnerTitle: '',
				partnerLink: '',
				link: null
			}]
		}

		setAttributes({ partnersList: partnersToAdd })
	}

	const onRemovePartner = (id) => {
		const newPartners = partnersList.filter(partner => partner.id !== id)
		const partnersToAdd = newPartners.map((partner, i) => ({ ...partner, id: i }));
		setAttributes({ partnersList: partnersToAdd })

	}

	const onMovePartner = (id, dir) => {
		const position = partnersList.findIndex(partner => partner.id === id);
		const item = partnersList[position];
		const newPartners = partnersList.filter(partner => partner.id !== id);
		newPartners.splice(position + dir, 0, item);

		const partnersToAdd = newPartners.map((partner, i) => ({ ...partner, id: i }));

		setAttributes({ partnersList: partnersToAdd })
	}

	const onSelectLogo = (logo, id) => {
		const partnersToAdd = partnersList.map(partner => {
			if (partner.id === id) {
				if (null == logo) {
					return { ...partner, logo: null }
				}
				return { ...partner, logo: logo.url }
			}
			return partner;
		})

		setAttributes({ partnersList: partnersToAdd })
	}


	const onChangePartnerLink = (partnerLink, id) => {

		const partnersToAdd = partnersList.map(partner => {
			if (partner.id === id) {
				return { ...partner, partnerLink }
			}
			return partner;
		})

		setAttributes({ partnersList: partnersToAdd })
	}
	const onChangePartnerTitle = (partnerTitle, id) => {

		const partnersToAdd = partnersList.map(partner => {
			if (partner.id === id) {
				return { ...partner, partnerTitle }
			}
			return partner;
		})

		setAttributes({ partnersList: partnersToAdd })
	}
	const onChangePartnerId = (partnerId, id) => {

		const partnersToAdd = partnersList.map(partner => {
			if (partner.id === id) {
				return { ...partner, partnerId }
			}
			return partner;
		})

		setAttributes({ partnersList: partnersToAdd })
	}
	const onChangeDescription = (description, id) => {
		const partnersToAdd = partnersList.map(partner => {
			if (partner.id === id) {
				return { ...partner, description }
			}
			return partner;
		})

		setAttributes({ partnersList: partnersToAdd })
	}
	const onChangeLink = (link, id) => {
		const partnersToAdd = partnersList.map(partner => {
			if (partner.id === id) {
				return { ...partner, link }
			}
			return partner;
		})

		setAttributes({ partnersList: partnersToAdd })
	}

	const handleOnClick = (suggestion, id) => {
		const partnerId = suggestion.id;
		const partnerTitle = suggestion.title;
		const partnerLink = suggestion.url;

		const partnersToAdd = partnersList.map(partner => {
			if (partner.id === id) {
				return { ...partner, partnerId, partnerTitle, partnerLink }
			}
			return partner;
		})

		setAttributes({ partnersList: partnersToAdd })
	}
	const suggestionsRender = (suggestions, id) => {

		suggestions = suggestions.filter((suggestion) => {
			return suggestion.type === 'partner';
		})
		return (
			<div className="components-dropdown-menu__menu">
				{

					suggestions.map((suggestion, index) => {
						return (
							<div onClick={() => handleOnClick(suggestion, id)} className="components-button components-dropdown-menu__menu-item is-active has-text has-icon">{suggestion.title}</div>
						)
					})
				}
			</div>
		)
	}

	return (
		<section {...blockProps} className="partners-module">
			<div className="container">
				<div className="row">

					<div className="col-12 col-xl-3 mb-5 mb-xl-0">
						<RichText
							tagName='h2'
							value={title}
							onChange={title => setAttributes({ title })}
							placeholder={__('Insert block title here...')}
						/>
					</div>
					<div className="col-12 col-xl-8 offset-xl-1 partners-list">
						{!partnersList || partnersList.length === 0 ? (
							<Button variant={'secondary'} onClick={onAddPartner}>
								Add parner
							</Button>
						) : (
							partnersList.length !== 0 && partnersList.map(partner => {


								return (
									<>
										<div class="partner-block">
											<PartnersItem
												key={partner.id}
												id={partner.id}
												partnerId={partner.partnerId}
												partnerLink={partner.partnerLink}
												partnerTitle={partner.partnerTitle}
												link={partner.link}
												onChangePartnerLink={onChangePartnerLink}
												onChangeLink={onChangeLink}
												partnersNumber={partnersList.length}
												onRemovePartner={onRemovePartner}
												onMovePartner={onMovePartner}
												suggestionsRender={suggestionsRender}
											/>
										</div>
										{partner.id === partnersList.length - 1 && (
											<div class="partner-block">
												<Button variant={'secondary'} className="mt-5" onClick={onAddPartner}>
													Add another partner
												</Button>
											</div>
										)}
									</>
								)


							})

						)
						}


					</div>
				</div>
			</div>
		</section>
	);
}
