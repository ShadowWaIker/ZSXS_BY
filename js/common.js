//打开字滑入效果
window.onload = function(){
	$(".connect p").eq(0).animate({"left":"0%"}, 600);
	$(".connect p").eq(1).animate({"left":"0%"}, 400);
};
//jquery.validate表单验证
$(document).ready(function(){
	//登陆表单验证
	$("#loginForm").validate({
		rules:{
			username:{
				required:true,//必填
				minlength:11, //最少11个字符
				maxlength:15,//最多15个字符
			},
			idcard:{
				required:true,
				minlength:15,
				maxlength:18,
			},
			password:{
				required:true,
				minlength:3, 
				maxlength:32,
			},
		},
		//错误信息提示
		messages:{
			username:{
				required:"必须填写用户名",
				minlength:"用户名至少为11个字符",
				maxlength:"用户名至多为15个字符",
				remote: "用户名已存在",
			},
			idcard:{
				required:"必须填写身份证号码",
				minlength:"用户名至少为15个字符",
				maxlength:"用户名至多为18个字符",
				remote: "用户名已存在",
			},
			password:{
				required:"必须填写密码",
				minlength:"密码至少为3个字符",
				maxlength:"密码至多为32个字符",
			},
		},

	});
	//邮寄信息表单验证
	$("#mailMsgForm").validate({
		rules:{
			name:{
				required:true,
				minlength:2, 
				maxlength:5,
			},
			address:{
				required:true,
				minlength:3, 
				maxlength:32,
			},
			phone_number:{
				required:true,
				phone_number:true,//自定义的规则
				digits:true,//整数
			},
			code:{
				required:true,
				minlength:4, 
				maxlength:4,
			},
			phone_number_bak:{
				required:true,
				phone_number:true,//自定义的规则
				digits:true,//整数
			}
		},
		//错误信息提示
		messages:{
			name:{
				required:"必须填写收件人姓名",
				minlength:"收件人姓名至少为2个字符",
				maxlength:"收件人姓名至多为5个字符",
				remote: "用户名已存在",
			},
			address:{
				required:"必须填写收件地址",
				minlength:"收件地址至少为3个字符",
				maxlength:"收件地址至多为32个字符",
			},
			phone_number:{
				required:"请输入收件人手机号码",
				digits:"请输入正确的收件人手机号码",
			},
			code:{
				required:"必须填写验证码",
				minlength:"验证码为4个字符",
				maxlength:"验证码为4个字符",
			},
			phone_number_bak:{
				required:"请输入其他联系电话",
				digits:"请输入正确的其他联系电话",
			}
		},
	});
	//注册表单验证
	$("#registerForm").validate({
		rules:{
			username:{
				required:true,//必填
				minlength:3, //最少6个字符
				maxlength:32,//最多20个字符
				remote:{
					url:"http://kouss.com/demo/Sharelink/remote.json",//用户名重复检查，别跨域调用
					type:"post",
				},
			},
			password:{
				required:true,
				minlength:3, 
				maxlength:32,
			},
			email:{
				required:true,
				email:true,
			},
			confirm_password:{
				required:true,
				minlength:3,
				equalTo:'.password'
			},
			phone_number:{
				required:true,
				phone_number:true,//自定义的规则
				digits:true,//整数
			}
		},
		//错误信息提示
		messages:{
			username:{
				required:"必须填写用户名",
				minlength:"用户名至少为3个字符",
				maxlength:"用户名至多为32个字符",
				remote: "用户名已存在",
			},
			password:{
				required:"必须填写密码",
				minlength:"密码至少为3个字符",
				maxlength:"密码至多为32个字符",
			},
			email:{
				required:"请输入邮箱地址",
				email: "请输入正确的email地址"
			},
			confirm_password:{
				required: "请再次输入密码",
				minlength: "确认密码不能少于3个字符",
				equalTo: "两次输入密码不一致",//与另一个元素相同
			},
			phone_number:{
				required:"请输入手机号码",
				digits:"请输入正确的手机号码",
			},
		
		},
	});
	//添加自定义验证规则
	jQuery.validator.addMethod("phone_number", function(value, element) { 
		var length = value.length; 
		var phone_number = /^((1)+\d{10})$/ 
		return this.optional(element) || (length == 11 && phone_number.test(value)); 
	}, "手机号码格式错误"); 
});
