/* ==================================================================================== *
 *
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 * & https://roots.io/sage/
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 *
 * ==================================================================================== *
 *
 * TweenMax
 * By GreenStock
 * https://greensock.com/tweenmax
 * https://ihatetomatoes.net/wp-content/uploads/2016/07/GreenSock-Cheatsheet-4.pdf
 *
 * ==================================================================================== */

(function ($) {

	// Use this variable to set up the common and page specific functions. If you
	// rename this variable, you will also need to rename the namespace below.
	var armcodirecttheme = {
		// All pages
		'common': {
			init: function () {

				var firstSection = $('.main-content-wrap section').first();
				$(window).on('scroll', function () {
					var scrollTop = $(this).scrollTop();

					if (scrollTop > 50) {
						$('header').addClass('sticky');
					} else {
						$('header').removeClass('sticky');
					}

					if (scrollTop > 50) {
						$('header').addClass('appear');
					} else {
						$('header').removeClass('appear');
					}
				});

				getheaderHeight();
				function getheaderHeight() {
					var headerHeight = $('header').outerHeight();
					$('.main-content-wrap').css('margin-top', headerHeight);
				}

				$(window).on('resize', function () {
					setTimeout(function () {
						getheaderHeight();
					}, 400);
				});

				// JavaScript to be fired on all pages
				$('.wpcf7-form .wpcf7-form-control').on('keyup focus', function (e) {
					$(this).removeClass('wpcf7-not-valid');
				});

				var swiperObjs = [];
				var swiperItems = document.querySelectorAll(".swiper-container");

				swiperItems.forEach(function (swiperItem, index) {
					var _this = $(swiperItem),
						sliderOptions = _this.attr('data-slider-options');
					if (typeof (sliderOptions) !== 'undefined' && sliderOptions !== null) {
						sliderOptions = $.parseJSON(sliderOptions);

						var swiperObj = new Swiper(swiperItem, sliderOptions);
						swiperObjs.push(swiperObj);
					}
				});
				// init Masonry
				if ($('.masonry-js').length > 0) {
					var $grid = $('.masonry-js').masonry({
						// options
						itemSelector: '.grid-item',
						columnWidth: 400
					});
				}

				// Open menu on click mobile
				$(document).on('click', '.mobile-dropdown-toggle', function (e) {
					var _this = $(this);
					_this.parent().toggleClass('open');
				});

				$(document).on('click', '.navbar-toggler', function () {
					if ($('.dropdown').hasClass('open')) {
						$('.dropdown').removeClass('open');
					}
				});

				// Comment form validation
				$('.comment-button').on('click', function () {
					var fields;
					fields = "";
					var _grandParent = $(this).parent().parent();

					if (_grandParent.find('#author').length == 1) {
						if ($('#author').val().length == 0 || $('#author').val().value == '') {
							fields = '1';
							$('#author').addClass('inputerror');
						}
					}
					if (_grandParent.find('#comment').length == 1) {
						if ($('#comment').val().length == 0 || $('#comment').val().value == '') {
							fields = '1';
							$('#comment').addClass('inputerror');
						}
					}
					if (_grandParent.find('#email').length == 1) {
						if ($('#email').val().length == 0 || $('#email').val().length == '') {
							fields = '1';
							$('#email').addClass('inputerror');

						} else {
							var re = new RegExp();
							re = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
							var sinput;
							sinput = "";
							sinput = $('#email').val();
							if (!re.test(sinput)) {
								fields = '1';
								$('#email').addClass('inputerror');
							}
						}
					}
					if (fields != "") {
						return false;
					} else {
						return true;
					}
				});

				$('.comment-field').on('keyup focus', function (e) {
					$(this).removeClass('inputerror');
				});

				if ($('a[href ^= "#"]').length > 0) {
					$('a[href ^= "#"]').click(function (event) {
						event.preventDefault();
						var headerHeight = 0;
						if ($('header').length > 0) {
							var headerHeight = $('header').outerHeight();
						}
						if ($('#wpadminbar').length > 0) {
							headerHeight = headerHeight + $('#wpadminbar').outerHeight();
						}
						$('html, body').animate({
							scrollTop: $($.attr(this, 'href')).offset().top - headerHeight
						}, 0, 'linear');
					});
				}

				// Scroll To calculate summary in mobile
				var scrolltobottom = $('.scroll-to-calculator-summary');

				$(window).scroll(function () {
					if ( $( '.step-wrapper' ).length > 0 ) {
						let SideBlockPos = $( '.step-wrapper' ).offset().top - $( document ).scrollTop(),
						WindowHeight = $(window).height();

						if (SideBlockPos <= WindowHeight) {
						scrolltobottom.css({ "opacity": 0, "visibility": "hidden" });
						} else {
							scrolltobottom.css({ "opacity": 1, "visibility": "visible" });
						}
					}
				});

				scrolltobottom.click(function () {
					$('html, body').animate({
						scrollTop: $('.step-wrapper').offset().top
					}, 0, 'linear');
				});
			},
			finalize: function () {
				// JavaScript to be fired on all pages, after page specific JS is fired
			}
		},
		// Home/Index page example - if WordPress, 'index' will need to be changed to 'home'
		'home': {
			init: function () {
				// JavaScript to be fired on the home page

			},
			finalize: function () {
				// JavaScript to be fired on the home page, after the init JS
			}
		},
		// About us page, note the change from about-us to about_us.
		'about_us': {
			init: function () {
				// JavaScript to be fired on the about us page
			}
		}
		// ...
	};

	// The routing fires all common scripts, followed by the page specific scripts.
	// Add additional events for more control over timing e.g. a finalize event
	var UTIL = {
		fire: function (func, funcname, args) {
			var fire;
			var namespace = armcodirecttheme;
			funcname = (funcname === undefined) ? 'init' : funcname;
			fire = func !== '';
			fire = fire && namespace[func];
			fire = fire && typeof namespace[func][funcname] === 'function';

			if (fire) {
				namespace[func][funcname](args);
			}
		},
		loadEvents: function () {
			// Fire common init JS
			UTIL.fire('common');

			// Fire page-specific init JS, and then finalize JS
			$.each(document.body.className.replace(/-/g, '_').split(/\s+/), function (i, classnm) {
				UTIL.fire(classnm);
				UTIL.fire(classnm, 'finalize');
			});

			// Fire common finalize JS
			UTIL.fire('common', 'finalize');
		}
	};

	// Load Events
	$(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
