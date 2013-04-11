<?php

class Config extends Conf
{
	/**
     * mysql主机地址
     */
    const DB_MYSQL_HOST = '127.0.0.1';

	/**
	 * mysql 搜索主机地址
	 */
	const DB_MYSQL_SEARCH_HOST = '114.112.163.2';

	/**
	 * mysql 搜索主机端口
	 */
	const DB_MYSQL_SEARCH_PORT = 9350;
    
    /**
     * mysql 用户名称
     */
    const DB_MYSQL_USERNAME = 'root';
    
    /**
     * mysql 密码
     */
    const DB_MYSQL_PASSWORD = 'llpp@quzhao.com,./123';
    
    /**
     * 数据库名称
     */
	const DB_MYSQL_DBNAME = 'db_quzhao';

	/**
	 * 搜索数据库名称
	 */
	const DB_MYSQL_SEARCH_DBNAME = 'db_quzhao_search';

	/**
	 * redis 地址
	 */
	const REDIS_HOST = '127.0.0.1';

	/**
	 * redis 端口
	 */
	const REDIS_PORT = '6379';

	/**
	 * redis 密码
	 */
	const REDIS_PASSWORD = '#$@quZhao';
	

}
