<?php
/**
* @OA\Info(
*     title="API",
*     description="Fitness Tracker API",
*     version="1.0",
*     @OA\Contact(
*         email="azam.hadzimujic@stu.ibu.edu.ba",
*         name="Azam Hadzimujic"
*     )
* )
*/
/**
* @OA\Server(
*     url= "http://localhost/Web-Programming/backend",
*     description="API server"
* )
*/
/**
* @OA\SecurityScheme(
*     securityScheme="ApiKey",
*     type="apiKey",
*     in="header",
*     name="Authentication"
* )
*/

/**
 * @OA\Schema(
 * schema="Activity",
 * title="Activity",
 * required={"activity_id", "user_id", "category_id", "name"},
 * @OA\Property(property="activity_id", type="integer", format="int64", description="Unique ID of the activity."),
 * @OA\Property(property="user_id", type="integer", format="int64", description="ID of the user who logged the activity (Foreign Key to User)."),
 * @OA\Property(property="category_id", type="integer", format="int64", description="ID of the category the activity belongs to (Foreign Key to Category)."),
 * @OA\Property(property="name", type="string", description="Name/title of the activity.", maxLength=200),
 * @OA\Property(property="duration", type="integer", format="int32", description="Duration of the activity in minutes (unsigned int, default 10)."),
 * @OA\Property(property="date", type="string", format="date-time", description="Date and time when the activity was logged (default CURRENT_TIMESTAMP).")
 * )
 */


/**
 * @OA\Schema(
 * schema="Blogpost",
 * title="Blogpost",
 * required={"post_id", "user_id", "content"},
 * @OA\Property(property="post_id", type="integer", format="int64", description="Unique ID of the blog post."),
 * @OA\Property(property="user_id", type="integer", format="int64", description="ID of the user who created the post (Foreign Key to User)."),
 * @OA\Property(property="name", type="string", nullable=true, description="Title of the blog post.", maxLength=300),
 * @OA\Property(property="content", type="string", description="Body content of the blog post.", maxLength=500),
 * @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the post was created (default CURRENT_TIMESTAMP).")
 * )
 */


/**
 * @OA\Schema(
 * schema="Category",
 * title="Category",
 * required={"category_id", "name", "description"},
 * @OA\Property(property="category_id", type="integer", format="int64", description="Unique ID of the category."),
 * @OA\Property(property="name", type="string", description="Name of the fitness category.", maxLength=250),
 * @OA\Property(property="description", type="string", description="Detailed description of the category.", maxLength=300)
 * )
 */

/**
 * @OA\Schema(
 * schema="Progresslog",
 * title="Progresslog",
 * required={"progress_id", "user_id", "weight"},
 * @OA\Property(property="progress_id", type="integer", format="int64", description="Unique ID of the progress log entry."),
 * @OA\Property(property="user_id", type="integer", format="int64", description="ID of the user this log belongs to (Foreign Key to User)."),
 * @OA\Property(property="weight", type="integer", format="int32", description="Logged weight of the user in kg/lbs (default 75)."),
 * @OA\Property(property="body_fat", type="integer", format="int32", nullable=true, description="Logged body fat percentage (default 25).")
 * )
 */


/**
 * @OA\Schema(
 * schema="User",
 * title="User",
 * required={"user_id", "name", "email", "password"},
 * @OA\Property(property="user_id", type="integer", format="int64", description="Unique ID of the user."),
 * @OA\Property(property="name", type="string", description="User's full name or nickname.", maxLength=100),
 * @OA\Property(property="email", type="string", format="email", description="User's email address (must be unique).", maxLength=250),
 * @OA\Property(property="password", type="string", description="Hashed password for the user.", maxLength=100),
 * @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the user account was created (default CURRENT_TIMESTAMP)."),
 * @OA\Property(property="role", type="integer", format="int32", description="User's role (0=standard, 1=admin).", default=0, minimum=0, maximum=1)
 * )
 */
?>
