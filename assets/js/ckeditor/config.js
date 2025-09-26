/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
        { name: 'colors' },
        { name: 'links' },
        { name: 'insert' },
        { name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'about' }
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	// config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';

    config.allowedContent = true;
    config.enterMode = CKEDITOR.ENTER_BR;
    config.autoParagraph = false;

    config.autoGrow_onStartup = true;
    config.autoGrow_minHeight = 300;
    config.autoGrow_maxHeight = 600;

    config.extraPlugins = 'fontawesome,panelbutton,colorbutton,colordialog,autogrow';

    config.contentsCss = ['/css/bootstrap.min.css', '/css/font-awesome.min.css', '/css/style.css']
};

CKEDITOR.dtd.$removeEmpty['span'] = false;
CKEDITOR.dtd.$removeEmpty['i'] = false;
