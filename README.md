# Basic project with NelmioApiBundle

This is just a project to show how to enable API documentation with NelmioApiBundle.

# Installation of NelmioApiBundle

```bash
composer require nelmio/api-doc-bundle twig asset
```

# Create a Model

```
./src/Model/Book.php
```

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

# Create a Controller

```
./src/Controller/BookController.php
```

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

# Create a Repository

```
./src/Repository/BookRepository.php
```

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


