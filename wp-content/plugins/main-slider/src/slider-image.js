import { Button, TextControl } from '@wordpress/components';
import { useBlockProps, InspectorControls, MediaUpload, RichText, MediaPlaceholder, __experimentalLinkControlSearchInput as LinkControlSearchInput } from '@wordpress/block-editor';

export default function SliderImage(
    {
        dataId,
        url,
        alt,
        title,
        content,
        contentType,
        contentLink,
        contentLinkText,
        searchButtonText,
        searchInputPlaceholder,
        imagesNumber,
        onRemoveHandler,
        onChangeTitle,
        onChangeContent,
        onChangeContentLink,
        onChangeContentLinkText,
        onChangeSearchInputPlaceholder,
        onMoveImage,
        onChangeSearchButtonText,
        setAttributes
    }
) {

    const UP = -1;
    const DOWN = 1;


    const img = (
        <img
            data-id={dataId}
            src={url}
            alt={alt}

        />
    );



    const setImageAttributes =  ( image ) => {

        const sortedImages = [...images];
        sortedImages.map( (item, i) => item.dataId = dataId);
        setAttributes({
                contentType,
                images: [
                        ...sortedImages,
                        {
                                dataId: index,
                                url: image.url,
                                alt: image.alt,
                                title: "",
                                content: "",
                                contentLink: ""
                        }
                ],
        })
}

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

        <div className={`main-slider__item intro-slide`}>
            <figure className="intro-background-image">
                {img}
            </figure>
            <div className="intro-content">
                <div className="row">
                    <div className="shape-content">
                        <RichText
                            tagName={'h2'}
                            className="intro-content-title h1"
                            placeholder={'Add title'}
                            value={title}
                            onChange={title => onChangeTitle(title, dataId)}
                        />
                            
                        <RichText
                            tagName={'p'}
                            className="intro"
                            placeholder={'Add text'}
                            value={content}
                            onChange={(content) => onChangeContent(content, dataId)}
                        />
                        {(contentType !== 'blog') &&
                            (
                                <div className="d-flex">
                                    <div className="me-2">
                                        <RichText
                                            tagName="a"
                                            className="main-slider__content-link button primary"
                                            placeholder={'Add link text'}
                                            value={contentLinkText}
                                            onChange={contentLinkText => onChangeContentLinkText(contentLinkText, dataId)}
                                            type="button"
                                        />
                                    </div>
                                    <div className="d-inline-block">
                                        <LinkControlSearchInput
                                            placeholder="Search button link here..."
                                            className="main-slider__content-link"
                                            renderSuggestions={(props) => suggestionsRender(props)}
                                            allowDirectEntry={false}
                                            withURLSuggestion={false}
                                            value={contentLink}
                                            onChange={(contentLink) => onChangeContentLink(contentLink, dataId)}
                                            withCreateSuggestion={false}
                                        />
                                    </div>
                                </div>

                            )
                        }
                        {(contentType == 'blog') &&
                            (
                                <div className="blog-search-group">
                                    <div className="form-group pe-4">
                                        <input type="text" className="blog-search-input blog-search-input-placeholder" placeholder={searchInputPlaceholder}/>
                                        <TextControl
                                                placeholder="Set placeholder text"
                                                value={searchInputPlaceholder}
                                                onChange={(searchInputPlaceholder) => onChangeSearchInputPlaceholder(searchInputPlaceholder, dataId)}
                                        />
                                    </div>
                                    <button className="button white">
                                    <RichText
                                        tagName="span"
                                        className="blog-search-button"
                                        placeholder={'Search'}
                                        value={searchButtonText}
                                        onChange={(searchButtonText) => onChangeSearchButtonText(searchButtonText, dataId)}
                                    />
                                    </button>
                                </div>
                            )
                        }
                    </div>
                </div>
            </div>
            <div className="slider-controls absolute">
                <div className="d-flex justify-content-between">
                    <Button
                        onClick={() => onRemoveHandler(dataId)}
                        className="removeBtn components-button me-2"
                        variant={'secondary'}
                        isDestructive
                        icon="no-alt"
                    >
                        Remove Slide
                    </Button>
                    
                    {(imagesNumber > 0 && !!dataId && dataId != 0 && dataId != imagesNumber - 1) &&
                        (<>
                            <Button variant={'secondary'} className="me-2" onClick={() => onMoveImage(dataId, UP)}>Up</Button>
                            <Button variant={'secondary'} className="me-2" onClick={() => onMoveImage(dataId, DOWN)}>Down</Button>
                        </>)
                    }
                    {(imagesNumber > 1 && dataId == 0) &&
                        (<>
                            <Button variant={'secondary'} className="me-2" onClick={() => onMoveImage(dataId, DOWN)}>Down</Button>
                        </>)
                    }
                    {(imagesNumber > 1 && dataId == imagesNumber - 1) &&
                        (<>
                            <Button variant={'secondary'} className="me-2" onClick={() => onMoveImage(dataId, UP)}>Up</Button>
                        </>)
                    }
                </div>


            </div>
        </div>
    );

}