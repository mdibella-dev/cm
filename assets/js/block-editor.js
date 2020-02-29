wp.domReady( () => {
	// Nichtgenutzte Standardstile entfernen
	wp.blocks.unregisterBlockStyle( 'core/button', 'default' );
	wp.blocks.unregisterBlockStyle( 'core/button', 'circular' );
	wp.blocks.unregisterBlockStyle( 'core/button', 'outline' );
	wp.blocks.unregisterBlockStyle( 'core/button', 'squared' );
	wp.blocks.unregisterBlockStyle( 'core/button', 'shadow' );
	wp.blocks.unregisterBlockStyle( 'core/button', '3d' );
	wp.blocks.unregisterBlockStyle( 'core/table', 'regular' );
	wp.blocks.unregisterBlockStyle( 'core/table', 'stripes' );


	// Button
	wp.blocks.registerBlockStyle( 'core/button', {
		name: 'default',
		label: 'Default',
		isDefault: true
	} );

	wp.blocks.registerBlockStyle( 'core/button', {
		name: 'black-ghost',
		label: 'Ghost (schwarz)',
		isDefault: false
	} );

	wp.blocks.registerBlockStyle( 'core/button', {
		name: 'white-ghost',
		label: 'Ghost (weiß)',
		isDefault: false
	} );


	// Table
	wp.blocks.registerBlockStyle( 'core/table', {
		name: 'default',
		label: 'Standard',
		isDefault: true
	} );

	wp.blocks.registerBlockStyle( 'core/table', {
		name: 'default-with-header-column',
		label: 'Standard mit Titelspalte',
		isDefault: false
	} );

	wp.blocks.registerBlockStyle( 'core/table', {
		name: 'default-with-header-row',
		label: 'Standard mit Titelzeile',
		isDefault: false
	} );


	// Image
	wp.blocks.registerBlockStyle( 'core/image', {
		name: 'with-caption',
		label: 'Mit Bildbeschreibung',
		isDefault: false
	} );


	// Cover
	wp.blocks.registerBlockStyle( 'core/cover', {
		name: 'with-overlay',
		label: 'Mit Überlagerung',
		isDefault: false
	} );
} );
