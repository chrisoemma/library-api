<?php
/**
 * @OA\Schema(
 *     title="Favorite",
 *     description="Favorite model",
 *     @OA\Xml(
 *         name="Favorite"
 *     )
 * )
 */
class Favorite
{

    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;


      /**
     * @OA\Property(
     *      title="User ID",
     *      description="User's id",
     *      format="int64",
     *      example=5
     * )
     *
     * @var integer
     */
    public $user_id;

      /**
     * @OA\Property(
     *      title="Book ID",
     *      description="Book's id",
     *      format="int64",
     *      example=1
     * )
     *
     * @var integer
     */
    public $book_id;


    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $updated_at;
  
}