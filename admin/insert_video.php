<?php
$active = "video.php";
include("db.php");
include("sidebar.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if form data is set
    if (!isset($_POST['title']) || !isset($_POST['description'])) {
        die("Form data not set properly.");
    }

    $title = $_POST['title'];
    $description = $_POST['description'];
    $uploadDirectory = 'videos/'; // Directory for video files
    $posterDirectory = 'images/'; // Directory for poster images
    $allowedVideoTypes = ['mp4', 'avi', 'mov', 'wmv'];
    $allowedPosterTypes = ['jpg', 'jpeg', 'png', 'gif'];

    // Prepare SQL statement for inserting the video entry
    $stmt = $conn->prepare("INSERT INTO videos (v_title, v_descr, v_time) VALUES (?, ?, NOW())");
    if (!$stmt) {
        die("Error preparing SQL statement: " . $conn->error);
    }
    $stmt->bind_param("ss", $title, $description);
    
    if ($stmt->execute()) {
        $videoId = $stmt->insert_id; // Get the last inserted ID

        // Handle video file upload
        if (isset($_FILES['videos'])) {
            $videoFiles = $_FILES['videos'];
            $videoNames = $videoFiles['name'];
            $videoTmpNames = $videoFiles['tmp_name'];
            $videoErrors = $videoFiles['error'];
            $totalVideos = count($videoNames);
            
            $uploadSuccess = true;

            for ($i = 0; $i < $totalVideos; $i++) {
                $videoName = $videoNames[$i];
                $videoTmpName = $videoTmpNames[$i];
                $videoError = $videoErrors[$i];

                $videoExtension = pathinfo($videoName, PATHINFO_EXTENSION);
                $newVideoName = uniqid('', true) . '.' . $videoExtension; // Unique file name to avoid collisions

                if ($videoError === UPLOAD_ERR_OK) {
                    // Check for valid video file type
                    if (in_array(strtolower($videoExtension), $allowedVideoTypes)) {
                        // Move the video file to the uploads directory
                        if (move_uploaded_file($videoTmpName, $uploadDirectory . $newVideoName)) {
                            // Handle poster image upload (optional)
                            if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
                                $posterFile = $_FILES['poster'];
                                $posterName = $posterFile['name'];
                                $posterTmpName = $posterFile['tmp_name'];
                                $posterError = $posterFile['error'];
                                $posterExtension = pathinfo($posterName, PATHINFO_EXTENSION);
                                $newPosterName = uniqid('', true) . '.' . $posterExtension; // Unique file name

                                if (in_array(strtolower($posterExtension), $allowedPosterTypes)) {
                                    if (move_uploaded_file($posterTmpName, $posterDirectory . $newPosterName)) {
                                        // Update the video entry with the poster image
                                        $stmtPoster = $conn->prepare("UPDATE videos SET v_poster = ? WHERE v_id = ?");
                                        if (!$stmtPoster) {
                                            die("Error preparing SQL statement for poster: " . $conn->error);
                                        }
                                        $stmtPoster->bind_param("si", $newPosterName, $videoId);
                                        if (!$stmtPoster->execute()) {
                                            $uploadSuccess = false;
                                            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                                                <script>
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Error updating video poster: " . $stmtPoster->error . "',
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                    });
                                                </script>";
                                        }
                                        $stmtPoster->close(); // Close the poster statement
                                    } else {
                                        $uploadSuccess = false;
                                        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                                            <script>
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error moving poster image file.',
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
                                                title: 'Invalid poster file type. Only JPG, JPEG, PNG, and GIF are allowed.',
                                                showConfirmButton: false,
                                                timer: 1500
                                            });
                                        </script>";
                                }
                            }

                            // Update the video entry with the video file
                            $stmtVideo = $conn->prepare("UPDATE videos SET video = ? WHERE v_id = ?");
                            if (!$stmtVideo) {
                                die("Error preparing SQL statement for video: " . $conn->error);
                            }
                            $stmtVideo->bind_param("si", $newVideoName, $videoId);
                            if (!$stmtVideo->execute()) {
                                $uploadSuccess = false;
                                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                                    <script>
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error updating video entry: " . $stmtVideo->error . "',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    </script>";
                            }
                            $stmtVideo->close(); // Close the video statement
                        } else {
                            $uploadSuccess = false;
                            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                                <script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error moving uploaded video file.',
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
                                    title: 'Invalid video file type. Only MP4, AVI, MOV, and WMV are allowed.',
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
                                title: 'Error uploading video file.',
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
                            title: 'Video entry added successfully!',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            window.location.href = 'insert_video.php';
                        });
                    </script>";
            }
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'No video files were uploaded.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                </script>";
        }
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error adding video entry: " . $stmt->error . "',
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>";
    }
    $stmt->close(); // Close the video entry statement
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
            <a href="video.php" style="margin-left:80px;margin-top:20px;">
                <i class="fa-solid fa-circle-chevron-left fa-2x"></i>
            </a>
            <div class="col-lg-12">
                <div class="container">
                    <!-- Add Entry Form -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa-solid fa-plus"></i> Add Video
                            </h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="addVideoForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Title</label>
                                    <div class="col-md-12">
                                        <input name="title" type="text" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="col-md-3 control-label">Description</label>
                                    <div class="col-md-12">
                                        <textarea name="description" class="form-control" rows="4" required></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Video</label>
                                    <div class="col-md-12">
                                        <input name="videos[]" type="file" class="form-control" multiple accept="video/*" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Poster (Optional)</label>
                                    <div class="col-md-12">
                                        <input name="poster" type="file" class="form-control" accept="image/*">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Add Video</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  <footer class="footer">
    <p><span class="footer__copyright">&copy;</span> 2024 MTH</p>
    <p>Crafted with <i class="fas fa-heart footer__icon"></i> by <a href="https://www.linkedin.com/in/matt-holland/" target="_blank" class="footer__signature">Hasan Ony</a></p>
  </footer>




</body>
</html>