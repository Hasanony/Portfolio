<?php
$active = "about.php";
include("db.php");

// Initialize variables with default values
$f_name = $l_name = $age = $nation = $address = $phone = $email = $language = $facebook = $wsapp = '';

// Check if we need to fetch the existing about info
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Assuming $conn is your database connection
    $a_id = 1; // Replace with actual a_id as needed
    
    // Fetch existing about info
    $sql = "SELECT f_name, l_name, age, nation, address, phone, email, language, facebook, wsapp FROM about WHERE a_id = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $a_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $f_name, $l_name, $age, $nation, $address, $phone, $email, $language, $facebook, $wsapp);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing the statement: " . mysqli_error($conn);
    }
}
?>

<?php include("sidebar.php"); ?>

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
 width:100%;
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
            <div class="col-lg-12">
             
                <div class="container">
                    <!-- About Info Form -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa-solid fa-user"></i> About Info
                            </h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="updateAboutForm" method="post">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">First Name</label>
                                    <div class="col-md-12">
                                        <input name="f_name" type="text" class="form-control" 
                                            value="<?php echo htmlspecialchars($f_name); ?>" required>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="col-md-3 control-label">Last Name</label>
                                    <div class="col-md-12">
                                        <input name="l_name" type="text" class="form-control" 
                                            value="<?php echo htmlspecialchars($l_name); ?>" required>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="col-md-3 control-label">Age</label>
                                    <div class="col-md-12">
                                        <input name="age" type="number" class="form-control" 
                                            value="<?php echo htmlspecialchars($age); ?>" required>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="col-md-3 control-label">Nationality</label>
                                    <div class="col-md-12">
                                        <input name="nation" type="text" class="form-control" 
                                            value="<?php echo htmlspecialchars($nation); ?>" required>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="col-md-3 control-label">Address</label>
                                    <div class="col-md-12">
                                        <input name="address" type="text" class="form-control" 
                                            value="<?php echo htmlspecialchars($address); ?>" required>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="col-md-3 control-label">Phone</label>
                                    <div class="col-md-12">
                                        <input name="phone" type="text" class="form-control" 
                                            value="<?php echo htmlspecialchars($phone); ?>" required>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="col-md-3 control-label">Email</label>
                                    <div class="col-md-12">
                                        <input name="email" type="email" class="form-control" 
                                            value="<?php echo htmlspecialchars($email); ?>" required>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="col-md-3 control-label">Language</label>
                                    <div class="col-md-12">
                                        <input name="language" type="text" class="form-control" 
                                            value="<?php echo htmlspecialchars($language); ?>" required>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="col-md-3 control-label">Facebook</label>
                                    <div class="col-md-12">
                                        <input name="facebook" type="text" class="form-control" 
                                            value="<?php echo htmlspecialchars($facebook); ?>" required>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="col-md-3 control-label">WhatsApp</label>
                                    <div class="col-md-12">
                                        <input name="wsapp" type="text" class="form-control" 
                                            value="<?php echo htmlspecialchars($wsapp); ?>" required>
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

                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Get form data
                    $f_name = mysqli_real_escape_string($conn, $_POST['f_name']);
                    $l_name = mysqli_real_escape_string($conn, $_POST['l_name']);
                    $age = mysqli_real_escape_string($conn, $_POST['age']);
                    $nation = mysqli_real_escape_string($conn, $_POST['nation']);
                    $address = mysqli_real_escape_string($conn, $_POST['address']);
                    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
                    $email = mysqli_real_escape_string($conn, $_POST['email']);
                    $language = mysqli_real_escape_string($conn, $_POST['language']);
                    $facebook = mysqli_real_escape_string($conn, $_POST['facebook']);
                    $wsapp = mysqli_real_escape_string($conn, $_POST['wsapp']);

                    // Assuming the about ID is known (replace with actual a_id as needed)
                    $a_id = 1;

                    // Update query
                    $sql = "UPDATE about SET f_name = ?, l_name = ?, age = ?, nation = ?, address = ?, phone = ?, email = ?, language = ?, facebook = ?, wsapp = ? WHERE a_id = ?";

                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        mysqli_stmt_bind_param($stmt, 'ssisssssssi', $f_name, $l_name, $age, $nation, $address, $phone, $email, $language, $facebook, $wsapp, $a_id);
                        if (mysqli_stmt_execute($stmt)) {
                            echo "<script> Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Personal info has been updated successfully!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(function() {
                                        window.location.href = 'about.php';
                                    });</script>";
                        } else {
                            echo "Error executing the statement: " . mysqli_error($conn);
                        }
                        mysqli_stmt_close($stmt);
                    } else {
                        echo "Error preparing the statement: " . mysqli_error($conn);
                    }
                }
                ?>

            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('updateAboutForm').addEventListener('submit', function() {
        document.getElementById('loadingCircle').style.display = 'block'; // Show loader on form submission
    });
</script>

                <?php include("footer.php"); ?>