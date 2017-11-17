(function( $ ) {
	//'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 */

	$(function () {
		var $widgetCars = $('.wp-cars-test-widget');

		$widgetCars.each(function () {
			//$(this).find('.btn.show-next-car')
		});

		$widgetCars.on('click', '.btn.show-next-car', null, function (e) {
			e.preventDefault();
			show_next_posts(this);
		});

		$widgetCars.find('.btn.show-next-car').attr('data-current-post-id', getCookie('wp_cars_last_ID')).trigger('click');

	}); // End DOM ready











	/**
	 * ****************************
	 * HELPERS FUNCTIONS
	 * ****************************
	 */


	/**
	 *  Load via ajax next Posts to display
	 *  @param DOMElement btn The DOM element of button
	 *  @return boolean | jqxhr
	 */
	function show_next_posts(btn) {
		if (!btn) return false;

		var btn, ajaxData, jqxhr, loader;

		btn = $(btn);

		loader = $('<div id="mdev-overlay" class="relative"><div class="mdev-loader rotateLinear">&#9679;&#9679;</div></div>');

		// prepeare data to send with ajax request
		ajaxData = {
			action: 'show_next_post',
			security: WPCARSAJAX.nonce,
			currentPostID: btn.attr('data-current-post-id'),
			numberPosts: btn.attr('data-number-posts')
		};

		// send ajax request
		jqxhr = $.ajax({
			type: "POST",
			url: WPCARSAJAX.ajax_url,
			cache: false,
			data: ajaxData,
			dataType: "json",
			beforeSend: function (jqXHR, settings) {
				btn.hide().after(loader.show());
			},
			success: function (response, textStatus, jqXHR) {
				if (response.status) {
					//console.log('response = ', response);
					btn.closest('.wp-cars-test-widget')
						.find(btn.data('target'))
						.html(response.html);
					btn.attr('data-current-post-id', response.currentPostID);
					setCookie('wp_cars_last_ID', response.currentPostID);
				}
				else {
					alert(response.resmessage);
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(WPCARSAJAX.ajax_error_message);
			},
			complete: function (jqXHR, textStatus) {
				btn.show();
				loader.remove();
			}
		});

		return jqxhr;
	}



	/**
	 *  Set cookie with 'name' and 'value'
	 *  @param string name The name of cookie
	 *  @param string value The value of cookie
	 *  @param object options The options of cookie  (expires, path, domain, secure)
	 *  @return Void
	 */
	function setCookie(name, value, options) {
		var options = options || {};
		var expires = options.expires;
		var d = new Date();
		var name = name || '';
		var value = encodeURIComponent(value) || '';
		var updatedCookie = name + "=" + value;

		if ( typeof expires == "number" && expires ) {
			d.setTime(d.getTime() + expires*1000);
			expires = options.expires = d;
		}

		if ( expires && expires.toUTCString ) {
			options.expires = expires.toUTCString();
		}

		for( var propName in options ) {
			var propValue = options[propName]; updatedCookie += "; " + propName; if (propValue !== true) { updatedCookie += "=" + propValue; }
		}

		document.cookie = updatedCookie;
	}



	/**
	 *  Get cookie by name
	 *  @param string name The name of cookie
	 *  @return string | undefined
	 */
	function getCookie(name) {
		var matches;

		matches = document.cookie.match(new RegExp( "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)" ));

		return matches ? decodeURIComponent(matches[1]) : undefined;
	}



	/**
	 *  Delete cookie by name
	 *  @param string name The name of cookie
	 *  @return Void
	 */
	function deleteCookie(name) {
		setCookie(name, "", { expires: -1 })
	}

})( jQuery );