jQuery(function ($) {
	$(document).ready(function () {
		$(document).on('added_to_cart', function (event, fragments, cart_hash, $button) {
			/* alert('El producto se ha añadido al carrito');*/ 
		});

		$('form.cart').on('submit', function (e) {
			e.preventDefault();

			var form = $(this);
			form.block({ message: null, overlayCSS: { background: '#fff', opacity: 0.6 } });

			var formData = new FormData(form[0]);
			formData.append('add-to-cart', form.find('[name=add-to-cart]').val());

			$.ajax({
				url: wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'ace_add_to_cart'),
				data: formData,
				type: 'POST',
				processData: false,
				contentType: false,
				complete: function (response) {
					response = response.responseJSON;

					if (!response) {
						return;
					}

					if (response.error && response.product_url) {
						window.location = response.product_url;
						return;
					}

					if (wc_add_to_cart_params.cart_redirect_after_add === 'yes') {
						window.location = wc_add_to_cart_params.cart_url;
						return;
					}

					var $thisbutton = form.find('.single_add_to_cart_button'); 

					$(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);

					$('.woocommerce-error, .woocommerce-message, .woocommerce-info').remove();

					form.closest('.product').before(response.fragments.notices_html)

					form.unblock();
				}
			});
		});
	});
});