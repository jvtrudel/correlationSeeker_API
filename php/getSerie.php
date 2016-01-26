<?
require_once('php/tools.php');


require_once('fred_api/Autoloader.php');
Fred_Autoloader::register();
$fredConf=parseJSONfile("config.json");
$api = new fred_api($fredConf->API_key);
$series_api = $api->factory('series');




$parameters = array('series_id' => $id,'file_type'=>'json');
$results = json_decode($series_api->observations($parameters));



$series_api=null;
$api=null;
