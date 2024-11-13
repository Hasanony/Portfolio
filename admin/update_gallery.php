<?php
// Include database connection and other necessary files
include("db.php");
include("sidebar.php");

// Get the gallery ID from the URL
$gallery_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($gallery_id <= 0) {
    die("Invalid gallery ID.");
}

// Fetch the gallery details
$query = "SELECT g_name, g_descr FROM gallery WHERE g_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $gallery_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $gallery_name, $gallery_descr);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle image deletion
    if (isset($_POST['delete_images']) && !empty($_POST['delete_images'])) {
        $delete_ids = $_POST['delete_images'];

        // Delete selected images
        foreach ($delete_ids as $image_id) {
            $image_id = intval($image_id);
            
            // Fetch image filename
            $image_query = "SELECT g_img FROM gallery_images WHERE id = ?";
            $image_stmt = mysqli_prepare($conn, $image_query);
            mysqli_stmt_bind_param($image_stmt, 'i', $image_id);
            mysqli_stmt_execute($image_stmt);
            mysqli_stmt_bind_result($image_stmt, $image_filename);
            mysqli_stmt_fetch($image_stmt);
            mysqli_stmt_close($image_stmt);
            
            // Delete the image file
            if ($image_filename && file_exists("images/$image_filename")) {
                unlink("images/$image_filename");
            }
            
            // Delete the image record from the database
            $delete_query = "DELETE FROM gallery_images WHERE id = ?";
            $delete_stmt = mysqli_prepare($conn, $delete_query);
            mysqli_stmt_bind_param($delete_stmt, 'i', $image_id);
            mysqli_stmt_execute($delete_stmt);
            mysqli_stmt_close($delete_stmt);
        }
        echo "<script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Selected images deleted successfully!',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = 'update_gallery.php?id=$gallery_id';
            });
        </script>";
    }

    // Handle gallery information update
    if (isset($_POST['name']) && isset($_POST['descr'])) {
        $name = $_POST['name'];
        $descr = $_POST['descr'];

        // Update the gallery details
        $update_query = "UPDATE gallery SET g_name = ?, g_descr = ? WHERE g_id = ?";
        $update_stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($update_stmt, 'ssi', $name, $descr, $gallery_id);

        if (mysqli_stmt_execute($update_stmt)) {
            echo "<script>
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Gallery info has been updated successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = 'update_gallery.php?id=$gallery_id';
                });
            </script>";
        } else {
            $error_message = "Failed to update gallery.";
        }

        mysqli_stmt_close($update_stmt);
    }

    // Handle file uploads
    if (!empty($_FILES['new_images']['name'][0])) {
        $uploaded_files = $_FILES['new_images'];

        for ($i = 0; $i < count($uploaded_files['name']); $i++) {
            $file_name = $uploaded_files['name'][$i];
            $file_tmp = $uploaded_files['tmp_name'][$i];

            // Generate a unique filename and move the uploaded file
            $new_file_name = uniqid() . "_" . basename($file_name);
            $upload_path = "images/" . $new_file_name;

            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Insert the image into the gallery_images table
                $insert_image_query = "INSERT INTO gallery_images (gallery_id, g_img) VALUES (?, ?)";
                $insert_image_stmt = mysqli_prepare($conn, $insert_image_query);
                mysqli_stmt_bind_param($insert_image_stmt, 'is', $gallery_id, $new_file_name);
                mysqli_stmt_execute($insert_image_stmt);
                mysqli_stmt_close($insert_image_stmt);
            }
        }
    }
}

// Fetch the gallery images (if any)
$image_query = "SELECT id, g_img FROM gallery_images WHERE gallery_id = ?";
$image_stmt = mysqli_prepare($conn, $image_query);
mysqli_stmt_bind_param($image_stmt, 'i', $gallery_id);
mysqli_stmt_execute($image_stmt);
$image_result = mysqli_stmt_get_result($image_stmt);
$images = mysqli_fetch_all($image_result, MYSQLI_ASSOC);
mysqli_stmt_close($image_stmt);
?>

<!-- HTML and CSS here (no changes) -->


<style>
 .form-container {
  
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Adjustments for larger screens */
@media (min-width: 768px) {
    .form-container {
        max-width: 100%; /* Wider on tablets and larger screens */
    }
}

@media (min-width: 992px) {
    .form-container {
        max-width: 70%; /* Even wider on desktops */
    }
}

    .form-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .form-container label {
        font-weight: bold;
    }

    .form-container input[type="text"], .form-container textarea {
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
    }

    .form-container button:hover {
        background-color: #218838;
    }

    .gallery-images img {
        width: 100px;
        height: auto;
        margin: 10px;
        border-radius: 5px;
    }

    .gallery-images .delete-image {
        display: inline-block;
        margin-top: 5px;
        color: red;
        cursor: pointer;
    }
     .panel-heading {
        background-color: #5b4282;
        color: white;
        padding: 15px;
        text-align: center;
    }
/* File input wrapper styling */
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

.file-input-label::after {
    content: "";
    display: inline-block;
    margin-left: 8px;
    vertical-align: middle;
}

        /* Button Styles */
        .button {
            position: relative;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            display: inline-block;
            font-size: 14px;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
            color: #fff;
            margin-bottom: 10px;
            background-color: #6559C7;
        }

     
       .button {
     --background: #6559C7;
    --background-hover: #1e2235;
    --text: #fff;
    --shadow: rgba(0, 9, 61, .2);
    --paper: var(--background);
    --paper-lines: #fff;
    --trash: #e1e6f9;
    --trash-lines: #bbc1e1;
    --check: #fff;
    --check-background: var(--background);
    position: relative;
    border: none;
    outline: none;
    text-align: center;
    background: none;
    padding: 10px 20px; /* Adjust padding to match the update button */
    border-radius: 7px;
    min-width: 20px; /* Adjust to the desired width */
    max-width: 120px; /* Ensure max-width is between 30px and desired width */
    box-sizing: border-box; /* Ensure padding and border are included in the width */
    -webkit-appearance: none;
    -webkit-tap-highlight-color: transparent;
    cursor: pointer;
    display: flex;
    color: var(--text);
    background: var(--btn, var(--background));
    box-shadow: 0 var(--shadow-y, 4px) var(--shadow-blur, 8px) var(--shadow);
    transform: scale(var(--scale, 1));
    transition: transform 0.3s, box-shadow 0.3s, background 0.3s;
        }
        .button:before, .button:after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: transparent; /* Adjust as needed */
    z-index: -1; /* Ensure they stay behind the button text */
}

.button span {
     display: block;
    font-size: 14px;
    line-height: 25px;
    font-weight: 600;
    opacity: var(--span-opacity, 1);
    transform: translateX(var(--span-x, 0)) translateZ(0);
    transition: transform 0.4s ease var(--span-delay, 0.2s), opacity 0.3s ease var(--span-delay, 0.2s);
}


table.dataTable tbody th, table.dataTable tbody td {
    padding: 8px 10px 30px 20px !important;
}
    .update{
        min-width: 20px;
        max-width: 120px;
    }
    
    /* Button Click Animation */
.button.update {
    position: relative;
    background-color: #28a745; /* Green color for update button */
    color: #fff;
    border: none;
    border-radius: 7px;
    padding: 10px 20px;
    cursor: pointer;
    text-align: center;
    display: inline-block;
    text-decoration: none;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.button.update.animate {
    animation: buttonClick 0.5s forwards;
}

@keyframes buttonClick {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.1);
        opacity: 0.8;
    }
    100% {
        transform: scale(1);
        opacity: 0;
    }
}

</style>

<div class="main-content" style="padding:100px;">
     <a href="gallery.php" style="margin-left:80px;margin-top:20px;">
                <i class="fa-solid fa-circle-chevron-left fa-2x"></i>
            </a>
    <div class="container-fluid">
        
        <div class="form-container">
            
            <div class="panel-heading" style="margin-bottom:20px;">
                <h3 class="panel-title">
                    <i class="fa-solid fa-user"></i> Gallery Info
                </h3>
            </div>

            <?php if (isset($success_message)): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php elseif (isset($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data">
                <label for="name">Gallery Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($gallery_name); ?>" required>

                <label for="descr">Gallery Description:</label>
                <textarea id="descr" name="descr" rows="5" required><?php echo $gallery_descr; ?></textarea>

                <div class="gallery-images">
                    <label for="current-images">Current Images:</label><br>
                    <?php foreach ($images as $image): ?>
                        <div>
                            <img src="images/<?php echo $image['g_img']; ?>" alt="Gallery Image">
                            <input type="checkbox" name="delete_images[]" value="<?php echo $image['id']; ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
<button type="submit" name="delete_selected" class="button">
                   <div class="trash">
            <div class="top">
                <div class="paper"></div>
            </div>
            <div class="box"></div>
            <div class="check">
                <svg viewBox="0 0 8 6">
                    <polyline points="1 3.4 2.71428571 5 7 1"></polyline>
                </svg>
            </div>
        </div>
        <span>Delete</span>
    </button>
                <!-- File Upload Input -->
                <div class="file-input-wrapper">
                    <input type="file" id="new-images" name="new_images[]" multiple>
                    <span id="file-names" class="file-input-label">Choose New Files</span>
                </div>

                <button type="submit" class="btn btn-primary form-control">Update Gallery</button>
                
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('new-images').addEventListener('change', function(event) {
        var input = event.target;
        var fileNames = Array.from(input.files).map(file => file.name).join(', ');
        var label = document.getElementById('file-names');
        label.textContent = fileNames || 'Choose Files';
    });
</script>



<?php include("footer.php"); ?>