<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php

include("db.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Prepare the SQL statement
    $stmt = $conn->prepare("DELETE FROM award WHERE aw_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect to awards page with success message
      echo "<script>window.open('award.php','_self')</script>";
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
                        window.location.href = 'award.php'; // Redirect to awards page
                    });
                });
            </script>";
    }
    
    $stmt->close();
} else {
    // Redirect to awards page if no ID is provided
    header('Location: award.php');
}

$conn->close();
?>
