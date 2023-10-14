jQuery(function ($) {
	$(document).ready(function () {
		$(document).on('added_to_cart', function (event, fragments, cart_hash, $button) {
			alert('El producto se ha añadido al carrito');
		});
	});
});