<?php
header('Content-Type: application/json; charset=utf-8');
$method = $_GET['method'];
$id     = $_GET['id'];


// if valid method
include("php/".$method.".php");

echo json_encode($results);

?>
