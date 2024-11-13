<?php

$active="achive.php";
include("db.php");
include("sidebar.php");
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
</style>

<div id="page-content-wrapper" style="margin-bottom:10px;">
    <div class="container-fluid">
        
        <div class="row">
             
                <a href="achive.php" style="margin-left:80px;margin-top:20px;">
                    <i class="fa-solid fa-circle-chevron-left fa-2x"></i>
                </a>
            <div class="col-lg-12">
            

                <div class="container">
                    <!-- Add Entry Form -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa-solid fa-plus"></i> Add More
                            </h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="addBoxForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Number</label>
                                    <div class="col-md-12">
                                        <input name="number" type="number" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="col-md-3 control-label">Description</label>
                                    <div class="col-md-12">
                                        <input name="descr" type="text" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <div class="col-md-12">
                                        <input type="submit" name="submit" class="btn btn-primary form-control" value="Insert">
                                    </div>
                                </div>
                            </form>

                            <!-- Loader Circle (Hidden initially) -->
                            <div class="loading-circle" id="loadingCircle" style="display: none;"></div>
                        </div>
                    </div>

                    <?php
            
                    // Handle form submission
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $number = $_POST['number'];
                        $descr = $_POST['descr'];

                        // Prepare the SQL query to insert a new entry into `ab_boxx`
                        $stmt = $conn->prepare("INSERT INTO ab_box (number, descr) VALUES (?, ?)");
                        $stmt->bind_param("is", $number, $descr);

                        if ($stmt->execute()) {
                            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                            <script>
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Entry added successfully!',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function() {
                                    window.location.href = 'insert_achive.php';
                                });
                            </script>";
                        } else {
                            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error adding entry: " . $stmt->error . "',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            </script>";
                        }

                        $stmt->close(); // Close the statement
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>


<?php include("footer.php");
?>














