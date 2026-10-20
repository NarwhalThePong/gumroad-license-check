( function ( blocks, blockEditor, components, element, i18n ) {
	'use strict';
	var el = element.createElement;
	var __ = i18n.__;
	var InnerBlocks = blockEditor.InnerBlocks;

	blocks.registerBlockType( 'license-gate-for-gumroad/gate', {
		edit: function ( props ) {
			var attributes = props.attributes;
			var blockProps = blockEditor.useBlockProps( { className: 'lgfg-gate-editor' } );

			return el(
				element.Fragment,
				null,
				el(
					blockEditor.InspectorControls,
					null,
					el(
						components.PanelBody,
						{ title: __( 'Gumroad product', 'license-gate-for-gumroad' ) },
						el( components.TextControl, {
							label: __( 'Product ID', 'license-gate-for-gumroad' ),
							help: __( 'Leave empty to use the default product ID from Settings > License Gate.', 'license-gate-for-gumroad' ),
							value: attributes.productId || '',
							onChange: function ( value ) {
								props.setAttributes( { productId: value } );
							},
						} ),
						el( components.TextareaControl, {
							label: __( 'Locked message (optional)', 'license-gate-for-gumroad' ),
							value: attributes.message || '',
							onChange: function ( value ) {
								props.setAttributes( { message: value } );
							},
						} )
					)
				),
				el(
					'div',
					blockProps,
					el(
						'p',
						{ className: 'lgfg-gate-editor__label' },
						__( 'License Gate: the blocks below are shown only after a valid Gumroad license key is entered.', 'license-gate-for-gumroad' )
					),
					el( InnerBlocks )
				)
			);
		},
		save: function () {
			return el( InnerBlocks.Content );
		},
	} );
} )( window.wp.blocks, window.wp.blockEditor, window.wp.components, window.wp.element, window.wp.i18n );
