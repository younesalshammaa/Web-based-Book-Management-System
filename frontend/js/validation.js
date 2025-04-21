function validateForm() {
 const title = document.getElementById('title').value.trim();
 const author = document.getElementById('author').value.trim();
 const isbn = document.getElementById('isbn').value.trim();

 if (!title || !author || !isbn) {
     alert('Please fill in all required fields.');
     return false;
 }
 return true;
}