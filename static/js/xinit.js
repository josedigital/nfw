/* skel-baseline v2.0.3 | (c) n33 | getskel.com | MIT licensed */

(function($) {

	skel.init({
		reset: 'full',
		breakpoints: {
			global: {
				href: 'http://localhost/nfw/static/css/style.css',
				containers: 1400,
				grid: { gutters: ['2em', 0] }
			},
			xlarge: {
				media: '(max-width: 1680px)',
				href: 'http://localhost/nfw/static/css/style-xlarge.css',
				containers: 1200
			},
			large: {
				media: '(max-width: 1280px)',
				href: 'http://localhost/nfw/static/css/style-large.css',
				containers: 960,
				grid: { gutters: ['1.5em', 0] },
				viewport: { scalable: false }
			},
			medium: {
				media: '(max-width: 980px)',
				href: 'http://localhost/nfw/static/css/style-medium.css',
				containers: '90%'
			},
			small: {
				media: '(max-width: 736px)',
				href: 'http://localhost/nfw/static/css/style-small.css',
				containers: '90%',
				grid: { gutters: ['1.25em', 0] }
			},
			xsmall: {
				media: '(max-width: 480px)',
				href: 'http://localhost/nfw/static/css/style-xsmall.css'
			}
		},
		plugins: {
			layers: {
				config: {
					mode: 'transform'
				},
				navPanel: {
					animation: 'pushX',
					breakpoints: 'medium',
					clickToHide: true,
					height: '100%',
					hidden: true,
					html: '<div data-action="moveElement" data-args="nav"></div>',
					orientation: 'vertical',
					position: 'top-left',
					side: 'left',
					width: 250
				},
				navButton: {
					breakpoints: 'medium',
					height: '4em',
					html: '<span class="toggle" data-action="toggleLayer" data-args="navPanel"></span>',
					position: 'top-left',
					side: 'top',
					width: '6em'
				}
			}
		}
	});

	$(function() {

		var	$window = $(window),
			$body 	= $('body'),
			$header = $('#header'),
			$banner = $('#banner');

		// Disable animations/transitions until the page has loaded.
			$body.addClass('is-loading');

			$window.on('load', function() {
				$body.removeClass('is-loading');
			});


		// Header.
		// If the header is using "alt" styling and #banner is present, use scrollwatch
		// to revert it back to normal styling once the user scrolls past the banner.
			if ($header.hasClass('alt')
			&&	$banner.length > 0) {

				$window.on('load', function() {

					$banner.scrollwatch({
						delay:		0,
						range:		0.98,
						anchor:		'top',
						on:			function() { $header.addClass('alt reveal'); },
						off:		function() { $header.removeClass('alt'); }
					});

					skel.change(function() {

						if (skel.isActive('medium'))
							$banner.scrollwatchSuspend();
						else
							$banner.scrollwatchResume();

					});

				});

			}

		// Scrolly
			$('.scrolly').scrolly({
				speed: 1500,
				offset: $header.outerHeight() - 90
			});


		// Form
			var frm = $('#contact-form');
			frm.validate();
			frm.ajaxForm({ 
				// target identifies the element(s) to update with the server response 
				target: '#success',
	 
				// success identifies the function to invoke when the server response 
				// has been received; here we apply a fade-in effect to the new content 
				success: function() {
					frm.fadeOut('slow', function() {
						$('#success').fadeIn('slow');
					});
				} 
			});



		// Scrollex
			$('.landing #banner .inner').scrollex({
				scroll: function(progress) {

				 // Set #foobar's background color to green when we scroll into it.
					 $(this).css('opacity', 2.75 - (progress * 1.5));
					 console.log( 1 - (progress * 1) );

				}
			});			




	}); //end $(function)

})(jQuery);