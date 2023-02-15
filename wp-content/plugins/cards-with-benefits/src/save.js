/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { RichText, useBlockProps } from '@wordpress/block-editor';

const Save = (props) => {
    const {
        attributes: { title, mainContent, optionColumns, fontSize, backgroundColor,
            fcMediaID, fcMediaURL, fcContentTitle, fcContent, fcLink, fcfBenefitIcon, fcfBenefitTitle, fcfBenefit, fcsBenefitIcon, fcsBenefit, fcsBenefitTitle,
            fsMediaID, fsMediaURL, fsContentTitle, fsContent, fsLink, fsfBenefitIcon, fsfBenefitTitle, fsfBenefit, fssBenefitIcon, fssBenefitTitle, fssBenefit,
            ftMediaID, ftMediaURL, ftContentTitle, ftContent, ftLink, ftfBenefitIcon, ftfBenefitTitle, ftfBenefit, ftsBenefitIcon, ftsBenefitTitle, ftsBenefit
        }
    } = props;

    const blockProps = useBlockProps.save();

    let fontSizeClass = 'default';

    if (fontSize === 20) {
        fontSizeClass = 'medium';
    } else if (fontSize === 24) {
        fontSizeClass = 'large';
    }

    return (
        <section {...blockProps} className={`${backgroundColor} wp-block-create-block-cards-with-benefits`}>

            <div className={`${optionColumns} container`}>
                <div className="row">
                    <div className="col-12 col-xl-3 mb-4 mb-xl-0">
                        {title && (
                            <RichText.Content tagName="h2" value={title} />
                        )}
                        {mainContent && (
                            <RichText.Content tagName="p" className={`mainContent ${fontSizeClass}`} value={mainContent} />
                        )}
                    </div>
                    <div className="col-12 col-xl-8 offset-xl-1">
                        <div className="row cards-grid">
                            <div className={`${(fcLink) ? 'post-card__hover' : ''}`}>
                                <a href={fcLink} className="post-card fc-content-link">
                                    {fcMediaURL && (
                                        <figure class="card-column__figure">
                                            <img
                                                className="fc-media-url"
                                                src={fcMediaURL}
                                                alt={__('Image', 'cards-with-benefits')}
                                            />
                                        </figure>
                                    )}
                                    {fcContentTitle && (
                                        <RichText.Content tagName="h3" className="fc-content-title" value={fcContentTitle} />
                                    )}
                                    {fcContent && (
                                        <RichText.Content tagName="p" className="fc-content" value={fcContent} />
                                    )}
                                    {fcLink && (
                                        <p className="read-more d-md-none">{__('Read more', 'cards-with-benefits')} <i className="icon-arrow-right"></i></p>
                                    )}
                                </a>

                            </div>
                            {(optionColumns !== 'one-col') &&
                                (
                                    <div className={`${(fsLink) ? 'post-card__hover' : ''}`}>
                                        <a href={fsLink} className="post-card fs-content-link">
                                            {fsMediaURL && (
                                                <figure class="card-column__figure">
                                                    <img
                                                        className="fs-media-url"
                                                        src={fsMediaURL}
                                                        alt={__('Image', 'cards-with-benefits')}
                                                    />
                                                </figure>
                                            )}
                                            {fsContentTitle && (
                                                <RichText.Content tagName="h3" className="fs-content-title" value={fsContentTitle} />
                                            )}
                                            {fsContent && (
                                                <RichText.Content tagName="p" className="fs-content" value={fsContent} />
                                            )}
                                            {fsLink && (
                                                <p className="read-more d-md-none">{__('Read more', 'cards-with-benefits')} <i className="icon-arrow-right"></i></p>
                                            )}
                                        </a>

                                    </div>
                                )
                            }
                            {(optionColumns == 'three-col') &&
                                (
                                    <div className={`post-card__hover`}>
                                        <a href={ftLink} className="post-card ft-content-link">
                                            {ftMediaURL && (
                                                <figure class="card-column__figure">
                                                    <img
                                                        className="ft-media-url"
                                                        src={ftMediaURL}
                                                        alt={__('Image', 'cards-with-benefits')}
                                                    />
                                                </figure>
                                            )}
                                            {ftContentTitle && (
                                                <RichText.Content tagName="h3" className="ft-content-title" value={ftContentTitle} />
                                            )}
                                            {ftContent && (
                                                <RichText.Content tagName="p" className="ft-content" value={ftContent} />
                                            )}
                                            {ftLink && (
                                                <p className="read-more d-md-none">{__('Read more', 'cards-with-benefits')} <i className="icon-arrow-right"></i></p>
                                            )}
                                        </a>

                                    </div>
                                )
                            }
                            {(fcfBenefitIcon || fcfBenefitTitle || fcfBenefit || fcsBenefitIcon || fcsBenefitTitle || fcsBenefit) && (

                                <div className="benefits-row">
                                    <div className="benefit-column">
                                        {fcfBenefitIcon && (
                                            <img
                                                className="mb-3 fcf-benefit-icon"
                                                width="24"
                                                src={fcfBenefitIcon}
                                                alt={__('Image', 'cards-with-benefits')}
                                            />
                                        )}
                                        {fcfBenefitTitle && (
                                            <RichText.Content tagName="h4" className="fcf-benefit-title" value={fcfBenefitTitle} />
                                        )}
                                        {fcfBenefit && (
                                            <RichText.Content tagName="p" className="fcf-benefit" value={fcfBenefit} />
                                        )}
                                    </div>
                                    <div className="benefit-column">
                                        {fcsBenefitIcon && (
                                            <img
                                                className="mb-3 fcs-benefit-icon"
                                                width="24"
                                                src={fcsBenefitIcon}
                                                alt={__('Image', 'cards-with-benefits')}
                                            />
                                        )}
                                        {fcsBenefitTitle && (
                                            <RichText.Content tagName="h4" className="fcs-benefit-title" value={fcsBenefitTitle} />
                                        )}
                                        {fcsBenefit && (
                                            <RichText.Content tagName="p" className="fcs-benefit" value={fcsBenefit} />
                                        )}
                                    </div>
                                </div>
                            )}


                            {(optionColumns == 'two-col') &&
                                (
                                (fsfBenefitIcon || fsfBenefitTitle || fsfBenefit || fssBenefitIcon || fssBenefitTitle || fssBenefit) && (
                                <div className="benefits-row">
                                        <div className="benefit-column">
                                            {fsfBenefitIcon && (
                                                <img
                                                    className="mb-3 fsf-benefit-icon"
                                                    width="24"
                                                    src={fsfBenefitIcon}
                                                    alt={__('Image', 'cards-with-benefits')}
                                                />
                                            )}
                                            {fsfBenefitTitle && (
                                                <RichText.Content tagName="h4" className="fsf-benefit-title" value={fsfBenefitTitle} />
                                            )}
                                            {fsfBenefit && (
                                                <RichText.Content tagName="p" className="fsf-benefit" value={fsfBenefit} />
                                            )}
                                        </div>
                                        <div className="benefit-column">
                                            {fssBenefitIcon && (
                                                <img
                                                    className="mb-3 fss-benefit-icon"
                                                    width="24"
                                                    src={fssBenefitIcon}
                                                    alt={__('Image', 'cards-with-benefits')}
                                                />
                                            )}
                                            {fssBenefitTitle && (
                                                <RichText.Content tagName="h4" className="fss-benefit-title" value={fssBenefitTitle} />
                                            )}
                                            {fssBenefit && (
                                                <RichText.Content tagName="p" className="fss-benefit" value={fssBenefit} />
                                            )}
                                        </div>
                                    </div>
                                )
                            )}

                            {(optionColumns == 'three-col') &&
                                (
                                    (ftfBenefitIcon || ftfBenefitTitle || ftfBenefit || ftsBenefitIcon || ftsBenefitTitle || ftsBenefit) && (
                                    <div className="benefits-row">
                                        <div className="benefit-column">
                                            {ftfBenefitIcon && (
                                                <img
                                                    className="mb-3 fsf-benefit-icon"
                                                    width="24"
                                                    src={fsfBenefitIcon}
                                                    alt={__('Image', 'cards-with-benefits')}
                                                />
                                            )}
                                            {ftfBenefitTitle && (
                                                <RichText.Content tagName="h4" className="fsf-benefit-title" value={fsfBenefitTitle} />
                                            )}
                                            {ftfBenefit && (
                                                <RichText.Content tagName="p" className="fsf-benefit" value={fsfBenefit} />
                                            )}
                                        </div>
                                        <div className="benefit-column">
                                            {ftsBenefitIcon && (
                                                <img
                                                    className="mb-3 fss-benefit-icon"
                                                    width="24"
                                                    src={fssBenefitIcon}
                                                    alt={__('Image', 'cards-with-benefits')}
                                                />
                                            )}
                                            {ftsBenefitTitle && (
                                                <RichText.Content tagName="h4" className="fss-benefit-title" value={fssBenefitTitle} />
                                            )}
                                            {ftsBenefit && (
                                                <RichText.Content tagName="p" className="fss-benefit" value={fssBenefit} />
                                            )}
                                        </div>
                                    </div>
                                    )
                                )}
                        </div>
                    </div>

                </div>
            </div>

        </section>
    );
};

export default Save;