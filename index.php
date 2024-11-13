<?php
include("admin/db.php"); // Ensure your database connection is properly set up in db.php

// Initialize variables for 'home' table
$name = $job = $descr = $pic = '';

// Fetch existing home info
$h_id = 1; // Replace with the actual h_id if needed

$sql_home = "SELECT name, job, descr, pic FROM home WHERE h_id = ?";
if ($stmt = mysqli_prepare($conn, $sql_home)) {
    mysqli_stmt_bind_param($stmt, 'i', $h_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name, $job, $descr, $pic);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
} else {
    echo "Error preparing the statement: " . mysqli_error($conn);
}

// Initialize variables for 'personal_info' table
$f_name = $l_name = $age = $nation = $address = $phone = $email = $language = $facebook = $wsapp = '';

// Fetch data from the 'personal_info' table
$sql_personal_info = "SELECT * FROM about WHERE a_id = 1"; // Replace '1' with the desired record ID
$result = mysqli_query($conn, $sql_personal_info);

if ($result) {
    $row = mysqli_fetch_assoc($result); // Fetch the data as an associative array
    if ($row) {
        // Sanitize output to prevent XSS attacks
        $f_name = htmlspecialchars($row['f_name']);
        $l_name = htmlspecialchars($row['l_name']);
        $age = htmlspecialchars($row['age']);
        $nation = htmlspecialchars($row['nation']);
        $address = htmlspecialchars($row['address']);
        $phone = htmlspecialchars($row['phone']);
        $email = htmlspecialchars($row['email']);
        $language = htmlspecialchars($row['language']);
        $facebook = htmlspecialchars($row['facebook']);
        $wsapp = htmlspecialchars($row['wsapp']);
    }
} else {
    echo "Error fetching data: " . mysqli_error($conn);
}
?><!doctypehtml><html lang=en><meta charset=utf-8><meta content="width=device-width,initial-scale=0.8"name=viewport><meta content="Mir Abdul Alim"property=og:title><meta content="Mir Abdul Alim"property=og:description><meta content=website property=og:type><meta content="admin/images/<?php echo htmlspecialchars($pic); ?>"property=og:image><meta content=300 property=og:image:width><meta content=300 property=og:image:height><meta content=http://mirabdulalim.com/ property=og:url><meta content=Summary_large_image name=twitter:card><meta content=Logo name=twitter:image:alt><link href=admin/images/l1.png rel="shortcut icon"type=image/png><title><?php echo htmlspecialchars($name); ?></title><meta content="width=device-width,initial-scale=1"name=viewport><link href="https://fonts.googleapis.com/css?family=Poppins:400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"rel=stylesheet><link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,600i,700"rel=stylesheet><link href=css/bootstrap.min.css rel=stylesheet><link href=css/component.css rel=stylesheet><link href=css/circle.css rel=stylesheet><link href=https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css rel=stylesheet><link href=css/style.css rel=stylesheet><link href=css/skins/yellow.css rel=stylesheet><link href=css/skins/blue.css rel="alternate stylesheet"title=blue><link href=css/skins/green.css rel="alternate stylesheet"title=green><link href=css/skins/yellow.css rel="alternate stylesheet"title=yellow><link href=css/skins/blueviolet.css rel="alternate stylesheet"title=blueviolet><link href=css/skins/goldenrod.css rel="alternate stylesheet"title=goldenrod><link href=css/skins/magenta.css rel="alternate stylesheet"title=magenta><link href=css/skins/orange.css rel="alternate stylesheet"title=orange><link href=css/skins/purple.css rel="alternate stylesheet"title=purple><link href=css/skins/red.css rel="alternate stylesheet"title=red><link href=css/skins/yellowgreen.css rel="alternate stylesheet"title=yellowgreen><link href=css/styleswitcher.css rel=stylesheet><script src=js/modernizr.min.js></script><script src=https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js></script><script src=https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.34/moment-timezone-with-data.min.js></script><script src=https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.34/moment-timezone-with-data.min.js></script><script src=https://cdnjs.cloudflare.com/ajax/libs/moment-timeago/4.0.2/moment-timeago.min.js></script><script>var scrollInterval,originalTitle="<?php echo htmlspecialchars($name); ?>",attentionTitle="Come back!😞",scrollTitle=attentionTitle+" ";function showAttentionTitle(){var t=0;scrollInterval=setInterval(function(){document.title=scrollTitle.substring(t)+scrollTitle.substring(0,t),t=(t+1)%scrollTitle.length},200)}function restoreOriginalTitle(){clearInterval(scrollInterval),document.title=originalTitle}document.addEventListener("visibilitychange",function(){document.hidden?showAttentionTitle():restoreOriginalTitle()})</script><style>.about{margin-bottom:40px}.e-box{position:relative;overflow:hidden;transition:color .3s ease}.e-box::before{content:'';position:absolute;top:0;left:0;width:100%;height:100%;background-color:#e3e3e3;z-index:-1;transition:transform .5s ease;transform:scaleX(0);transform-origin:left}.e-box:hover::before{transform:scaleX(1)}.e-box:hover{color:#fff;background-color:rgba(11,100,100,.28)}.e-box:hover h3{color:#ff5733;transform:scale(1.1);transition:color .3s ease,transform .3s ease}figure.scrollable{overflow-y:auto;padding:10px;border:1px solid #ddd}figure.scrollable img{max-width:100%;margin-bottom:10px}.scrollable figcaption{text-align:center;margin-top:10px}.videocontainer{position:relative;display:inline-block;width:auto}.slideshow-image{display:block;width:100%}.nav-next-image,.nav-prev-image{position:absolute;top:50%;transform:translateY(-50%);background-color:rgba(0,0,0,.5);color:#fff;border:none;outline:0;padding:10px 20px;cursor:pointer;font-size:16px;z-index:10;transition:background-color .3s ease}.nav-next-image:hover,.nav-prev-image:hover{color:rgba(96,7,7,.8)}.nav-next-image:focus,.nav-prev-image:focus{outline:0}.nav-prev-image{left:10px;background:0 0}.nav-next-image{right:10px;background:0 0}.facebook{display:inline-block;height:40px;width:40px;line-height:42px;text-align:center;color:#fff;transition:.3s;font-size:17px;margin:0 6px;background:#4267b2;border-radius:50%;color:#fff;border-radius:50%}.whatsapp{display:inline-block;height:40px;width:40px;line-height:42px;text-align:center;color:#fff;transition:.3s;font-size:17px;margin:0 6px;background:#00ff58;color:#fff;border-radius:50%}.youtube{display:inline-block;height:40px;width:40px;line-height:42px;text-align:center;color:#fff;transition:.3s;font-size:17px;margin:0 6px;background:red;color:#fff;border-radius:50%}.insta{display:inline-block;height:40px;width:40px;line-height:42px;text-align:center;color:#fff;transition:.3s;font-size:17px;margin:0 6px;background:linear-gradient(to right,#833ab4,#fd1d1d,#fcb045);color:#fff;border-radius:50%}button.btn-primary{font-size:19px;font-family:Pacifico;border-radius:3px;position:relative;padding-right:30px;background:linear-gradient(to bottom,#ecfbff 50%,#a6e0ee 50%);background-size:100% 200%;background-position:top;border:none;color:#9b0101!important;display:block;margin:20px auto;height:60px;width:200px;cursor:pointer;text-align:center;transition:background-position .6s ease}button.btn-primary:hover{background-position:bottom;color:#f85454!important}button svg{position:absolute;top:13px;right:25px;height:30px;width:auto;color:#fff!important;transition:transform .15s,color 1s ease}button.processing{background-color:#cff5b3;border:2px solid #cff5b3;color:#6aaa3b;padding-right:6px;cursor:default}button.processing p{display:none}button.processing::after{content:"Please wait...";display:block;color:#6aaa3b;font-size:19px}button.clicked{background-color:#cff5b3;border:2px solid #cff5b3;color:#fff;padding-right:6px;cursor:default}button.clicked p{display:none}button.clicked::after{content:"Sent!";color:#4b9812;font-size:19px}button.clicked svg{animation:flyaway 1.3s linear;top:-80px;right:-1000px}@keyframes flyaway{0%{transform:rotate(10deg);top:13px;right:25px;height:30px}5%{transform:rotate(10deg);top:13px;right:0;height:30px}20%{transform:rotate(-20deg);top:13px;right:-130px;height:45px}40%{transform:rotate(10deg);top:-40px;right:-280px;opacity:1}100%{transform:rotate(60deg);top:-200px;right:-1000px;height:0;opacity:0}}@keyframes bounce-in{0%{padding-right:30px}40%{padding-right:6px}50%{padding-left:30px}100%{padding-left:6px}}.card{transition:all .3s ease-in-out;border-radius:10px;box-shadow:0 4px 12px rgba(0,0,0,.1)}.card:hover{transform:translateY(-5px);box-shadow:0 6px 15px rgba(0,0,0,.2)}.post-thumb img{height:400px;object-fit:cover;width:100%;border-top-left-radius:10px;border-top-right-radius:10px}.image-overlay{position:absolute;top:0;left:0;width:100%;height:100%;background-color:rgba(0,0,0,.4);opacity:0;transition:opacity .3s ease-in-out}.post-thumb:hover .image-overlay{opacity:1}.card-title{font-size:1rem;font-weight:700;color:#333}.card-text{font-size:.95rem;color:#000}.text-muted{font-size:.85rem}.fa-calendar,.fa-clock{margin-right:5px}.container{padding-top:30px;padding-bottom:30px}.title-section h2{font-size:1.5rem}.title-section .title-bg{font-size:1.5rem}.post-container .card-title{font-size:1.3rem}.post-container .card-text{font-size:.85rem}.post-container .card-text .font-weight-600{font-size:1.5rem}.post-container .card-text a{font-size:1.25rem}.d-flex .text-center{font-size:.55rem}.award-title::before{content:"•";color:#000;font-size:2rem;display:inline-block;width:.2em;margin-right:.5em;vertical-align:middle}.awards .entry-header h5{color:#000;font-size:1.25rem;margin:0}@media (max-width:767px){.post-container{flex-direction:column;text-align:center}.post-thumb{margin-bottom:15px}.post-content{padding-left:0}}.post-container{background-color:#fff;border-radius:8px;box-shadow:0 4px 8px rgba(0,0,0,.1);overflow:hidden;transition:box-shadow .3s ease,transform .3s ease}.post-container:hover{box-shadow:0 8px 16px rgba(0,0,0,.2);transform:translateY(-5px)}.post-thumb img{width:100%;height:auto;border-bottom:1px solid #ddd}.post-content{padding:15px}.entry-header h3 a{color:#333;text-decoration:none}.entry-header h3 a:hover{text-decoration:underline}.entry-content p{color:#666;font-size:.9rem}.video-section .title-section h2 span{color:#f8b400}.videocontainer{position:relative;padding-bottom:56.25%;width:100%;height:70vh;object-fit:cover;overflow:hidden;max-width:100%;background:#000}.videocontainer iframe{position:absolute;top:0;left:0;width:100%;height:100%}.video-title{margin-top:10px}.video-title h4{font-size:1.2em;color:#333}.video-title p{font-size:.9em;color:#666}.video-info{margin-top:10px;padding:20px}.publisher,.time-posted,.video-title h4{font-size:16px}.video-title{text-align:left}.time-posted{text-align:right}.video-item{box-shadow:0 4px 15px rgba(0,0,0,.1);margin-top:30px}.btn-subscribe{display:inline-block;margin-top:20px;padding:10px 20px;background-color:red;color:#fff;text-transform:uppercase;font-weight:700;border-radius:5px;text-decoration:none;transition:background-color .3s ease}.btn-subscribe:hover{background-color:#c00;text-decoration:none;color:#fff}.v_d{width:100%;height:70vh;object-fit:cover}@media (max-width:768px){.video-item{margin-top:20px}.video-section .title-section h2{font-size:1.2em}.video-section .title-bg{font-size:.8em}.video-description{padding:10px}.btn-see-more{font-size:.9em}.v_d{width:100%;height:40vh;object-fit:cover}.videocontainer{width:100%!important;height:60vh!important;object-fit:cover!important}}@media (max-width:480px){.video-title h4{font-size:.9em}.time-posted,.video-title p{font-size:.7em}.btn-subscribe{padding:6px 12px;font-size:.8em}}</style><body class="dark home-page"><header class=header id=navbar-collapse-toggle><ul class="d-lg-block d-none icon-menu"id=desktop-nav><li class="desktop-nav-element icon-box active"><i class="fa fa-home"></i><div><h2>Home</h2></div><li class="desktop-nav-element icon-box"><i class="fa fa-user"></i><div><h2>About</h2></div><li class="desktop-nav-element icon-box"><i class="fa fa-solid fa-image"></i><div><h2>Gallery</h2></div><li class="desktop-nav-element icon-box"><i class="fa fa-envelope-open"></i><div><h2>Contact</h2></div><li class="desktop-nav-element icon-box"><i class="fa fa-solid fa-pen-nib"></i><div><h2>Columns</h2></div><li class="desktop-nav-element icon-box"><i class="fa fa-trophy"></i><div><h2>Awards</h2></div><li class="desktop-nav-element icon-box"><i class="fa fa-book"></i><div><h2>Books</h2></div><li class="desktop-nav-element icon-box"><i class="fa fa-video"></i><div><h2>Video</h2></div></ul><nav class="d-block d-lg-none"><div class=inputmobile id=inputmobile><div class=trigger-mobile id=trigger-mobile><span></span> <span></span> <span></span> বিস্তারিত</div><ul class=list-unstyled id=mobile-nav><li class="mobile-nav-element active home-link"><div><i class="fa fa-home"></i> <span>Home</span></div><li class=mobile-nav-element><div><i class="fa fa-user"></i> <span>About</span></div><li class=mobile-nav-element><div><i class="fa fa-solid fa-image"></i> <span>Gallery</span></div><li class=mobile-nav-element><div><i class="fa fa-envelope-open"></i> <span>Contact</span></div><li class=mobile-nav-element><div><i class="fa fa-solid fa-pen-nib"></i> <span>Columns</span></div><li class=mobile-nav-element><div><i class="fa fa-trophy"></i> <span>Awards</span></div><li class=mobile-nav-element><div><i class="fa fa-book"></i> <span>Books</span></div><li class=mobile-nav-element><div><i class="fa fa-video"></i> <span>Videos</span></div></ul></div></nav></header><div class=pages><div class="page page--current"id=home><div class=home><div class="container-fluid container-home main-container p-0"><div class="d-lg-block d-none color-block"></div><div class="row align-items-center home-details-container"><img alt=""src="admin/images/<?php echo htmlspecialchars($pic); ?>"class="d-lg-block d-none col-lg-4 position-fixed"style=width:1020px;height:746px><div class="col-12 col-lg-8 home-details offset-lg-4 text-left text-lg-left text-sm-center"><div><img alt="my picture"src="admin/images/<?php echo htmlspecialchars($pic); ?>"class="d-block d-lg-none d-sm-block img-fluid main-img-mobile"style=width:300px;height:300px><h1 class="text-uppercase poppins-font" style="color:black;"><?php echo htmlspecialchars($name); ?>. <span><?php echo htmlspecialchars($job); ?></span></h1><p class=open-sans-font><?php echo $descr; ?></p><a class=button id=link-about><span class=button-text>more about me</span> <span class="fa button-icon fa-arrow-right"></span></a></div></div></div></div></div></div><div class=page id=about><div class="text-left text-sm-center title-section"><h2 style=font-size:2.5rem>ABOUT <span>ME</span></h2><span class=title-bg style=font-size:4.5rem>Information</span></div><div class=about><div class=main-content><div class=container><div class=row><div class="col-12 col-xl-6 col-lg-5"><div class=row><div class=col-12><h3 class="text-uppercase custom-title ft-wt-600 mb-0">personal infos</h3></div><div class="d-block col-12 d-sm-none"><img alt="my picture"src="admin/images/<?php echo htmlspecialchars($pic); ?>"class="img-fluid main-img-mobile"></div><div class=col-6><ul class="open-sans-font about-list list-unstyled"><li><span class=title>First name :</span> <span class="d-block d-lg-block d-sm-inline-block d-xl-inline-block value"><?php echo $f_name; ?></span><li><span class=title>Last name :</span> <span class="d-block d-lg-block d-sm-inline-block d-xl-inline-block value"><?php echo $l_name; ?></span><li><span class=title>Age :</span> <span class="d-block d-lg-block d-sm-inline-block d-xl-inline-block value"><?php echo $age; ?>Years</span><li><span class=title>Nationality :</span> <span class="d-block d-lg-block d-sm-inline-block d-xl-inline-block value"><?php echo $nation; ?></span><li><span class=title>Address :</span> <span class="d-block d-lg-block d-sm-inline-block d-xl-inline-block value"><?php echo $address; ?></span></ul></div><div class=col-6><ul class="open-sans-font about-list list-unstyled"><li><span class=title>Phone :</span> <span class="d-block d-lg-block d-sm-inline-block d-xl-inline-block value"><?php echo $phone; ?></span><li><span class=title>Email :</span> <span class="d-block d-lg-block d-sm-inline-block d-xl-inline-block value"><?php echo $email; ?></span><li><span class=title>Facebook :</span> <span class="d-block d-lg-block d-sm-inline-block d-xl-inline-block value"><?php echo $facebook; ?></span><li><span class=title>What's App :</span> <span class="d-block d-lg-block d-sm-inline-block d-xl-inline-block value">><?php echo $wsapp; ?></span><li><span class=title>Languages :</span> <span class="d-block d-lg-block d-sm-inline-block d-xl-inline-block value"><?php echo $language; ?></span></ul></div></div></div><?php


// Fetch all the entries from the `ab_box` table
$query = "SELECT ab_id, number, descr FROM ab_box";
$result = mysqli_query($conn, $query);
$achievements = [];

// Store all the rows into an array
while ($row = mysqli_fetch_assoc($result)) {
    $achievements[] = $row;
}
?><div class="col-12 col-xl-6 col-lg-7 mt-5 mt-lg-0"><div class=row><?php foreach ($achievements as $achievement): ?><div class="col-6 e-box"><div class="box-stats with-margin"><h3 class="position-relative poppins-font"><?php echo htmlspecialchars($achievement['number']); ?></h3><p class="open-sans-font position-relative m-0 text-uppercase"><?php echo $achievement['descr']; ?></div></div><?php endforeach; ?></div></div></div></div></div></div></div><?php

// Fetch all galleries and their images using JOIN
$sql = "
    SELECT g.g_id, g.g_name, g.g_descr, gi.g_img
    FROM gallery g
    LEFT JOIN gallery_images gi ON g.g_id = gi.gallery_id
    ORDER BY g.g_id, gi.id
";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching galleries and images: " . mysqli_error($conn));
}

// Initialize arrays to hold gallery data
$galleries = [];

// Process the results
while ($row = mysqli_fetch_assoc($result)) {
    $galleryId = $row['g_id'];

    // Collect gallery details
    if (!isset($galleries[$galleryId])) {
        $galleries[$galleryId] = [
            'g_name' => $row['g_name'],
            'g_descr' => $row['g_descr'],
            'images' => []
        ];
    }

    // Collect images for the gallery
    if ($row['g_img']) {
        $galleries[$galleryId]['images'][] = $row['g_img'];
    }
}

?><div class=page id=portfolio><div class=portfolio><div class="text-left text-sm-center title-section"><h2 style=font-size:2.5rem>my <span>Gallery</span></h2><span class=title-bg style=font-size:4.5rem>Status</span></div><div class="main-content text-center"><div class="container grid-gallery"id=grid-gallery><div class=grid-wrap><ul class="row grid gridlist"><?php foreach ($galleries as $galleryId => $gallery): ?><li><figure><?php if (!empty($gallery['images'])): ?><img alt="Portfolio Image"src="admin/images/<?php echo $gallery['images'][0]; ?>"><div><span><?php echo htmlspecialchars($gallery['g_name']); ?></span></div><?php endif; ?></figure></li><?php endforeach; ?></ul></div><div class=slideshow><ul><?php foreach ($galleries as $galleryId => $gallery): ?><li class=l><figure class=scrollable><figcaption><div class="row open-sans-font"><h3 style=text-align:center><?php echo htmlspecialchars($gallery['g_name']); ?></h3></div></figcaption><h4>Description</h4><div><p><?php echo $gallery['g_descr']; ?></div><?php if (!empty($gallery['images'])): ?><div class=videocontainer><button class=nav-prev-image onclick="changeImage(<?php echo $galleryId; ?>,-1)"><img alt=previous src=img/projects/navigation/left-arrow.png></button> <img alt="Gallery Image"src="admin/images/<?php echo $gallery['images'][0]; ?>"class=slideshow-image style=height:60vh id="gallery-image-<?php echo $galleryId; ?>"> <button class=nav-next-image onclick="changeImage(<?php echo $galleryId; ?>,1)"><img alt=next src=img/projects/navigation/right-arrow.png></button></div><?php foreach ($gallery['images'] as $index => $image): ?><input type=hidden id="gallery-<?php echo $galleryId; ?>-image-<?php echo $index; ?>"value="admin/images/<?php echo $image; ?>"><?php endforeach; ?><?php endif; ?></figure></li><?php endforeach; ?><li><figure><figcaption><div class="row open-sans-font"><h3 style=text-align:center>Youtube Project</h3></div></figcaption><h4>Description</h4><div><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum varius purus id nunc cursus, ut feugiat ex facilisis. Morbi dapibus erat sed felis fringilla cursus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum varius purus id nunc cursus, ut feugiat ex facilisis. Morbi dapibus erat sed felis fringilla cursus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum varius purus id nunc cursus, ut feugiat ex facilisis. Morbi dapibus erat sed felis fringilla cursus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum varius purus id nunc cursus, ut feugiat ex facilisis. Morbi dapibus erat sed felis fringilla cursus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum varius purus id nunc cursus, ut feugiat ex facilisis. Morbi dapibus erat sed felis fringilla cursus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum varius purus id nunc cursus, ut feugiat ex facilisis. Morbi dapibus erat sed felis fringilla cursus.</div><div class=videocontainer><iframe allowfullscreen class=youtube-video src="https://www.youtube.com/embed/7e90gBu4pas?enablejsapi=1&version=3&playerapiid=ytplayer"></iframe></div></figure><li><figure><video class=responsive-video controls poster=img/projects/project-1.jpg id=video><source src=img/projects/video.mp4 type=video/mp4></video></figure></ul><nav><span class="icon nav-prev"style=font-size:18px;font-weight:700>Previous </span><span class="icon nav-next"style=font-size:18px;font-weight:700>Next </span><span class=nav-close><img alt=close src=img/projects/navigation/close-button.png></span></nav></div></div></div></div></div><?php

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);

    // Insert data into the 'contact' table
    $query = "INSERT INTO contact (name, email, subject, msz) VALUES ('$name', '$email', '$subject', '$message')";

    // Execute the query
    if ($conn->query($query) === TRUE) {
        // Success: Animation handles this part, so no echo
        exit();
    } else {
        // Optional: You can log errors for debugging purposes if needed
        // error_log("Error: " . $conn->error);
        exit();
    }
}


?><div class=page id=contact><div class=contact><div class="text-left text-sm-center title-section"><h2>get in <span>touch</span></h2><span class=title-bg>contact</span></div><div class=main-content><div class=container><div class=row><div class="col-12 col-lg-4"><h3 class="text-uppercase custom-title ft-wt-600 mb-0 pb-3">Don't be shy !</h3><p class="open-sans-font mb-3">Feel free to get in touch with me.<p class="open-sans-font position-relative custom-span-contact"><i class="fa fa-envelope-open position-absolute"></i> <span class=d-block>mail me</span><?php echo $email; ?><p class="open-sans-font position-relative custom-span-contact"><i class="fa position-absolute fa-phone-square"></i> <span class=d-block>call me</span><?php echo $phone; ?><ul class="list-unstyled mb-5 pt-1 social"><li class=facebook><a href=# title=Facebook><i class="fa fa-facebook"></i></a><li class=whatsapp><a href=# title=whatsapp><i class="fa fa-whatsapp"></i></a><li class=youtube><a href=# title=Youtube><i class="fa fa-youtube"></i></a><li class=insta><a href=# title=instagram><i class="fa fa-instagram"></i></a></ul></div><div class="col-12 col-lg-8"><form action=send_message.php class=contactform id=contact-form method=POST><div class=contactform><div class=row><div class="col-12 col-md-4"><input autocomplete=off name=name placeholder="YOUR NAME"required></div><div class="col-12 col-md-4"><input autocomplete=off name=email placeholder="YOUR EMAIL"required type=email></div><div class="col-12 col-md-4"><input autocomplete=off name=subject placeholder="YOUR SUBJECT"required></div><div class=col-12><textarea name=message placeholder="YOUR MESSAGE"required></textarea><div class=text-center><button class="btn btn-primary mt-3 py-3"id=submit-button type=submit><p id=button-text>Send</p><svg class="feather feather-send"fill=none id=send-svg stroke=#000000 stroke-linecap=round stroke-linejoin=round stroke-width=2 viewBox="0 0 24 24"xmlns=http://www.w3.org/2000/svg><line x1=22 x2=11 y1=2 y2=13></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg></button></div></div><div class="col-12 form-message"><span class="text-center font-weight-600 output_message text-uppercase"></span></div></div></div></form></div></div></div></div></div></div><script>document.getElementById("contact-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission

    const button = document.getElementById("submit-button");
    const buttonText = document.getElementById("button-text");
    const sendSvg = document.getElementById("send-svg");

    // Change button text to "Processing..."
    buttonText.innerText = "Processing...";
    
    // Send form data using AJAX (you can use jQuery's AJAX or Fetch API here)
    const formData = new FormData(this);

    fetch('send_message.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Message sent successfully
            buttonText.innerText = "Sent!";
            button.style.backgroundColor = "#FF5733";
            // Add animation to make SVG fly away
            sendSvg.style.transition = "transform 1s ease-in-out";
            sendSvg.style.transform = "translateX(900px) translateY(-400px) rotate(45deg)";

            // Keep "Sent!" for 3 seconds, then reset form and button
            setTimeout(() => {
                buttonText.innerText = "Send";
                sendSvg.style.transform = "translateX(0) translateY(0) rotate(0deg)";
                document.getElementById("contact-form").reset();
            }, 3000);
        } else {
            buttonText.innerText = "Send"; // Reset to "Send" on failure
            alert(data.error); // Show error message
        }
    })
    .catch(error => {
        console.error('Error:', error);
        buttonText.innerText = "Send"; // Reset on failure
        alert("An error occurred. Please try again later.");
    });
});</script><?php

// Initialize variables for 'home' table
$first_two_letters = $remaining_letters = '';

// Query to split the name into two parts (first two letters and the remaining letters)
$sql = "SELECT 
            LEFT(name, 2) AS first_two_letters, 
            SUBSTRING(name, 3) AS remaining_letters 
        FROM home";

// Execute the query
$result = mysqli_query($conn, $sql);

// Check if there are results
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $first_two_letters = $row['first_two_letters'];
    $remaining_letters = $row['remaining_letters'];
} else {
    echo "No results found.";
}

// Function to truncate text to a specific number of words
function truncateText($text, $wordLimit) {
    $words = explode(' ', $text);
    if (count($words) > $wordLimit) {
        $truncated = implode(' ', array_slice($words, 0, $wordLimit));
        return $truncated . '...';
    }
    return $text;
}

// Function to convert Gregorian month to Bengali month
function convertToBengaliMonth($month) {
    $bengali_month_mapping = [
        'January' => 'পৌষ',
        'February' => 'মাঘ',
        'March' => 'ফাল্গুন',
        'April' => 'চৈত্র',
        'May' => 'বৈশাখ',
        'June' => 'জ্যৈষ্ঠ',
        'July' => 'আষাঢ়',
        'August' => 'শ্রাবণ',
        'September' => 'ভাদ্র',
        'October' => 'আশ্বয়ন',
        'November' => 'কার্তিক',
        'December' => 'অগ্রহায়ণ'
    ];

    return $bengali_month_mapping[$month] ?? $month;
}

// Function to convert English date to Bengali date
function convertToBengaliDate($date) {
    $date = new DateTime($date);
    $month = $date->format('F');
    $day = $date->format('j');
    $year = $date->format('Y');
    
    $bengali_month = convertToBengaliMonth($month);

    return $day . ' ' . $bengali_month . ' ' . $year;
}

// Fetch columns from the 'column' table
$sql_columns = "SELECT c_id, title, c_descr, c_pic, c_date FROM `column`";
if ($stmt = mysqli_prepare($conn, $sql_columns)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $c_id, $title, $c_descr, $c_pic, $c_date);
    
    // Fetch all results and store them in an array
    $columns = [];
    while (mysqli_stmt_fetch($stmt)) {
        $columns[] = [
            'c_id' => htmlspecialchars($c_id),
            'title' => htmlspecialchars($title),
            'c_descr' => $c_descr,
            'c_pic' => htmlspecialchars($c_pic),
            'c_date' => htmlspecialchars($c_date),
            'bengali_date' => convertToBengaliDate($c_date) // Convert the date here
        ];
    }
} else {
    echo "Error preparing the statement: " . mysqli_error($conn);
}
?><div class=page id=work><div class=work><div class="text-left text-sm-center title-section"><h2 style=font-size:2.5rem>My <span style=font-weight:700>Columns</span></h2><span class=title-bg style=font-size:4.5rem>Writing</span></div><div class=main-content><div class=container><div class=row><?php foreach ($columns as $column): ?><div class="col-12 col-lg-4 col-md-6 mb-4"><article class="post-container border-0 card rounded shadow-sm"><div class="position-relative overflow-hidden post-thumb"style=height:250px><a href="column.php?id=<?php echo $column['c_id']; ?>"class=d-block><img alt="Column Image"src="admin/images/<?php echo $column['c_pic']; ?>"class=card-img-top style=height:250px><div class=image-overlay></div></a></div><div class="card-body p-3"><h3 class="mb-3 card-title"><a href="column.php?id=<?php echo $column['c_id']; ?>"class="font-weight-bold text-dark"><?php echo $column['title']; ?></a></h3><hr><p class=card-text><span style=font-size:1.5rem;font-weight:600><?php echo $first_two_letters; ?></span><?php echo $remaining_letters; ?>:<?php echo truncateText($column['c_descr'], 15); ?><a href="column.php?id=<?php echo $column['c_id']; ?>"style=font-size:1.25rem>...বিস্তারিত</a><hr><div class="text-center align-items-center d-flex justify-content-between mt-3 small text-muted"><span class="text-center w-50"style=font-size:.75rem><i class="fa fa-calendar"></i><?php echo $column['c_date']; ?></span><span class="text-center w-50"style=font-size:.75rem><i class="fa fa-calendar"></i><?php echo $column['bengali_date']; ?></span></div></div></article></div><?php endforeach; ?></div></div></div></div></div><?php

// Query to fetch awards
$sql = "SELECT aw_id, aw_pic, aw_name FROM award";
$result = $conn->query($sql);
?><div class=page id=awards><div class=awards><div class="text-left text-sm-center title-section"><h2 style=font-size:2.5rem>my <span>awards</span></h2><span class=title-bg style=font-size:1.5rem>achievements</span></div><div class=main-content><div class=container><div class=row><?php if ($result->num_rows > 0): ?><?php while($row = $result->fetch_assoc()): ?><div class="col-12 mb-30"><article class="align-items-center d-flex post-container"style="border:none;border-radius:8px;box-shadow:0 4px 2px rgba(0,0,0,.1);padding:15px"><div class=post-thumb style=flex-shrink:0><a href=# class="d-block overflow-hidden position-relative"style=display:block;width:100%;height:250px;overflow:hidden;padding:0><img alt="Award Post"src="admin/images/<?php echo $row['aw_pic']; ?>"class=img-fluid style=width:100%;height:100%;object-fit:cover;border-radius:8px></a></div><div class=post-content style=flex-grow:1;padding-left:15px><div class=entry-header><h5 class=award-title><?php echo $row['aw_name']; ?></h5></div></div></article></div><?php endwhile; ?><?php else: ?><p>No awards found</p><?php endif; ?></div></div></div></div></div><?php

// Fetch books from the database
$query = "SELECT b_id, b_name, b_descr, b_pic, b_link FROM book";
$result = $conn->query($query);
?><div class=page id=blog><div class=blog><div class="text-left text-sm-center title-section"><h2 style=font-size:2.5rem>my <span>books</span></h2><span class=title-bg style=font-size:4.5rem>collection</span></div><div class=main-content><div class=container><div class=row><?php while ($row = $result->fetch_assoc()): ?><div class="col-12 col-md-6 col-lg-6 col-xl-4 mb-30"><article class=post-container><div class=post-thumb><a href="<?php echo htmlspecialchars($row['b_link']); ?>"class="d-block overflow-hidden position-relative"><img alt="<?php echo htmlspecialchars($row['b_name']); ?>"src="admin/images/<?php echo htmlspecialchars($row['b_pic']); ?>"class=img-fluid></a></div><div class=post-content style=background:#fff><div class=entry-header><h3><a href="<?php echo htmlspecialchars($row['b_link']); ?>"style=color:#000><?php echo htmlspecialchars($row['b_name']); ?></a></h3></div><div class="open-sans-font entry-content"><p><?php echo $row['b_descr']; ?></div></div></article></div><?php endwhile; ?></div></div></div></div></div><?php

// Fetch publishers
$publisherQuery = "SELECT * FROM publisher";
$publisherResult = $conn->query($publisherQuery);
$publisher = $publisherResult->fetch_assoc(); // Assuming only one publisher

// Fetch videos
$videoQuery = "SELECT * FROM videos";
$videoResult = $conn->query($videoQuery);
$videos = [];
while ($row = $videoResult->fetch_assoc()) {
    $videos[] = $row;
}
?><div class=page id=video><div class=video-section><div class="text-left text-sm-center title-section"><h2>my <span>Videos</span></h2><span class=title-bg>media</span></div><div class="main-content text-center"><div class="container video-gallery"id=video-gallery><div class="row grid gridlist"><?php foreach ($videos as $video): ?><div class=col-12><div class="shadow-box video-item"><div class=videocontainer><video class=v_d controls poster="<?php echo 'admin/images/' . $video['v_poster']; ?>"><source src="<?php echo 'admin/videos/' . $video['video']; ?>"type=video/mp4>Your browser does not support the video tag.</video></div><div class="align-items-center d-flex justify-content-between video-info"><div class="text-left video-title"><h4 class=video-title style=margin:0;font-weight:700><?php echo $video['v_title']; ?></h4><p class=publisher style=margin:0><?php 
                                            // Display the publisher name directly
                                            echo $publisher['p_publisher'];
                                        ?></div><p class=time-posted style=margin:0 data-time="<?php echo $video['v_time']; ?>"></div><div class=subscribe-btn><a href="<?php echo $publisher['p_url']; ?>"class=btn-subscribe target=_blank>Visit</a></div><div class=video-description style=padding:20px><p class=full-description style=display:none><?php echo $video['v_descr']; ?></p><a href=# class=btn-see-more>See More</a></div></div></div><?php endforeach; ?></div></div></div></div></div></div><script src=js/jquery-3.7.1.min.js></script><script src=js/styleswitcher.js></script><script src=js/imagesloaded.pkgd.min.js></script><script src=js/masonry.pkgd.min.js></script><script src=js/classie.js></script><script src=js/main.js></script><script src=js/cbpGridGallery.js></script><script src=js/jquery.hoverdir.js></script><script src=js/bootstrap.js></script><script src=js/popper.min.js></script><script src=js/menu.js></script><script src=js/custom.js></script><script>// Store the current image index for each gallery
    const currentImageIndex = {};

    function changeImage(galleryId, direction) {
        const imageElements = document.querySelectorAll(`[id^="gallery-${galleryId}-image-"]`);
        const totalImages = imageElements.length;

        // Initialize the current index if not already set
        if (currentImageIndex[galleryId] === undefined) {
            currentImageIndex[galleryId] = 0;
        }

        // Calculate the new image index
        currentImageIndex[galleryId] += direction;
        if (currentImageIndex[galleryId] < 0) {
            currentImageIndex[galleryId] = totalImages - 1; // Wrap around to the last image
        } else if (currentImageIndex[galleryId] >= totalImages) {
            currentImageIndex[galleryId] = 0; // Wrap around to the first image
        }

        // Update the displayed image
        const newImageSrc = document.getElementById(`gallery-${galleryId}-image-${currentImageIndex[galleryId]}`).value;
        document.getElementById(`gallery-image-${galleryId}`).src = newImageSrc;
    }</script><script>document.addEventListener("DOMContentLoaded", function() {
        const seeMoreButtons = document.querySelectorAll('.btn-see-more');

        seeMoreButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default anchor behavior
                
                // Find the corresponding full-description in the current video item
                const description = this.closest('.video-item').querySelector('.full-description');

                if (description.style.display === 'none' || description.style.display === '') {
                    description.style.display = 'block'; // Show the description
                    this.textContent = 'See Less'; // Change button text to 'See Less'
                } else {
                    description.style.display = 'none'; // Hide the description
                    this.textContent = 'See More'; // Change button text back to 'See More'
                }
            });
        });
    });</script><script>function timeAgo(time) {
        const currentTime = new Date();
        const videoTime = new Date(time);
        const timeDifference = currentTime - videoTime;

        const seconds = Math.floor(timeDifference / 1000);
        const minutes = Math.floor(seconds / 60);
        const hours = Math.floor(minutes / 60);
        const days = Math.floor(hours / 24);
        const months = Math.floor(days / 30);
        const years = Math.floor(days / 365);

        if (seconds < 60) return `${seconds} seconds ago`;
        if (minutes < 60) return `${minutes} minutes ago`;
        if (hours < 24) return `${hours} hours ago`;
        if (days < 30) return `${days} days ago`;
        if (months < 12) return `${months} months ago`;
        return `${years} years ago`;
    }

    // Apply the timeAgo function to each video
    document.addEventListener("DOMContentLoaded", function() {
        const timePostedElements = document.querySelectorAll('.time-posted');
        timePostedElements.forEach(element => {
            const videoTime = element.getAttribute('data-time');
            element.textContent = timeAgo(videoTime);
        });
    });</script>