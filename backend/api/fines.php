<?php
include '../config/db.php';

header('Content-Type: application/json');

$query = "SELECT * FROM fines";
$result = mysqli_query($conn, $query);
$fines = [];
while ($row = mysqli_fetch_assoc($result)) {
    $fines[] = $row;
}
echo json_encode($fines);
?>