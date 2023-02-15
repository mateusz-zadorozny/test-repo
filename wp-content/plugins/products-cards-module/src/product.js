import { Button } from '@wordpress/components';
import { useBlockProps, MediaUpload, RichText, MediaPlaceholder } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

export default function Product(
  {
    dataId,
    image,
    title,
    linkUrl,
    logo,
    productsNumber,
    onRemoveHandler,
    onMoveProduct,
    setAttributes,
    onSelectItemImage,
    onSelectItemLogo,
    onSelectItemLink,
    onChangeItemTitle
  }
) {

  const UP = -1;
  const DOWN = 1;

  return (
    <>
      {(productsNumber > 0 && !!dataId && dataId != 0 && dataId != productsNumber - 1) &&
        (<>
          <Button variant={'secondary'} className="me-2" onClick={() => onMoveImage(dataId, UP)}>Up</Button>
          <Button variant={'secondary'} className="me-2" onClick={() => onMoveImage(dataId, DOWN)}>Down</Button>
        </>)
      }
      {(productsNumber > 1 && dataId == 0) &&
        (<>
          <Button variant={'secondary'} className="me-2" onClick={() => onMoveImage(dataId, DOWN)}>Down</Button>
        </>)
      }
      {(productsNumber > 1 && dataId == productsNumber - 1) &&
        (<>
          <Button variant={'secondary'} className="me-2" onClick={() => onMoveImage(dataId, UP)}>Up</Button>
        </>)
      }
      <div className="productCards__card">

        <figure className="productCards__card-imgBox" key={dataId} data-id={dataId}>
          {
            <MediaUpload
              onSelect={(media) => onSelectItemImage(media, dataId)}
              allowedTypes="image"
              className="productCards__card-img-url"
              value={image}
              render={({ open }) => (
                <Button
                  className={
                    image ? 'image-button product-card-img' : 'button small mb-3'
                  }
                  onClick={open}
                >
                  {!image ? (
                    __('Upload Image', 'productsCard-upload')
                  ) : (
                    <>
                      <img
                        className="productCards__card-img"
                        src={image}
                        alt={__(
                          'Upload Image',
                          'products-card'
                        )}
                      />
                      <Button className="remove-card-img" onClick={() => onSelectItemImage(null, dataId)} >remove image</Button>
                    </>
                  )}

                </Button>
              )}
            />
          }
        </figure>
        <div className="productCards__card-product w-100">
          <span className="productCards__card-span"></span>

          <div className="productCards__card-bottom">
            <RichText
              tagName="h3"
              className="productCards__card-title"
              value={title}
              allowedFormats={['core/bold', 'core/italic']}
              onChange={(title) => onChangeItemTitle(title, dataId)}
              placeholder={__('Insert title...')}
            />
            {
              <MediaUpload
                onSelect={(media) => onSelectItemLogo(media, dataId)}
                allowedTypes="image"
                className="productCards__card-logo-url"
                value={logo}
                render={({ open }) => (
                  <Button
                    className={
                      logo ? 'image-button' : 'button small mb-3'
                    }
                    onClick={open}
                  >
                    {!logo ? (
                      __('Upload Image', 'counters-section')
                    ) : (
                      <>
                        <img
                          className="productCards__card-logo"
                          src={logo}
                          alt={__(
                            'Upload Image',
                            'products-card'
                          )}
                        />
                        <Button onClick={() => onSelectItemLogo(null, dataId)} >remove image</Button>
                      </>
                    )}

                  </Button>
                )}
              />
            }

            <RichText
              tagName="a"
              className="productCards__card-linkUrl link-container"
              placeholder={'Add link'}
              value={linkUrl}
              onChange={(linkUrl) => onSelectItemLink(linkUrl, dataId)}
              type="button"
            />

          </div>

        </div>
      </div>
      <div>
        <Button
          onClick={() => onRemoveHandler(dataId)}
          className="removeBtn components-button me-2"
          variant={'secondary'}
          isDestructive
          product="no-alt"
        >
          Remove Product
        </Button>
      </div>
    </>


  );

}