<!DOCTYPE html>
<html>
<head>
 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      
    <title>Read Products</title>
     
    <!-- include material design CSS -->
    <link rel="stylesheet" href="libs/css/materialize.min.css" />
     
    <!-- include material design icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
     
	 <!-- custom CSS -->
	<style>
		.width-30-pct{
			width:30%;
		}
		 
		.text-align-center{
			text-align:center;
		}
		 
		.margin-bottom-1em{
			margin-bottom:1em;
		}
	</style>
</head>
<body>
 
<div class="container" ng-app="myApp" ng-controller="productsCtrl">
	<div class="row">
		<div class="col s12">
			<h4>Products</h4>
			<!-- used for searching the current list -->
			<input type="text" ng-model="search" class="form-control" placeholder="Search product..." />
			 
			<!-- table that shows product record list -->
			<table class="hoverable bordered">
			 
				<thead>
					<tr>
						<th class="text-align-center">ID</th>
						<th class="width-30-pct">Name</th>
						<th class="width-30-pct">Description</th>
						<th class="text-align-center">Price</th>
						<th class="text-align-center">Action</th>
					</tr>
				</thead>
			 
				<tbody ng-init="getAll()">
					<tr ng-repeat="d in names | filter:search">
						<td class="text-align-center">{{ d.id }}</td>
						<td>{{ d.name }}</td>
						<td>{{ d.description }}</td>
						<td class="text-align-center">{{ d.price }}</td>
						<td>
							<a ng-click="readOne(d.id)" class="waves-effect waves-light btn margin-bottom-1em"><i class="material-icons left">edit</i>Edit</a>
							<a ng-click="deleteProduct(d.id)" class="waves-effect waves-light btn margin-bottom-1em"><i class="material-icons left">delete</i>Delete</a>
						</td>
					</tr>
				</tbody>
			</table>
			<!-- modal for for creating new product -->
			<div id="modal-product-form" class="modal">
				<div class="modal-content">
					<h4 id="modal-product-title">Create New Product</h4>
					<form ng-submit="processForm()">
					<input type="hidden" ng-model="product.id">
					<div class="row">
						<div class="input-field col s12">
							<input ng-model="product.name" type="text" class="validate" id="form-name" placeholder="Type name here..."/>
							<label for="name">Name</label>
						</div>
			 
						<div class="input-field col s12">
							<textarea ng-model="product.description" type="text" class="validate materialize-textarea" placeholder="Type description here..."></textarea>
							<label for="description">Description</label>
						</div>
			 
			 
						<div class="input-field col s12">
							<input ng-model="product.price" type="text" class="validate" id="form-price" placeholder="Type price here..." />
							<label for="price">Price</label>
						</div>
			 
			 
						<div class="input-field col s12">
							<!--<a id="btn-create-product" class="waves-effect waves-light btn margin-bottom-1em" ng-click="createProduct()"><i class="material-icons left">add</i>Create</a>-->
							<button type="submit" id="btn-create-product" class="waves-effect waves-light btn margin-bottom-1em"><i class="material-icons left">add</i>Create</button>
			 
							<button type="submit" id="btn-update-product" class="waves-effect waves-light btn margin-bottom-1em"><i class="material-icons left">edit</i>Save Changes</button>
			 
							<button class="modal-action modal-close waves-effect waves-light btn margin-bottom-1em" ng-click="closeForm()"><i class="material-icons left" >close</i>Close</button>
						</div>
					</div>
					</form>
				</div>
			</div><!--/modal-->
			<!-- floating button for creating product -->
			<div class="fixed-action-btn" style="bottom:45px; right:24px;">
				<a class="waves-effect waves-light btn modal-trigger btn-floating btn-large red" href="#modal-product-form" ng-click="showCreateForm()"><i class="large material-icons">add</i></a>
			</div>
		</div><!--/col s12-->
	</div><!--/row-->
</div><!--/container-->
 
<!-- include jquery -->
<script type="text/javascript" src="libs/js/jquery.min.js"></script>
 
<!-- material design js -->
<script src="libs/js/materialize.min.js"></script>
 
<!-- include angular js -->
<script src="libs/js/angular.min.js"></script>
 
<script>
// angular js codes will be here
 var app = angular.module('myApp', []);
 app.controller('productsCtrl', function($scope, $http){
	 //app vars
	 $scope.product = {};

	$scope.showCreateForm = function(){
		//clear form
		$scope.clearForm();

		//change modal title
		$('#modal-product-title').text("Create New Product");

		//hide update button
		$('#btn-update-product').hide();

		//show create product button
		$('#btn-create-product').show();
		//$('.modal').show();
	}

	$scope.clearForm = function(){
		$scope.product.id = '';
		$scope.product.name = '';
		$scope.product.description = '';
		$scope.product.price = '';
	}

	$scope.closeForm = function(){
		$('#modal-product-form').hide();
	}

	$scope.processForm = function(){
		//add product
		$('#btn-create-product').click(function(){
			//fields in key-value pairs
			 $http({
			  method  : 'POST',
			  url     : 'create_product.php',
			  data    : $scope.product, //forms product object
			  headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
			 })
			 .then(function(response, status, headers, config){
				 console.log(response.data);
				 //tell the user new product was created
				 Materialize.toast(response.data, 4000);

				 //clear form
				 $scope.clearForm();

				 //close form
				 $scope.closeForm();

				 //refresh the list
				 $scope.getAll();
			 });
		});

		//update product
		$('#btn-update-product').click(function(){
				$http({
				  method  : 'POST',
				  url     : 'update_product.php',
				  data    : $scope.product, //forms product object
				  headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
				 })
				 .then(function(response, status, headers, config){
					 console.log(response.data);
					 //tell the user new product was created
					 Materialize.toast(response.data, 4000);

					 //clear form
					 $scope.clearForm();

					 //close form
					 $scope.closeForm();

					 //refresh the list
					 $scope.getAll();
				 });
		});

	} //end process form code

	//read products 
	$scope.getAll = function(){
		$http.get('read_products.php').then(function(response){
			$scope.names = response.data;
			
		});
	}

	//single product
	$scope.readOne = function(id){
		//change modal title
		$('#modal-product-title').text("Edit Product");

		//show update product button
		$('#btn-update-product').show();

		//hide create button
		$('#btn-create-product').hide();

		//post id of product to be edited
		$http.post('read_one.php', {
			'id': id
		})
		.then(function(response, status, header, config){
				//put the values in form
				$scope.product.id = response.data[0]['id'];
				$scope.product.name = response.data[0]['name'];
				$scope.product.description = response.data[0]['description'];
				$scope.product.price = response.data[0]['price'];

				//show modal
				$('#modal-product-form').openModal();
			}, function(response, status, header, config){
				//error
				Materialize.toast('Unable to retrieve record', 4000);
			});
	}

	//delete product
	$scope.deleteProduct = function(id){
		if(confirm('Are you sure?')){

			//post id of product to be deleted
			$http.post('delete_product.php', {
				'id': id
			})
			.then(function(response, status, header, config){
					Materialize.toast('Product record deleted', 4000);

					//refresh the list
					 $scope.getAll();
				});
		}
	}

	
 });
// jquery codes will be here

$(document).ready(function(){
    // initialize modal
    $('.modal-trigger').leanModal();
	//$('.modal').show();
});
</script>
 
</body>
</html>