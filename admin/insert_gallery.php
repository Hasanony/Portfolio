<?php
$active = "gallery.php";
include("db.php");
include("sidebar.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $uploadDirectory = 'images/'; // Make sure this directory exists and is writable
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    // Prepare SQL statement for inserting the gallery entry
    $stmt = $conn->prepare("INSERT INTO gallery (g_name, g_descr) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $description);
    
    if ($stmt->execute()) {
        $galleryId = $stmt->insert_id; // Get the last inserted ID

        $imageFiles = $_FILES['images'];
        $fileNames = $imageFiles['name'];
        $fileTmpNames = $imageFiles['tmp_name'];
        $fileErrors = $imageFiles['error'];
        $totalFiles = count($fileNames);
        
        $uploadSuccess = true;

        for ($i = 0; $i < $totalFiles; $i++) {
            $fileName = $fileNames[$i];
            $fileTmpName = $fileTmpNames[$i];
            $fileError = $fileErrors[$i];

            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName = uniqid('', true) . '.' . $fileExtension; // Unique file name to avoid collisions

            if ($fileError === UPLOAD_ERR_OK) {
                // Check for valid file type
                if (in_array(strtolower($fileExtension), $allowedTypes)) {
                    // Move the file to the uploads directory
                    if (move_uploaded_file($fileTmpName, $uploadDirectory . $newFileName)) {
                        // Insert the uploaded file information into the gallery_images table
                        $stmtImage = $conn->prepare("INSERT INTO gallery_images (gallery_id, g_img) VALUES (?, ?)");
                        $stmtImage->bind_param("is", $galleryId, $newFileName);
                        if (!$stmtImage->execute()) {
                            $uploadSuccess = false;
                            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                                <script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error uploading image: " . $stmtImage->error . "',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                </script>";
                        }
                        $stmtImage->close(); // Close the image statement
                    } else {
                        $uploadSuccess = false;
                        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error moving uploaded file.',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            </script>";
                    }
                } else {
                    $uploadSuccess = false;
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        </script>";
                }
            } else {
                $uploadSuccess = false;
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error uploading file.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    </script>";
            }
        }

        if ($uploadSuccess) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Gallery entry added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = 'insert_gallery.php';
                    });
                </script>";
        }

    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error adding gallery entry: " . $stmt->error . "',
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>";
    }
    $stmt->close(); // Close the gallery entry statement
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
</style>

<div id="page-content-wrapper" style="margin-bottom:10px;">
    <div class="container-fluid">
        <div class="row">
            <a href="gallery.php" style="margin-left:80px;margin-top:20px;">
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
                            <form class="form-horizontal" id="addGalleryForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Title</label>
                                    <div class="col-md-12">
                                        <input name="name" type="text" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="col-md-3 control-label">Description</label>
                                    <div class="col-md-12">
                                        <input name="description" type="text" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="col-md-3 control-label">Upload Images</label>
                                    <div class="col-md-12">
                                        <input name="images[]" type="file" class="form-control" multiple required>
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <div class="col-md-12">
                                        <input type="submit" name="submit" class="btn btn-primary form-control" value="Insert">
                                    </div>
                                </div>
                            </form>

                            <!-- Loader Circle (Hidden initially) -->
                            <div class="loading-circle" id="loadingCircle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include("footer.php"); ?>
