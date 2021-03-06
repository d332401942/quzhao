var userCallBak = function(){};

function loginOut() {
	$.ajax({
		url: '__AJAX__/user/loginOut?stmp=' + new Date().toString(),
		dataType: 'json',
		success: function(data) {
			if (data.result) {
				window.location.reload();
			}
		}
	});
}

function showLeftLogin() {
	var obj = $('#js-login-div');
	$.removeCookie('UserInfo');
	var interval = setInterval(function(){
		listenUserInfo(interval);
	},30);
	if (!obj.is(':visible')) {	
		obj.fadeIn('fast', function(){
			$('body').bind('click',function(e) {
				var _this = $(e.target);
				if (!_this.closest('#js-login-div').length) {
					hideLeftLogin();
				}
			});
		});	
	}
}

function hideLeftLogin() {
	var obj = $('#js-login-div');
	obj.fadeOut('fast');
	$('body').unbind('click');
}

function loginTaobao() {
	var url = '<{$connectModel->stepTaobao1}>';  
	window.open(url,'logintaobao','channelmode=yes,width=800,height=500,left=400,top=100');
}

function loginWeibo() {
	var url = '<{$connectModel->stepWeibo1}>';
	window.open(url,'logintaobao','channelmode=yes,width=800,height=500,left=400,top=100');
}

function loginQQ() {
	var url = '<{$connectModel->stepQQ1}>';
	window.open(url,'loginqq','channelmode=yes,width=800,height=500,left=400,top=100');
}

function listenUserInfo(interval) {
	var userInfo = $.cookie('UserInfo');
	if (userInfo) {
		eval('userInfo = ' + userInfo);
	}
	if (typeof(userInfo) == 'object') {
		clearInterval(interval);
		if (!userInfo.email || userInfo.email == "0") {
			preset();
		}
		else {
			window.location.reload();
		}
	}
}

function preset() {
	$.ajax({
		url: '__APP__/user/preset?stmp=' + new Date().toString(),
		success: function(html) {
			$.mask.close(function(){
				$.mask.show($(html));
			});	
		}
	});
}

function showLoginDiv() {
	$.removeCookie('UserInfo');
	var interval = setInterval(function(){
		listenUserInfo(interval);
	},30);
	$.ajax({
		url: '__APP__/user/userlogin?stmp=' + new Date().toString(),
		success: function(html) {
			$.mask.show($(html));
		}
	});
}

function showRegDiv() {
	$.removeCookie('UserInfo');
	var interval = setInterval(function(){
		listenUserInfo(interval);
	},30);
	$.ajax({
		url: '__APP__/user/userreg?stmp=' + new Date().toString(),
		success: function(html) {
			$.mask.show($(html));
		}
	});
}

function showShareDiv() {
	//如果用户没有登录先登录
	if (!CurrentUserInfo) {
		userCallBak = showShareDiv;
		showLoginDiv();
	}
	else {
		$.ajax({
			url: '__APP__/user/share?stmp=' + new Date().toString(),
			success: function(html) {
				$.mask.show($(html));
			}
		});
	}
}

function doLogin(obj) {
	$(obj).ajaxSubmit({
		type: 'post',
		url: '__AJAX__/user/login?stmp=' + new Date().toString(),
		dataType: 'json',
		success: function(data) {
			if (data.result) {
				CurrentUserInfo = data.result;
				$.mask.close()
				userCallBak();
				showTop();
			}
			else {
				var msg = data.error.message;
				if ($('#js-error').length) {
					$('#js-error').html(msg);
				}
				else {
					alert(msg);
				}
			}
		}
	});
	return false;
}

//注册
function doReg(obj) {
	$(obj).ajaxSubmit({
		dataType: 'json',
		success: function(data) {
			if (data.result) {
				//window.location.href = '__APP__/user/change';
			}
		}
	});
	return false;
}

function checkRePassword(obj) {
	obj.type = 'password';
	if (obj.value =='确认密码') {
		obj.value = ''
	}
}

function rePasswordBlur(obj) {
	var password = $('#js-password').val();
	if (obj.value == '') {
		obj.value='确认密码'
		obj.type = 'text';
	}
	else if (obj.value != password) {
		$('#js-pass-error').html('两次密码输入的不一致');
		$(obj).css('border-color','#E872C0');
	}
}

function doPreset() {
	if (!checkNikeNamePreset() | !checkEmailPreset() | !checkPasswordPreset()) {
		return false;
	}
	var formObj = $('#js-preset-form');
	var email = formObj.find('input[name="email"]').val();
	var nikename = formObj.find('input[name="nikename"]').val();
	var password = formObj.find('input[name="password"]').val();
	$.ajax({
		url: '__AJAX__/user/preSet?stmp='+ new Date().toString(),
		data: {email:email,nikename:nikename,password:password},
		dataType: 'json',
		type: 'post',
		success: function(data) {
			if (data.result) {
				window.location.reload();
			}
		}
	});
	return false;
}

function checkNikeNamePreset() {

	var formObj = $('#js-preset-form');
	//var nikenameObj = formObj.find('input[name="nikename"]');
	//var errObj = nikenameObj.next();
	var nikename = nikenameObj.val();
	
	if (!nikename) {
		errObj.html('昵称不能为空');
		return false;
	}
	else if (nikename.length > 8) {
		errObj.html('昵称不能超过8个字');
		return false;
	}
	errObj.html('');
	return true;
}

function checkEmailPreset() {
	var formObj = $('#js-preset-form');
	var emailObj = formObj.find('input[name="email"]');
	var errObj = emailObj.next();
	var email = emailObj.val();
	if (!email || email == '登录邮箱') {
		errObj.html('请填写email');
		return false;
	}
	var url  = '__AJAX__/user/checkuser?stmp'+Math.random();
	var data = {name:email};
	var status = false;
	$.ajax({
		url:url,
		data:data,
		async: false,
		dataType:'json',
		success:function(data){
			if (data.result) {
				status = true;
				errObj.html('<font color="green">用户名可用</font>');
			}
			else {
				errObj.html(data.error.message);
			}
		}
	});
	return status;
}

function checkPasswordPreset() {
	var formObj = $('#js-preset-form');
	var passwordObj = formObj.find('input[name="password"]');
	var errObj = passwordObj.next();
	var password = passwordObj.val();
	if (password == '密码') {
		password = '';
		
	}
	
	if (!password || password.length < 6) {
		errObj.html('密码不能小于6位');
		return false;
	}
	if (password.length > 32) {
		errObj.html('密码不能大于32位');
		return false;
	}
	errObj.html('');
	return true;
}



function checkname() {
	obj = $('#js-user-name');
	var name = obj.val();
	alert(name);
	if (!name || name == '昵称') {
		$('#js-user-name').html('请填写昵称');
		obj.css('border-color','#E872C0');
		if (name =='') {
			obj.val('昵称');
		}
		return false;
	}
	
	var data = {name:name};
	var url  = '__AJAX__/user/checkuser?stmp'+Math.random();
	$.ajax({
		type:'get',
		url:url,
		data:data,
		dataType:'json',
		success:function(data){
			if (data.result) {
				$('#js-user-error').html('<font color="green">昵称可用</font>');
				$(obj).css('border-color','#cdcdcd');
			}
			else {
				$('#js-user-error').html(data.error.message);
				$(obj).css('border-color','#E872C0');
			}
		}
	});
}



function checkverify(value) {
	if (value ==''){value='验证码'}
	var data = {verify:value};
	var url  = '__AJAX__/user/checkverify?stmp'+Math.random();
	$.ajax({
		type:'get',
		url:url,
		data:data,
		dataType:'json',
		success:function(data){
			if (data.result) {
				$('.kuang3').css('border-color','#cdcdcd');
				$('#verify').html('');
			}
			else {
				$('#verify').html('<font color="#E872C0">'+data.error.message+'</font>');
				$('.kuang3').css('border-color','#E872C0');
			}
		}
	});
}
//CharMode函数 
//测试某个字符是属于哪一类. 
function CharMode(iN) {
	if (iN >= 48 && iN <= 57) //数字 
		return 1;
	if (iN >= 65 && iN <= 90) //大写字母 
		return 2;
	if (iN >= 97 && iN <= 122) //小写 
		return 4;
	else
		return 8; //特殊字符 
}
//bitTotal函数 
//计算出当前密码当中一共有多少种模式 
function bitTotal(num) {
	modes = 0;
	for (i = 0; i < 4; i++) {
		if (num & 1) modes++;
		num >>>= 1;
	}
	return modes;
}
//checkStrong函数 
//返回密码的强度级别 
function checkStrong(sPW) {
	if (sPW.length <= 4)
		return 0; //密码太短 
	Modes = 0;
	for (i = 0; i < sPW.length; i++) {
		//测试每一个字符的类别并统计一共有多少种模式. 
		Modes |= CharMode(sPW.charCodeAt(i));
	}
	return bitTotal(Modes);
}
//pwStrength函数 
//当用户放开键盘或密码输入框失去焦点时，根据不同的级别显示不同的颜色 
function pwStrength(pwd, type) {
	if (pwd == null || pwd == '') {
		$(".right2_yi_zuo").html('<img src="__RESOURCE__/images/ruo1.jpg">');
		$(".right2_yi_zhong").html('<img src="__RESOURCE__/images/zhong.jpg">');
		$(".right2_yi_you").html('<img src="__RESOURCE__/images/qiang.jpg">');
		$('#js-pass-error').html('请填写密码');
		$('#js-password').val('密码').get(0).type = 'text';
		$('#js-password').css('border-color','#E872C0');

	}
	else if (type && type == 'onblur' && pwd.length < 6) {
		$('#js-pass-error').html('密码不能低于6位');
		$('#password').css('border-color','#E872C0');
	}
	else if(pwd.length > 32) {
		$('#js-pass-error').html('密码不能超过32位');
		$('#password').css('border-color','#E872C0');
	}
	else {
		$('#js-pass-error').html('');	
		$('#js-password').css('border-color','#cdcdcd');
		S_level = checkStrong(pwd);
		switch (S_level) {
			case 0:
				$(".right2_yi_zuo").html('<img src="__RESOURCE__/images/ruo1.jpg">');
				$(".right2_yi_zhong").html('<img src="__RESOURCE__/images/zhong.jpg">');
				$(".right2_yi_you").html('<img src="__RESOURCE__/images/qiang.jpg">');
			case 1:
				$(".right2_yi_zuo").html('<img src="__RESOURCE__/images/ruo1.jpg">');
				$(".right2_yi_zhong").html('<img src="__RESOURCE__/images/zhong.jpg">');
				$(".right2_yi_you").html('<img src="__RESOURCE__/images/qiang.jpg">');
				break;
			case 2:		 
			   $(".right2_yi_zuo").html('<img src="__RESOURCE__/images/ruo.gif">');
			   $(".right2_yi_you").html('<img src="__RESOURCE__/images/qiang.jpg">');
			   $(".right2_yi_zhong").html('<img src="__RESOURCE__/images/zhong1.gif">');
				break;
			default:
				$(".right2_yi_zuo").html('<img src="__RESOURCE__/images/ruo.gif">');
				$(".right2_yi_zhong").html('<img src="__RESOURCE__/images/zhong.jpg">');
				$(".right2_yi_you").html('<img src="__RESOURCE__/images/qiang1.gif">');
		}
	}
} 