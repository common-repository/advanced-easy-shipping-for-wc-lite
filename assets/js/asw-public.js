( function ( $ ) {
	'use strict';
	$( document ).ready( function () {
		$( 'body' ).on( 'change', 'input[name="payment_method"]', function () {
			$( 'body' ).trigger( 'update_checkout' );
		} );
	} );
} )( jQuery );
