<?php
/**
* @OA\Get(
*      path="/activities",
*      tags={"activities"},
*      summary="Get all activities",
*      @OA\Response(
*           response=200,
*           description="Array of all activities in the database"
*      )
* )
*/
Flight::route('GET /activities', function(){
    $service = new ActivitiesService();
    $activities = $service->getAll();
    Flight::json($activities);
});

/**
* @OA\Get(
*      path="/activities/{id}",
*      tags={"activities"},
*      summary="Get activity by ID",
*      @OA\Parameter(
*          name="id",
*          in="path",
*          required=true,
*          @OA\Schema(type="integer")
*      ),
*      @OA\Response(
*           response=200,
*           description="Activity details"
*      )
* )
*/
Flight::route('GET /activities/@id', function($id){
    $service = new ActivitiesService();
    $activity = $service->getById($id);
    Flight::json($activity);
});

/**
* @OA\Post(
*      path="/activities",
*      tags={"activities"},
*      summary="Create a new activity",
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(ref="#/components/schemas/Activity")
*      ),
*      @OA\Response(
*           response=201,
*           description="Activity created successfully"
*      )
* )
*/
Flight::route('POST /activities', function(){
    $data = Flight::request()->data->getData();
    $service = new ActivitiesService();
    $newActivity = $service->insert($data); 
    Flight::json($newActivity);
});

/**
* @OA\Put(
*      path="/activities/{id}",
*      tags={"activities"},
*      summary="Update an existing activity",
*      @OA\Parameter(
*          name="id",
*          in="path",
*          required=true,
*          @OA\Schema(type="integer")
*      ),
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(ref="#/components/schemas/Activity")
*      ),
*      @OA\Response(
*           response=200,
*           description="Activity updated successfully"
*      )
* )
*/
Flight::route('PUT /activities/@id', function($id){
    $data = Flight::request()->data->getData();
    $service = new ActivitiesService();
    $updatedActivity = $service->update($id, $data);
    Flight::json($updatedActivity);
});

/**
* @OA\Delete(
*      path="/activities/{id}",
*      tags={"activities"},
*      summary="Delete an activity",
*      @OA\Parameter(
*          name="id",
*          in="path",
*          required=true,
*          @OA\Schema(type="integer")
*      ),
*      @OA\Response(
*           response=200,
*           description="Activity deleted successfully"
*      )
* )
*/
Flight::route('DELETE /activities/@id', function($id){
    $service = new ActivitiesService();
    $service->delete($id);
    Flight::json(['message' => "Activity with id $id deleted"]);
});

/**
* @OA\Get(
*      path="/activities/user/{user_id}",
*      tags={"activities"},
*      summary="Get activities by user ID",
*      @OA\Parameter(
*          name="user_id",
*          in="path",
*          required=true,
*          @OA\Schema(type="integer")
*      ),
*      @OA\Response(
*           response=200,
*           description="Array of activities for the specified user"
*      )
* )
*/
Flight::route('GET /activities/user/@user_id', function($user_id){
    $service = new ActivitiesService();
    $activities = $service->getByUserId($user_id);
    Flight::json($activities);
});

/**
* @OA\Get(
*      path="/activities/category/{category_id}",
*      tags={"activities"},
*      summary="Get activities by category ID",
*      @OA\Parameter(
*          name="category_id",
*          in="path",
*          required=true,
*          @OA\Schema(type="integer")
*      ),
*      @OA\Response(
*           response=200,
*           description="Array of activities for the specified category"
*      )
* )
*/
Flight::route('GET /activities/category/@category_id', function($category_id){
    $service = new ActivitiesService();
    $activities = $service->getByCategoryId($category_id);
    Flight::json($activities);
});
?>