# Basic project with NelmioApiBundle

This is just a project to show how to enable API documentation with NelmioApiBundle.

## Installation of NelmioApiBundle

```bash
composer require nelmio/api-doc-bundle twig asset
```

## Simple project, that has no API documentation enabled

File  `./src/Model/Book.php` :

```php
<?php
namespace App\Model;

class Book
{
    private string $title;
    private string $author;
    private string $isbn;

    public function __construct(string $title, string $author, string $isbn)
    {
        $this->title = $title;
        $this->author = $author;
        $this->isbn = $isbn;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }
}
```


File `./src/Controller/BookController.php` :

```php
<?php
namespace App\Controller;

// use: AbstractController, Response
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use a Book repository
use App\Repository\BookRepository;


class BookController extends AbstractController
{
    #[Route('/api/books', name: 'api_books')]
    public function index(BookRepository $bookRepository): Response
    {
        // Get the books from a repository
        $books = $bookRepository->findAll();
        return $this->json($books);
    }
}
```


File `./src/Repository/BookRepository.php` :

```php
<?php

namespace App\Repository;
use App\Model\Book;

class BookRepository
{
    private array $books = [];

    public function __construct()
    {
        $this->books[] = new Book('The Hitchhiker\'s Guide to the Galaxy', 'Douglas Adams', '978-0345391803');
        $this->books[] = new Book('1984', 'George Orwell', '978-0451524935');
        $this->books[] = new Book('To Kill a Mockingbird', 'Harper Lee', '978-0061120084');
        $this->books[] = new Book('The Great Gatsby', 'F. Scott Fitzgerald', '978-0743273565');
        $this->books[] = new Book('Upon the Road', 'Jack Kerouac', '978-0140042592');
        $this->books[] = new Book('Brave New World', 'Aldous Huxley', '978-0060850524');
        $this->books[] = new Book('Fahrenheit 451', 'Ray Bradbury', '978-1451673319');
        $this->books[] = new Book('The Catcher in the Rye', 'J.D. Salinger', '978-0316769488');
    }

    public function findAll(): array
    {
        return $this->books;
    }
}
```

## Now, we enable the API documentation

File `./config/routes/nelmio_api_doc.yaml` (full file):

```yaml
app.swagger:
    path: /api/doc.json
    methods: GET
    defaults: { _controller: nelmio_api_doc.controller.swagger }

app.swagger_ui:
    path: /api/doc
    methods: GET
    defaults: { _controller: nelmio_api_doc.controller.swagger_ui }
```

File `./src/Model/Book.php` (add the annotations):

```php
<?php
namespace App\Model;

use OpenApi\Attributes as OA; // <-- Import OpenAPI attributes

class Book
{
    #[OA\Property(description: 'The title of the book', type: 'string', example: 'The Hitchhiker\'s Guide to the Galaxy')]
    public string $title;

    #[OA\Property(description: 'The author of the book', type: 'string', example: 'Douglas Adams')]
    public string $author;

    #[OA\Property(description: 'The International Standard Book Number', type: 'string', example: '978-0345391803')]
    public string $isbn;

    public function __construct(string $title, string $author, string $isbn)
    {
        $this->title = $title;
        $this->author = $author;
        $this->isbn = $isbn;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }
}
```

File `./src/Controller/BookController.php` (add the annotations):

```php
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
```


