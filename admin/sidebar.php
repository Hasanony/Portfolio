<?php


session_start();
if (!isset($_SESSION['admin_email'])) {
    header('Location: login.php');
    exit();
}
include("db.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
     <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
 <link href="css/jquery.bxslider.min.css" rel="stylesheet">
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/owl.theme.default.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <link href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
     <link href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="styles.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
     <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDXN8boGL5PKTsORieuerJr4wHoPtPN_gc&callback=console.debug&libraries=maps,marker&v=beta">
    </script>
    <script src="https://cdn.tiny.cloud/1/phs5tez8r6jtzyxx4n4njc1v3p88hvdm5flhrw4spt67kw2m/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <style>
 

        .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
  border: none !important;
}
.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
  padding: 8px;
  
  vertical-align: middle;
  border-top: none !important;
}


        ul#sidebar-menu {
            position: fixed;
        top: 180px;
        bottom: 0;
        width: 220px;
        overflow-y: auto;
        overflow-x: hidden;
        padding-bottom: 40px;
        border-radius: 0;
    }
        
    </style>
</head>
<body>
  <div class="sidebar">
    <div class="sidebar-header">
        <h2>Admin Panel</h2>
        <div class="toggle-button" id="menu-toggle">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
    </div>
    <div class="welcome-section">
              <?php

// Fetch the user data
$sql = "SELECT name, pic FROM home WHERE h_id = 1"; // Change h_id to match your desired user
$result = $conn->query($sql);

$user = $result->fetch_assoc(); // Fetch the user data as an associative array

// Check if user data is fetched
if ($user) {
    $name = htmlspecialchars($user['name']); // Sanitize output
    $pic = htmlspecialchars($user['pic']);
} else {
    $name = "User";
    $job = "Position";
}


?>
        <img src="images/<?php echo $pic; ?>" alt="Profile Image" class="profile-image">
        <h3 style="
            background: linear-gradient(40deg, #F42A41, #006A4E); 
            -webkit-background-clip: text; 
            -webkit-text-fill-color: transparent;">
            Welcome! <span><?php echo $name; ?></span>
        </h3>
    </div><script src="https://cdn.tiny.cloud/1/phs5tez8r6jtzyxx4n4njc1v3p88hvdm5flhrw4spt67kw2m/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
   <ul id="sidebar-menu">
    <li><a href="index.php" class="<?php if($active=='index.php') echo 'active'; ?>">Dashboard</a></li>
    <li><a href="home.php" class="<?php if($active=='home.php') echo 'active'; ?>">Home</a></li>

    <!-- Dropdown for About -->
    <li class="dropdown">
        <a href="#about" class="dropdown-toggle <?php if($active=='about.php'||$active=='achive.php') echo 'active'; ?>">About</a>
        <ul class="dropdown-content">
            <li><a href="about.php" class="<?php if($active=='about.php') echo 'active'; ?>">About</a></li>
            <li><a href="achive.php" class="<?php if($active=='achive.php') echo 'active'; ?>">Achievements</a></li>
        </ul>
    </li>

    <li><a href="gallery.php" class="<?php if($active=='gallery.php') echo 'active'; ?>">Gallery</a></li>
           <li class="dropdown">
        <a href="#contact" class="dropdown-toggle <?php if($active=='social.php'||$active=='contact.php') echo 'active'; ?>">Contact</a>
        <ul class="dropdown-content">
            <li><a href="social.php" class="<?php if($active=='social.php') echo 'active'; ?>">Social</a></li>
            <li><a href="contact.php" class="<?php if($active=='contact.php') echo 'active'; ?>">Contact</a></li>
        </ul>
    </li>
       

    <li><a href="column.php" class="<?php if($active=='column.php') echo 'active'; ?>">Columns</a></li>
    <li><a href="award.php" class="<?php if($active=='award.php') echo 'active'; ?>">Awards</a></li>
    <li><a href="book.php" class="<?php if($active=='book.php') echo 'active'; ?>">Books</a></li> 
          <li class="dropdown">
        <a href="#video" class="dropdown-toggle <?php if($active=='video.php'||$active=='publisher.php') echo 'active'; ?>">Video</a>
        <ul class="dropdown-content">
            <li><a href="video.php" class="<?php if($active=='video.php') echo 'active'; ?>">Videos</a></li>
            <li><a href="publisher.php" class="<?php if($active=='publisher.php') echo 'active'; ?>">Publisher</a></li>
        </ul>
    </li>
       <li><a href="logout.php">Logout</a></li>
</ul>


    </div>
  

