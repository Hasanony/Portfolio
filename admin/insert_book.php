<?php
$active = "books.php";
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

    /* Container for centering content */
    .container {
        margin-top: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        min-height: 80vh;
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
        flex: 0 0 30%;
        margin-bottom: 0;
    }

    .form-group .col-md-12 {
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
        overflow-x: hidden;
    }
</style>

<div id="page-content-wrapper" style="margin-bottom:10px;">
    <div class="container-fluid">
        <div class="row">
            <a href="book.php" style="margin-left:80px;margin-top:20px;">
                <i class="fa-solid fa-circle-chevron-left fa-2x"></i>
            </a>
            <div class="col-lg-12">
                <div class="container">
                    <!-- Add Book Form -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa-solid fa-plus"></i> Add Book
                            </h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="addBookForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Book Name</label>
                                    <div class="col-md-12">
                                        <input name="b_name" type="text" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="col-md-3 control-label">Description</label>
                                    <div class="col-md-12">
                                        <textarea name="b_descr" type="file" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="col-md-3 control-label">Upload Cover Image</label>
                                    <div class="col-md-12">
                                        <input name="b_pic" type="file" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="col-md-3 control-label">Link</label>
                                    <div class="col-md-12">
                                        <input name="b_link" type="url" class="form-control">
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
                        $b_name = $_POST['b_name'];
                        $b_descr = $_POST['b_descr'];
                        $b_link = $_POST['b_link'];

                        // Handle file upload
                        $b_pic = $_FILES['b_pic']['name'];
                        $b_pic_tmp = $_FILES['b_pic']['tmp_name'];
                        $upload_directory = 'images/'; // Directory where images will be saved
                        $upload_file = $upload_directory . basename($b_pic);

                        // Check if file is uploaded successfully
                        if (move_uploaded_file($b_pic_tmp, $upload_file)) {
                            // Prepare the SQL query to insert a new book into the `book` table
                            $stmt = $conn->prepare("INSERT INTO book (b_name, b_descr, b_pic, b_link) VALUES (?, ?, ?, ?)");
                            $stmt->bind_param("ssss", $b_name, $b_descr, $b_pic, $b_link);

                            if ($stmt->execute()) {
                                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                                <script>
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Book added successfully!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(function() {
                                        window.location.href = 'insert_book.php';
                                    });
                                </script>";
                            } else {
                                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                                <script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error adding book: " . $stmt->error . "',
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
