<?

function rawJSONfile($mfile){
   $pfile=file_get_contents($mfile);
   // *** file_get_contents semble brisé pour utf8:   http://stackoverflow.com/questions/2236668/file-get-contents-breaks-up-utf-8-characters
   $pfile=preg_replace('/:\s*(-?\d{'.$max_int_length.',})/', ': "$1"',
    $pfile);
    return $pfile;
}

function parseJSONfile($mfile){
   $pfile=rawJSONfile($mfile);
    $pfile=json_decode($pfile);  //  ?? encode ou decode?
    return $pfile;
}

function array2cvs($arr,$fname,$x,$y){
   // transforme un array en fichier cvs
   $fp = fopen($fname, 'w');
   fputcsv($fp, array($x,$y));
    foreach($arr as $line ){
      //var_dump($line->{'date'});
      fputcsv($fp, array($line->{$x},$line->{$y}));
   }

   fclose($fp);


}

function cleanJsonEncode($mfile){
   $pfile=preg_replace('/:\s*(-?\d{'.$max_int_length.',})/', ': "$1"',
   $mfile);
   return json_encode($pfile);
}
