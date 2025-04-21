<?php
// test/backend-tests/BooksTest.php
use PHPUnit\Framework\TestCase;

class BooksTest extends TestCase
{
    private $conn;

    // Remove the return type ": void" for compatibility with older PHP versions
    protected function setUp()
    {
        // Create an in-memory SQLite database for testing
        $this->conn = new PDO('sqlite::memory:');
        $this->conn->exec("CREATE TABLE books (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            author TEXT NOT NULL,
            isbn TEXT NOT NULL,
            location TEXT,
            quantity INTEGER DEFAULT 0,
            total_pages INTEGER DEFAULT 0,
            publication_date TEXT
        )");
    }

    public function testAddBook()
    {
        // Simulate adding a book
        $stmt = $this->conn->prepare("INSERT INTO books (title, author, isbn, location, quantity, total_pages, publication_date) 
                                      VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute(['Test Book', 'Test Author', '1234567890', 'Shelf A1', 5, 300, '2023-01-01']);

        $result = $this->conn->query("SELECT * FROM books")->fetchAll(PDO::FETCH_ASSOC);
        $this->assertCount(1, $result);
        $this->assertEquals('Test Book', $result[0]['title']);
    }

    public function testDeleteBook()
    {
        // Add a book first
        $this->conn->exec("INSERT INTO books (title, author, isbn) VALUES ('Test Book', 'Test Author', '1234567890')");

        // Delete the book
        $stmt = $this->conn->prepare("DELETE FROM books WHERE id = ?");
        $stmt->execute([1]);

        $result = $this->conn->query("SELECT * FROM books")->fetchAll(PDO::FETCH_ASSOC);
        $this->assertCount(0, $result);
    }

    public function testUpdateBook()
    {
        // Add a book first
        $this->conn->exec("INSERT INTO books (title, author, isbn) VALUES ('Test Book', 'Test Author', '1234567890')");

        // Update the book
        $stmt = $this->conn->prepare("UPDATE books SET title = ?, author = ? WHERE id = ?");
        $stmt->execute(['Updated Book', 'Updated Author', 1]);

        $result = $this->conn->query("SELECT * FROM books")->fetchAll(PDO::FETCH_ASSOC);
        $this->assertEquals('Updated Book', $result[0]['title']);
        $this->assertEquals('Updated Author', $result[0]['author']);
    }

    public function testGetSingleBook()
    {
        // Add a book first
        $this->conn->exec("INSERT INTO books (title, author, isbn) VALUES ('Test Book', 'Test Author', '1234567890')");

        // Fetch the book
        $stmt = $this->conn->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->execute([1]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotNull($result);
        $this->assertEquals('Test Book', $result['title']);
    }

    public function testGetAllBooks()
    {
        // Add multiple books
        $this->conn->exec("INSERT INTO books (title, author, isbn) VALUES ('Book 1', 'Author 1', '12345')");
        $this->conn->exec("INSERT INTO books (title, author, isbn) VALUES ('Book 2', 'Author 2', '67890')");

        // Fetch all books
        $result = $this->conn->query("SELECT * FROM books")->fetchAll(PDO::FETCH_ASSOC);
        $this->assertCount(2, $result);
        $this->assertEquals('Book 1', $result[0]['title']);
        $this->assertEquals('Book 2', $result[1]['title']);
    }
}