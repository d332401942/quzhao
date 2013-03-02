<?php
define('APP_DIR', './admin');
define('APP_ROOT','');
define('APP_URL','/quzhaoroot.php');
include '../feng/main.php';
include './request.php';
$regulation = array(
	'/^\/?ajax(.*?)__(.*)/' => array('ajaxRequest', 1, 2),
	'/^\/?ajax(.*)/' => array('ajaxRequest', 1),
	'/(.*?)__(.*)/' => array('httpRequest', 1, 2),
	'/.*/' => array('httpRequest', 0),
);
$mainClass = new Main();

try
{
    $mainClass->run($regulation);
}
catch (ViewExceptionLib $e)
{
    $msg = $e->getMessage();
    $msg = urlencode($msg);
    header('Location: '.APP_URL .'/index/msg?mark=0&msg='.$msg);
}
catch (BusinessExceptionLib $e)
{
    $msg = $e->getMessage();
    $msg = urlencode($msg);
    header('Location: '.APP_URL .'/index/msg?mark=0&msg='.$msg);
}
catch (Exception $e)
{
    throw $e;
}
