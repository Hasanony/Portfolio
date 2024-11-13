<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include("db.php"); // Include your database connection file

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Get and sanitize the ab_id

    // Prepare the SQL query to delete the record from the ab_box table
    $sql = "DELETE FROM ab_box WHERE ab_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Display success message using SweetAlert and redirect to ab_box.php
        echo "<script>window.open('achive.php','_self')</script>";
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
                        window.location.href = 'achive.php'; // Redirect to main page
                    });
                });
            </script>";
    }

    $stmt->close(); // Close the statement
}

$conn->close(); // Close the database connection
?>
