<?php
echo 'oi';
die();
session_start();

include('core/Saud.php');

include('saudconfig.php');


$valor =  date('Y');

try {
	
	$app = new Saud($settings);
	$app->run();

} catch (Exception $e) {

	try {
 		Logger::exceptionLog ($e);

		$app->setCacheException($e);
		$app->forward('error');

	} catch (Exception $e) {
		echo "<pre>"; print_r($e->getMessage()); echo "</pre>"; die(__FILE__." - ".__LINE__);
	}
}
