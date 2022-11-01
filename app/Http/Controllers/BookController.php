<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


/**
 * @OA\SecurityScheme(
 *     securityScheme="bearer",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 * )
 */

 /**
 * @OA\Parameter(
 *   parameter="get_books_request_parameter_limit",
 *   name="limit",
 *   description="Limit the number of results",
 *   in="query",
 *   @OA\Schema(
 *     type="number", default=100
 *   )
 * ),
 */

class BookController extends Controller
{
      /**
     * @OA\Get(
     *      path="/books",
     *      operationId="getBooksList",
     *      tags={"Books"},
     *      security={ {"bearer": {} }},
     *      summary="Get list of books",
     *      description="Returns list of all books",
     *     @OA\Parameter(ref="#/components/parameters/get_books_request_parameter_limit"),
     *         @OA\Property(
     *          property="pagination",
    *          ref="#/components/schemas/pagination"
    *        ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful",
     *          @OA\JsonContent(ref="#/components/schemas/BookResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * 
     *     )
     */

    public function index()
    {
        try {

            $books = Book::paginate(100);

            $data = [
                'books' => $books,
            ];

            return $this->returnJsonResponse(true, 'Success', $data);

        } catch (\Exception$exception) {
            Log::error($exception->getMessage());
            return $this->returnJsonResponse(false, $exception->getMessage(), []);
        }
    }


    /**
     * @OA\Post(
     *      path="/books",
     *      operationId="storeBook",
     *      tags={"Books"},
     *      security={ {"bearer": {} }},
     *      summary="Store new Book",
     *      description="Returns book data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreBookRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful",
     *          @OA\JsonContent(ref="#/components/schemas/Book")
     *       ),
     *  
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    public function store(Request $request)
    {
        //

    
        try {

            $validator = Validator::make($request->all(), [
                "title" => "required",
                "author" => 'required',
            ]);

            if ($validator->fails()) {
                return $this->returnJsonResponse(false, 'Validation failed.', ["errors" => $validator->errors()->toJson()]);
            }

            $book = Book::create($request->all());
            if ($book) {
                return $this->returnJsonResponse(true, 'Success', $book);
            } else {
                return $this->returnJsonResponse(false, "Something went wrong", []);
            }
        } catch (\Exception$exception) {
            Log::error($exception->getMessage());
            return $this->returnJsonResponse(false, $exception->getMessage(), []);
        }
    }

        /**
     * @OA\Get(
     *      path="/books/{id}",
     *      operationId="getBookById",
     *      tags={"Books"},
     *       security={ {"bearer": {} }},
     *      summary="Get book information",
     *      description="Returns book data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Book id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Book")
     *       ),
     *  
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    public function show($id)
    {
        try {

            $book = Book::findOrFail($id);

            $data = [
                'book' => $book,
            ];

            return $this->returnJsonResponse(true, 'Success', $data);

        } catch (\Exception$exception) {
            Log::error($exception->getMessage());
            return $this->returnJsonResponse(false, $exception->getMessage(), []);
        }
    }

        /**
     * @OA\Put(
     *      path="/books/{id}",
     *      operationId="updateBook",
     *      tags={"Books"},
     *      security={ {"bearer": {} }},
     *      summary="Update existing book",
     *      description="Returns updated book data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Book id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateBookRequest")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful",
     *          @OA\JsonContent(ref="#/components/schemas/Book")
     *       ),
     *   
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

    public function update(Request $request, $id)
    {
        try {
            $book = Book::findOrFail($id);

            if ($book) {
                $book->update($request->all());
                return $this->returnJsonResponse(true, 'Success', $book);
            } else {
                return $this->returnJsonResponse(false, "Something went wrong", []);
            }

        } catch (\Exception$exception) {
            Log::error($exception->getMessage());
            return $this->returnJsonResponse(false, $exception->getMessage(), []);
        }
    }

        /**
     * @OA\Delete(
     *      path="/books/{id}",
     *      operationId="deleteBook",
     *      tags={"Books"},
     *      security={ {"bearer": {} }},
     *      summary="Delete existing book",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="book id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

    public function destroy($id)
    {
        try {

            $book = Book::findOrFail($id);

            $book->delete();
            $data = [];

            return $this->returnJsonResponse(true, 'Success', $data);

        } catch (\Exception$exception) {
            Log::error($exception->getMessage());
            return $this->returnJsonResponse(false, $exception->getMessage(), []);
        }
    }



    
    /**
     * @OA\Post(
     *      path="/books/favorite/{id}",
     *      operationId="addBookToFavorite",
     *      tags={"Books"},
     *      security={ {"bearer": {} }},
     *      summary="Add book to favorite",
     *      description="Returns  added favorite book data",
     *      @OA\Response(
     *          response=201,
     *          description="Successful",
     *          @OA\JsonContent(ref="#/components/schemas/Favorite")
     *       ),
     *  
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function add_to_favorite($id)
    {

        try {

            $book = Book::findOrFail($id);

            $user = Auth::user();
            $data = [
                'book_id' => $book->id,
                'user_id' => $user->id,
            ];
            $existing_favorite = Favorite::where('book_id', $book->id)
                ->where('user_id', Auth::user()->id)->first();
            if (is_null($existing_favorite)) {
                $favorite = Favorite::create($data);
            } else {
                $favorite = $existing_favorite;
            }

            return $this->returnJsonResponse(true, 'Success', $favorite);

        } catch (\Exception$exception) {
            Log::error($exception->getMessage());
            return $this->returnJsonResponse(false, $exception->getMessage(), []);
        }
    }

       /**
     * @OA\Delete(
     *      path="/books/favorite/{id}",
     *      operationId="deleteBookFromFavorite",
     *      tags={"Books"},
     *      security={ {"bearer": {} }},
     *      summary="Delete existing book from favorites",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="book id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function remove_from_favorite($id)
    {

        try {

            $book = Book::findOrFail($id);
            $favorite = Favorite::where('book_id', $book->id)
                ->where('user_id', Auth::user()->id)->first();

            $favorite->delete();
            return $this->returnJsonResponse(true, 'Success', []);

        } catch (\Exception$exception) {
            Log::error($exception->getMessage());
            return $this->returnJsonResponse(false, $exception->getMessage(), []);
        }

    }


        /**
     * @OA\Post(
     *      path="/books/likes/{id}",
     *      operationId="addLikeToBook",
     *      tags={"Books"},
     *      security={ {"bearer": {} }},
     *      summary="Add like to book",
     *      description="Returns  added like to book data",
     *      @OA\Response(
     *          response=201,
     *          description="Successful",
     *          @OA\JsonContent(ref="#/components/schemas/Like")
     *       ),
     *  
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    public function like($id)
    {

        try {

            $book = Book::findOrFail($id);

            $user = Auth::user();
            $data = [
                'book_id' => $book->id,
                'user_id' => $user->id,
            ];
            $existing_like = Like::where('book_id', $book->id)
                ->where('user_id', Auth::user()->id)->first();
            if (is_null($existing_like)) {
                $like = Like::create($data);
            } else {
                $like = $existing_like;
            }

            return $this->returnJsonResponse(true, 'Success', $like);

        } catch (\Exception$exception) {
            Log::error($exception->getMessage());
            return $this->returnJsonResponse(false, $exception->getMessage(), []);
        }
    }


           /**
     * @OA\Delete(
     *      path="/books/likes/{id}",
     *      operationId="RemovoveLikeFromBook",
     *      tags={"Books"},
     *      security={ {"bearer": {} }},
     *      summary="remove existing like from book",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="book id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function unlike($id)
    {

        try {

            $book = Book::findOrFail($id);
            $favorite = Like::where('book_id', $book->id)
                ->where('user_id', Auth::user()->id)->first();

            $favorite->delete();
            return $this->returnJsonResponse(true, 'Success', []);

        } catch (\Exception$exception) {
            Log::error($exception->getMessage());
            return $this->returnJsonResponse(false, $exception->getMessage(), []);
        }

    }



          /**
     * @OA\Post(
     *      path="/books/comments/{id}",
     *      operationId="addCommenToBook",
     *      tags={"Books"},
     *      security={ {"bearer": {} }},
     *      summary="Add comment to a specific book",
     *      description="Returns  added comment to book",
     *     @OA\Parameter(
     *          name="id",
     *          description="book id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreCommentRequest")
     *      ),
     * 
     *      @OA\Response(
     *          response=201,
     *          description="Successful",
     *          @OA\JsonContent(ref="#/components/schemas/Book")
     *       ),
     *  
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    public function add_comment(Request $request, $id)
    {
        try {

            $book = Book::findOrFail($id);

            $user = Auth::user();

            $validator = Validator::make($request->all(), [
                "body" => "required",
            ]);

            if ($validator->fails()) {
                return $this->returnJsonResponse(false, 'Validation failed.', ["errors" => $validator->errors()->toJson()]);
            }
            $data = [
                'book_id' => $book->id,
                'user_id' => $user->id,
                'body'=>$request->body
            ];
           
                $comment = Comment::create($data);
          

            return $this->returnJsonResponse(true, 'Success', $comment);

        } catch (\Exception$exception) {
            Log::error($exception->getMessage());
            return $this->returnJsonResponse(false, $exception->getMessage(), []);
        }
    }


            /**
     * @OA\Get(
     *      path="/books/comments/{id}/view",
     *      operationId="getCommentsById",
     *      tags={"Books"},
     *       security={ {"bearer": {} }},
     *      summary="Get comments of a specific book",
     *      description="Returns comments data of specic book",
     *      @OA\Parameter(
     *          name="id",
     *          description="Book id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Book")
     *       ),
     *  
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */

    public function view_comments($id)
    {
        try {

            $book = Book::findOrFail($id);

           $comments= $book->comments;

           
            $data = [
                'comments' => $comments,
            ];

            return $this->returnJsonResponse(true, 'Success', $data);

        } catch (\Exception$exception) {
            Log::error($exception->getMessage());
            return $this->returnJsonResponse(false, $exception->getMessage(), []);
        }
    }

         /**
     * @OA\Get(
     *      path="/popular",
     *      operationId="getPopularBooksList",
     *      tags={"Books"},
     *       security={ {"bearer": {} }},
     *      summary="Get popular books list",
     *      description="Returns  popular list of all books",
     *      @OA\Response(
     *          response=200,
     *          description="Successful",
     *          @OA\JsonContent(ref="#/components/schemas/Book")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */

    public function popular(){
        
        try {

            $books = Book::has('likes', '>=' , 1)->withCount('likes')->orderBy('likes_count','DESC')->get();

            $data = [
                'books' => $books,
            ];

            return $this->returnJsonResponse(true, 'Success', $data);

        } catch (\Exception$exception) {
            Log::error($exception->getMessage());
            return $this->returnJsonResponse(false, $exception->getMessage(), []);
        } 
    }


}
