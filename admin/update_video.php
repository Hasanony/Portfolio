<?php
// Include database connection and other necessary files
include("db.php");
include("sidebar.php");

// Get the video ID from the URL
$video_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($video_id <= 0) {
    die("Invalid video ID.");
}

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required fields are set
    if (isset($_POST['title'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];

        // Handle file upload if there is a new video file
        if (!empty($_FILES['video']['name'])) {
            $video_file_name = $_FILES['video']['name'];
            $video_file_tmp = $_FILES['video']['tmp_name'];

            // Generate a unique filename and move the uploaded file
            $new_video_file_name = uniqid() . "_" . basename($video_file_name);
            $video_upload_path = "videos/" . $new_video_file_name;

            if (move_uploaded_file($video_file_tmp, $video_upload_path)) {
                // Update the video record with new video file
                $update_query = "UPDATE `videos` SET v_title = ?, v_descr = ?, video = ? WHERE v_id = ?";
                $update_stmt = mysqli_prepare($conn, $update_query);
                mysqli_stmt_bind_param($update_stmt, 'sssi', $title, $description, $new_video_file_name, $video_id);
            } else {
                $error_message = "Failed to upload video.";
            }
        } elseif (!empty($_FILES['poster']['name'])) {
            // Handle file upload if there is a new poster
            $poster_file_name = $_FILES['poster']['name'];
            $poster_file_tmp = $_FILES['poster']['tmp_name'];

            // Generate a unique filename and move the uploaded file
            $new_poster_file_name = uniqid() . "_" . basename($poster_file_name);
            $poster_upload_path = "images/" . $new_poster_file_name;

            if (move_uploaded_file($poster_file_tmp, $poster_upload_path)) {
                // Update the video record with new poster file
                $update_query = "UPDATE `videos` SET v_title = ?, v_descr = ?, v_poster = ? WHERE v_id = ?";
                $update_stmt = mysqli_prepare($conn, $update_query);
                mysqli_stmt_bind_param($update_stmt, 'sssi', $title, $description, $new_poster_file_name, $video_id);
            } else {
                $error_message = "Failed to upload poster.";
            }
        } else {
            // Update the video record without changing the video file or poster
            $update_query = "UPDATE `videos` SET v_title = ?, v_descr = ? WHERE v_id = ?";
            $update_stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($update_stmt, 'ssi', $title, $description, $video_id);
        }

        if (mysqli_stmt_execute($update_stmt)) {
            echo "<script>
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Video has been updated successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = 'update_video.php?id=$video_id';
                });
            </script>";
        } else {
            $error_message = "Failed to update video.";
        }

        mysqli_stmt_close($update_stmt);
    }
}

// Fetch the current video details for display in the form
$query = "SELECT v_title, v_descr, video, v_poster FROM `videos` WHERE v_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $video_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $video_title, $video_descr, $video_file, $poster_file);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Video</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
            margin: 0;
        }

        .form-container {
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 800px;
            width: 100%;
            margin-bottom: 20px;
            margin-top: 20px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container label {
            font-weight: bold;
        }

        .form-container input[type="text"],
        .form-container input[type="file"],
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #218838;
        }

        .current-video,
        .current-poster {
            text-align: center;
            margin-bottom: 15px;
        }

        .current-video video,
        .current-poster img {
            max-width: 300px;
            max-height: 300px;
            width: auto;
            height: auto;
            border-radius: 10px;
        }

        .footer {
            text-align: center;
            margin-top: auto;
            padding: 10px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <a href="video.php">
            <i class="fa fa-chevron-left fa-2x"></i>
        </a>
        <h2>Update Video</h2>
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php elseif (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Display current video file and poster if they exist -->
        <?php if (!empty($video_file)): ?>
            <div class="current-video">
                <video controls>
                    <source src="videos/<?php echo htmlspecialchars($video_file); ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        <?php endif; ?>

        <?php if (!empty($poster_file)): ?>
            <div class="current-poster">
                <img src="images/<?php echo htmlspecialchars($poster_file); ?>" alt="Current Poster">
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Video Title:</label>
                <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($video_title); ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control" rows="4" required><?php echo htmlspecialchars($video_descr); ?></textarea>
            </div>

            <div class="form-group">
                <label for="video">Video File:</label>
                <input type="file" id="video" name="video" class="form-control-file">
            </div>

            <div class="form-group">
                <label for="poster">Poster Image:</label>
                <input type="file" id="poster" name="poster" class="form-control-file">
            </div>

            <button type="submit" class="btn btn-primary">Update Video</button>
        </form>
    </div>

    <?php include("footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>
</html>
