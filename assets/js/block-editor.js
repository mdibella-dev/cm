wp.domReady( () => {

	/** core/button **/

	wp.blocks.unregisterBlockStyle( 'core/button', [ 'default', 'fill', 'outline' ] );

	wp.blocks.registerBlockStyle( 'core/button', {
		name: 'default',
		label: 'Standard',
		isDefault: true
	} );

	wp.blocks.registerBlockStyle( 'core/button', {
		name: 'default-with-shadow',
		label: 'Schattiert',
		isDefault: false
	} );

	wp.blocks.registerBlockStyle( 'core/button', {
		name: 'grey-with-shadow',
		label: 'Grau, schattiert',
		isDefault: false
	} );


	/** core/table **/

	wp.blocks.unregisterBlockStyle( 'core/table', [ 'regular', 'stripes' ] );

	wp.blocks.registerBlockStyle( 'core/table', {
		name: 'default',
		label: 'Standard',
		isDefault: true,
	} );

	wp.blocks.registerBlockStyle( 'core/table', {
		name: 'default-with-header-column',
		label: 'Mit Titelspalte',
		isDefault: false,
	} );

	wp.blocks.registerBlockStyle( 'core/table', {
		name: 'default-with-header-row',
		label: 'Mit Titelzeile',
		isDefault: false,
	} );


	/** core/image **/

	wp.blocks.unregisterBlockStyle( 'core/image', [ 'rounded' ] );

	wp.blocks.registerBlockStyle( 'core/image', {
		name: 'with-caption',
		label: 'Mit Beschreibung',
		isDefault: false,
	} );


	/** core/cover **/

	wp.blocks.registerBlockStyle( 'core/cover', {
		name: 'with-overlay',
		label: 'Mit Überlagerung',
		isDefault: false,
	} );
} );
