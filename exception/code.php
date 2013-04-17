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
	*注册失败
	*/
	const USER_ERROR		= 10003;
	
	/*
	*密码为空
	*/
	const USER_PASS_EMPTY	= 10004;
}