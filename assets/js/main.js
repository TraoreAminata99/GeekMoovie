$(document).ready(function () {
	
	/*==============================
	Home carousel
	==============================*/
	$('.home__carousel').owlCarousel({
		mouseDrag: true,
		touchDrag: true,
		dots: true,
		loop: true,
		autoplay: false,
		smartSpeed: 600,
		margin: 20,
		autoHeight: true,
		autoWidth: true,
		responsive: {
			0 : {
				items: 2,
			},
			576 : {
				items: 2,
				margin: 20,
			},
			768 : {
				items: 2,
				margin: 30,
				center: true,
			},
			1200 : {
				items: 3,
				margin: 30,
				center: true,
				mouseDrag: false,
				dots: false,
				startPosition: 1,
				slideBy: 3,
			},
		}
	});

	/*==============================
	Select
	==============================*/
	$('.catalog__select').select2({
		minimumResultsForSearch: Infinity
	});

	/*==============================
	Carousel
	==============================*/
	$('.section__carousel').owlCarousel({
		mouseDrag: true,
		touchDrag: true,
		dots: true,
		loop: true,
		autoplay: false,
		smartSpeed: 600,
		margin: 20,
		autoHeight: true,
		responsive: {
			0 : {
				items: 2,
			},
			576 : {
				items: 3,
			},
			768 : {
				items: 3,
				margin: 30,
			},
			992 : {
				items: 4,
				margin: 30,
			},
			1200 : {
				items: 6,
				margin: 30,
				dots: false,
				mouseDrag: false,
				slideBy: 6,
				smartSpeed: 400,
			},
		}
	});

	/*==============================
	Interview
	==============================*/
	$('.section__interview').owlCarousel({
		mouseDrag: true,
		touchDrag: true,
		dots: true,
		loop: true,
		autoplay: false,
		smartSpeed: 600,
		margin: 20,
		autoHeight: true,
		responsive: {
			0 : {
				items: 1,
			},
			576 : {
				items: 2,
			},
			768 : {
				items: 2,
				margin: 30,
			},
			992 : {
				items: 3,
				margin: 30,
			},
			1200 : {
				items: 3,
				margin: 30,
				dots: false,
				mouseDrag: false,
				slideBy: 3,
				autoplay: true,
				autoplayTimeout: 5000,
				autoplayHoverPause: true,
			},
		}
	});

	
	/*==============================
	Navigation
	==============================*/
	$('.section__nav--prev, .home__nav--prev').on('click', function() {
		var carouselId = $(this).attr('data-nav');
		$(carouselId).trigger('prev.owl.carousel');
	});
	$('.section__nav--next, .home__nav--next').on('click', function() {
		var carouselId = $(this).attr('data-nav');
		$(carouselId).trigger('next.owl.carousel');
	});

});