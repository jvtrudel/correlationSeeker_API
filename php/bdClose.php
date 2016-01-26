<?
try{
   $mdb=null;
}catch(PDOException $e){
   die("Erreur à la fermeture de la connection: ".$e->getMessage());
}
