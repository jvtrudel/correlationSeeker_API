<?

include('tools.php');

$serieA=parseJSONfile("../data/serieB.json");

//var_dump($serieA->observations);

array2cvs($serieA->observations,'../data/serieB.csv','date','value');
