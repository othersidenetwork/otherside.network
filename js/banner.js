(function( $ ) {

    'use strict';

    function otherside_network_toggle() {
        $( '#otherside-network-banner' ).toggleClass( 'otherside-network-closed' );
    }

    $( '.otherside-network-toggle' ).click( otherside_network_toggle );

})( window.jQuery );