<?php
// Include database connection and other necessary files
include("db.php");
include("sidebar.php");

// Get the ab_box ID from the URL
$ab_box_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($ab_box_id <= 0) {
    die("Invalid ab_box ID.");
}

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required fields are set
    if (isset($_POST['number']) && isset($_POST['descr'])) {
        $number = $_POST['number'];
        $descr = $_POST['descr'];

        // Update the ab_box record
        $update_query = "UPDATE `ab_box` SET number = ?, descr = ? WHERE ab_id = ?";
        $update_stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($update_stmt, 'ssi', $number, $descr, $ab_box_id);

        // Execute the query and check if the update was successful
        if (mysqli_stmt_execute($update_stmt)) {
            echo "<script>
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'ab_box has been updated successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = 'update_achive.php?id=$ab_box_id';
                });
            </script>";
        } else {
            $error_message = "Failed to update ab_box.";
        }

        // Close the prepared statement
        mysqli_stmt_close($update_stmt);
    }
}

// Fetch the current ab_box details for display in the form
$query = "SELECT number, descr FROM `ab_box` WHERE ab_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $ab_box_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ab_box_number, $ab_box_descr);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update ab_box</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .form-container {
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 60px;
            margin-top: 60px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container label {
            font-weight: bold;
        }

        .form-container input[type="text"],
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
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 offset-md-2">
                <div class="form-container">
                    <a href="ab_box.php">
                        <i class="fa-solid fa-circle-chevron-left fa-2x"></i>
                    </a>
                    <h2>Update About Box</h2>
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    <form method="post">
                        <div class="form-group">
                            <label for="number">Number:</label>
                            <input type="text" id="number" name="number" class="form-control" value="<?php echo htmlspecialchars($ab_box_number); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="descr">Description:</label>
                            <textarea id="descr" name="descr" class="form-control" rows="5" required><?php echo $ab_box_descr; ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Update ab_box</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>
</body>
</html>
