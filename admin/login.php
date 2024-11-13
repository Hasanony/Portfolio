<?php
session_start();
include('db.php'); // Include your database connection file

// Redirect if the user is already logged in
if (isset($_SESSION['admin_email'])) {
    header('Location: index.php');
    exit();
}

// Handle login request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['admin_email'];
    $password = $_POST['admin_pass'];

    // Sanitize inputs to prevent SQL injection
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Fetch the user from the database
    $query = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    // Check if user exists
    if (mysqli_num_rows($result) > 0) {
        // User found, create session
        $_SESSION['admin_email'] = $email;
        echo json_encode(['success' => true]);
    } else {
        // Invalid credentials
        echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Panel</title>
    <link rel="stylesheet" href="css/bootstrap-337.min.css">
    <link rel="stylesheet" href="css/login.css">
    <style>
        body {
            background-image: url('images/u.gif'); /* Ensure correct file path */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .form-login {
            background-color: rgba(255, 255, 255, 0.7); /* Semi-transparent */
            padding: 60px;
            border-radius: 10px;
            box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.1);
            min-width: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
            backdrop-filter: blur(5px); /* Background blur */
        }

        .form-login-heading {
            font-size: 24px;
            margin-bottom: 30px;
            text-align: center;
            color: #007bff;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 15px;
            border-radius: 30px;
            font-size: 18px;
            width: 100%;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
            width: 100%;
        }

        .input-group_input {
            padding: 10px;
            border: 1px solid black;
            border-radius: 4px;
            width: 100%;
            font-size: 16px;
        }

        .input-group_label {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #000;
            background-color: #f8f9fa;
            padding: 0 5px;
        }

        .input-group_input:focus + .input-group_label {
            top: -10px;
            transform: translateY(0);
            font-size: 12px;
        }
    </style>
</head>
<body>
   <div class="container">
       <form id="loginForm" class="form-login" method="post">
           <h2 class="form-login-heading">Admin Login</h2>
           
           <div class="input-group">
               <input type="text" id="adminEmail" name="admin_email" class="form-control input-group_input" required>
               <label for="adminEmail" class="input-group_label">Email Address</label>
           </div>

           <div class="input-group">
               <input type="password" id="adminPassword" name="admin_pass" class="form-control input-group_input" required>
               <label for="adminPassword" class="input-group_label">Your Password</label>
           </div>

           <button type="button" class="btn btn-lg btn-primary btn-block" onclick="handleLogin()">Login</button>
       </form>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script>
      function handleLogin() {
          const email = document.getElementById('adminEmail').value;
          const password = document.getElementById('adminPassword').value;
          
          // Validate inputs
          if (!email || !password) {
              Swal.fire('Error', 'Please enter both email and password.', 'error');
              return;
          }
          
          // Perform login via AJAX
          fetch('login.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/x-www-form-urlencoded'
              },
              body: `admin_email=${encodeURIComponent(email)}&admin_pass=${encodeURIComponent(password)}`
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  Swal.fire({
                      icon: 'success',
                      title: 'Logged in successfully!',
                      timer: 1500,
                      showConfirmButton: false
                  }).then(() => {
                      window.location.href = 'index.php';
                  });
              } else {
                  Swal.fire('Error', data.message, 'error');
              }
          })
          .catch(error => {
              Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
              console.error('Error:', error);
          });
      }
   </script>
</body>
</html>
