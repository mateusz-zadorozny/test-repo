import { MediaUpload, RichText } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';
import arrow from '../assets/Arrow.svg'

const socialCard = ({ dataId, title, text, socialURL, iconImage, onChangeSocialCardsProperty, onRemoveIcon }) => {
    const ALLOWED_MEDIA_TYPES = ['image'];


    return (
        <div className="social-media-banner__item">
            <div className="social-media-banner__item-main">
                <div>
                    <RichText
                        tagName="h3"
                        className="social-media-banner__item-title mb-1"
                        placeholder="Add social title"
                        allowedFormats={ [ 'core/bold', 'core/italic' ] }
                        value={title}
                        onChange={(title) => onChangeSocialCardsProperty('title', title, dataId)}
                    />
                    <RichText
                        tagName="p"
                        className="social-media-banner__item-content mt-1"
                        placeholder="Add social text"
                        allowedFormats={ [ 'core/bold', 'core/italic' ] }
                        value={text}
                        onChange={(text) => onChangeSocialCardsProperty('text', text, dataId)}
                    />
                </div>
                <span className="social-media-banner__item-icon">
                    {!!iconImage ? (
                        <figure className="social-media-banner__avatar">
                            <img className="social-media-banner__img img-fluid" src={iconImage.url} alt="Client" />
                        </figure>
                    ) : (
                        <>
                            <img src={arrow} alt="arrow icon"/>
                        </>
                    )}
                </span>
            </div>
            <div className="d-flex align-items-center justify-content-between mt-3">
                <Button
                    onClick={() => onRemoveIcon(dataId)}
                    className="removeBtn components-button"
                    variant={'secondary'}
                    isDestructive
                    icon="no-alt"
                >
                    Remove card
                </Button>
                <MediaUpload
                    onSelect={(image) => onChangeSocialCardsProperty('iconImage', image, dataId)}
                    allowedTypes={ALLOWED_MEDIA_TYPES}
                    render={({ open }) => (
                        <>
                            <Button variant={'secondary'} onClick={open}>
                                Change icon
                            </Button>
                        </>
                    )}
                />
            </div>
            <RichText 
                tagName="p"
                className="form-control text-truncate text-nowrap"
                placeholder="http://"
                allowedFormats={ [''] }
                value={socialURL}
                onChange={(socialURL) => onChangeSocialCardsProperty('socialURL', socialURL, dataId)}
            />
        </div>
    )
}

export default socialCard;