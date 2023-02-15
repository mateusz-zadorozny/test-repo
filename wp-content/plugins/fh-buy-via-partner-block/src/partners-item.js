import { __ } from '@wordpress/i18n';
import { RichText, MediaUpload, __experimentalLinkControlSearchInput as LinkControlSearchInput } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';

export default function PartnersItem({ id, partnerId, partnerLink, partnerTitle, link, onChangePartnerLink, onChangeLink, partnersNumber, onRemovePartner, onMovePartner, suggestionsRender }) {

  const UP = -1;
  const DOWN = 1;


  return (
    <>
      <div className="partner-block__brand">
        <h2>{partnerTitle}</h2>
      </div>
      <div className="partner-block__description">
        <LinkControlSearchInput
          placeholder="Search for partner here..."
          className="partner-block-link"
          renderSuggestions={(props) => suggestionsRender(props.suggestions, id)}
          allowDirectEntry={false}
          withURLSuggestion={false}
          value={partnerLink}
          onChange={(partnerLink) => onChangePartnerLink(partnerLink, id)}
          withCreateSuggestion={false}
        />

        <RichText
          tagName='p'
          className="partner-block-second-link link-control"
          value={link}
          onChange={(link) => onChangeLink(link, id)}
          placeholder={__("Insert custom link to partner's website...")}
        />
      </div>
      <div className="partner-buttons-group d-flex mt-3">
        {partnersNumber && id > 0 && (
          <Button
            onClick={() => onRemovePartner(id)}
            className="removeBtn components-button me-2"
            variant={'secondary'}
            isDestructive
            icon="no-alt"
          >
              Remove partner
          </Button>
        )}
        {(partnersNumber > 0 && !!id && id != 0 && id != partnersNumber - 1) &&
          (<>
            <Button variant={'secondary'} className="me-2" onClick={() => onMovePartner(id, UP)}>Up</Button>
            <Button variant={'secondary'} className="me-2" onClick={() => onMovePartner(id, DOWN)}>Down</Button>
          </>)
        }
        {(partnersNumber > 1 && id == 0) &&
          (<>
            <Button variant={'secondary'} className="me-2" onClick={() => onMovePartner(id, DOWN)}>Down</Button>
          </>)
        }
        {(partnersNumber > 1 && id == partnersNumber - 1) &&
          (<>
            <Button variant={'secondary'} className="me-2" onClick={() => onMovePartner(id, UP)}>Up</Button>
          </>)
        }
      </div>
    </>
  )
}