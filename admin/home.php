<?php
$active = "home.php";
include("db.php");
include("sidebar.php");
// Initialize variables with default values
$name = $job = $descr = $pic = '';

// Check if we need to fetch the existing home info
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Assuming $conn is your database connection
    $h_id = 1; // Replace with actual h_id as needed
    
    // Fetch existing home info
    $sql = "SELECT name, job, descr, pic FROM home WHERE h_id = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $h_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $name, $job, $descr, $pic);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing the statement: " . mysqli_error($conn);
    }
}
?>


<style>
    /* Loader Circle */
    .loading-circle {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 30px;
        height: 30px;
        border: 4px solid rgba(0, 0, 0, 0.1);
        border-top: 4px solid rgba(0, 0, 0, 0.47);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        display: none; /* Hidden initially */
        z-index: 9999; /* Make sure it's above other content */
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Container for centering content */
    .container {
        margin-top: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column; /* Stack children vertically */
        min-height: 80vh; /* Ensure it takes at least 80% of viewport height */
    }

    /* Panel Styling */
    .panel {
        width: 100%;
    
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        background-color: #ffffff;
    }

    .panel-heading {
        background-color: #5b4282;
        color: white;
        padding: 15px;
        text-align: center;
    }

    .panel-body {
        padding: 30px;
    }

    .form-horizontal {
        margin-left: 30px;
        margin-right: 30px;
    }

    /* Flexbox for side-by-side fields */
    .form-group {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .form-group label {
        flex: 0 0 30%; /* Adjust the width of the label */
        margin-bottom: 0;
    }

    .form-group .col-md-12 {
        flex: 1; /* Take up the remaining space */
    }

    .form-group.double-input {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .form-group.double-input .form-control {
        flex: 1;
    }

    /* Button Styling */
    .btn-primary {
        background-color: #5b4282;
        border-color: #5b4282;
    }

    .btn-primary:hover {
        background-color: #472e63;
        border-color: #472e63;
    }

    /* Ensure body allows scrolling if content overflows */
    body {
        overflow-x: hidden; /* Prevent horizontal scrolling */
    }

    /* Circular image container */
    .profile-pic-container {
        position: relative;
        width: 150px; /* Adjust size as needed */
        height: 150px; /* Adjust size as needed */
        margin: 0 auto;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        overflow: hidden;
        margin-bottom: 20px; /* Space between image and form */
    }

    /* Style for the circular image */
    .profile-pic-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }
/* Button container styling */
.edit-button-container {
    text-align: center;
    margin: 10px; /* Add space above the button */
}

/* Edit button styling */
.edit-button {
    background-color: #5b4282;
    color: white;
    border: none;
    border-radius: 30%;
    padding: 8px 15px; /* Add padding for button */
    display: inline-flex;
    align-items: center;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

.edit-button:hover {
    background-color: #472e63;
}


    /* Hide the file input */
    .file-input {
        display: none;
    }
</style>

<!-- Page Content -->
<div id="page-content-wrapper" style="margin-bottom:10px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="container">
                    <!-- Home Info Form -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa-solid fa-home"></i> Home Info
                            </h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="updateHomeForm" enctype="multipart/form-data" method="post">
                              <!-- Circular Image and Edit Button -->
                                <div class="profile-pic-container">
                                    <?php if ($pic): ?>
                                        <img src="images/<?php echo htmlspecialchars($pic); ?>" alt="Current Picture">
                                    <?php else: ?>
                                        <img src="images/default.jpg" alt="Default Picture"> <!-- Placeholder image -->
                                    <?php endif; ?>
                                    <input name="pic" type="file" class="file-input" id="fileInput">
                                </div>

                                <!-- Edit Button Positioned Outside -->
                                <div class="edit-button-container">
                                    <button type="button" class="edit-button" id="editButton">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Name</label>
                                    <div class="col-md-12">
                                        <input name="name" type="text" class="form-control" 
                                            value="<?php echo htmlspecialchars($name); ?>" required>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="col-md-3 control-label">Job</label>
                                    <div class="col-md-12">
                                        <input name="job" type="text" class="form-control" 
                                            value="<?php echo htmlspecialchars($job); ?>" required>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="col-md-3 control-label">Description</label>
                                    <div class="col-md-12">
                                        <textarea name="descr" class="form-control" rows="3" required>
                                            <?php echo $descr; ?>
                                        </textarea>
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

                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Get form data
                    $name = mysqli_real_escape_string($conn, $_POST['name']);
                    $job = mysqli_real_escape_string($conn, $_POST['job']);
                    $descr = mysqli_real_escape_string($conn, $_POST['descr']);

                    // Handle file upload
                    if (isset($_FILES['pic']) && $_FILES['pic']['error'] == UPLOAD_ERR_OK) {
                        $pic = basename($_FILES['pic']['name']);
                        move_uploaded_file($_FILES['pic']['tmp_name'], "images/" . $pic);
                    } else {
                        // If no new file uploaded, retain the old picture
                        $pic = htmlspecialchars($pic);
                    }

                    // Assuming the home ID is known (replace with actual h_id as needed)
                    $h_id = 1;

                    // Prepare the SQL update query
                    $sql = "UPDATE home SET name = ?, job = ?, descr = ?, pic = ? WHERE h_id = ?";

                    // Initialize a prepared statement
                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        // Bind parameters (s = string, i = integer)
                        mysqli_stmt_bind_param($stmt, 'ssssi', $name, $job, $descr, $pic, $h_id);

                        // Execute the statement
                        if (mysqli_stmt_execute($stmt)) {
                            // Success message and redirect
                            echo "<script>
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Home info has been updated successfully!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(function() {
                                        window.location.href = 'home.php';
                                    });
                                </script>";
                        } else {
                            echo "<script>
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'error',
                                        title: 'Error updating home info: ',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(function() {
                                        window.location.href = 'home.php';
                                    });
                                </script>" . mysqli_error($conn);
                        }

                        // Close the statement
                        mysqli_stmt_close($stmt);
                    } else {
                        echo "<script>
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: 'Error preparing the statement: ',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function() {
                                    window.location.href = 'home.php';
                                });
                            </script>" . mysqli_error($conn);
                    }

                    // Close the database connection
                    mysqli_close($conn);
                }
                ?>

                <!-- Bootstrap JS and dependencies -->
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
                <!-- jQuery -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <!-- Custom JavaScript -->
                <script>
                    $(document).ready(function(){
                        $("#menu-toggle").click(function(e){
                            e.preventDefault();
                            $("#wrapper").toggleClass("menuDisplayed");
                        });
                    });

                    $(document).ready(function() {
                        $('form').on('submit', function() {
                            $('#loadingCircle').show();
                        });
                    });

                    // Edit button click event
                    document.getElementById('editButton').addEventListener('click', function() {
                        document.getElementById('fileInput').click();
                    });

                    // File input change event
                    document.getElementById('fileInput').addEventListener('change', function(event) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                document.querySelector('.profile-pic-container img').src = e.target.result;
                            }
                            reader.readAsDataURL(file);
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>
