<?php
include("db.php");

// Check if 'id' is set in the request
if (isset($_GET['id']) && isset($_GET['gallery_id'])) {
    $id = intval($_GET['id']);
    $gallery_id = intval($_GET['gallery_id']);

    // Fetch the image filename from the database
    $sql = "SELECT g_img FROM gallery_images WHERE id = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $g_img);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // Check if image exists in the database
        if ($g_img) {
            // Delete the image file from the filesystem
            $file_path = "images/" . $g_img; // Adjust path as needed
            if (file_exists($file_path)) {
                unlink($file_path);
            }

            // Delete the image record from the database
            $sql = "DELETE FROM gallery_images WHERE id = ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, 'i', $id);
                if (mysqli_stmt_execute($stmt)) {
                    // Redirect or send success response
                    echo "<script>window.open('update_gallery.php?id=$gallery_id','_self')</script>";
                    exit;
                } else {
                    // Handle error
                    echo "Error deleting record from database: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "Error preparing statement: " . mysqli_error($conn);
            }
        } else {
            echo "Image not found in database.";
        }
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
mysqli_close($conn);
?>
