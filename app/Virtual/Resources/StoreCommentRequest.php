<?php
/**
 * @OA\Schema(
 *      title="Store User request",
 *      description="Store User request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class StoreCommentRequest
{
      /**
     * @OA\Property(
     *      title="body",
     *      description="comment body",
     *      example="The comment body"
     * )
     *
     * @var string
     */
    public $body;
   
}