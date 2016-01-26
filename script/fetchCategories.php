<?php
header('Content-Type: text/html; charset=utf-8');
// Récupération des catégories de FRED
echo "</br>Fetch (FRED) Categories</br>";
echo "Mise à jour des catégories de FRED (https://research.stlouisfed.org/docs/api/fred/)</br>";


set_time_limit(0);
require_once('../php/tools.php');

echo "</br>Chargement de l'api FRED</br>";
require_once('../vendor/fred_api/Autoloader.php');
Fred_Autoloader::register();
$fredConf=parseJSONfile("fredAPI.json");
$api = new fred_api($fredConf->API_key);
$category_api = $api->factory('category');


echo "</br>Connection à la base de donnée locale</br>";
// db conf data
$infoDB=parseJSONfile("../config.json");  //retrieve bd info !!security warning!!

// connection à la DB
try {
   $mdb=new PDO('mysql:host='.$infoDB->host.";
    dbname=".$infoDB->db."; charset=utf8",
    $infoDB->user,$infoDB->pass);
    $mdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
   die("Erreur lors de la connection à la base de donnée: ".$e->getMessage());
}

$qry1="SELECT * FROM categories WHERE id=:id";
//var_dump($qry1);
$stmt1= $mdb->prepare($qry1);
$stmt1->bindParam(":id",$id_,PDO::PARAM_INT);

$qry2="INSERT IGNORE INTO categories(id,name,parent_id) VALUES (:id,:name,:parent_id)";
//var_dump($qry2);
$stmt2= $mdb->prepare($qry2);
$stmt2->bindParam(":id",$id_,PDO::PARAM_INT);
$stmt2->bindParam(":name",$name_,PDO::PARAM_STR,100);
$stmt2->bindParam(":parent_id",$parent_id_,PDO::PARAM_INT);

$qry3="INSERT IGNORE INTO child_categories(id,child_id) VALUES (:id,:child_id)";
$stmt3= $mdb->prepare($qry3);
$stmt3->bindParam(":id",$id_,PDO::PARAM_INT);
$stmt3->bindParam(":child_id",$child_id_,PDO::PARAM_INT);


// Récupération des catégories enfants à partir de id=0.
//33705
$id_=0;
$parameters=array("category_id"=>$id_,file_type=>"json");
$category_children = $category_api->children($parameters);
$category_children=json_decode($category_children);

$categList=$category_children->categories;

foreach($categList as $categ){
   $child_id_=$categ->id;
   $stmt3->execute();
}


while (count($categList)>0){
   $current=array_pop($categList);

   $id_=$current->id;
   $name_=$current->name;
   $parent_id_=$current->parent_id;

//   $stmt1->execute();
//   $result=$stmt1->fetchAll(PDO::FETCH_OBJ);
   //var_dump($result);

//   if(count($result)==0){
//      $stmt2->execute();
//   }

    echo "</br></br>";
   //var_dump($id_);
   var_dump($name_);
   //var_dump($parent_id_);
   echo "</br></br>";

   $parameters=array("category_id"=>$id_,file_type=>"json");
   $category_children_ = $category_api->children($parameters);
   $category_children_=json_decode($category_children_);


   //if (is_array($category_children_->categories)){
   //    $categList=array_merge($categList,$category_children_->categories);
   //}
   foreach($category_children_->categories as $categ){
      $child_id_=$categ->id;
      $stmt3->execute();
      $categList[]=$categ;
   }

}



// fermeture de la connection à DB
try{
   $mdb=null;
}catch(PDOException $e){
   die("Erreur à la fermeture de la connection: ".$e->getMessage());
}


echo "</br>Fin de la mise à jour des catégories FRED</br>";
