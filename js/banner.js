(function( $ ) {

    'use strict';

    function otherside_network_toggle() {
        $( '#otherside-network-banner' ).toggleClass( 'otherside-network-closed' );
    }

    function otherside_network_resize() {
        if ( $( window ).width() >= 480 ) {
            $( '#otherside-network-banner' ).addClass( 'otherside-network-closed' );
        }
    }

    $( '.otherside-network-toggle' ).click( otherside_network_toggle );
    $( window ).resize( otherside_network_resize );

})( window.jQuery );