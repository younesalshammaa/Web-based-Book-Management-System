// test/frontend-tests/api.test.js
const api = require('../../frontend/js/api');

describe('API Tests', () => {
    // Mock fetch function globally
    beforeEach(() => {
        global.fetch = jest.fn();
    });

    // Test for adding a new book
    test('adds a new book successfully', async () => {
        const mockResponse = { id: 1, title: 'Test Book' };
        global.fetch.mockResolvedValue({
            json: jest.fn().mockResolvedValue(mockResponse),
        });

        const bookData = {
            title: 'Test Book',
            author: 'Test Author',
            isbn: '1234567890',
            location: 'Shelf A1',
            quantity: 5,
            total_pages: 300,
            publication_date: '2023-01-01',
        };

        const response = await api.addBook(bookData);
        expect(global.fetch).toHaveBeenCalledWith('/book-management-app/backend/api/books.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(bookData),
        });
        expect(response).toEqual(mockResponse);
    });

    // Test for deleting a book
    test('deletes a book successfully', async () => {
        const mockResponse = { message: 'Book deleted successfully' };
        global.fetch.mockResolvedValue({
            json: jest.fn().mockResolvedValue(mockResponse),
        });

        const bookId = 1;
        const response = await api.deleteBook(bookId);

        expect(global.fetch).toHaveBeenCalledWith('/book-management-app/backend/api/books.php?id=1', {
            method: 'DELETE',
        });
        expect(response).toEqual(mockResponse);
    });

    // Test for updating a book
    test('updates a book successfully', async () => {
        const mockResponse = { message: 'Book updated successfully' };
        global.fetch.mockResolvedValue({
            json: jest.fn().mockResolvedValue(mockResponse),
        });

        const bookId = 1;
        const updatedData = { title: 'Updated Book Title' };
        const response = await api.updateBook(bookId, updatedData);

        expect(global.fetch).toHaveBeenCalledWith('/book-management-app/backend/api/books.php?id=1', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(updatedData),
        });
        expect(response).toEqual(mockResponse);
    });

    // Test for fetching a single book
    test('fetches a single book successfully', async () => {
        const mockResponse = { id: 1, title: 'Test Book', author: 'Test Author' };
        global.fetch.mockResolvedValue({
            json: jest.fn().mockResolvedValue(mockResponse),
        });

        const bookId = 1;
        const response = await api.getBook(bookId);

        expect(global.fetch).toHaveBeenCalledWith('/book-management-app/backend/api/books.php?id=1');
        expect(response).toEqual(mockResponse);
    });

    // Test for fetching all books
    test('fetches all books successfully', async () => {
        const mockResponse = [
            { id: 1, title: 'Book 1', author: 'Author 1' },
            { id: 2, title: 'Book 2', author: 'Author 2' },
        ];
        global.fetch.mockResolvedValue({
            json: jest.fn().mockResolvedValue(mockResponse),
        });

        const response = await api.getBooks();

        expect(global.fetch).toHaveBeenCalledWith('/book-management-app/backend/api/books.php');
        expect(response).toEqual(mockResponse);
    });
});