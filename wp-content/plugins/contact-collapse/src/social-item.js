import { MediaUpload, RichText } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';


const socialCard = ({ dataId, title, socialURL, iconImage, onChangeSocialLinksProperty, onRemoveSocialLink }) => {
    const ALLOWED_MEDIA_TYPES = ['image'];

    return (
        <li className="social-media-link__item">
            <div className="social-media-link__item-main">
                {!!iconImage && (
                    <figure className="social-media-link__img-wrapper">
                        <img className="social-media-link__img-src" src={iconImage.url} alt="Social icon" />
                    </figure>
                )}
                <div>
                    <RichText
                        tagName="span"
                        className="social-media-link__item-title mb-1"
                        placeholder="Add social title"
                        allowedFormats={ [ 'core/bold', 'core/italic' ] }
                        value={title}
                        onChange={(title) => onChangeSocialLinksProperty('title', title, dataId)}
                    />
                </div>
            </div>
            <div className="controls-panel absolute">
                <div className="d-flex align-items-center justify-content-between mt-3">
                    <Button
                        onClick={() => onRemoveSocialLink(dataId)}
                        className="removeBtn components-button"
                        variant={'secondary'}
                        isDestructive
                        icon="no-alt"
                    >
                        Remove
                    </Button>
                    <MediaUpload
                        onSelect={(image) => onChangeSocialLinksProperty('iconImage', image, dataId)}
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
                    onChange={(socialURL) => onChangeSocialLinksProperty('socialURL', socialURL, dataId)}
                />
            </div>
        </li>
    )
}

export default socialCard;