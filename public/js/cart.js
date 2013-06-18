$(document).ready(function() {

	$(".portlet-content .cart_remove").click(function() {
		if (confirm("确认从购物车删除这一项？")) {

			var idval = $(this).attr("id");
			var send_data = {
				"id" : idval
			};
			$.post("/cart/remove", send_data, function(data) {
				window.location.reload();

			});
		}
	});

});
