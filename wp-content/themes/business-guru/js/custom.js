/*global jQuery, window, Modernizr, navigator, lang_home, objFlexSlider, objFlickr, jCarousel, objPostSlider, objGallerySlider, objTestimonials, objBlackAndWhite, google, objGoogleMap*/

(function ($, win, Modernizr, nav, doc) {

	"use strict";

	$(function () {

		/* ---------------------------------------------------- */
		/*	Main Navigation										*/
		/* ---------------------------------------------------- */

		(function () {

			var	arrowimages = {
				down: 'downarrowclass',
				right: 'rightarrowclass'
			}, $mainNav = $('#navigation'), $mainList  = $mainNav.find('ul').eq(0), optionsList = '<option value="" selected>Navigate...</option>', $submenu = $mainList.find("ul").parent();

			$submenu.each(function (i) {
				var $curobj = $(this);
					this.istopheader = ($curobj.parents("ul").length === 1 ? true : false);
				$curobj.children("a").append('<span class="' + (this.istopheader ? arrowimages.down : arrowimages.right) + '"></span>');
			});

			$mainList.on('mouseenter', 'li', function () {
				var $this    = $(this),
					$subMenu = $this.children('ul');
				if ($subMenu.length) {
					$this.addClass('hover');
				}
				$subMenu.hide().stop(true, true).fadeIn(200);
			}).on('mouseleave', 'li', function () {
				$(this).removeClass('hover').children('ul').stop(true, true).fadeOut(50);
			});

			// Responsive
			$mainList.find('li').each(function () {
				var $this   = $(this), $anchor = $this.children('a'), depth   = $this.parents('ul').length - 1, indent  = '';
				if (depth) {
					while (depth > 0) {
						indent += '-';
						depth = depth - 1;
					}
				}
				optionsList += '<option value="' + $anchor.attr('href') + '">' + indent + ' ' + $anchor.text() + '</option>';

			});

			$mainNav.after('<select class="responsive-nav">' + optionsList + '</select>');

			$('.responsive-nav').on('change', function () {
				win.location = $(this).val();
			});

		}());

		/* end Main Navigation */

		/* ---------------------------------------------------- */
		/*	Media Element										*/
		/* ---------------------------------------------------- */

		(function () {

			var $player = $('audio, video');

			if ($player.length) {

				$player.mediaelementplayer({
					audioWidth: '100%',
					audioHeight: '30px',
					videoWidth: '100%',
					videoHeight: '100%'
				});

			}
		}());

		/* ---------------------------------------------------------------------- */
		/*	Detect Touch Device													  */
		/* ---------------------------------------------------------------------- */

		(function () {

			if (Modernizr.touch) {
				$('body').addClass('touch-device');
			}

			if ($.browser.safari === true) {
				$('body').addClass('safari');
			}

		}());

		/* end Detect Touch Device */

				
		/* ---------------------------------------------------- */
		/* Back to Top											*/
		/* ---------------------------------------------------- */

		(function () {

			var extend = {
				button: '#back-top',
				text: 'Back to Top',
				min: 200,
				fadeIn: 400,
				fadeOut: 400,
				speed: 800
			}, oldiOS = false, oldAndroid = false;

			// Detect if older iOS device, which doesn't support fixed position
			if (/(iPhone|iPod|iPad)\sOS\s[0-4][_\d]+/i.test(nav.userAgent)) {
				oldiOS = true;
			}

			// Detect if older Android device, which doesn't support fixed position
			if (/Android\s+([0-2][\.\d]+)/i.test(nav.userAgent)) {
				oldAndroid = true;
			}

			$('body').append('<a href="#" id="' + extend.button.substring(1) + '" title="' + extend.text + '">' + extend.text + '</a>');

			$(win).scroll(function () {
				var pos = $(win).scrollTop();

				if (oldiOS || oldAndroid) {
					$(extend.button).css({
						'position': 'absolute',
						'top': pos + $(win).height()
					});
				}

				if (pos > extend.min) {
					$(extend.button).fadeIn(extend.fadeIn);
				} else {
					$(extend.button).fadeOut(extend.fadeOut);
				}

			});

			$(extend.button).on('click', function (e) {
				$('html, body').animate({
					scrollTop: 0
				}, extend.speed);
				e.preventDefault();
			});

		}());

		/* end Back to Top */

		/*----------------------------------------------------*/
		/*	Search Form										  */
		/*----------------------------------------------------*/

		(function () {

			var $search = $('.search-wrapper'), $text = $('input[type="text"]', $search), $submit = $('.submit-search', $search);

			function closeSearch(el, text) {
				$submit.removeClass("active");
				el.stop(true, false).animate({
					width: 0,
					paddingRight: '35px'
				}, 250, function () {
					text.val("").click(function () {
						return false;
					});
					el.removeClass("active").find("input[type='text']").blur();
				});
			}

			function searchAnimate(wrapper, text) {
				wrapper.stop(true, false).animate({
					width: '185px',
					paddingRight: '41px'
				}, 250, function () {
					wrapper.addClass("active").find("input[type='text']").focus();
					text.click(function () {
						return false;
					});
				});
				return false;
			}

			$submit.on('click', function (e) {
				var target = $(e.target);

				if ($(target).hasClass('active')) {
					return true;
				} else {
					target.addClass("active");
					searchAnimate($search, $text);
				}
				return false;
			});


			$('body').on('click', function (e) {
				var current = $(e.target);
				if ($search.hasClass('active')) {
					if (current !== $submit) {
						closeSearch($search, $text);
					}

				}
			});

		}());

		/* end Search Form */

		/* ---------------------------------------------------- */
		/*	Testimonials										*/
		/* ---------------------------------------------------- */

		(function () {

			function swipeFunc(e, dir) {

				var $quotes = $(e.currentTarget);

				// Enable swipes if more than one slide
				if ($quotes.data('slideCount') > 1) {

					$quotes.data('dir', '');

					if (dir === 'left') {
						$quotes.cycle('next');
					}

					if (dir === 'right') {
						$quotes.data('dir', 'prev');
						$quotes.cycle('prev');
					}

				}

			}

			var $quotes = $('.testimonials');

			if ($quotes.length) {

				$quotes.each(function (i) {

					var $this = $(this);

					$this.css('height', $this.children('li:first').height()).cycle({
						before: function (curr, next, opts) {
							var $this = $(this);
							$this.parent().stop().animate({
								height: $this.height()
							}, opts.speed);
						},
						containerResize: false,
						easing: objTestimonials.easing,
						fit: true,
						next: '',
						pause: true,
						prev: '',
						slideResize: true,
						speed: objTestimonials.speed,
						timeout: objTestimonials.timeout,
						width: '100%'
					}).data('slideCount', $this.children('li').length);

				});

				// Resize
				$(win).on('resize', function () {
					$quotes.css('height', $quotes.find('li:visible').height());
				});

				// Include Swipe
				if (Modernizr.touch) {

					$quotes.swipe({
						swipeLeft: swipeFunc,
						swipeRight: swipeFunc,
						allowPageScroll: 'auto'
					});

				}
			}

		}());


		/* ---------------------------------------------------- */
		/*	Portfolio											*/
		/* ---------------------------------------------------- */

		(function () {

			var $cont = $('#portfolio-items'), $itemsFilter, mouseOver;

			if ($cont.length) {

				$itemsFilter = $('#portfolio-filter');

				// Copy categories to item classes
				$cont.children('article').each(function (i) {
					var $this = $(this);
					$this.addClass($this.attr('data-categories'));
				});

				// Run Isotope when all images are fully loaded
				$(win).on('load', function () {

					$cont.isotope({
						itemSelector: 'article',
						layoutMode: 'fitRows'
					});

				});

				// Filter projects
				$itemsFilter.on('click', 'a', function (e) {
					
					var $this = $(this), currentOption = $this.attr('data-categories');

					$itemsFilter.find('a').removeClass('active');
					$this.addClass('active');
					
					if (currentOption) {
						if (currentOption !== '*') {
							currentOption = currentOption.replace(currentOption, '.' + currentOption);
						}
						$cont.isotope({
							filter: currentOption
						}, function() {
							if (currentOption == '*') {
								$('.single-image', $cont).attr('rel', 'gallery');
							} else { 
								$(currentOption, $cont).find('.single-image').attr('rel', currentOption.substring(1));
							}
						});
					}
					e.preventDefault();
				});
				
				$itemsFilter.find('a').first().addClass('active');
			}

		}());

		/* end Portfolio  */

		
		/* ---------------------------------------------------- */
		/*	Preloader											*/
		/* ---------------------------------------------------- */

		(function () {

			$.preloader = function (el, options) {
				var elem = $(el), methods = {},
					elements = elem.find('.preloader'),
					o = $.extend({}, $.preloader.defaults, options);

				methods = {
					init: function () {
						this.loader();
						this.eventListener();
					},
					eventListener: function () {
						$(win).load(function () {
							elements.each(function (i, val) {
								$(val).removeClass('loader');
							});
						});						
					},
					loader: function () {
						elements.each(function (i, val) {
							win.setTimeout(function () {
								$(val).addClass('loader');
							}, i * o.speed);
						});
					}
				};
				methods.init();

			};
			
			$.preloader.defaults = {speed : 250};

			$.fn.preloader = function (options) {
				if (typeof options === 'object') {
					return this.each(function () {
						new $.preloader(this, options);
					});
				};
			};

			$('.container').preloader({
				speed: 300
			});

		}());

		/* end Preloader */

		/* ---------------------------------------------------- */
		/*	Ajax Navigation										*/
		/* ---------------------------------------------------- */

		(function () {

			$.ajaxnav = function(el) {
				
				var element = $(el), 
					methods = {};

				methods = {
					elements: {
						'.ajax-nav': 'navList',
						'.ajax-content': 'content',
						'.ajax-navigation-item': 'list'
					},
					proxy: function(func) { return $.proxy(func, this); },
					init: function() {
						this.refreshElements();
						this.eventsListener();
					},
					$: function(selector) {
						return $(selector, element);
					},
					refreshElements: function() {
						for (var key in this.elements) {
							this[this.elements[key]] = this.$(key);
						}
					},
					eventsListener: function() {
						var that = this;
						this.navList.children('li').first().addClass('current');
						this.proxy(that.clickEvents(that), that);
					},
					clickEvents: function(that) {
						this.navList.on('click', 'a', function(e) {
							var $this = $(this).parent('li'), $index = $this.index();
								$this.siblings('li').removeClass('current').end().addClass('current');
								that.content.find(methods.list).hide().end().eq($index).stop(true, true).show(700);
								e.preventDefault();
						});
					}
				};
				methods.init();
			};

			$.fn.ajaxnav = function() {
				return this.each(function() {
					new $.ajaxnav(this);
				});
			};

			$(function() {
				$('.container').ajaxnav();
			});

		}());

		/* end Ajax Navigation */

	});

	/* ---------------------------------------------------- */
	/*	Actual Plugin										*/
	/* ---------------------------------------------------- */

	// jQuery Actual Plugin - Version: 1.0.13 (http://dreamerslab.com/)
		;(function(a){a.fn.extend({actual:function(b,l){if(!this[b]){throw'$.actual => The jQuery method "'+b+'" you called does not exist';}var f={absolute:false,clone:false,includeMargin:false};var i=a.extend(f,l);var e=this.eq(0);var h,j;if(i.clone===true){h=function(){var m="position: absolute !important; top: -1000 !important; ";e=e.clone().attr("style",m).appendTo("body");};j=function(){e.remove();};}else{var g=[];var d="";var c;h=function(){c=e.parents().andSelf().filter(":hidden");d+="visibility: hidden !important; display: block !important; ";if(i.absolute===true){d+="position: absolute !important; ";}c.each(function(){var m=a(this);g.push(m.attr("style"));m.attr("style",d);});};j=function(){c.each(function(m){var o=a(this);var n=g[m];if(n===undefined){o.removeAttr("style");}else{o.attr("style",n);}});};}h();var k=/(outer)/g.test(b)?e[b](i.includeMargin):e[b]();j();return k;}});})(jQuery);
	$(window).load(function() {		$('#slider').nivoSlider();	});
	/* end jQuery Actual Plugin */

}(jQuery, window, Modernizr, navigator, document));