const api = {
    getBooks: async () => {
        const response = await fetch('/book-management-app/backend/api/books.php');
        return await response.json();
    },
    addBook: async (bookData) => {
        const response = await fetch('/book-management-app/backend/api/books.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(bookData)
        });
        return await response.json();
    },
    deleteBook: async (bookId) => {
        const response = await fetch(`/book-management-app/backend/api/books.php?id=${bookId}`, {
            method: 'DELETE'
        });
        return await response.json();
    },
    getBook: async (bookId) => {
        const response = await fetch(`/book-management-app/backend/api/books.php?id=${bookId}`);
        return await response.json();
    },
    updateBook: async (bookId, updatedData) => {
        const response = await fetch(`/book-management-app/backend/api/books.php?id=${bookId}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(updatedData)
        });
        return await response.json();
    }
};

// Export the API object
module.exports = api;