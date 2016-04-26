<?php
if (DEBUG) ini_set('display_errors',1); error_reporting(E_ALL);


@include(dirname(__FILE__) . '/config.core.php');

@include_once(CORE_PATH . '/dengrudiscuss.class.php');
if (!@include_once(CORE_PATH . '/dengrudiscuss.class.php')) {
	header('HTTP/1.1 503 Service Unavailable');
	echo "<html><title>Error 503: Site temporarily unavailable</title><body><h1>Error 503</h1><p>Site temporarily unavailable</p></body></html>";
	exit();
} 

$deng = new DengruDiscuss();
$deng->initialize();// Initialize DengruCMS

?>