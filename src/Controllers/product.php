<?php

use Slim\Http\Request; //namespace
use Slim\Http\Response; //namespace

//Include productsProc.php file
include __DIR__ . '/../Controllers/productProc.php';


//To read table products/shoes
$app->get('/products', function (Request $request, Response $response, array $arg){
  $data = getAllProducts($this->db);
  return $this->response->withJson(array('data' => $data), 200);
});

//Request table products by condition (id)
$app->get('/products/[{id}]', function ($request, $response, $args){
    
    $productId = $args['id'];
   if (!is_numeric($productId)) {
      return $this->response->withJson(array('error' => 'Product Id Not Found!'), 422);
   }
  $data = getProduct($this->db,$productId);
  if (empty($data)) {
    return $this->response->withJson(array('error' => 'No data found! Please search correct id'), 404);
 }
   return $this->response->withJson(array('data' => $data), 200);
});

//request table products by condition (price)
$app->get('/productsbyprice/[{price}]', function ($request, $response, $args){
    
  $shoePrice = $args['price'];
$data = getShoePrice($this->db,$shoePrice);
if (empty($data)) {
  return $this->response->withJson(array('error' => 'no data found, please search again'), 404);
}
 return $this->response->withJson(array('data' => $data), 200);
});


//Add new product/shoes
$app->post('/products/add', function ($request, $response, $args) {
  $form_data = $request->getParsedBody();
  $data = createProduct($this->db, $form_data);
  if ($data <= 0) {
    return $this->response->withJson(array('error' => 'Add data failed!'), 500);
  }
  return $this->response->withJson(array('add data' => 'Successfully added new product'), 201);
  }
);

//delete products/shoes by id
$app->delete('/products/del/[{id}]', function ($request, $response, $args){
    
  $productId = $args['id'];
 if (!is_numeric($productId)) {
    return $this->response->withJson(array('error' => 'No Data Found!'), 422);
 }
$data = deleteProduct($this->db,$productId);
if (empty($data)) {
 return $this->response->withJson(array($productId=> 'Product successfully deleted'), 202);};
});

//delete products/shoes by products price
$app->delete('/productsbyprice/del/[{price}]', function ($request, $response, $args){
    
  $productPrice = $args['price'];
 if (!is_numeric($productPrice)) {
    return $this->response->withJson(array('error' => 'No Data Found!'), 422);
 }
$data = deleteProductPrice($this->db,$productPrice);
if (empty($data)) {
 return $this->response->withJson(array($productPrice=> 'Product by price successfully deleted'), 202);};
});



//Put/Update table products by id
$app->put('/products/put/[{id}]', function ($request,  $response,  $args){
  $productId = $args['id'];
  $date = date("Y-m-j h:i:s");
  
 if (!is_numeric($productId)) {
    return $this->response->withJson(array('error' => 'Please enter numeric only!'), 422);
 }
  $form_dat=$request->getParsedBody();
  
$data=updateProduct($this->db,$form_dat,$productId,$date);

return $this->response->withJson(array('data' => $data), 200);
});

//Put/Update table products by name
$app->put('/productsbyname/put/[{name}]', function ($request,  $response,  $args){
  $productName = $args['name'];
  $date = date("Y-m-j h:i:s");
  
  $form_dat=$request->getParsedBody();
  
$data=updateProductbyName($this->db,$form_dat,$productName,$date);

return $this->response->withJson(array('data' => $data), 200);
});


