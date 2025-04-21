# 🧪 Project Testing Documentation

This document provides a detailed overview of the testing strategy used in the Web-based Book Management System project.

---

## ✅ Frontend Testing

### A. Tools Used
- **Jest**: A JavaScript testing framework.
- **Mocking**: Used `jest.fn()` to mock functions like `fetch`.

### B. Functions Tested
- **addBook**: Adds a new book with valid input, handles invalid data.
- **deleteBook**: Deletes a book by ID.
- **updateBook**: Updates book details by ID.
- **getBook**: Fetches a book by ID.
- **getBooks**: Fetches a list of all books.

### C. Test File Location
```
test/frontend-tests/api.test.js
```

### D. How to Run
```bash
npx jest test/frontend-tests/api.test.js
```

### E. Expected Output
```bash
PASS  test/frontend-tests/api.test.js
  API Tests
    ✓ adds a new book successfully (X ms)
    ✓ deletes a book successfully (X ms)
    ✓ updates a book successfully (X ms)
    ✓ fetches a single book successfully (X ms)
    ✓ fetches all books successfully (X ms)

Test Suites: 1 passed, 1 total
Tests:       5 passed, 5 total
Snapshots:   0 total
Time:        X.XXX s
```

---

## ✅ Backend Testing

### A. Tools Used
- **PHPUnit**: PHP testing framework.
- **In-Memory SQLite**: Temporary database for isolated testing.

### B. Functions Tested
- **POST**: Adds a new book to the database.
- **DELETE**: Removes a book using its ID.
- **PUT**: Updates book details using ID.
- **GET (by ID)**: Retrieves a single book.
- **GET (all)**: Retrieves all books.

### C. Test File Location
```
test/backend-tests/BooksTest.php
```

### D. How to Run
```bash
vendor\bin\phpunit test\backend-tests/BooksTest.php
```

### E. Expected Output
```
PHPUnit 5.7.27 by Sebastian Bergmann and contributors.

.....                                                               5 / 5 (100%)

Time: X ms, Memory: Y MB

OK (5 tests, 10 assertions)
```

---

## 📌 Notes
- All tests passed successfully.
- Tests cover essential CRUD operations.
- The testing setup ensures no effect on the real database.

---

## 🧑‍💻 Author
Yunes Al-Shamea – Final-year Software Engineering student  
Email: younesalshammaa@gmail.com  
GitHub: [github.com/younesalshammaa](https://github.com/younesalshammaa)
