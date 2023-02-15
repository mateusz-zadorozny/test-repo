
import { __ } from '@wordpress/i18n';
import { RichText, MediaUpload} from '@wordpress/block-editor';
import { Button } from '@wordpress/components';

export default function CountersItem({
  dataId,
  itemValue,
  itemLabel,
  itemsNumber,
  itemImage,
  itemButtonText,
  itemButtonURL,
  imageLabel,
  viewType,
  onChangeItemValue,
  onChangeItemLabel,
  onChangeItemButtonText,
  onChangeItemButtonURL,
  onDeleteCounter,
  onAddCounter,
  onSelectItemImage,
  onChangeImageLabel

}) {
  let percentageValue = (viewType === 'charts') ? itemValue.replace('%', '') : 0;
  const contentSpecialClass = (viewType === 'charts') ? 'smart-card' : '';

  const suggestionsRender = (props) => (
      <div className="components-dropdown-menu__menu">
          {props.suggestions.map((suggestion, index) => {
              return (
                  <div onClick={() => props.handleSuggestionClick(suggestion)} className="components-button components-dropdown-menu__menu-item is-active has-text has-icon">{suggestion.title}</div>
              )
          })
          }
      </div>
  )

  return (
    <div key={dataId} className={`${contentSpecialClass} my-4`} data-id={dataId}>
      {
        (!!itemsNumber) && (
          <div>
            <Button className="removeBtn components-button me-2 mb-2" variant={'secondary'} icon="no-alt" isDestructive>Delete</Button>
          </div>
        )
      }

      {
        (viewType === 'columns') && (
          <>
            <MediaUpload
              onSelect={(media) => onSelectItemImage(media, dataId)}
              allowedTypes="image"
              className="counters-section__items-image-url"
              value={itemImage}
              render={({ open }) => (
                <Button
                  className={
                    itemImage ? 'image-button' : 'button small mb-3'
                  }
                  onClick={open}
                >
                  {!itemImage ? (
                    __('Upload Image', 'counters-section')
                  ) : (
                    <>
                      <img
                        className="fc-media-url"
                        src={itemImage}
                        alt={__(
                          'Upload Image',
                          'counters-section'
                        )}
                      />
                      {
                        (itemImage) && (
                          <Button className="white-txt" onClick={() => onSelectItemImage(null, dataId)} >remove image</Button>
                        )
                      }
                    </>
                  )}
                </Button>
              )}
            />
            <RichText
              className="counters-section__item-value h3 mb-1"
              tagName="p"
              placeholder="Add counter value"
              value={itemValue}
              onChange={(itemValue) => onChangeItemValue(itemValue, dataId)}
            />
            <RichText
              className="counters-section__item-label py-0"
              tagName="p"
              placeholder="Add counter label"
              value={itemLabel}
              onChange={(itemLabel) => onChangeItemLabel(itemLabel, dataId)}
            />
            <RichText
              tagName="a"
              className="counters-section__item-button button white"
              placeholder={'Add link text'}
              value={itemButtonText}
              onChange={(itemButtonText) => onChangeItemButtonText(itemButtonText, dataId )}
              type="button"
            />
            <div className="mt-2">
              <RichText
                tagName="span"
                placeholder="Add link URL here..."
                className="counters-section__item-button link-container"
                value={itemButtonURL}
                onChange={(itemButtonURL) => onChangeItemButtonURL(itemButtonURL, dataId )}
                type="button"
              />
            </div>
          </>
        )
      }
      {
        (viewType == 'counters') && (
          <>
            <RichText
              className="counters-section__item-value h1 mb-1"
              tagName="p"
              placeholder="Add counter value"
              value={itemValue}
              onChange={(itemValue) => onChangeItemValue(itemValue, dataId)}
            />
            <RichText
              className="counters-section__item-label intro py-0"
              tagName="p"
              placeholder="Add counter label"
              value={itemLabel}
              onChange={(itemLabel) => onChangeItemLabel(itemLabel, dataId)}
            />
          </>
        )
      }

      {
        (viewType === 'charts') && (
          <>
            <div className="smart-card-img">
              <div className="smart-card-img-mainCircle">
                <div className="mkCharts" data-percent={percentageValue} data-size="154"></div>
                <div className="smart-card-chart-content">
                  <MediaUpload
                    onSelect={(media) => onSelectItemImage(media, dataId)}
                    allowedTypes="image"
                    className="counters-section__items-image-url"
                    value={itemImage}
                    render={({ open }) => (
                      <Button
                        className={
                          itemImage ? 'image-button' : 'button small mb-3'
                        }
                        onClick={open}
                      >
                        {!itemImage ? (
                          __('Upload Image', 'counters-section')
                        ) : (
                          <>
                            <div>
                              <img
                                src={itemImage}
                                alt={__(
                                  'Upload Image',
                                  'counters-section'
                                )}
                              />

                            </div>
                            {
                              (itemImage) && (
                                <div class="chart-icon-controls">
                                  <Button className="removeBtn components-button" variant={'secondary'} icon="no-alt" isDestructive onClick={() => onSelectItemImage(null, dataId)} >remove image</Button>
                                </div>
                              )
                            }
                          </>
                        )}
                      </Button>
                    )}
                  />
                  <RichText
                    className="counters-section__item-image-label"
                    tagName="p"
                    placeholder="Image label"
                    value={imageLabel}
                    onChange={(imageLabel) => onChangeImageLabel(imageLabel, dataId)}
                  />
                </div>
              </div>
            </div>
            <div className="smart-card-text">
              <RichText
                className="counters-section__item-value smart-card-text-big"
                tagName="p"
                placeholder="Add %"
                value={itemValue}
                onChange={(itemValue) => onChangeItemValue(itemValue, dataId)}
              />
              <RichText
                className="counters-section__item-label smart-card-text-small"
                tagName="p"
                placeholder="Add counter label"
                value={itemLabel}
                onChange={(itemLabel) => onChangeItemLabel(itemLabel, dataId)}
              />
            </div>
          </>

        )
      }

    </div>
  );
}

