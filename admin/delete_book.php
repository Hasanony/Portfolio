<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php

include("db.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Prepare the SQL statement for the book table
    $stmt = $conn->prepare("DELETE FROM book WHERE b_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect to books page with success message
        echo "<script>window.open('book.php','_self')</script>";
    } else {
        // Display error message if deletion failed
        echo "
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Error deleting record',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = 'book.php'; // Redirect to books page
                    });
                });
            </script>";
    }
    
    $stmt->close();
} else {
    // Redirect to books page if no ID is provided
    header('Location: book.php');
}

$conn->close();
?>
