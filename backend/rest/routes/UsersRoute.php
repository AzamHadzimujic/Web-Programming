<?php
/**
* @OA\Get(
*      path="/users",
*      tags={"users"},
*      summary="Get all users",
*      @OA\Response(
*           response=200,
*           description="Array of all users in the database"
*      )
* )
*/
Flight::route('GET /users', function(){
    $service = new UsersService();
    $result = $service->getAll();
    Flight::json($result);
});

/**
* @OA\Get(
*      path="/users/{id}",
*      tags={"users"},
*      summary="Get user by ID",
*      @OA\Parameter(
*          name="id",
*          in="path",
*          required=true,
*          @OA\Schema(type="integer")
*      ),
*      @OA\Response(
*           response=200,
*           description="User details"
*      )
* )
*/
Flight::route('GET /users/@id', function($id){
    $service = new UsersService();
    $result = $service->getById($id);
    Flight::json($result);
});

/**
* @OA\Post(
*      path="/users",
*      tags={"users"},
*      summary="Create a new user",
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(ref="#/components/schemas/User")
*      ),
*      @OA\Response(
*           response=201,
*           description="User created successfully"
*      )
* )
*/
Flight::route('POST /users', function(){
    $data = Flight::request()->data->getData();
    $service = new UsersService();
    $result = $service->insert($data);
    Flight::json($result);
});

/**
* @OA\Put(
*     path="/users/{id}",
*     tags={"users"},
*     summary="Update an existing user",
*    @OA\Parameter(
*        name="id",
*        in="path",
*        required=true,
*       @OA\Schema(type="integer")
*    ),
*   @OA\RequestBody(
*       required=true,
*      @OA\JsonContent(ref="#/components/schemas/User")
*    ),
*   @OA\Response(
*       response=200,
*       description="User updated successfully"
*     )
* )
*/
Flight::route('PUT /users/@id', function($id){
    $data = Flight::request()->data->getData();
    $service = new UsersService();
    $result = $service->update($id, $data);
    Flight::json($result);
});

/**
* @OA\Delete(
*      path="/users/{id}",
*      tags={"users"},
*      summary="Delete a user",
*      @OA\Parameter(
*          name="id",
*          in="path",
*          required=true,
*          @OA\Schema(type="integer")
*      ),
*      @OA\Response(
*           response=200,
*           description="User deleted successfully"
*      )
* )
*/
Flight::route('DELETE /users/@id', function($id){
    $service = new UsersService();
    $result = $service->delete($id);
    Flight::json($result);
});

/**
* @OA\Get(
*      path="/users/email/{email}",
*      tags={"users"},
*      summary="Get user by email",
*      @OA\Parameter(
*          name="email",
*          in="path",
*          required=true,
*          @OA\Schema(type="string")
*      ),
*      @OA\Response(
*           response=200,
*           description="User details"
*      )
* )
*/
Flight::route('GET /users/email/@email', function($email){
    $service = new UsersService();
    $result = $service->getByEmail($email);
    Flight::json($result);
});

/**
* @OA\Get(
*      path="/users/username/{username}",
*      tags={"users"},
*      summary="Get user by username",
*      @OA\Parameter(
*          name="username",
*          in="path",
*          required=true,
*          @OA\Schema(type="string")
*      ),
*      @OA\Response(
*           response=200,
*           description="User details"
*      )
* )
*/
Flight::route('GET /users/username/@username', function($username){
    $service = new UsersService();
    $result = $service->getByUsername($username);
    Flight::json($result);
});
?>