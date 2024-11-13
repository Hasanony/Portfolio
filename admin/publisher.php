<?php
$active = "publisher.php";
include("db.php");

 include("sidebar.php");

// Initialize variables
$p_publisher = $p_url = "";

// Fetch existing values from the database
$sql = "SELECT * FROM publisher WHERE p_id = 1"; // Replace '1' with the actual id or criteria
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $p_publisher = $row['p_publisher'];
    $p_url = $row['p_url'];
} else {
    echo "Error fetching publisher data: " . mysqli_error($conn);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $p_publisher = mysqli_real_escape_string($conn, $_POST['p_publisher']);
    $p_url = mysqli_real_escape_string($conn, $_POST['p_url']);

    // Prepare the SQL update query
    $sql = "UPDATE publisher SET p_publisher = ?, p_url = ? WHERE p_id = 1"; // Replace '1' with the actual id or criteria

    // Initialize a prepared statement
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'ss', $p_publisher, $p_url);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Publisher information has been updated successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = 'publisher.php';
                });
            </script>";
        } else {
            // Handle query execution failure
            echo "<script>
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error updating Publisher information: " . mysqli_error($conn) . "',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = 'publisher.php';
                });
            </script>";
            echo "Error executing query: " . mysqli_stmt_error($stmt);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Handle preparation error
        echo "Error preparing the statement: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>


<style>
    /* Loader Circle */
    .loading-circle {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 30px;
        height: 30px;
        border: 4px solid rgba(0, 0, 0, 0.1);
        border-top: 4px solid rgba(0, 0, 0, 0.47);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Centering the form container */
    .container {
        margin-top: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 80vh;
    }

    .panel {
        width: 100%;
        max-width: 600px; /* Limit width for a cleaner look */
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Adding a subtle box shadow */
        border-radius: 8px;
        overflow: hidden;
    }

    .panel-heading {
        background-color: #5b4282; /* Custom header background */
        color: white;
        padding: 15px;
        text-align: center;
    }

    .panel-body {
        padding: 30px;
        background-color: #fff; /* White background for form body */
    }

    .form-horizontal {
        left: 30px;
    }

    /* Button Styling */
    .btn-primary {
        background-color: #5b4282; /* Custom button color */
        border-color: #5b4282;
    }

    .btn-primary:hover {
        background-color: #472e63;
        border-color: #472e63;
    }
</style>

<!-- Page Content -->
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="container">
                    <!-- Publisher Form -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa-solid fa-pen"></i> Publisher Information
                            </h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="updatePublisherForm" method="post">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Publisher Name</label>
                                    <div class="col-md-12">
                                        <input name="p_publisher" type="text" class="form-control" value="<?php echo htmlspecialchars($p_publisher); ?>" required>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="col-md-3 control-label"><i class="fa fa-link"></i> YouTube Channel URL</label>
                                    <div class="col-md-12">
                                        <input name="p_url" type="text" class="form-control" value="<?php echo htmlspecialchars($p_url); ?>" required>
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <div class="col-md-12">
                                        <input type="submit" class="btn btn-primary form-control" value="Update">
                                    </div>
                                </div>
                            </form>

                            <!-- Loader Circle (Hidden initially) -->
                            <div class="loading-circle" id="loadingCircle" style="display: none;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ionicons/7.4.0/esm/ionicons.min.js"></script>
