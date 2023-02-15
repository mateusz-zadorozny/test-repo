import { Button } from '@wordpress/components';
import { useBlockProps, MediaUpload, RichText, MediaPlaceholder } from '@wordpress/block-editor';

export default function Icon(
    {
        dataId,
        url,
        alt,
        iconsNumber,
        onRemoveHandler,
        onMoveImage,
        setAttributes
    }
) {

    const UP = -1;
    const DOWN = 1;


    const img = (
        <img
            class="logos-exhibition-section-logo"
            data-id={dataId}
            src={url}
            alt={alt}

        />
    );

    const setIconAttributes = (icon) => {

        const sortedIcons = [...icons];
        sortedIcons.map((item, i) => item.dataId = dataId);
        setAttributes({
            icons: [
                ...sortedIcons,
                {
                    dataId: index,
                    url: icon.url,
                    alt: icon.alt,
                    link: ""
                }
            ],
        })
    }

    return (
        <div class="logo-group">
            <figure>
                {img}
            </figure>

            <div className="logo-controls absolute">
                <div className="d-flex justify-content-between">
                    <Button
                        onClick={() => onRemoveHandler(dataId)}
                        className="removeBtn components-button me-2"
                        variant={'secondary'}
                        isDestructive
                        icon="no-alt"
                    >
                        Remove Icon
                    </Button>

                    {(iconsNumber > 0 && !!dataId && dataId != 0 && dataId != iconsNumber - 1) &&
                        (<>
                            <Button variant={'secondary'} className="me-2" onClick={() => onMoveImage(dataId, UP)}>Up</Button>
                            <Button variant={'secondary'} className="me-2" onClick={() => onMoveImage(dataId, DOWN)}>Down</Button>
                        </>)
                    }
                    {(iconsNumber > 1 && dataId == 0) &&
                        (<>
                            <Button variant={'secondary'} className="me-2" onClick={() => onMoveImage(dataId, DOWN)}>Down</Button>
                        </>)
                    }
                    {(iconsNumber > 1 && dataId == iconsNumber - 1) &&
                        (<>
                            <Button variant={'secondary'} className="me-2" onClick={() => onMoveImage(dataId, UP)}>Up</Button>
                        </>)
                    }
                </div>

            </div>
        </div>

    );

}