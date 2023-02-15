"use strict";

var _blocks = require("@wordpress/blocks");

require("./style.scss");

var _edit = _interopRequireDefault(require("./edit"));

var _save = _interopRequireDefault(require("./save"));

var _block = _interopRequireDefault(require("./block.json"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */

/**
 * Internal dependencies
 */

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
(0, _blocks.registerBlockType)(_block["default"].name, {
  /**
   * @see ./edit.js
   */
  edit: _edit["default"],

  /**
   * @see ./save.js
   */
  save: _save["default"]
});