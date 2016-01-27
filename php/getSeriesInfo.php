<?php
require_once('php/tools.php');


require_once('fred_api/Autoloader.php');
Fred_Autoloader::register();
$fredConf=parseJSONfile("config.json");
$api = new fred_api($fredConf->API_key);
$category_api = $api->factory('category');




$parameters = array('category_id' => $id,'file_type'=>'json');
$series = json_decode($category_api->series($parameters));



$category_api=null;
$api=null;

$results= $series->{'seriess'};
