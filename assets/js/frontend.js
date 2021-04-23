jQuery( document ).ready( function ( $ ) {
	const slide = $( '.wp-slideshow-slide' ),
		slideGroup = $( '.wp-slideshow-slide-group' ),
		bullet = $( '.wp-slideshow-slide-bullet' );

	var slidesTotal = slide.length - 1,
		current = 0,
		isAutoSliding = true;

	bullet.first().addClass( 'current' );

	const clickSlide = function () {
		//stop auto sliding
		window.clearInterval( autoSlide );
		isAutoSliding = false;

		const slideIndex = bullet.index( $( this ) );

		updateIndex( slideIndex );
	};

	var updateIndex = function ( currentSlide ) {
		if ( isAutoSliding ) {
			if ( current === slidesTotal ) {
				current = 0;
			} else {
				current++;
			}
		} else {
			current = currentSlide;
		}

		bullet.removeClass( 'current' );
		bullet.eq( current ).addClass( 'current' );

		transition( current );
	};

	var transition = function ( slidePosition ) {
		slideGroup.animate( {
			top: '-' + slidePosition + '00%',
		} );
	};

	bullet.on( 'click', clickSlide );

	var autoSlide = window.setInterval( updateIndex, 2000 );
} );
