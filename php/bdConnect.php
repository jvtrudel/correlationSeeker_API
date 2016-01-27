<?php
require_once('php/tools.php');

$infoDB=parseJSONfile("config.json");

try {
   $mdb=new PDO('mysql:host='.$infoDB->host.";
    dbname=".$infoDB->db."; charset=utf8",
    $infoDB->user,$infoDB->pass);
    $mdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
   die("Erreur lors de la connection à la base de donnée: ".$e->getMessage());
}
