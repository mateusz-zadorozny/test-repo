import { MediaUpload, RichText } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';
import { __experimentalNumberControl as NumberControl } from '@wordpress/components';

const OpinionCard = ({ dataId, text, clientImage, clientName, rate, onChangeOpinionProperty, onRemoveOpinion }) => {
    const ALLOWED_MEDIA_TYPES = ['image'];


    return (
        <div className="OpinionsModule__content-card col-4 col-sm-12 col-md-6 col-lg-4">
            <div className="OpinionsModule__content-card--item">
                <NumberControl
                    onChange={(rate) => onChangeOpinionProperty('rate', rate, dataId)}
                    value={rate}
                    label="Add rate"
                    labelPosition="side"
                    max={5}
                    min={1}
                />
                <RichText
                    tagName="p"
                    className="OpinionsModule__quote"
                    placeholder="Add review text"
                    value={text}
                    onChange={(text) => onChangeOpinionProperty('text', text, dataId)}
                />

                <span className="card-item-span"></span>

                <div className="OpinionsModule__quote-author">
                    {!!clientImage ? (
                        <>
                            <figure className="OpinionsModule__avatar">
                                <img className="OpinionsModule__img img-fluid" src={clientImage.url} alt="Client" />
                            </figure>
                            <MediaUpload
                                onSelect={(image) => onChangeOpinionProperty('clientImage', image, dataId)}
                                allowedTypes={ALLOWED_MEDIA_TYPES}
                                render={({ open }) => (
                                    <>
                                        <Button variant={'secondary'} onClick={open}>
                                            Change client image
                                        </Button>
                                    </>
                                )}
                            />
                        </>
                    ) : (
                        <MediaUpload
                            onSelect={(image) => onChangeOpinionProperty('clientImage', image, dataId)}
                            allowedTypes={ALLOWED_MEDIA_TYPES}
                            render={({ open }) => (
                                <>
                                    <Button variant={'secondary'} onClick={open}>
                                        Upload client image
                                    </Button>
                                </>
                            )}
                        />
                    )}

                    <RichText
                        tagName="p"
                        className="OpinionsModule__name"
                        placeholder="Add client name"
                        value={clientName}
                        onChange={(clientName) => onChangeOpinionProperty('clientName', clientName, dataId)}
                    />
                </div>
                <Button
                    onClick={() => onRemoveOpinion(dataId)}
                    className="removeBtn components-button mt-2"
                    variant={'secondary'}
                    isDestructive
                    icon="no-alt"
                >
                    Remove review
                </Button>
            </div>
        </div>
    )
}

export default OpinionCard;