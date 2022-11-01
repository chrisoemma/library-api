<?php
/**
 * @OA\Schema(
 *      title="Store User request",
 *      description="Store User request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class StoreUserRequest
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