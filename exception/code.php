<?php

class CodeException extends Feng
{
	/*
	*注册成功
	*/
	const USER_SUCCESS		= 10000;
	
	/*
	*用户名为空
	*/
	const USER_EMAIL_EMPTY 	= 10001;
	
	/*
	*用户名格式错误
	*/
	const USER_EAMIL_FORMAT = 10002;
	
	/*
	*用户名已被占用
	*/
	const USER_EMAIL_EXISTS	= 10003;
	
	/*
	*密码为空
	*/
	const USER_PASS_EMPTY	= 10004;
	
	/*
	*没有接受用户协议
	*/
	const USER_NO_AGREEMENT	= 10005;
	
	/**
	 * 用户昵称没有填写
	 */
	const USER_NO_NICKNAME = 10006;
	
	/**
	 * 没有登录
	 */
	const USER_NOT_LOGIN = 50001;
	
	/**
	 * 没有设置用户email
	 */
	const USER_NO_EAMIL = 50002;
	
	/**
	 * 权限不够
	 * @var unknown
	 */
	const USER_NOT_POWER = 6000;
}