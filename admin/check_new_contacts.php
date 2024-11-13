<?php
include("db.php");

// Fetch the count of contacts
$sql = "SELECT COUNT(*) as count FROM contact";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo json_encode($row['count']);
?>
