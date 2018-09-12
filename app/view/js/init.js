$( document ).ready(function() {
	$(".cart_num").on("change", change_cart_num);
	$(".cart_num_minus").on("click", $.proxy(plus_minus_cart_num, null, 'minus'));
	$(".cart_num_plus").on("click", $.proxy(plus_minus_cart_num, null, 'plus'));
});