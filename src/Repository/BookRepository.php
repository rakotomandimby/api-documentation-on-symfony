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

