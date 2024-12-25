<?php

namespace App\Contexts\Book\Infrastructure\Http\Controllers;

use App\Base\BaseApiController;
use App\Contexts\Book\Application\BookService;
use App\Contexts\Book\Domain\Entities\BookEntity;
use App\Contexts\Book\Infrastructure\Http\Requests\StoreBookRequest;
use App\Contexts\Book\Infrastructure\Http\Requests\UpdateBookRequest;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @OA\Tag(
 *     name="Books",
 *     description="API Endpoints for Managing Books"
 * )
 */
class BookApiApiController extends BaseApiController
{
    private BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * @OA\Get(
     *     path="/api/books",
     *     tags={"Books"},
     *     summary="List all books",
     *     description="Retrieve a list of all books in the library.",
     *     security={{"Bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of books retrieved successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Book")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Not authenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $books = $this->bookService->listBooks();
        return $this->respondWithData($books);
    }

    /**
     * @OA\Post(
     *     path="/api/books",
     *     tags={"Books"},
     *     summary="Create a new book",
     *     description="Add a new book to the library. Only users with the librarian role can perform this action.",
     *     security={{"Bearer":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","publisher","author","genre","publication_date","pages","price"},
     *             @OA\Property(property="title", type="string", example="The Great Gatsby"),
     *             @OA\Property(property="publisher", type="string", example="Scribner"),
     *             @OA\Property(property="author", type="string", example="F. Scott Fitzgerald"),
     *             @OA\Property(property="genre", type="string", example="Fiction"),
     *             @OA\Property(property="publication_date", type="string", format="date", example="1925-04-10"),
     *             @OA\Property(property="pages", type="integer", example=180),
     *             @OA\Property(property="price", type="number", format="float", example=15.99)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Book created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden, insufficient role",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Forbidden, insufficient role")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid input data")
     *         )
     *     )
     * )
     */
    public function store(StoreBookRequest $request)
    {
        $bookEntity = new BookEntity(
            $request->input('title'),
            $request->input('publisher'),
            $request->input('author'),
            $request->input('genre'),
            $request->input('publication_date'),
            $request->input('pages'),
            $request->input('price')
        );

        $createdBook = $this->bookService->createBook($bookEntity);

        return $this->respondCreated($createdBook);
    }

    /**
     * @OA\Get(
     *     path="/api/books/{id}",
     *     tags={"Books"},
     *     summary="Get a single book",
     *     description="Retrieve details of a specific book by its ID.",
     *     security={{"Bearer":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the book to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Book not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Not authenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function show(int $id)
    {
        $book = $this->bookService->getBook($id);
        if (!$book) {
            return $this->respondNotFound('Book not found');
        }
        return $this->respondWithData($book);
    }

    /**
     * @OA\Patch(
     *     path="/api/books/{id}",
     *     tags={"Books"},
     *     summary="Update a book",
     *     description="Update details of an existing book. Only users with the librarian role can perform this action.",
     *     security={{"Bearer":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the book to update",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="The Great Gatsby (Updated)"),
     *             @OA\Property(property="publisher", type="string", example="Scribner"),
     *             @OA\Property(property="author", type="string", example="F. Scott Fitzgerald"),
     *             @OA\Property(property="genre", type="string", example="Classic Fiction"),
     *             @OA\Property(property="publication_date", type="string", format="date", example="1925-04-10"),
     *             @OA\Property(property="pages", type="integer", example=200),
     *             @OA\Property(property="price", type="number", format="float", example=18.99)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden, insufficient role",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Forbidden, insufficient role")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Book not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid input data")
     *         )
     *     )
     * )
     */
    public function update(UpdateBookRequest $request, int $id)
    {
        $existing = $this->bookService->getBook($id);
        if (!$existing) {
            return $this->respondNotFound('Book not found');
        }

        $updatedEntity = new BookEntity(
            $request->input('title', $existing->getTitle()),
            $request->input('publisher', $existing->getPublisher()),
            $request->input('author', $existing->getAuthor()),
            $request->input('genre', $existing->getGenre()),
            $request->input('publication_date', $existing->getPublicationDate()),
            $request->input('pages', $existing->getPages()),
            $request->input('price', $existing->getPrice())
        );

        $updatedBook = $this->bookService->updateBook($id, $updatedEntity);
        if (!$updatedBook) {
            return $this->respondNotFound('Book not found');
        }

        return $this->respondWithData($updatedBook);
    }

    /**
     * @OA\Delete(
     *     path="/api/books/{id}",
     *     tags={"Books"},
     *     summary="Delete a book",
     *     description="Remove a book from the library. Only users with the librarian role can perform this action.",
     *     security={{"Bearer":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the book to delete",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Book deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden, insufficient role",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Forbidden, insufficient role")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Book not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Not authenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function destroy(int $id)
    {
        $deleted = $this->bookService->deleteBook($id);
        if (!$deleted) {
            return $this->respondNotFound('Book not found');
        }
        return $this->respondWithData(null, ResponseAlias::HTTP_NO_CONTENT);
    }
}
