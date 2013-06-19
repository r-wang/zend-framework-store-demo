$(document).ready(function() {



	$(".submit").click(function() {

		var errors = new Array();

		var name = $(":input[name*=name]").val();

		if (name.length == 0) {

			errors['name'] = "字段不能为空";

		} else {

			errors['name'] = null

		}



		var email_reg = /^[a-zA-Z0-9_]+@[a-zA-Z]+(\.[a-zA-Z]+)+$/gi;

		var email = $(":input[name*=email]").val();

		if (email.length == 0) {

			errors['email'] = "字段不能为空";

		} else if (!email_reg.test(email)) {

			errors['email'] = "邮箱格式错误";

		} else {

			errors['email'] = null;

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

		for ( var i in errors) {



			$("#Customer_" + i + "_em_").empty();

			$("#Customer_" + i + "_em_").append(errors[i]);

			$("#Customer_" + i + "_em_").show();

			if (errors[i] != null) {

				isVerified = false;

			}



		}

		$.post("/customer/checkdata", {

			"email" : email

		}, function(data) {

			if (data !== "ok") {
				isVerified = false;

				$("#Customer_email_em_").empty();

				$("#Customer_email_em_").append(data);

				$("#Customer_email_em_").show();
				

			} 
		if (isVerified) {

			$("#register-form").submit();

		}

		});


	});



});