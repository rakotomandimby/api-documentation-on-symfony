<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BookRepository;
use App\Model\Book; // <-- Import the Book model
use OpenApi\Attributes as OA; // <-- Import OpenAPI attributes
use Nelmio\ApiDocBundle\Attribute\Model; // <-- Import Model attribute for OpenAPI documentation

class BookController extends AbstractController
{
    /**
     * List all books.
     * Retrieves a collection of all available books.
     */
    #[Route('/api/books', name: 'api_books', methods: ['GET'])] // <-- Specify HTTP method explicitly
    #[OA\Response(
        response: 200,
        description: 'Returns the list of books',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Book::class)) // <-- Reference the Book model
        )
    )]
    #[OA\Tag(name: 'Books')] // <-- Group endpoints under a "Books" tag in Swagger UI
    public function index(BookRepository $bookRepository): Response
    {
        // Get the books from a repository
        $books = $bookRepository->findAll();
        return $this->json($books);
    }
}

