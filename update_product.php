<?php
include_once('config/db.php');
include_once('objects/product.php');

$db = new DB();
$db = $db->getConnection();

//get posted data
$data = json_decode(file_get_contents('php://input'));
$id = $data->id;
$name = $data->name;
$price = $data->price;
$description = $data->description;

$product = new Product($db, $name, $price, $description, null);

if($product->updateProduct($id)){
	echo "Product was updated.";
}else{
	echo "Product was not updated.";

}
?>