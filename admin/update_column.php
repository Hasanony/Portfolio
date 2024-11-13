<?php
// Include database connection and other necessary files
include("db.php");
include("sidebar.php");

// Get the column ID from the URL
$column_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($column_id <= 0) {
    die("Invalid column ID.");
}

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required fields are set
    if (isset($_POST['title']) && isset($_POST['descr']) && isset($_POST['date'])) {
        $title = $_POST['title'];
        $descr = $_POST['descr'];
        $date = $_POST['date'];

        // Handle file upload if there is a new picture
        if (!empty($_FILES['pic']['name'])) {
            $file_name = $_FILES['pic']['name'];
            $file_tmp = $_FILES['pic']['tmp_name'];

            // Generate a unique filename and move the uploaded file
            $new_file_name = uniqid() . "_" . basename($file_name);
            $upload_path = "images/" . $new_file_name;

            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Update the column record with new picture
                $update_query = "UPDATE `column` SET title = ?, c_descr = ?, c_pic = ?, c_date = ? WHERE c_id = ?";
                $update_stmt = mysqli_prepare($conn, $update_query);
                mysqli_stmt_bind_param($update_stmt, 'ssssi', $title, $descr, $new_file_name, $date, $column_id);
            } else {
                $error_message = "Failed to upload picture.";
            }
        } else {
            // Update the column record without changing the picture
            $update_query = "UPDATE `column` SET title = ?, c_descr = ?, c_date = ? WHERE c_id = ?";
            $update_stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($update_stmt, 'sssi', $title, $descr, $date, $column_id);
        }

        if (mysqli_stmt_execute($update_stmt)) {
           echo "<script>
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Column has been updated successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = 'update_column.php?id=$column_id';
                });
            </script>";
        } else {
            $error_message = "Failed to update column.";
        }

        mysqli_stmt_close($update_stmt);
    }
}

// Fetch the current column details for display in the form
$query = "SELECT title, c_descr, c_pic, c_date FROM `column` WHERE c_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $column_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $column_title, $column_descr, $column_pic, $column_date);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Column</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .form-container {
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 60px;
            margin-top: 60px;
            max-width: 800px; /* Set max-width for the form */
            margin-left: auto; /* Center the form horizontally */
            margin-right: auto; /* Center the form horizontally */
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container label {
            font-weight: bold;
        }

        .form-container input[type="text"],
        .form-container textarea,
        .form-container input[type="date"] {
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

        /* Optional: File input styling */
        .file-input-wrapper {
            position: relative;
            display: inline-block;
        }

        .file-input-wrapper input[type="file"] {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .file-input-label {
            display: inline-block;
            padding: 8px 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f8f9fa;
            color: #333;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 offset-md-2"> <!-- Centered with offset -->
            <div class="form-container">
                <a href="column.php">
                    <i class="fa-solid fa-circle-chevron-left fa-2x"></i>
                </a>
                <h2>Update Column</h2>
                <?php if (isset($success_message)): ?>
                    <div class="alert alert-success"><?php echo $success_message; ?></div>
                <?php elseif (isset($error_message)): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($column_title); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="descr">Description:</label>
                        <textarea id="descr" name="descr" class="form-control" rows="5" required><?php echo $column_descr; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="pic">Picture:</label>
                        <input type="file" id="pic" name="pic" class="form-control-file">
                    </div>

                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date" class="form-control" value="<?php echo htmlspecialchars($column_date); ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Column</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>

   