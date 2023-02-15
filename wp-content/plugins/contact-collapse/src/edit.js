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
import { useBlockProps, RichText, PlainText, InspectorControls } from '@wordpress/block-editor';
import { Button, Placeholder, SelectControl } from '@wordpress/components';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import BlockItem from './block-item';
import SocialItem from './social-item';

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
		attributes: { title, content, contactBlocks, sidebarBackgroundColor, socialMediaTitle, socialLinks, columnsVariant, sidebarTitle, formShortCode },
	} = props;

	const sortBlocks = (blocks, blockId) => {
		blocks.sort((a, b) => a.blockId - b.blockId);
		const newArrFoundedIndex = blocks.findIndex(block => block.blockId === blockId);
		blocks[newArrFoundedIndex].contacts.sort((a, b) => a.personId - b.personId);
		return blocks;
	}

	const onAddContactBlock = () => {
		let indexBlock = 0;
		let blocksToAdd = [];
		if (!!contactBlocks && contactBlocks.length !== 0) {
			const maxIdIndexBlocks = contactBlocks.length - 1;
			indexBlock = maxIdIndexBlocks + 1
			blocksToAdd = [...contactBlocks, {
				blockId: indexBlock,
				title: '',
				description: '',
				contacts: [{
					personId: 0,
					name: '',
					email: '',
					phone: ''
				}]
			}]
		} else {
			blocksToAdd = [{
				blockId: indexBlock,
				title: '',
				description: '',
				contacts: [{
					personId: 0,
					name: '',
					email: '',
					phone: ''
				}]
			}]
		}
		blocksToAdd.sort((a, b) => a.blockId - b.blockId);
		setAttributes({ contactBlocks: blocksToAdd })
	}

	const onAddPerson = (blockId) => {

		if (!contactBlocks) return;
		const foundedBlockIndex = contactBlocks.findIndex(block => block.blockId === blockId)

		const blocksToAdd = [
			...contactBlocks.filter(block => block.blockId !== blockId),
			{
				...contactBlocks[foundedBlockIndex],
				contacts: [
					...contactBlocks[foundedBlockIndex].contacts,
					{
						personId: contactBlocks[foundedBlockIndex].contacts.length,
						name: '',
						email: '',
						phone: ''
					}
				]
			}
		]

		const sortedBlocks = sortBlocks(blocksToAdd, blockId)
		setAttributes({ contactBlocks: sortedBlocks })
	}

	const onChangeTitle = (title, id) => {
		const blocksToAdd = contactBlocks.map(block => {
			if (block.blockId === id) {
				return { ...block, title }
			}
			return block;
		})

		setAttributes({ contactBlocks: blocksToAdd })
	}

	const onChangeSidebarTitle = (title) => {
		setAttributes({ sidebarTitle: title })
	}

	const onChangeDescription = (desc, id) => {
		const blocksToAdd = contactBlocks.map(block => {
			if (block.blockId === id) {
				return { ...block, description: desc }
			}
			return block;
		})

		setAttributes({ contactBlocks: blocksToAdd })
	}

	const onChangePersonProperty = (propertyName, propertyValue, blockId, personId) => {

		const foundBlockIndex = contactBlocks.findIndex(block => block.blockId === blockId)
		if (foundBlockIndex === -1) return;
		const contactsToAdd = [...contactBlocks[foundBlockIndex].contacts]
		const foundPersonIndex = contactsToAdd.findIndex(contact => contact.personId === personId)
		if (foundBlockIndex === -1) return;
		const filteredBlocks = contactBlocks.filter(block => block.blockId !== blockId);

		const filteredContacts = contactBlocks[foundBlockIndex].contacts.filter(contact => contact.personId !== personId)


		const blocksToAdd = [
			...filteredBlocks, {
				...contactBlocks[foundBlockIndex], contacts: [
					...filteredContacts,
					{
						...contactBlocks[foundBlockIndex].contacts[foundPersonIndex],
						...(propertyName === 'name') && { name: propertyValue },
						...(propertyName === 'email') && { email: propertyValue },
						...(propertyName === 'phone') && { phone: propertyValue },
					}
				]
			}
		]

		const sortedBlocks = sortBlocks(blocksToAdd, blockId)
		setAttributes({ contactBlocks: sortedBlocks })
	}

	const onRemoveBlock = (blockId) => {
		const filteredBlocks = contactBlocks.filter(block => block.blockId !== blockId)

		const blocksToAdd = filteredBlocks.map((block, index) => {
			return {
				...block,
				blockId: index
			}
		});
		blocksToAdd.sort((a, b) => a.blockId - b.blockId);
		setAttributes({ contactBlocks: blocksToAdd })
	}

	const onRemovePerson = (blockId, personId) => {

		const filteredBlocks = contactBlocks.filter(block => block.blockId !== blockId);
		const wantedBlock = contactBlocks.filter(block => block.blockId === blockId);
		const filteredContacts = wantedBlock[0].contacts.filter(contact => contact.personId !== personId)

		let blocksToAdd = [
			...filteredBlocks,
			{
				...wantedBlock[0],
				contacts: [
					...filteredContacts
				]
			}
		]

		const sortedBlocks = sortBlocks(blocksToAdd, blockId)
		setAttributes({ contactBlocks: sortedBlocks })
	}

	const setColumnsVariant = (columnsVariant) => {
		setAttributes({ columnsVariant: columnsVariant });
	}

	let columnClass1 = 'col-sm-12 col-xl-3 mb-5 mb-xl-0';
	let columnClass2 = 'col-sm-12 col-xl-8 offset-xl-1';

	if (columnsVariant === "4/8") {
		if (sidebarBackgroundColor === "white-bg"){
			columnClass1 = 'col-sm-12 col-xl-4 mb-5 mb-xl-0 ps-xl-5';
			columnClass2 = 'col-sm-12 col-xl-8';
		} else {
			columnClass1 = 'col-sm-12 col-xl-3 mb-5 mb-xl-0';
			columnClass2 = 'col-sm-12 col-xl-8 offset-xl-1';
		}
	} else if (columnsVariant === "8/4") {
		columnClass1 = 'col-sm-12 col-lg-7 mb-5';
		columnClass2 = 'col-sm-12 col-lg-5 d-flex justify-content-end';
	} else if (columnsVariant === "6/6") {
		columnClass1 = 'col-lg-6';
		columnClass2 = 'col-lg-6';
	}

	const setSidebarBackgroundColor = (backgroundColor) => {
		setAttributes({ sidebarBackgroundColor: backgroundColor });
	}

	const onChangeSocialMediaTitle = (socialMediaTitle) => {
		setAttributes({ socialMediaTitle: socialMediaTitle })
	}

	const onChangeSocialLinksProperty = (propertyName, propertyValue, socialItemId) => {

		if (!socialLinks || socialLinks.length === 0) return;
		const socialLinksToAdd = socialLinks.map(socialItem => {
			if (socialItem.socialItemId === socialItemId) {
				return {
					...socialItem,
					...(propertyName === 'iconImage') && { iconImage: propertyValue },
					...(propertyName === 'socialURL') && { socialURL: propertyValue },
					...(propertyName === 'title') && { title: propertyValue },
				}
			}
			return socialItem;
		})

		setAttributes({ socialLinks: socialLinksToAdd })
	}

	const onRemoveSocialLink = (socialItemId) => {
		const filteredSocialLinks = socialLinks.filter(socialItem => socialItem.socialItemId !== socialItemId)

		const socialLinksToAdd = filteredSocialLinks.map((socialItem, index) => {
			return {
				...socialItem,
				socialItemId: index
			}
		});
		socialLinksToAdd.sort((a, b) => a.socialItemId - b.socialItemId);
		setAttributes({ socialLinks: socialLinksToAdd })
	}


	const onAddSocialLinks = () => {
		let indexSocialLinks = 0;
		let socialLinksToAdd = [];
		if (!!socialLinks && socialLinks.length !== 0) {
			const maxIdIndex = socialLinks.length - 1;
			indexSocialLinks = maxIdIndex + 1
			socialLinksToAdd = [...socialLinks, {
				socialItemId: indexSocialLinks,
				socialURL: '',
				title: '',
			}]
		} else {
			socialLinksToAdd = [{
				socialItemId: indexSocialLinks,
				socialURL: '',
				title: '',
			}]
		}
		socialLinksToAdd.sort((a, b) => a.socialItemId - b.socialItemId);
		setAttributes({ socialLinks: socialLinksToAdd })
	}



	return (

		<section className="wp-block-create-block-contact-collapse" {...blockProps} >
			<InspectorControls key="setting">
				<fieldset class="p-3">
					<legend className="icons-columns-control__label">
						Columns variant
					</legend>
					<SelectControl

						value={columnsVariant}
						onChange={(columnsVariant) => { setColumnsVariant(columnsVariant) }}
						__nextHasNoMarginBottom
					>
						<option value="4/8">4/8</option>
						<option value="8/4">8/4</option>
						<option value="6/6">6/6</option>
					</SelectControl>
				</fieldset>
				<fieldset class="p-3">
					<legend className="counters-section-control__label">
						Form short code
					</legend>
					<PlainText
						tagName="form"
						placeholder="Add form short code"
						value={formShortCode}
						onChange={(formShortCode) => setAttributes({ formShortCode: formShortCode })}
					/>
				</fieldset>
				<fieldset class="p-3">
					<legend className="icons-columns-control__label">
						Sidebar Background color
					</legend>
					<SelectControl

						value={sidebarBackgroundColor}
						onChange={(sidebarBackgroundColor) => { setSidebarBackgroundColor(sidebarBackgroundColor) }}
						__nextHasNoMarginBottom
					>
						<option value="white-bg">White</option>
						<option value="xlgrey-bg">Light Grey</option>
						<option value="lgrey-bg">Grey</option>
					</SelectControl>
				</fieldset>
			</InspectorControls>
			<div className="container">

				<div className="row">
					<div className={columnClass1}>
						<div>
							<RichText
								tagName="h2"
								value={title}
								className="mt-0 contact-collapse-main-title"
								allowedFormats={['core/bold', 'core/italic']}
								onChange={(title) => setAttributes({ title })}
								placeholder={__('Insert block title here...')}
							/>
							<RichText
								tagName="p"
								className={`content`}
								value={content}
								allowedFormats={['core/bold', 'core/italic']}
								onChange={(content) => setAttributes({ content })}
								placeholder={__('Insert block content here...')}
							/>
						</div>
						{!contactBlocks || contactBlocks.length === 0 ? (
							<Button variant={'secondary'} onClick={onAddContactBlock}>Add contact block</Button>
						) : (
							<div className="contact-collapse">
								{contactBlocks.length !== 0 && contactBlocks.map(block => {
									return (
										<BlockItem
											key={block.blockId}
											dataId={block.blockId}
											title={block.title}
											description={block.description}
											contacts={block.contacts}
											onAddContactBlock={onAddContactBlock}
											onAddPerson={onAddPerson}
											onChangeTitle={onChangeTitle}
											onChangeDescription={onChangeDescription}
											onChangeContactName={onChangePersonProperty}
											onChangeContactEmail={onChangePersonProperty}
											onChangeContactPhone={onChangePersonProperty}
											onRemoveBlock={onRemoveBlock}
											onRemovePerson={onRemovePerson}
										/>
									)
								})}
							</div>
						)}

						{(columnsVariant !== '4/8') && (
							<div className="social-media">
								<RichText
									tagName="h3"
									value={socialMediaTitle}
									className="mt-5"
									allowedFormats={['core/bold', 'core/italic']}
									onChange={(socialMediaTitle) => onChangeSocialMediaTitle(socialMediaTitle)}
									placeholder={__('Insert block title here...')}
								/>
								<ul className="socials-list">
									{socialLinks.length !== 0 && socialLinks.map(block => {
										return (
											<SocialItem
												key={block.socialItemId}
												dataId={block.socialItemId}
												socialURL={block.socialURL}
												title={block.title}
												text={block.text}
												iconImage={block.iconImage ?? null}
												onChangeSocialLinksProperty={onChangeSocialLinksProperty}
												onRemoveSocialLink={onRemoveSocialLink}
											/>
										)
									})}
									<li>
										<Button variant={'secondary'} onClick={onAddSocialLinks}>Add link</Button>
									</li>
								</ul>
							</div>
						)}
					</div>

					<div className={columnClass2}>
						<div className={`${sidebarBackgroundColor} lgrey-bg sidebar`}>
							{sidebarBackgroundColor === 'white-bg' ? (
								<RichText
									className="contact__sidebar--title sidebar-title"
									tagName="h2"
									placeholder="Add sidebar title"
									value={sidebarTitle}
									onChange={(sidebarTitle) => onChangeSidebarTitle(sidebarTitle)}
								/>
							) : (
								<RichText
									className="contact__sidebar--title sidebar-intro"
									tagName="p"
									placeholder="Add sidebar title"
									value={sidebarTitle}
									onChange={(sidebarTitle) => onChangeSidebarTitle(sidebarTitle)}
								/>
							)}
							{formShortCode && (
								<Placeholder
									isColumnLayout
								>
									<div style={{ backgroundColor: "#e7e7e7", padding: "56px 64px", display: "flex", justifyContent: "center" }}>
										Form
									</div>
								</Placeholder>
							)}
						</div>
					</div>
				</div>
			</div>

		</section>
	);
}
