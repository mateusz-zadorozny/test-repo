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
import { useBlockProps, RichText, MediaUpload, InspectorControls } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import appStore from '../assets/appStore.svg';
import googlePlay from '../assets/googlePlay.svg';

import Icon from './icon';
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
        attributes: { backgroundImage, title, subtitle, androidLinkText, mobileAndroidLinkText, androidLink, iosLinkText, mobileIosLinkText, iosLink, content, icons },
        setAttributes } = props;

    const ALLOWED_MEDIA_TYPES = ['image'];
    const onRemove = (id) => {
        const iconsList = icons.filter(image => image.dataId !== id);

        iconsList.map((item, i) => item.dataId = i);
        setAttributes({ icons: iconsList })
    }


    const moveImage = (id, dir) => {
        const position = icons.findIndex(image => image.dataId === id);
        const item = icons[position];
        const newIcons = icons.filter(image => image.dataId !== id);
        newIcons.splice(position + dir, 0, item);

        newIcons.map((item, i) => item.dataId = i);

        setAttributes({
            icons: newIcons
        });
    }

    const setIconAttributes = (icon) => {
        const maxIdIndex = icons.length - 1;
        let index = maxIdIndex + 1;
        const sortedIcons = [...icons];
        sortedIcons.map((item, i) => item.dataId = i);
        setAttributes({
            icons: [
                ...sortedIcons,
                {
                    dataId: index,
                    url: icon.url,
                    alt: icon.alt,
                    link: "",
                }
            ],
        })
    }

    const onSelectBackgroundImage = (media) => {
        return props.setAttributes({
            backgroundImage: media.url
        });
    }

    return (
        <section className="appSection" {...blockProps}>
            {
                <InspectorControls key="setting">
                    <div id="main-slider-control">
                        <fieldset class="p-3">
                            <legend className="main-slider-control__label">
                                Side image
                            </legend>
                            <MediaUpload
                                onSelect={onSelectBackgroundImage}
                                allowedTypes="image"
                                className="fc-media-ID"
                                value={backgroundImage}
                                render={({ open }) => (
                                    <Button
                                        className={
                                            backgroundImage ? 'image-button' : 'button button-large mb-3'
                                        }
                                        onClick={open}
                                    >
                                        {!backgroundImage ? (
                                            __('Upload Image', 'app-section')
                                        ) : (
                                            <img
                                                class="fc-media-url"
                                                src={backgroundImage}
                                                alt={__(
                                                    'Upload Image',
                                                    'app-section'
                                                )}
                                            />
                                        )}
                                    </Button>
                                )}
                            />
                            {backgroundImage && (
                                <Button onClick={() => props.setAttributes({ backgroundImage: null })} >remove</Button>
                            )}
                        </fieldset>

                    </div>
                </InspectorControls>

            }
            <div className="container">
                <div className="row appSection__content">
                    <div className="col-sm-12 col-lg-6 appSection__content-col">
                        <div className="appSection__content-col--item">
                            <RichText
                                tagName="h2"
                                className="appSection__title"
                                value={title}
                                allowedFormats={['core/bold', 'core/italic']}
                                onChange={(title) => setAttributes({ title })}
                                placeholder={__('Insert block title here...')}
                            />
                            <RichText
                                tagName="p"
                                className="appSection__text"
                                value={subtitle}
                                allowedFormats={['core/bold', 'core/italic']}
                                onChange={(subtitle) => setAttributes({ subtitle })}
                                placeholder={__('Insert block subtitle here...')}
                            />
                            <div className="appSection__buttons">
                                <div className="d-none d-sm-block">
                                    <RichText
                                        tagName="a"
                                        className="button secondary module-button module-button-icon"
                                        placeholder={'Add iOS link text'}
                                        value={iosLinkText}
                                        onChange={(iosLinkText) => setAttributes({ iosLinkText })}
                                        type="button"
                                    />
                                    <RichText
                                        tagName="a"
                                        className="link-container"
                                        placeholder={'Add iOS link'}
                                        value={iosLink}
                                        onChange={(iosLink) => setAttributes({ iosLink })}
                                        type="button"
                                    />
                                </div>
                                <div className="d-none d-sm-block ml">
                                    <RichText
                                        tagName="a"
                                        className="button secondary module-button module-button-icon"
                                        placeholder={'Add Android link text'}
                                        value={androidLinkText}
                                        onChange={(androidLinkText) => setAttributes({ androidLinkText })}
                                        type="button"
                                    />
                                    <RichText
                                        tagName="a"
                                        className="link-container"
                                        placeholder={'Add Android link'}
                                        value={androidLink}
                                        onChange={(androidLink) => setAttributes({ androidLink })}
                                        type="button"
                                    />
                                </div>
                                <div className="d-block d-sm-none">
                                    <RichText
                                        tagName="a"
                                        className="button secondary module-button module-button-icon"
                                        placeholder={'Add iOS link text'}
                                        value={mobileIosLinkText}
                                        onChange={(mobileIosLinkText) => setAttributes({ mobileIosLinkText })}
                                        type="button"
                                    />
                                    <RichText
                                        tagName="a"
                                        className="link-container"
                                        placeholder={'Add iOS link'}
                                        value={iosLink}
                                        onChange={(iosLink) => setAttributes({ iosLink })}
                                        type="button"
                                    />
                                </div>
                                <div className="d-block d-sm-none">
                                    <RichText
                                        tagName="a"
                                        className="button secondary module-button module-button-icon"
                                        placeholder={'Add Android link text'}
                                        value={mobileAndroidLinkText}
                                        onChange={(mobileAndroidLinkText) => setAttributes({ mobileAndroidLinkText })}
                                        type="button"
                                    />
                                    <RichText
                                        tagName="a"
                                        className="link-container"
                                        placeholder={'Add Android link'}
                                        value={androidLink}
                                        onChange={(androidLink) => setAttributes({ androidLink })}
                                        type="button"
                                    />
                                </div>

                            </div>
                            <img className="appSection__img-mobile" src={{backgroundImage}} alt="photo" />
                            <div className='appSection__support'>
                                <RichText
                                    tagName="p"
                                    className="appSection__support-title"
                                    value={content}
                                    allowedFormats={['core/bold', 'core/italic']}
                                    onChange={(content) => setAttributes({ content })}
                                    placeholder={__('Insert block content here...')}
                                />
                                <div className="appSection__support-logos">
                                    {
                                        icons && icons.length !== 0 && icons.map(icon => (

                                            <Icon
                                                key={icon.dataId}
                                                dataId={icon.dataId}
                                                url={icon.url}
                                                alt={icon.alt}
                                                title={icon.title}
                                                iconsNumber={icons.length}
                                                onRemoveHandler={onRemove}
                                                onMoveImage={moveImage}
                                            />
                                        ))
                                    }


                                    <div className="upload">
                                        <MediaUpload
                                            onSelect={setIconAttributes}
                                            allowedTypes={ALLOWED_MEDIA_TYPES}
                                            render={({ open }) => (
                                                <div>
                                                    <Button variant={'secondary'} onClick={open}>
                                                        {icons.length === 0
                                                            ? 'Upload icon'
                                                            : 'Upload new icon'
                                                        }
                                                    </Button>
                                                </div>
                                            )}
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="col-sm-12 col-lg-6 appSection__img-container">
                        <img className="appSection__img img-fluid" src={backgroundImage} alt="photo" />
                    </div>
                </div>
            </div>
        </section>
    );
}
