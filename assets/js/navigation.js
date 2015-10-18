/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 */
(function() {
	var container, button, menu, stickHeight, header;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = document.getElementById( 'navigation-toggle' );
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	button.onclick = function() {
		container.classList.toggle( 'nav--toggled' );
	};

	// Add sticky behavior for navigation.
	stickHeight = document.getElementById( 'branding' ).offsetHeight;
	header      = document.getElementById( 'masthead' );
	if ( document.body.classList.contains( 'admin-bar' ) ) {
		stickHeight += 46;
	}
	window.addEventListener( 'scroll', function() {
		if ( document.body.scrollTop > stickHeight ) {
			header.classList.add( 'header--sticky' );
		} else {
			header.classList.remove( 'header--sticky' );
		}
	});
})();
