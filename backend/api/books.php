<?php
include '../config/db.php';

// تفعيل تسجيل الأخطاء
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // حل مشكلة CORS

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'] ?? null;

    if ($id) {
        // جلب بيانات كتاب واحد
        $id = intval($id);
        $query = "SELECT * FROM books WHERE id = $id";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo json_encode(['error' => 'Failed to fetch book: ' . mysqli_error($conn)]);
            exit;
        }

        $book = mysqli_fetch_assoc($result);
        if ($book) {
            echo json_encode($book);
        } else {
            echo json_encode(['error' => 'Book not found']);
        }
    } else {
        // جلب جميع الكتب
        $query = "SELECT * FROM books";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo json_encode(['error' => 'Failed to fetch books: ' . mysqli_error($conn)]);
            exit;
        }

        $books = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $books[] = $row;
        }

        echo json_encode($books);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['title']) || empty($data['author']) || empty($data['isbn'])) {
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }

    $title = mysqli_real_escape_string($conn, $data['title']);
    $author = mysqli_real_escape_string($conn, $data['author']);
    $isbn = mysqli_real_escape_string($conn, $data['isbn']);
    $location = mysqli_real_escape_string($conn, $data['location'] ?? '');
    $quantity = intval($data['quantity'] ?? 0);
    $total_pages = intval($data['total_pages'] ?? 0);
    $publication_date = mysqli_real_escape_string($conn, $data['publication_date'] ?? '');

    $query = "INSERT INTO books (title, author, isbn, location, quantity, total_pages, publication_date) 
              VALUES ('$title', '$author', '$isbn', '$location', $quantity, $total_pages, '$publication_date')";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['message' => 'Book added successfully']);
    } else {
        echo json_encode(['error' => 'Failed to add book: ' . mysqli_error($conn)]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = $_GET['id'] ?? null;

    if (!$id) {
        echo json_encode(['error' => 'Missing book ID']);
        exit;
    }

    $id = intval($id); // تحويل ID إلى عدد صحيح

    $query = "DELETE FROM books WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        echo json_encode(['message' => 'Book deleted successfully']);
    } else {
        echo json_encode(['error' => 'Failed to delete book: ' . mysqli_error($conn)]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $id = $_GET['id'] ?? null;

    if (!$id) {
        echo json_encode(['error' => 'Missing book ID']);
        exit;
    }

    $id = intval($id); // تحويل ID إلى عدد صحيح
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['title']) || empty($data['author']) || empty($data['isbn'])) {
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }

    $title = mysqli_real_escape_string($conn, $data['title']);
    $author = mysqli_real_escape_string($conn, $data['author']);
    $isbn = mysqli_real_escape_string($conn, $data['isbn']);
    $location = mysqli_real_escape_string($conn, $data['location'] ?? '');
    $quantity = intval($data['quantity'] ?? 0);
    $total_pages = intval($data['total_pages'] ?? 0);
    $publication_date = mysqli_real_escape_string($conn, $data['publication_date'] ?? '');

    $query = "UPDATE books 
              SET title = '$title', author = '$author', isbn = '$isbn', location = '$location', 
                  quantity = $quantity, total_pages = $total_pages, publication_date = '$publication_date' 
              WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['message' => 'Book updated successfully']);
    } else {
        echo json_encode(['error' => 'Failed to update book: ' . mysqli_error($conn)]);
    }
}
?>