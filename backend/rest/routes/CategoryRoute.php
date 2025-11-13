<?php
/**
* @OA\Get(
*      path="/categories",
*      tags={"categories"},
*      summary="Get all categories",
*      @OA\Response(
*           response=200,
*           description="Array of all categories in the database"
*      )
* )
*/
Flight::route('GET /categories', function(){
    $service = new CategoryService();
    $categories = $service->getAll();
    Flight::json($categories);
});

/**
* @OA\Get(
*      path="/categories/{id}",
*      tags={"categories"},
*      summary="Get category by ID",
*      @OA\Parameter(
*          name="id",
*          in="path",
*          required=true,
*          @OA\Schema(type="integer")
*      ),
*      @OA\Response(
*           response=200,
*           description="Category details"
*      )
* )
*/
Flight::route('GET /categories/@id', function($id){
    $service = new CategoryService();
    $category = $service->getById($id);
    Flight::json($category);
});

/**
* @OA\Post(
*      path="/categories",
*      tags={"categories"},
*      summary="Create a new category",
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(ref="#/components/schemas/Category")
*      ),
*      @OA\Response(
*           response=201,
*           description="Category created successfully"
*      )
* )
*/
Flight::route('POST /categories', function(){
    $data = Flight::request()->data->getData();
    $service = new CategoryService();
    $newCategory = $service->insert($data);
    Flight::json($newCategory);
});

/**
* @OA\Put(
*      path="/categories/{id}",
*      tags={"categories"},
*      summary="Update an existing category",
*      @OA\Parameter(
*          name="id",
*          in="path",
*          required=true,
*          @OA\Schema(type="integer")
*      ),
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(ref="#/components/schemas/Category")
*      ),
*      @OA\Response(
*           response=200,
*           description="Category updated successfully"
*      )
* )
*/
Flight::route('PUT /categories/@id', function($id){
    $data = Flight::request()->data->getData();
    $service = new CategoryService();
    $updatedCategory = $service->update($id, $data);
    Flight::json($updatedCategory);
});

/**
* @OA\Delete(
*      path="/categories/{id}",
*      tags={"categories"},
*      summary="Delete a category",
*      @OA\Parameter(
*          name="id",
*          in="path",
*          required=true,
*          @OA\Schema(type="integer")
*      ),
*      @OA\Response(
*           response=200,
*           description="Category deleted successfully"
*      )
* )
*/
Flight::route('DELETE /categories/@id', function($id){
    $service = new CategoryService();
    $service->delete($id);
    Flight::json(['message' => 'Category deleted successfully']);
});

/**
* @OA\Get(
*      path="/categories/name/{name}",
*      tags={"categories"},
*      summary="Get category by name",
*      @OA\Parameter(
*          name="name",
*          in="path",
*          required=true,
*          @OA\Schema(type="string")
*      ),
*      @OA\Response(
*           response=200,
*           description="Category details"
*      )
* )
*/
Flight::route('GET /categories/name/@name', function($name){
    $service = new CategoryService();
    $category = $service->getByName($name);
    Flight::json($category);
});
?>