wp.domReady( () => {

	wp.blocks.registerBlockStyle( 'core/table', {
		name: 'fineline',
		label: 'Fineline',
		isDefault: false
	} );

	// Überschriften
	wp.blocks.registerBlockStyle( 'core/heading', {
		name: 'default',
		label: 'Default',
		isDefault: true
	} );

	wp.blocks.registerBlockStyle( 'core/heading', {
		name: 'thin',
		label: 'Thin',
		isDefault: false
 	} );

	// Buttons
	wp.blocks.unregisterBlockStyle( 'core/button', 'default' );
	wp.blocks.unregisterBlockStyle( 'core/button', 'circular' );
	wp.blocks.unregisterBlockStyle( 'core/button', 'outline' );
	wp.blocks.unregisterBlockStyle( 'core/button', 'squared' );
	wp.blocks.unregisterBlockStyle( 'core/button', '3d' );

	wp.blocks.registerBlockStyle( 'core/button', {
		name: 'default',
		label: 'Default',
		isDefault: true
	} );


	wp.blocks.registerBlockStyle( 'core/button', {
		name: 'rect',
		label: 'Rechteckig',
		isDefault: false
	} );

} );
