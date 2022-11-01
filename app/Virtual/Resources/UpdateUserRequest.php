<?php
/**
 * @OA\Schema(
 *      title="Update User request",
 *      description="Update User request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class UpdateUserRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="name of the new User",
     *      example="John doe"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="email",
     *      description="email of the new User",
     *      example="This is new User's email"
     * )
     *
     * @var string
     */
    public $email;
    /**
     * @OA\Property(
     *      title="password",
     *      description="password of the new User",
     *      example="This is new User's password"
     * )
     *
     * @var string
     */
    public $password;
   
}