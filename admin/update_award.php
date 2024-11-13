<?php
// Include database connection and other necessary files
include("db.php");
include("sidebar.php");

// Get the award ID from the URL
$award_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($award_id <= 0) {
    die("Invalid award ID.");
}

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required fields are set
    if (isset($_POST['title'])) {
        $title = $_POST['title'];

        // Handle file upload if there is a new picture
        if (!empty($_FILES['pic']['name'])) {
            $file_name = $_FILES['pic']['name'];
            $file_tmp = $_FILES['pic']['tmp_name'];

            // Generate a unique filename and move the uploaded file
            $new_file_name = uniqid() . "_" . basename($file_name);
            $upload_path = "images/" . $new_file_name;

            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Update the award record with new picture
                $update_query = "UPDATE `award` SET aw_name = ?, aw_pic = ? WHERE aw_id = ?";
                $update_stmt = mysqli_prepare($conn, $update_query);
                mysqli_stmt_bind_param($update_stmt, 'ssi', $title, $new_file_name, $award_id);
            } else {
                $error_message = "Failed to upload picture.";
            }
        } else {
            // Update the award record without changing the picture
            $update_query = "UPDATE `award` SET aw_name = ? WHERE aw_id = ?";
            $update_stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($update_stmt, 'si', $title, $award_id);
        }

        if (mysqli_stmt_execute($update_stmt)) {
            echo "<script>
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Award has been updated successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = 'update_award.php?id=$award_id';
                });
            </script>";
        } else {
            $error_message = "Failed to update award.";
        }

        mysqli_stmt_close($update_stmt);
    }
}

// Fetch the current award details for display in the form
$query = "SELECT aw_name, aw_pic FROM `award` WHERE aw_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $award_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $award_name, $award_pic);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Award</title>
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
        .form-container input[type="file"] {
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

        .current-pic {
            text-align: center;
            margin-bottom: 15px;
        }

        .current-pic img {
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
        <a href="award.php">
            <i class="fa fa-chevron-left fa-2x"></i>
        </a>
        <h2>Update Award</h2>
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php elseif (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Display current picture if it exists -->
        <?php if (!empty($award_pic)): ?>
            <div class="current-pic">
                <img src="images/<?php echo htmlspecialchars($award_pic); ?>" alt="Current Award Picture">
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Award Name:</label>
                <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($award_name); ?>" required>
            </div>

            <div class="form-group">
                <label for="pic">Picture:</label>
                <input type="file" id="pic" name="pic" class="form-control-file">
            </div>

            <button type="submit" class="btn btn-primary">Update Award</button>
        </form>
    </div>


        <?php include("footer.php"); ?>
    

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

