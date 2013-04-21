<?php

define('APP_DIR', './www');
define('APP_ROOT', '');
define('APP_URL', '');

include '../feng/main.php';
include './request.php';
$regulation = array(
    '/^\/?ajax(.*?)__(.*)/' => array('ajaxRequest', 1, 2),
    '/^\/?ajax(.*)/' => array('ajaxRequest', 1),
    '/(.*?)__(.*)/' => array('httpRequest', 1, 2),
    '/.*/' => array('httpRequest', 0),
);
$mainClass = new Main();
$notFoundFileName = 'www/404.html';
try
{
    $mainClass->run($regulation);
}
catch (OtherExceptionLib $e)
{
	if ($e->getMessage() == OtherExceptionLib::CLOSE_WINDOW)
	{
		echo '<script>';
		echo 'window.close()';
		echo '</script>';
		exit;
	}
}
catch (Exception $e)
{
    header("HTTP/1.0 404 Not Found");
    $mainClass->notFound($notFoundFileName);
    if (Config::FIRE_DEBUG)
    {
		echo $e->getMessage();
		echo "<br />\r\n";
        echo $e;
    }
}
catch (BusinessExceptionLib $e)
{
    header("HTTP/1.0 404 Not Found");
    $mainClass->notFound($notFoundFileName);
    if (Config::FIRE_DEBUG)
    {
        echo $e;
    }
}
catch (ViewExceptionLib $e)
{
    header("HTTP/1.0 404 Not Found");
    $mainClass->notFound($notFoundFileName);
    if (Config::FIRE_DEBUG)
    {
        echo $e;
    }
}
catch (DbExceptionLib $e)
{
    header("HTTP/1.0 404 Not Found");
    $mainClass->notFound($notFoundFileName);
    if (Config::FIRE_DEBUG)
    {
        echo $e;
    }
}
catch (Exception $e)
{
    header("HTTP/1.0 404 Not Found");
    $mainClass->notFound($notFoundFileName);
    if (Config::FIRE_DEBUG)
    {
        echo $e;
    }
}
