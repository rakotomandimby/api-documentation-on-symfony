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

    // Getters are not strictly necessary for NelmioApiDocBundle if properties are public,
    // but they are good practice in general.
    // NelmioApiDocBundle primarily uses reflection on properties for models.

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

