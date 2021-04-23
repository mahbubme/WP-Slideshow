jQuery( document ).ready( function ( $ ) {
	const slide = $( '.wp-slideshow-slide' ),
		slideGroup = $( '.wp-slideshow-slide-group' ),
		bullet = $( '.wp-slideshow-slide-bullet' );

	const slidesTotal = slide.length - 1;
	let current = 0;
	let isAutoSliding = true;

	bullet.first().addClass( 'current' );

	const clickSlide = function () {
		//stop auto sliding
		window.clearInterval( autoSlide );
		isAutoSliding = false;

		const slideIndex = bullet.index( $( this ) );

		updateIndex( slideIndex );
	};

	const updateIndex = function ( currentSlide ) {
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

	const transition = function ( slidePosition ) {
		slideGroup.animate( {
			top: '-' + slidePosition + '00%',
		} );
	};

	bullet.on( 'click', clickSlide );

	const autoSlide = window.setInterval( updateIndex, 2000 );
} );
