( function( api ) {

	// Extends our custom "lightblogify" section.
	api.sectionConstructor['lightblogify'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );
