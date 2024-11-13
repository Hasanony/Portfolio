
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php

include("db.php");

// Check if the ID parameter is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the SQL delete query
    $stmt = $conn->prepare("DELETE FROM `column` WHERE `c_id` = ?");
    $stmt->bind_param('i', $id);

    // Execute the query and check for success
    if ($stmt->execute()) {
        // Successfully deleted, redirect to the column list
         echo "<script>window.open('column.php','_self')</script>";
    } else {
        // Error occurred
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
                        window.location.href = 'achive.php'; // Redirect to main page
                    });
                });
            </script>";
    }
    

    // Close the statement
    $stmt->close();
} else {
    header('Location: column.php');
}

// Close the database connection
$conn->close();
?>


