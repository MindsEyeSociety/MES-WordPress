/**
 * carousel.js
 *
 * Handles the automatic carousel for the front page.
 */
(function() {
	'use strict';

	var carousel, curItem, maxItems, change;

	carousel = document.getElementById( 'carousel' );
	curItem  = 1;
	maxItems = document.getElementsByClassName( 'carousel__item' ).length;

	if ( maxItems <= 1 ) {
		return;
	}

	change = function() {

		carousel.classList.remove( 'carousel__wrapper--show-' + curItem );

		curItem++;

		if ( curItem > maxItems ) {
			curItem = 1;
		}

		carousel.classList.add( 'carousel__wrapper--show-' + curItem );

	};

	window.setInterval( change, 30000 ); // 30 seconds.

})();
