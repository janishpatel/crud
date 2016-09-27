<?php
include_once('config/db.php');
include_once('objects/product.php');

$db = new DB();
$db = $db->getConnection();
$product = new Product($db);

//get id of product to be edited
$data = json_decode(file_get_contents('php://input'));

if($product->deleteProduct($data->id)){
	echo "Product was deleted.";
}else{
	echo "Product was not deleted.";

}
?>