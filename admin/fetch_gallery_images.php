<?php
include("db.php");

if (isset($_GET['id'])) {
    $gallery_id = intval($_GET['id']);
    $query = "SELECT g_img FROM gallery_images WHERE gallery_id = ?";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $gallery_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $images = [];
        while ($row = $result->fetch_assoc()) {
            $images[] = $row['g_img'];
        }
        
        header('Content-Type: application/json');
        echo json_encode($images);
    }
}
?>

