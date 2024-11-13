<?php
$active="social.php";
include("db.php");

// Initialize variables with default values
$facebook = $w_app = $c_code = $insta = $ytube = $w_link = '';

// Check if we need to fetch the existing contact info
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Assuming $conn is your database connection
    $c_id = 1; // Replace with actual id as needed
    
    // Fetch existing social info
    $sql = "SELECT facebook, w_app, insta, ytube,w_link FROM social WHERE id = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $c_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $facebook, $w_app, $insta, $ytube,$w_link);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing the statement: " . mysqli_error($conn);
    }
}
?>

<?php include("sidebar.php");?>
 <style>
        /* Loader Circle */
        .loading-circle {
            position: absolute;
            top: 25%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-top: 4px solid rgba(0, 0, 0, 0.47);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    /* Centering the form container */
        .container {
            margin-top: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }

        .panel {
            width: 100%;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Adding a subtle box shadow */
            border-radius: 8px;
            overflow: hidden;
        }

        .panel-heading {
            background-color: #5b4282; /* Custom header background */
            color: white;
            padding: 15px;
            text-align: center;
        }

        .panel-body {
            padding: 30px;
            background-color: #fff; /* White background for form body */
            
        }
     .form-horizontal{
         left:30px;
     }

        /* Loader Circle */
        .loading-circle {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 30px;
            height: 30px;
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-top: 4px solid rgba(0, 0, 0, 0.47);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Button Styling */
        .btn-primary {
            background-color: #5b4282; /* Custom button color */
            border-color: #5b4282;
        }

        .btn-primary:hover {
            background-color: #472e63;
            border-color: #472e63;
        }
     
     
    </style>
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    
<div class="container">
    
    <!-- Add Slide Form -->
    <div class="panel panel-default">
       
        <div class="panel-heading">
            <h3 class="panel-title">
                
                <i class="fa-solid fa-shoe-prints"></i> Footer
            </h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" id="updateSocialForm" method="post">
    <div class="form-group">
        <label class="col-md-3 control-label"> <i class="fa-brands fa-facebook"></i> Facebook</label>
        <div class="col-md-12">
            <input name="facebook" type="text" class="form-control" value="<?php echo $facebook; ?>" required>
        </div>
    </div>

<div class="form-group mt-3 row">
    <label class="col-md-3 col-form-label"> <i class="fa-brands fa-whatsapp"></i> WhatsApp</label>
    
    <div class="col-md-4">
        <select name="c_code" class="form-control" required>
            <option value="+1" <?php if($c_code == '+1') echo 'selected'; ?>>+1 (USA)</option>
            <option value="+44" <?php if($c_code == '+44') echo 'selected'; ?>>+44 (UK)</option>
            <option value="+91" <?php if($c_code == '+91') echo 'selected'; ?>>+91 (India)</option>
            <option value="+61" <?php if($c_code == '+61') echo 'selected'; ?>>+61 (Australia)</option>
            <option value="+88" <?php if($c_code == '+88') echo 'selected'; ?>>+88 (Bangladesh)</option>
            <option value="+49" <?php if($c_code == '+49') echo 'selected'; ?>>+49 (Germany)</option>
            <option value="+33" <?php if($c_code == '+33') echo 'selected'; ?>>+33 (France)</option>
            <!-- Add more country codes as needed -->
        </select>
    </div>

    <div class="col-md-5">
        <input name="w_app" type="text" class="form-control" value="<?php echo $w_app; ?>" required>
    </div>
</div>

    <div class="form-group mt-3">
        <label class="col-md-3 control-label"> <i class="fa-brands fa-instagram"></i> Instagram</label>
        <div class="col-md-12">
            <input name="insta" type="text" class="form-control" value="<?php echo $insta; ?>" required>
        </div>   
    </div>
    
    <div class="form-group mt-3">
        <label class="col-md-3 control-label"> <i class="fa-brands fa-youtube"></i> YouTube</label>
        <div class="col-md-12">
            <input name="ytube" type="text" class="form-control" value="<?php echo $ytube; ?>" required>
        </div>
    </div>    
                
    <div class="form-group mt-3">
        <label class="col-md-3 control-label"> <i class="fa-brands fa-youtube"></i> Website Link</label>
        <div class="col-md-12">
            <input name="w_link" type="text" class="form-control" value="<?php echo $w_link; ?>" required>
        </div>
    </div>


    <div class="form-group mt-4">
        <div class="col-md-12">
            <input type="submit" class="btn btn-primary form-control" value="Update">
        </div>
    </div>
</form>


            <!-- Loader Circle (Hidden initially) -->
            <div class="loading-circle" id="loadingCircle" style="display: none;"></div>
        </div>
    </div>
</div>
                </div>
            </div>
        </div>
</div>

<?php

// Initialize variables
$facebook = $w_app = $insta = $ytube = $descr = "";

// Fetch existing values from the database
$sql = "SELECT * FROM social WHERE id = 1"; // Replace '1' with the actual id or criteria
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $facebook = $row['facebook'];
    $w_app = $row['w_app'];
    $insta = $row['insta'];
    $ytube = $row['ytube'];
    $w_link = $row['w_link'];

}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $facebook = mysqli_real_escape_string($conn, $_POST['facebook']);
    $w_app = mysqli_real_escape_string($conn, $_POST['w_app']);
    $insta = mysqli_real_escape_string($conn, $_POST['insta']);
    $ytube = mysqli_real_escape_string($conn, $_POST['ytube']);
     $c_code = mysqli_real_escape_string($conn, $_POST['c_code']); // Get the selected country code
      $w_link =  mysqli_real_escape_string($conn, $_POST['w_link']);

    // Prepare the SQL update query
    $sql = "UPDATE social SET facebook = ?, w_app = ?, insta = ?, ytube = ?,c_code=?,w_link=? WHERE id = 1"; // Replace '1' with the actual id or criteria

    // Initialize a prepared statement
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'ssssss', $facebook, $w_app, $insta, $ytube,$c_code,$w_link);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
               echo "<script>
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Social information has been updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = 'social.php';
                    });
                </script>";
        } else {
            // Handle query execution failure
              echo "<script>
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Error updating Social information: ',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = 'social.php';
                    });
                </script>". mysqli_error($conn);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Handle preparation error
        echo "Error preparing the statement: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
  <?php include("footer.php");?>
<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Custom JavaScript -->
<script>
 $(document).ready(function(){
  $("#menu-toggle").click(function(e){
    e.preventDefault();
    $("#wrapper").toggleClass("menuDisplayed");
  });
});

</script>



<!-- JavaScript for form handling -->
<script>
    document.getElementById('addSlideForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission

        var form = this;
        var submitButton = form.querySelector('input[type="submit"]');

        // Disable the submit button and show loader
        submitButton.disabled = true;
        document.getElementById('loadingCircle').style.display = 'block';

        // Simulate form submission delay
        setTimeout(function () {
            submitButton.disabled = false; // Re-enable the submit button
            document.getElementById('loadingCircle').style.display = 'none'; // Hide loader

            // Show a success message
            alert('Slide has been added successfully!');

            // Reset form
            form.reset();
        }, 2000); // Simulating a 2-second delay
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/ionicons/7.4.0/esm/ionicons.min.js"></script>
