<?php
class Product{
	private $conn;
	private $table_name;

	//obj properties
	private $id;
	private $name;
	private $description;
	private $price;
	private $created;

	//contruct method taking $db object
	public function __construct($db, $name = null, $price = null, $description = null, $created = null){
		$this->conn = $db;
		$this->name = strip_tags($name);
		$this->description = strip_tags($description);
		$this->price = strip_tags($price);
		$this->created = $created;
	}

	public function create(){
		$sql = "insert into products set name=:name, price=:price, description=:description, created=:created";

		//prepare query
		$stmt = $this->conn->prepare($sql);
		$values = array(":name"=>$this->name, ":price"=>$this->price, ":description"=>$this->description, ":created"=>$this->created);

		if($stmt->execute($values)){
			return true;
		}else{
			echo "<pre>";
            print_r($stmt->errorInfo());
			echo "</pre>";
			return false;
		}
	}

	public function readAll(){
		$sql = 'select id, name, description, price from products order by id desc';
		$stmt = $this->conn->query($sql);
		return $stmt;
	}

	public function readOne($id){
		$sql = 'select id, name, description, price from products where id = :id';
		$stmt = $this->conn->prepare($sql);
		$values = array(':id'=>$id);
		$stmt->execute($values);
		return $stmt;
	}

	public function updateProduct($id){
		$sql = 'update products set name=:name, description=:description, price=:price where id = :id';
		$stmt = $this->conn->prepare($sql);
		$values = array(":name"=>$this->name, ":price"=>$this->price, ":description"=>$this->description, ":id"=>$id);
		if($stmt->execute($values)){
			return true;
		}else{
			return false;
		}
	}

	public function deleteProduct($id){
		$sql = 'delete from products where id=:id';
		$stmt = $this->conn->prepare($sql);
		$values = array(':id'=>$id);
		if($stmt->execute($values)){
			return true;
		}else{
			return false;
		}
	}
}
?>