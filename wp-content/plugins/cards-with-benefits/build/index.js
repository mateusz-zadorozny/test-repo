/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/edit.js":
/*!*********************!*\
  !*** ./src/edit.js ***!
  \*********************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/extends */ "./node_modules/@babel/runtime/helpers/esm/extends.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./editor.scss */ "./src/editor.scss");


/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */


/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */



/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */


/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
const Edit = props => {
  const {
    attributes: {
      title,
      mainContent,
      optionColumns,
      fontSize,
      backgroundColor,
      fcMediaID,
      fcMediaURL,
      fcContentTitle,
      fcContent,
      fcLink,
      fcLinkText,
      fcfBenefitIcon,
      fcfBenefitTitle,
      fcfBenefit,
      fcsBenefitIcon,
      fcsBenefitTitle,
      fcsBenefit,
      fsMediaID,
      fsMediaURL,
      fsContentTitle,
      fsContent,
      fsLink,
      fsfBenefitIcon,
      fsfBenefitTitle,
      fsfBenefit,
      fssBenefitIcon,
      fssBenefitTitle,
      fssBenefit,
      ftMediaID,
      ftMediaURL,
      ftContentTitle,
      ftContent,
      ftLink,
      ftfBenefitIcon,
      ftfBenefitTitle,
      ftfBenefit,
      ftsBenefitIcon,
      ftsBenefitTitle,
      ftsBenefit
    },
    setAttributes
  } = props;
  const blockProps = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.useBlockProps)();
  function onSelectFCImage(media) {
    return props.setAttributes({
      fcMediaURL: media.url,
      fcMediaID: media.id
    });
  }
  ;
  function onSelectFSImage(media) {
    return props.setAttributes({
      fsMediaURL: media.url,
      fsMediaID: media.id
    });
  }
  ;
  function onSelectFTImage(media) {
    return props.setAttributes({
      ftMediaURL: media.url,
      ftMediaID: media.id
    });
  }
  ;
  function onSelectFcsBenefitIcon(media) {
    return props.setAttributes({
      fcsBenefitIcon: media.url
    });
  }
  ;
  function onSelectFcfBenefitIcon(media) {
    return props.setAttributes({
      fcfBenefitIcon: media.url
    });
  }
  ;
  function onSelectFssBenefitIcon(media) {
    return props.setAttributes({
      fssBenefitIcon: media.url
    });
  }
  ;
  function onSelectFsfBenefitIcon(media) {
    return props.setAttributes({
      fsfBenefitIcon: media.url
    });
  }
  ;
  function onSelectFtsBenefitIcon(media) {
    return props.setAttributes({
      fstsBenefitIcon: media.url
    });
  }
  ;
  function onSelectFtfBenefitIcon(media) {
    return props.setAttributes({
      ftfBenefitIcon: media.url
    });
  }
  ;
  const setOptionColumns = optionColumns => {
    setAttributes({
      optionColumns: optionColumns
    });
  };
  const setBackgroundColor = backgroundColor => {
    setAttributes({
      backgroundColor: backgroundColor
    });
  };
  const suggestionsRender = props => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "components-dropdown-menu__menu"
  }, props.suggestions.map((suggestion, index) => {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
      onClick: () => props.handleSuggestionClick(suggestion),
      className: "components-button components-dropdown-menu__menu-item is-active has-text has-icon"
    }, suggestion.title);
  }));
  let columnClass = 'col-12';
  if (optionColumns === "two-col") {
    columnClass = 'col-12 col-sm-6';
  } else if (optionColumns === "three-col") {
    columnClass = 'col-12 col-sm-6 col-lg-4';
  }
  const fontSizes = [{
    name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Default'),
    slug: 'default',
    size: 16
  }, {
    name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Large'),
    slug: 'large',
    size: 20
  }, {
    name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Extra Large'),
    slug: 'xlarge',
    size: 24
  }];
  const fallbackFontSize = 16;
  const setFontSize = fontSize => {
    setAttributes({
      fontSize: fontSize
    });
  };
  const ParagraphFontSizePicker = () => {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.FontSizePicker, {
      __nextHasNoMarginBottom: true,
      fontSizes: fontSizes,
      value: fontSize,
      disableCustomFontSizes: true,
      fallbackFontSize: fallbackFontSize,
      onChange: fontSize => {
        setFontSize(fontSize);
      }
    });
  };
  let fontSizeClass = 'default';
  if (fontSize === 20) {
    fontSizeClass = 'medium';
  } else if (fontSize === 24) {
    fontSizeClass = 'large';
  }
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("section", (0,_babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__["default"])({}, blockProps, {
    className: `wp-block-create-block-cards-with-benefits ${backgroundColor}`
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.InspectorControls, {
    key: "setting"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    id: "columns-control"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("fieldset", {
    className: "p-3"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("legend", {
    className: "columns-control__label"
  }, "Choose layout"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.SelectControl, {
    value: optionColumns,
    onChange: optionColumns => {
      setOptionColumns(optionColumns);
    },
    __nextHasNoMarginBottom: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("option", {
    value: "one-col"
  }, "1 column"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("option", {
    value: "two-col"
  }, "2 columns"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("option", {
    value: "three-col"
  }, "3 columns"))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("fieldset", {
    class: "p-3"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("legend", {
    className: "icons-columns-control__label"
  }, "Background color"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.SelectControl, {
    value: backgroundColor,
    onChange: backgroundColor => {
      setBackgroundColor(backgroundColor);
    },
    __nextHasNoMarginBottom: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("option", {
    value: "white-bg"
  }, "White"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("option", {
    value: "lgrey-bg"
  }, "Grey"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("option", {
    value: "lblue-bg"
  }, "Light Blue"))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("fieldset", {
    className: "p-3"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("legend", {
    className: "halves-section-control__label"
  }, "Main Text Size"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(ParagraphFontSizePicker, null)))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: `${optionColumns} container`
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "row"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "col-12 col-xl-3 mb-4 mb-xl-0"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    tagName: "h2",
    value: title,
    className: "mt-0",
    allowedFormats: ['core/bold', 'core/italic'],
    onChange: title => setAttributes({
      title
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Insert block title here...')
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    tagName: "p",
    className: `mainContent ${fontSizeClass}`,
    value: mainContent,
    allowedFormats: ['core/bold', 'core/italic'],
    onChange: mainContent => setAttributes({
      mainContent
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Insert block content here...')
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "col-12 col-xl-8 offset-xl-1"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "row"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: `${columnClass} mb-4 pe-lg-4`
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "d-inline-block"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.__experimentalLinkControlSearchInput, {
    placeholder: "Search button link here...",
    className: "fc-content-link",
    renderSuggestions: props => suggestionsRender(props),
    allowDirectEntry: false,
    withURLSuggestion: false,
    value: fcLink,
    onChange: fcLink => setAttributes({
      fcLink
    }),
    withCreateSuggestion: false
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.MediaUpload, {
    onSelect: onSelectFCImage,
    allowedTypes: "image",
    className: "fc-media-ID",
    value: fcMediaID,
    render: _ref => {
      let {
        open
      } = _ref;
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
        className: fcMediaID ? 'image-button' : 'button mb-3',
        onClick: open
      }, !fcMediaID ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Upload Image', 'cards-with-benefits') : (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("figure", {
        className: "mb-4 card-column__figure"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("img", {
        className: "fc-media-url",
        src: fcMediaURL,
        alt: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Upload Image', 'cards-with-benefits')
      })));
    }
  }), fcMediaURL && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
    onClick: () => props.setAttributes({
      fcMediaURL: null,
      fcMediaID: null
    })
  }, "remove"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    tagName: "h3",
    className: "fc-content-title",
    value: fcContentTitle,
    onChange: fcContentTitle => setAttributes({
      fcContentTitle
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Insert title here...'),
    preserveWhiteSpace: true,
    __unstablePastePlainText: true
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    tagName: "p",
    className: "fc-content",
    value: fcContent,
    allowedFormats: ['core/bold', 'core/italic'],
    onChange: fcContent => setAttributes({
      fcContent
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Insert column content here...'),
    preserveWhiteSpace: true,
    __unstablePastePlainText: true
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "benefits-row mt-5"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "benefit-column"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.MediaUpload, {
    onSelect: onSelectFcfBenefitIcon,
    allowedTypes: "image",
    value: fcfBenefitIcon,
    render: _ref2 => {
      let {
        open
      } = _ref2;
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
        className: fcfBenefitIcon ? 'image-button' : 'button small mb-3',
        onClick: open
      }, !fcfBenefitIcon ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Upload Image', 'cards-with-benefits') : (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("img", {
        className: "fcf-benefit-icon",
        width: "24",
        src: fcfBenefitIcon,
        alt: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Upload Image', 'cards-with-benefits')
      }));
    }
  }), fcfBenefitIcon && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
    onClick: () => props.setAttributes({
      fcfBenefitIcon: null
    })
  }, "remove"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    tagName: "h4",
    className: "fcf-benefit-title",
    value: fcfBenefitTitle,
    allowedFormats: ['core/bold', 'core/italic'],
    onChange: fcfBenefitTitle => setAttributes({
      fcfBenefitTitle
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Insert title here...')
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    tagName: "p",
    className: "fcf-benefit",
    value: fcfBenefit,
    allowedFormats: ['core/bold', 'core/italic', 'core/link'],
    onChange: fcfBenefit => setAttributes({
      fcfBenefit
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Insert column content here...')
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "benefit-column"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.MediaUpload, {
    onSelect: onSelectFcsBenefitIcon,
    allowedTypes: "image",
    value: fcsBenefitIcon,
    render: _ref3 => {
      let {
        open
      } = _ref3;
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
        className: fcsBenefitIcon ? 'image-button' : 'button small mb-3',
        onClick: open
      }, !fcsBenefitIcon ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Upload Image', 'cards-with-benefits') : (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("img", {
        className: "fcs-benefit-icon",
        width: "24",
        src: fcsBenefitIcon,
        alt: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Upload Image', 'cards-with-benefits')
      }));
    }
  }), fcsBenefitIcon && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
    onClick: () => props.setAttributes({
      fcsBenefitIcon: null
    })
  }, "remove"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    tagName: "h4",
    className: "fcs-benefit-title",
    value: fcsBenefitTitle,
    onChange: fcsBenefitTitle => setAttributes({
      fcsBenefitTitle
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Insert title here...')
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    tagName: "p",
    className: "fcs-benefit",
    value: fcsBenefit,
    allowedFormats: ['core/bold', 'core/italic', 'core/link'],
    onChange: fcsBenefit => setAttributes({
      fcsBenefit
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Insert column content here...')
  })))), (optionColumns == 'two-col' || optionColumns == 'three-col') && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: `${columnClass} mb-4 ps-lg-4`
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "d-inline-block"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.__experimentalLinkControlSearchInput, {
    placeholder: "Search button link here...",
    className: "fs-content-link",
    renderSuggestions: props => suggestionsRender(props),
    allowDirectEntry: false,
    withURLSuggestion: false,
    value: fsLink,
    onChange: fsLink => setAttributes({
      fsLink
    }),
    withCreateSuggestion: false
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.MediaUpload, {
    onSelect: onSelectFSImage,
    allowedTypes: "image",
    value: fsMediaID,
    render: _ref4 => {
      let {
        open
      } = _ref4;
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
        className: fsMediaID ? 'image-button' : 'button mb-3',
        onClick: open
      }, !fsMediaID ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Upload Image', 'cards-with-benefits') : (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("figure", {
        className: "mb-4 card-column__figure"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("img", {
        className: "fs-media-url",
        src: fsMediaURL,
        alt: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Upload Image', 'cards-with-benefits')
      })));
    }
  }), fsMediaURL && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
    onClick: () => props.setAttributes({
      fsMediaURL: null
    })
  }, "remove"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    tagName: "h3",
    className: "fs-content-title",
    value: fsContentTitle,
    onChange: fsContentTitle => setAttributes({
      fsContentTitle
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Insert title here...'),
    preserveWhiteSpace: true,
    __unstablePastePlainText: true
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    tagName: "p",
    className: "fs-content",
    value: fsContent,
    allowedFormats: ['core/bold', 'core/italic'],
    onChange: fsContent => setAttributes({
      fsContent
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Insert column content here...'),
    preserveWhiteSpace: true,
    __unstablePastePlainText: true
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "benefits-row mt-5"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "benefit-column"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.MediaUpload, {
    onSelect: onSelectFsfBenefitIcon,
    allowedTypes: "image",
    value: fsfBenefitIcon,
    render: _ref5 => {
      let {
        open
      } = _ref5;
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
        className: fsfBenefitIcon ? 'image-button' : 'button small mb-3',
        onClick: open
      }, !fsfBenefitIcon ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Upload Image', 'cards-with-benefits') : (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("img", {
        className: "fsf-benefit-icon",
        width: "24",
        src: fsfBenefitIcon,
        alt: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Upload Image', 'cards-with-benefits')
      }));
    }
  }), fsfBenefitIcon && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
    onClick: () => props.setAttributes({
      fsfBenefitIcon: null
    })
  }, "remove"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    tagName: "h4",
    className: "fsf-benefit-title",
    value: fsfBenefitTitle,
    onChange: fsfBenefitTitle => setAttributes({
      fsfBenefitTitle
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Insert title here...')
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    tagName: "p",
    className: "fsf-benefit",
    value: fsfBenefit,
    allowedFormats: ['core/bold', 'core/italic', 'core/link'],
    onChange: fsfBenefit => setAttributes({
      fsfBenefit
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Insert column content here...')
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "benefit-column"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.MediaUpload, {
    onSelect: onSelectFssBenefitIcon,
    allowedTypes: "image",
    value: fssBenefitIcon,
    render: _ref6 => {
      let {
        open
      } = _ref6;
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
        className: fssBenefitIcon ? 'image-button' : 'button small mb-3',
        onClick: open
      }, !fssBenefitIcon ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Upload Image', 'cards-with-benefits') : (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("img", {
        className: "fss-benefit-icon",
        width: "24",
        src: fssBenefitIcon,
        alt: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Upload Image', 'cards-with-benefits')
      }));
    }
  }), fssBenefitIcon && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
    onClick: () => props.setAttributes({
      fssBenefitIcon: null
    })
  }, "remove"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    tagName: "h4",
    className: "fss-benefit-title",
    value: fssBenefitTitle,
    onChange: fssBenefitTitle => setAttributes({
      fssBenefitTitle
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Insert title here...')
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    tagName: "p",
    className: "fss-benefit",
    value: fssBenefit,
    allowedFormats: ['core/bold', 'core/italic', 'core/link'],
    onChange: fssBenefit => setAttributes({
      fssBenefit
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Content...')
  })))), optionColumns == 'three-col' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: `${columnClass} mb-4 ps-lg-4`
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "d-inline-block"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.__experimentalLinkControlSearchInput, {
    placeholder: "Search button link here...",
    className: "ft-content-link",
    renderSuggestions: props => suggestionsRender(props),
    allowDirectEntry: false,
    withURLSuggestion: false,
    value: ftLink,
    onChange: ftLink => setAttributes({
      ftLink
    }),
    withCreateSuggestion: false
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.MediaUpload, {
    onSelect: onSelectFTImage,
    allowedTypes: "image",
    value: ftMediaID,
    render: _ref7 => {
      let {
        open
      } = _ref7;
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
        className: ftMediaID ? 'image-button' : 'button mb-3',
        onClick: open
      }, !ftMediaID ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Upload Image', 'cards-with-benefits') : (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("figure", {
        className: "mb-4 card-column__figure"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("img", {
        className: "ft-media-url",
        src: ftMediaURL,
        alt: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Upload Image', 'cards-with-benefits')
      })));
    }
  }), ftMediaURL && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
    onClick: () => props.setAttributes({
      ftMediaURL: null
    })
  }, "remove"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    tagName: "h3",
    className: "ft-content-title",
    value: ftContentTitle,
    onChange: ftContentTitle => setAttributes({
      ftContentTitle
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Insert title here...'),
    preserveWhiteSpace: true,
    __unstablePastePlainText: true
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    tagName: "p",
    className: "ft-content",
    value: ftContent,
    allowedFormats: ['core/bold', 'core/italic'],
    onChange: ftContent => setAttributes({
      ftContent
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Insert column content here...'),
    preserveWhiteSpace: true,
    __unstablePastePlainText: true
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "benefits-row mt-5"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "benefit-column"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.MediaUpload, {
    onSelect: onSelectFtfBenefitIcon,
    allowedTypes: "image",
    value: ftfBenefitIcon,
    render: _ref8 => {
      let {
        open
      } = _ref8;
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
        className: ftfBenefitIcon ? 'image-button' : 'button small mb-3',
        onClick: open
      }, !ftfBenefitIcon ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Upload Image', 'cards-with-benefits') : (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("img", {
        className: "fsf-benefit-icon",
        width: "24",
        src: ftfBenefitIcon,
        alt: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Upload Image', 'cards-with-benefits')
      }));
    }
  }), ftfBenefitIcon && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
    onClick: () => props.setAttributes({
      ftfBenefitIcon: null
    })
  }, "remove"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    tagName: "h4",
    className: "ftf-benefit-title",
    value: ftfBenefitTitle,
    onChange: ftfBenefitTitle => setAttributes({
      ftfBenefitTitle
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Insert title here...')
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    tagName: "p",
    className: "ftf-benefit",
    value: ftfBenefit,
    allowedFormats: ['core/bold', 'core/italic', 'core/link'],
    onChange: ftfBenefit => setAttributes({
      ftfBenefit
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Insert column content here...')
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "benefit-column"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.MediaUpload, {
    onSelect: onSelectFtsBenefitIcon,
    allowedTypes: "image",
    value: ftsBenefitIcon,
    render: _ref9 => {
      let {
        open
      } = _ref9;
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
        className: ftsBenefitIcon ? 'image-button' : 'button small mb-3',
        onClick: open
      }, !ftsBenefitIcon ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Upload Image', 'cards-with-benefits') : (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("img", {
        className: "fts-benefit-icon",
        width: "24",
        src: ftsBenefitIcon,
        alt: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Upload Image', 'cards-with-benefits')
      }));
    }
  }), ftsBenefitIcon && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
    onClick: () => props.setAttributes({
      ftsBenefitIcon: null
    })
  }, "remove"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    tagName: "h4",
    className: "fts-benefit-title",
    value: ftsBenefitTitle,
    onChange: ftsBenefitTitle => setAttributes({
      ftsBenefitTitle
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Insert title here...')
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText, {
    tagName: "p",
    className: "fts-benefit",
    value: ftsBenefit,
    allowedFormats: ['core/bold', 'core/italic', 'core/link'],
    onChange: ftsBenefit => setAttributes({
      ftsBenefit
    }),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Content...')
  })))))))));
};
/* harmony default export */ __webpack_exports__["default"] = (Edit);

/***/ }),

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./block.json */ "./src/block.json");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./edit */ "./src/edit.js");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./save */ "./src/save.js");
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./style.scss */ "./src/style.scss");
/**
 * WordPress dependencies
 */


/**
 * Internal dependencies
 */





// Destructure the json file to get the name and settings for the block
// For more information on how this works, see: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Destructuring_assignment
const {
  name
} = _block_json__WEBPACK_IMPORTED_MODULE_1__;

// Register the block
(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)(name, {
  edit: _edit__WEBPACK_IMPORTED_MODULE_2__["default"],
  save: _save__WEBPACK_IMPORTED_MODULE_3__["default"] // Object shorthand property - same as writing: save: save,
});

/***/ }),

/***/ "./src/save.js":
/*!*********************!*\
  !*** ./src/save.js ***!
  \*********************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/extends */ "./node_modules/@babel/runtime/helpers/esm/extends.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__);


/**
 * WordPress dependencies
 */


const Save = props => {
  const {
    attributes: {
      title,
      mainContent,
      optionColumns,
      fontSize,
      backgroundColor,
      fcMediaID,
      fcMediaURL,
      fcContentTitle,
      fcContent,
      fcLink,
      fcfBenefitIcon,
      fcfBenefitTitle,
      fcfBenefit,
      fcsBenefitIcon,
      fcsBenefit,
      fcsBenefitTitle,
      fsMediaID,
      fsMediaURL,
      fsContentTitle,
      fsContent,
      fsLink,
      fsfBenefitIcon,
      fsfBenefitTitle,
      fsfBenefit,
      fssBenefitIcon,
      fssBenefitTitle,
      fssBenefit,
      ftMediaID,
      ftMediaURL,
      ftContentTitle,
      ftContent,
      ftLink,
      ftfBenefitIcon,
      ftfBenefitTitle,
      ftfBenefit,
      ftsBenefitIcon,
      ftsBenefitTitle,
      ftsBenefit
    }
  } = props;
  const blockProps = _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.useBlockProps.save();
  let fontSizeClass = 'default';
  if (fontSize === 20) {
    fontSizeClass = 'medium';
  } else if (fontSize === 24) {
    fontSizeClass = 'large';
  }
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("section", (0,_babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__["default"])({}, blockProps, {
    className: `${backgroundColor} wp-block-create-block-cards-with-benefits`
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: `${optionColumns} container`
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "row"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "col-12 col-xl-3 mb-4 mb-xl-0"
  }, title && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText.Content, {
    tagName: "h2",
    value: title
  }), mainContent && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText.Content, {
    tagName: "p",
    className: `mainContent ${fontSizeClass}`,
    value: mainContent
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "col-12 col-xl-8 offset-xl-1"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "row cards-grid"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: `${fcLink ? 'post-card__hover' : ''}`
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("a", {
    href: fcLink,
    className: "post-card fc-content-link"
  }, fcMediaURL && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("figure", {
    class: "card-column__figure"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("img", {
    className: "fc-media-url",
    src: fcMediaURL,
    alt: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Image', 'cards-with-benefits')
  })), fcContentTitle && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText.Content, {
    tagName: "h3",
    className: "fc-content-title",
    value: fcContentTitle
  }), fcContent && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText.Content, {
    tagName: "p",
    className: "fc-content",
    value: fcContent
  }), fcLink && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("p", {
    className: "read-more d-md-none"
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Read more', 'cards-with-benefits'), " ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("i", {
    className: "icon-arrow-right"
  })))), optionColumns !== 'one-col' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: `${fsLink ? 'post-card__hover' : ''}`
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("a", {
    href: fsLink,
    className: "post-card fs-content-link"
  }, fsMediaURL && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("figure", {
    class: "card-column__figure"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("img", {
    className: "fs-media-url",
    src: fsMediaURL,
    alt: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Image', 'cards-with-benefits')
  })), fsContentTitle && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText.Content, {
    tagName: "h3",
    className: "fs-content-title",
    value: fsContentTitle
  }), fsContent && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText.Content, {
    tagName: "p",
    className: "fs-content",
    value: fsContent
  }), fsLink && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("p", {
    className: "read-more d-md-none"
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Read more', 'cards-with-benefits'), " ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("i", {
    className: "icon-arrow-right"
  })))), optionColumns == 'three-col' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: `post-card__hover`
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("a", {
    href: ftLink,
    className: "post-card ft-content-link"
  }, ftMediaURL && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("figure", {
    class: "card-column__figure"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("img", {
    className: "ft-media-url",
    src: ftMediaURL,
    alt: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Image', 'cards-with-benefits')
  })), ftContentTitle && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText.Content, {
    tagName: "h3",
    className: "ft-content-title",
    value: ftContentTitle
  }), ftContent && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText.Content, {
    tagName: "p",
    className: "ft-content",
    value: ftContent
  }), ftLink && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("p", {
    className: "read-more d-md-none"
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Read more', 'cards-with-benefits'), " ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("i", {
    className: "icon-arrow-right"
  })))), (fcfBenefitIcon || fcfBenefitTitle || fcfBenefit || fcsBenefitIcon || fcsBenefitTitle || fcsBenefit) && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "benefits-row"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "benefit-column"
  }, fcfBenefitIcon && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("img", {
    className: "mb-3 fcf-benefit-icon",
    width: "24",
    src: fcfBenefitIcon,
    alt: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Image', 'cards-with-benefits')
  }), fcfBenefitTitle && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText.Content, {
    tagName: "h4",
    className: "fcf-benefit-title",
    value: fcfBenefitTitle
  }), fcfBenefit && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText.Content, {
    tagName: "p",
    className: "fcf-benefit",
    value: fcfBenefit
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "benefit-column"
  }, fcsBenefitIcon && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("img", {
    className: "mb-3 fcs-benefit-icon",
    width: "24",
    src: fcsBenefitIcon,
    alt: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Image', 'cards-with-benefits')
  }), fcsBenefitTitle && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText.Content, {
    tagName: "h4",
    className: "fcs-benefit-title",
    value: fcsBenefitTitle
  }), fcsBenefit && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText.Content, {
    tagName: "p",
    className: "fcs-benefit",
    value: fcsBenefit
  }))), optionColumns == 'two-col' && (fsfBenefitIcon || fsfBenefitTitle || fsfBenefit || fssBenefitIcon || fssBenefitTitle || fssBenefit) && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "benefits-row"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "benefit-column"
  }, fsfBenefitIcon && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("img", {
    className: "mb-3 fsf-benefit-icon",
    width: "24",
    src: fsfBenefitIcon,
    alt: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Image', 'cards-with-benefits')
  }), fsfBenefitTitle && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText.Content, {
    tagName: "h4",
    className: "fsf-benefit-title",
    value: fsfBenefitTitle
  }), fsfBenefit && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText.Content, {
    tagName: "p",
    className: "fsf-benefit",
    value: fsfBenefit
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "benefit-column"
  }, fssBenefitIcon && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("img", {
    className: "mb-3 fss-benefit-icon",
    width: "24",
    src: fssBenefitIcon,
    alt: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Image', 'cards-with-benefits')
  }), fssBenefitTitle && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText.Content, {
    tagName: "h4",
    className: "fss-benefit-title",
    value: fssBenefitTitle
  }), fssBenefit && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText.Content, {
    tagName: "p",
    className: "fss-benefit",
    value: fssBenefit
  }))), optionColumns == 'three-col' && (ftfBenefitIcon || ftfBenefitTitle || ftfBenefit || ftsBenefitIcon || ftsBenefitTitle || ftsBenefit) && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "benefits-row"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "benefit-column"
  }, ftfBenefitIcon && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("img", {
    className: "mb-3 fsf-benefit-icon",
    width: "24",
    src: fsfBenefitIcon,
    alt: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Image', 'cards-with-benefits')
  }), ftfBenefitTitle && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText.Content, {
    tagName: "h4",
    className: "fsf-benefit-title",
    value: fsfBenefitTitle
  }), ftfBenefit && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText.Content, {
    tagName: "p",
    className: "fsf-benefit",
    value: fsfBenefit
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "benefit-column"
  }, ftsBenefitIcon && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("img", {
    className: "mb-3 fss-benefit-icon",
    width: "24",
    src: fssBenefitIcon,
    alt: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Image', 'cards-with-benefits')
  }), ftsBenefitTitle && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText.Content, {
    tagName: "h4",
    className: "fss-benefit-title",
    value: fssBenefitTitle
  }), ftsBenefit && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.RichText.Content, {
    tagName: "p",
    className: "fss-benefit",
    value: fssBenefit
  }))))))));
};
/* harmony default export */ __webpack_exports__["default"] = (Save);

/***/ }),

/***/ "./src/editor.scss":
/*!*************************!*\
  !*** ./src/editor.scss ***!
  \*************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/style.scss":
/*!************************!*\
  !*** ./src/style.scss ***!
  \************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ (function(module) {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ (function(module) {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ (function(module) {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ (function(module) {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ (function(module) {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/extends.js":
/*!************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/extends.js ***!
  \************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _extends; }
/* harmony export */ });
function _extends() {
  _extends = Object.assign ? Object.assign.bind() : function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];
      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }
    return target;
  };
  return _extends.apply(this, arguments);
}

/***/ }),

/***/ "./src/block.json":
/*!************************!*\
  !*** ./src/block.json ***!
  \************************/
/***/ (function(module) {

module.exports = JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":2,"name":"create-block/cards-with-benefits","version":"0.1.0","title":"[FH] Columns Grid","category":"widgets","icon":"grid-view","description":"Interactive or non-interactive module. Possibility of 3 types of grid composition (1, 2 or 3 columns enlarged in the upper part of module). Each column may be turned into interactive element leading to a sub-page.","supports":{"html":false},"textdomain":"cards-with-benefits","editorScript":"file:./index.js","editorStyle":"file:./index.css","style":"file:./style-index.css","attributes":{"title":{"type":"string","source":"html","selector":"h2"},"mainContent":{"type":"string","source":"html","selector":".mainContent"},"fontSize":{"type":"number","default":16},"backgroundColor":{"type":"string","default":"white-bg"},"optionColumns":{"type":"string"},"fcMediaID":{"type":"number","selector":".fc-media-ID"},"fcMediaURL":{"type":"string","source":"attribute","selector":".fc-media-url","attribute":"src"},"fcContentTitle":{"type":"string","source":"html","selector":".fc-content-title"},"fcContent":{"type":"string","source":"html","selector":".fc-content"},"fcLinkUrl":{"type":"string","source":"html","selector":".fc-content"},"fcLink":{"type":"string","source":"attribute","attribute":"href","selector":"a.fc-content-link"},"fsLink":{"type":"string","source":"attribute","attribute":"href","selector":"a.fs-content-link"},"ftLink":{"type":"string","source":"attribute","attribute":"href","selector":"a.ft-content-link"},"fcfBenefitIcon":{"type":"string","source":"attribute","selector":".fcf-benefit-icon","attribute":"src"},"fcfBenefitTitle":{"type":"string","source":"html","selector":".fcf-benefit-title"},"fcfBenefit":{"type":"string","source":"html","selector":".fcf-benefit"},"fcsBenefitIcon":{"type":"string","source":"attribute","selector":".fcs-benefit-icon","attribute":"src"},"fcsBenefitTitle":{"type":"string","source":"html","selector":".fcs-benefit-title"},"fcsBenefit":{"type":"string","source":"html","selector":".fcs-benefit"},"fsMediaID":{"type":"number"},"fsMediaURL":{"type":"string","source":"attribute","selector":".fs-media-url","attribute":"src"},"fsContentTitle":{"type":"string","source":"html","selector":".fs-content-title"},"fsContent":{"type":"string","source":"html","selector":".fs-content"},"fsfBenefitIcon":{"type":"string","source":"attribute","selector":".fsf-benefit-icon","attribute":"src"},"fsfBenefitTitle":{"type":"string","source":"html","selector":".fsf-benefit-title"},"fsfBenefit":{"type":"string","source":"html","selector":".fsf-benefit"},"fssBenefitIcon":{"type":"string","source":"attribute","selector":".fss-benefit-icon","attribute":"src"},"fssBenefitTitle":{"type":"string","source":"html","selector":".fss-benefit-title"},"fssBenefit":{"type":"string","source":"html","selector":".fss-benefit"},"ftMediaID":{"type":"number"},"ftMediaURL":{"type":"string","source":"attribute","selector":".ft-media-url","attribute":"src"},"ftContentTitle":{"type":"string","source":"html","selector":".ft-content-title"},"ftContent":{"type":"string","source":"html","selector":".ft-content"},"ftfBenefitIcon":{"type":"string","source":"attribute","selector":".ftf-benefit-icon","attribute":"src"},"ftfBenefitTitle":{"type":"string","source":"html","selector":".ftf-benefit-title"},"ftfBenefit":{"type":"string","source":"html","selector":".ftf-benefit"},"ftsBenefitIcon":{"type":"string","source":"attribute","selector":".fts-benefit-icon","attribute":"src"},"ftsBenefitTitle":{"type":"string","source":"html","selector":".fts-benefit-title"},"ftsBenefit":{"type":"string","source":"html","selector":".fss-benefit"}}}');

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	!function() {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = function(result, chunkIds, fn, priority) {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var chunkIds = deferred[i][0];
/******/ 				var fn = deferred[i][1];
/******/ 				var priority = deferred[i][2];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every(function(key) { return __webpack_require__.O[key](chunkIds[j]); })) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	!function() {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"index": 0,
/******/ 			"./style-index": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = function(chunkId) { return installedChunks[chunkId] === 0; };
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = function(parentChunkLoadingFunction, data) {
/******/ 			var chunkIds = data[0];
/******/ 			var moreModules = data[1];
/******/ 			var runtime = data[2];
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some(function(id) { return installedChunks[id] !== 0; })) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkcards_with_benefits"] = self["webpackChunkcards_with_benefits"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	}();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["./style-index"], function() { return __webpack_require__("./src/index.js"); })
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map