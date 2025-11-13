<?php
/**
* @OA\Get(
*      path="/progresslog",
*      tags={"progresslog"},
*      summary="Get all progress logs",
*      @OA\Response(
*           response=200,
*           description="Array of all progress logs in the database"
*      )
* )
*/
Flight::route('GET /progresslog', function(){
    $service = new ProgresslogService();
    $result = $service->getAll();
    Flight::json($result);
});

/**
* @OA\Get(
*      path="/progresslog/{id}",
*      tags={"progresslog"},
*      summary="Get progress log by ID",
*      @OA\Parameter(
*          name="id",
*          in="path",
*          required=true,
*          @OA\Schema(type="integer")
*      ),
*      @OA\Response(
*           response=200,
*           description="Progress log details"
*      )
* )
*/
Flight::route('GET /progresslog/@id', function($id){
    $service = new ProgresslogService();
    $result = $service->getById($id);
    Flight::json($result);
});

/**
* @OA\Post(
*      path="/progresslog",
*      tags={"progresslog"},
*      summary="Create a new progress log",
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(ref="#/components/schemas/Progresslog")
*      ),
*      @OA\Response(
*           response=201,
*           description="Progress log created successfully"
*      )
* )
*/
Flight::route('POST /progresslog', function(){
    $data = Flight::request()->data->getData();
    $service = new ProgresslogService();
    $result = $service->insert($data);
    Flight::json($result);
});

/**
 * @OA\Put(
 *     path="/progresslog/{id}",
 *     tags={"progresslog"},
 *     summary="Update an existing progress log",
 *    @OA\Parameter(
 *        name="id",
 *        in="path",
 *        required=true,
 *       @OA\Schema(type="integer")
 *    ),
 *   @OA\RequestBody(
 *       required=true,
 *      @OA\JsonContent(ref="#/components/schemas/Progresslog")
 *    ),
 *   @OA\Response(
 *       response=200,
 *       description="Progress log updated successfully"
 *     )
 * )
 */
Flight::route('PUT /progresslog/@id', function($id){
    $data = Flight::request()->data->getData();
    $service = new ProgresslogService();
    $result = $service->update($id, $data);
    Flight::json($result);
});

/**
* @OA\Delete(
*      path="/progresslog/{id}",
*      tags={"progresslog"},
*      summary="Delete a progress log",
*      @OA\Parameter(
*          name="id",
*          in="path",
*          required=true,
*          @OA\Schema(type="integer")
*      ),
*      @OA\Response(
*           response=200,
*           description="Progress log deleted successfully"
*      )
* )
*/
Flight::route('DELETE /progresslog/@id', function($id){
    $service = new ProgresslogService();
    $result = $service->delete($id);
    Flight::json($result);
});

/**
* @OA\Get(
*      path="/progresslog/user/{user_id}",
*      tags={"progresslog"},
*      summary="Get progress logs by user ID",
*      @OA\Parameter(
*          name="user_id",
*          in="path",
*          required=true,
*          @OA\Schema(type="integer")
*      ),
*      @OA\Response(
*           response=200,
*           description="Array of progress logs for the specified user"
*      )
* )
*/
Flight::route('GET /progresslog/user/@user_id', function($user_id){
    $service = new ProgresslogService();
    $result = $service->getByUserId($user_id);
    Flight::json($result);
});

/**
* @OA\Get(
*      path="/progresslog/user/{user_id}/latest",
*      tags={"progresslog"},
*      summary="Get the latest progress log by user ID",
*      @OA\Parameter(
*          name="user_id",
*          in="path",
*          required=true,
*          @OA\Schema(type="integer")
*      ),
*      @OA\Response(
*           response=200,
*           description="Latest progress log for the specified user"
*      )
* )
*/
Flight::route('GET /progresslog/user/@user_id/latest', function($user_id){
    $service = new ProgresslogService();
    $result = $service->getLatestByUserId($user_id);
    Flight::json($result);
});