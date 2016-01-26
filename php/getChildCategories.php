<?

//$parent_id_=$_GET['parent_id'];


include("php/bdConnect.php");





$qry1="SELECT * FROM categories WHERE parent_id=:parent_id";
//var_dump($qry1);
$stmt1= $mdb->prepare($qry1);
$stmt1->bindParam(":parent_id",$id,PDO::PARAM_INT);
$stmt1->execute();
$results=$stmt1->fetchAll(PDO::FETCH_OBJ);

include('php/bdClose.php');



//var_dump($results);
//echo json_encode($results);
//echo json_encode(array("cat", "chat","gato"));
