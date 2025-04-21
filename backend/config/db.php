<?php
$host = 'localhost';
$dbname = 'book_management';
$username = 'root'; // اسم المستخدم الافتراضي لـ MySQL
$password = '';     // كلمة المرور الافتراضية فارغة في XAMPP

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>