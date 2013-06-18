$(document).ready(function() {

	$(".submit").click(function() {

		var errors = new Array();
		var name = $(":input[name*=name]").val();
		if (name.length == 0) {
			errors['name'] = "字段不能为空";
		} else {
			errors['name'] = null;
		}

		var telephone = $(":input[name*=telephone]").val();
		if (telephone.length == 0) {
			errors['telephone'] = "字段不能为空";
		} else {
			errors['telephone'] = null;
		}
		var address = $(":input[name*=address]").val();
		if (address.length == 0) {
			errors['address'] = "字段不能为空";
		} else {
			errors['address'] = null;
		}
		var password = $(":input[name*=password]").val();

		if (password.length == 0) {
			errors['password'] = "字段不能为空";
		} else {
			errors['password'] = null;
		}
		var verifyPassword = $(":input[name*=verifyPassword]").val();
		if (verifyPassword.length == 0) {
			errors['verifyPassword'] = "字段不能为空";
		} else if (password !== verifyPassword) {
			errors['verifyPassword'] = "请再输入确认密码";
		} else {
			errors['verifyPassword'] = null;
		}
		var isVerified = true;

		$("div[id$=_em_]").remove();
		for ( var i in errors) {

			if (errors[i] != null) {

				mydiv = $("<div/>");
				mydiv.attr("id", "#Customer_" + i + "_em_");

				$("#Customer_" + i).after(mydiv);

				$(mydiv).empty();
				$(mydiv).append("&nbsp;" + errors[i]);
				$(mydiv).css("display", "inline");
				$(mydiv).css("color", "red");

				isVerified = false;
			}

		}
		if (isVerified) {
			$("#register-form").submit();
		}

	});

});