<?php
/**
 * @OA\Schema(
 *      title="Store Book request",
 *      description="Store Book request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class StoreBookRequest
{
    /**
     * @OA\Property(
     *      title="title",
     *      description="Title of the new Book",
     *      example="A nice Book"
     * )
     *
     * @var string
     */
    public $title;

   /**
     * @OA\Property(
     *      title="author",
     *      description="Author of the new Book",
     *      example="This is new Book's author"
     * )
     *
     * @var string
     */
    public $author;

}