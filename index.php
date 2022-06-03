<?php
require __DIR__ . "/inc/bootstrap.php";
 
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
//die();

if ((isset($uri[3]) && $uri[3] != 'hoiku') || !isset($uri[4])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}
 
require PROJECT_ROOT_PATH . "/Controller/Api/HoikuController.php";
 
$objFeedController = new HoikuController();
$strMethodName = $uri[4] . 'Action';
$objFeedController->{$strMethodName}();
?>