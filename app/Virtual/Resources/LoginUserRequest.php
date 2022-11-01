<?php
/**
 * @OA\Schema(
 *      title="Store User request",
 *      description="Store User request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class LoginUserRequest
{

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