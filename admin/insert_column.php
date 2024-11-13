<?php
$active = "columns.php";
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
        display: none;
        z-index: 9999;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .container {
        margin-top: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        min-height: 80vh;
    }

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

    .form-group {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .form-group label {
        flex: 0 0 30%;
        margin-bottom: 0;
    }

    .form-group .col-md-12 {
        flex: 1;
    }

    .btn-primary {
        background-color: #5b4282;
        border-color: #5b4282;
    }

    .btn-primary:hover {
        background-color: #472e63;
        border-color: #472e63;
    }

    body {
        overflow-x: hidden;
    }
</style>

<div id="page-content-wrapper" style="margin-bottom:10px;">
    <div class="container-fluid">
        <div class="row">
            <a href="column.php" style="margin-left:80px;margin-top:20px;">
                <i class="fa-solid fa-circle-chevron-left fa-2x"></i>
            </a>
            <div class="col-lg-12">
                <div class="container">
                    <!-- Add Column Form -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa-solid fa-plus"></i> Add Column
                            </h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="addColumnForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Column Title</label>
                                    <div class="col-md-12">
                                        <input name="title" type="text" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="col-md-3 control-label">Description</label>
                                    <div class="col-md-12">
                                        <textarea name="c_descr" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="col-md-3 control-label">Upload Image</label>
                                    <div class="col-md-12">
                                        <input name="c_pic" type="file" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="col-md-3 control-label">Date</label>
                                    <div class="col-md-12">
                                        <input name="c_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <div class="col-md-12">
                                        <input type="submit" name="submit" class="btn btn-primary form-control" value="Insert">
                                    </div>
                                </div>
                            </form>

                            <!-- Loader Circle -->
                            <div class="loading-circle" id="loadingCircle" style="display: none;"></div>
                        </div>
                    </div>

                    <?php
                    // Handle form submission
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $title = $_POST['title'];
                        $c_descr = $_POST['c_descr'];
                        $c_date = $_POST['c_date']; // User-selected date

                        // Handle file upload
                        $c_pic = $_FILES['c_pic']['name'];
                        $c_pic_tmp = $_FILES['c_pic']['tmp_name'];
                        $upload_directory = 'images/'; // Directory where images will be saved
                        $upload_file = $upload_directory . basename($c_pic);

                        // Check if file is uploaded successfully
                        if (move_uploaded_file($c_pic_tmp, $upload_file)) {
                            // Prepare the SQL query to insert a new column into the `column` table
                            $stmt = $conn->prepare("INSERT INTO `column` (title, c_descr, c_pic, c_date) VALUES (?, ?, ?, ?)");
                            $stmt->bind_param("ssss", $title, $c_descr, $c_pic, $c_date);

                            if ($stmt->execute()) {
                                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                                <script>
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Column added successfully!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(function() {
                                        window.location.href = 'insert_column.php';
                                    });
                                </script>";
                            } else {
                                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                                <script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error adding column: " . $stmt->error . "',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                </script>";
                            }

                            $stmt->close();
                        } else {
                            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error uploading image!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            </script>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>
