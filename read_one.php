<?php
include_once('config/db.php');
include_once('objects/product.php');

$db = new DB();
$db = $db->getConnection();
$product = new Product($db);

//get id of product to be edited
$data = json_decode(file_get_contents('php://input'));

$stmt = $product->readOne($data->id);
$num = $stmt->rowCount();

//check if more than 0 records found
if($num > 0){
	//json array to hold records
	$json = array();
	//fetch is faster than fetchAll()
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
		//this will make $row['name'] just $name
		extract($row);
		
		//append to json array with records
		$json[] = array('id'=>$id, 'name'=>$name, 'description'=>html_entity_decode($description), 'price'=>$price);
	
	//echo encoded json object
	echo json_encode($json);
}
?>