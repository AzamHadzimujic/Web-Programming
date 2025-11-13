<?php
/**
* @OA\Get(
*      path="/blogpost",
*      tags={"blogpost"},
*      summary="Get all blogposts",
*      @OA\Response(
*           response=200,
*           description="Array of all blogposts in the database"
*      )
* )
*/
Flight::route('GET /blogpost', function(){
    $service = new BlogpostService();
    $blogposts = $service->getAll();
    Flight::json($blogposts);
});

/**
* @OA\Get(
*      path="/blogpost/{id}",
*      tags={"blogpost"},
*      summary="Get blogpost by ID",
*      @OA\Parameter(
*          name="id",
*          in="path",
*          required=true,
*          @OA\Schema(type="integer")
*      ),
*      @OA\Response(
*           response=200,
*           description="Blogpost details"
*      )
* )
*/
Flight::route('GET /blogpost/@id', function($id){
    $service = new BlogpostService();
    $blogpost = $service->getById($id);
    Flight::json($blogpost);
});

/**
* @OA\Post(
*      path="/blogpost",
*      tags={"blogpost"},
*      summary="Create a new blogpost",
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(ref="#/components/schemas/Blogpost")
*      ),
*      @OA\Response(
*           response=201,
*           description="Blogpost created successfully"
*      )
* )
*/
Flight::route('POST /blogpost', function(){
    $data = Flight::request()->data->getData();
    $service = new BlogpostService();
    $newBlogpost = $service->insert($data);
    Flight::json($newBlogpost);
});

/**
* @OA\Put(
*      path="/blogpost/{id}",
*      tags={"blogpost"},
*      summary="Update an existing blogpost",
*      @OA\Parameter(
*          name="id",
*          in="path",
*          required=true,
*          @OA\Schema(type="integer")
*      ),
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(ref="#/components/schemas/Blogpost")
*      ),
*      @OA\Response(
*           response=200,
*           description="Blogpost updated successfully"
*      )
* )
*/
Flight::route('PUT /blogpost/@id', function($id){
    $data = Flight::request()->data->getData();
    $service = new BlogpostService();
    $updatedBlogpost = $service->update($id, $data);
    Flight::json($updatedBlogpost);
});

/**
* @OA\Delete(
*      path="/blogpost/{id}",
*      tags={"blogpost"},
*      summary="Delete a blogpost",
*      @OA\Parameter(
*          name="id",
*          in="path",
*          required=true,
*          @OA\Schema(type="integer")
*      ),
*      @OA\Response(
*           response=200,
*           description="Blogpost deleted successfully"
*      )
* )
*/
Flight::route('DELETE /blogpost/@id', function($id){
    $service = new BlogpostService();
    $service->delete($id);
    Flight::json(['message' => 'Blogpost deleted successfully']);
});

/**
* @OA\Get(
*      path="/blogpost/user/{user_id}",
*      tags={"blogpost"},
*      summary="Get blogposts by user ID",
*      @OA\Parameter(
*          name="user_id",
*          in="path",
*          required=true,
*          @OA\Schema(type="integer")
*      ),
*      @OA\Response(
*           response=200,
*           description="Array of blogposts for the specified user"
*      )
* )
*/
Flight::route('GET /blogpost/user/@user_id', function($user_id){
    $service = new BlogpostService();
    $blogposts = $service->getByUserId($user_id);
    Flight::json($blogposts);
});

/**
* @OA\Get(
*      path="/blogpost/search/{keyword}",
*      tags={"blogpost"},
*      summary="Search blogposts by title",
*      @OA\Parameter(
*          name="keyword",
*          in="path",
*          required=true,
*          @OA\Schema(type="string")
*      ),
*      @OA\Response(
*           response=200,
*           description="Array of blogposts matching the keyword"
*      )
* )
*/
Flight::route('GET /blogpost/search/@keyword', function($keyword){
    $service = new BlogpostService();
    $blogposts = $service->searchByTitle($keyword);
    Flight::json($blogposts);
});
?>