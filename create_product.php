<?php
//get db connection
include_once('config/db.php');
$conn = new DB();
$db = $conn->getConnection();

//create product object
include_once('objects/product.php');


//get posted data
$data = json_decode(file_get_contents('php://input'));

//set product property values
$name = $data->name;
$price = $data->price;
$description = $data->description;
$created = date('Y-m-d H:i:s');

//create the product
$product = new Product($db, $name, $price, $description, $created);
if($product->create()){
	echo "Product was created.";
}else{
	echo "There was an error creating the product.";
}
?>