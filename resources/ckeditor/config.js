/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.allowedContent = true;
    config.fontSize_defaultLabel = '12px';
    config.font_defaultLabel = 'Arial';
    //the next line add the new font to the combobox in CKEditor
    config.font_names = 'AvantGardeMedium;' + config.font_names;
    config.format_tags = 'p;h1;h2;h3;h4;pre';
	config.extraPlugins = 'widgetbootstrap,widgetcommon,widgettemplatemenu';
};
