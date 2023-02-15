import { MediaUpload, RichText } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';
import { __experimentalNumberControl as NumberControl } from '@wordpress/components';


const IconColumn = ({ dataId, text, title, iconImage, onChangeIconColumnProperty, onRemoveIconColumn }) => {
    const ALLOWED_MEDIA_TYPES = ['image'];


    return (
        <div className="col-12 col-sm-6 col-lg-4 mb-4 pe-lg-4 mb-4">
            <div className="icons-columns__card">
                {!!iconImage && (
                    <div className="icons-columns__card-left">
                        <img className="icons-columns__card-left--img" src={iconImage.url} />
                    </div>
                )}
                <div className="icons-columns__card-right">
                    <RichText
                        tagName="h3"
                        className="IconColumn_title"
                        placeholder="Add title"
                        value={title}
                        onChange={(title) => onChangeIconColumnProperty('title', title, dataId)}
                    />
                    <RichText
                        tagName="p"
                        className="IconColumn_text"
                        placeholder="Add text"
                        value={text}
                        onChange={(text) => onChangeIconColumnProperty('text', text, dataId)}
                    />

                </div>
            </div>
            <div className="d-flex align-items-center mt-4">
                <Button
                    onClick={() => onRemoveIconColumn(dataId)}
                    className="removeBtn components-button me-2"
                    variant={'secondary'}
                    isDestructive
                    icon="no-alt"
                >
                    Remove column
                </Button>
                {!!iconImage ? (
                    <>

                        <MediaUpload
                            onSelect={(image) => onChangeIconColumnProperty('iconImage', image, dataId)}
                            allowedTypes={ALLOWED_MEDIA_TYPES}
                            render={({ open }) => (
                                <>
                                    <Button variant={'secondary'} onClick={open}>
                                        Change icon
                                    </Button>
                                </>
                            )}
                        />
                    </>
                ) : (
                    <MediaUpload
                        onSelect={(image) => onChangeIconColumnProperty('iconImage', image, dataId)}
                        allowedTypes={ALLOWED_MEDIA_TYPES}
                        render={({ open }) => (
                            <>
                                <Button variant={'secondary'} onClick={open}>
                                    Upload icon
                                </Button>
                            </>
                        )}
                    />
                )}
            </div>
        </div>

    )
}

export default IconColumn;