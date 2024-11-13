<?php

$active = "video.php";
include("db.php");
include("sidebar.php");

// Fetch videos from the database
$query = "SELECT * FROM videos"; // Adjust table name if needed
$result = mysqli_query($conn, $query);
$videos = [];

while ($row = mysqli_fetch_assoc($result)) {
    $videos[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videos Box</title>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> <!-- Add Font Awesome if needed -->
    <style>
        .dataTables_wrapper .dataTables_filter input {
            margin-bottom: 10px !important;
        }

        .table-responsive {
            margin-top: 20px;
        }

        /* General Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin: 20px 0;
        }

        .table thead {
            background: #52459d;
            color: #fff;
        }

        .table thead th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #ddd;
        }

        .table tbody td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        .table tbody tr:hover {
            background: #f1f1f1;
        }

        table.dataTable tbody th, table.dataTable tbody td {
            padding: 8px 10px !important;
        }

        /* Image Styling */
        .video-img {
            width: 120px; /* Adjust size as needed */
            height: auto;
            border-radius: 5px;
        }

        /* Button Styles */
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
.button .trash {
    display: block;
    position: relative;
    left: -8px;
    transform: translate(var(--trash-x, 0), var(--trash-y, 1px)) translateZ(0) scale(var(--trash-scale, 0.64));
    transition: transform 0.5s;
}
.button .trash:before, .button .trash:after {
      content: '';
    position: absolute;
    height: 8px;
    width: 2px;
    border-radius: 1px;
    background: var(--icon, var(--trash));
    bottom: 100%;
    transform-origin: 50% 6px;
    transform: translate(var(--x, 3px), 2px) scaleY(var(--sy, 0.7)) rotate(var(--r, 0deg));
    transition: transform 0.4s, background 0.3s;
}
.button .trash:before {
    left: 1px;
}

.button .trash:after {
    right: 1px;
    --x: -3px;
}
        
        
.button.delete {
    --span-opacity: 0;
    --span-x: 16px;
    --span-delay: 0s;
    --trash-x: 46px;
    --trash-y: 2px;
    --trash-scale: 1;
    --trash-lines-opacity: 0;
    --trash-line-scale: 0;
    --icon: #fff;
    --check-offset: 0;
    --check-opacity: 1;
    --check-scale: 1;
    --check-y: 16px;
    --check-delay: 1.7s;
    --checkmark-delay: 2.1s;
    --check-duration: 0.55s;
    --check-duration-opacity: 0.3s;
}

.button .trash .top {
    position: absolute;
    overflow: hidden;
    left: -4px;
    right: -4px;
    bottom: 100%;
    height: 40px;
    z-index: 1;
    transform: translateY(2px);
}
.button .trash .top:before, .button .trash .top:after {
    content: '';
    position: absolute;
    border-radius: 1px;
    background: var(--icon, var(--trash));
    width: var(--w, 12px);
    height: var(--h, 2px);
    left: var(--l, 8px);
    bottom: var(--b, 5px);
    transition: background 0.3s, transform 0.4s;
}
.button .trash .top:after {
    --w: 28px;
    --h: 2px;
    --l: 0;
    --b: 0;
    transform: scaleX(var(--trash-line-scale, 1));
}
.button .trash .top .paper {
    width: 14px;
    height: 18px;
    background: var(--paper);
    left: 7px;
    bottom: 0;
    border-radius: 1px;
    position: absolute;
    transform: translateY(-16px);
    opacity: 0;
}
.button .trash .top .paper:before, .button .trash .top .paper:after {
    content: '';
    width: var(--w, 10px);
    height: 2px;
    border-radius: 1px;
    position: absolute;
    left: 2px;
    top: var(--t, 2px);
    background: var(--paper-lines);
    transform: scaleY(0.7);
    box-shadow: 0 9px 0 var(--paper-lines);
}
.button .trash .top .paper:after {
    --t: 5px;
    --w: 7px;
}
.button .trash .box {
    width: 20px;
    height: 25px;
    border: 2px solid var(--icon, var(--trash));
    border-radius: 1px 1px 4px 4px;
    position: relative;
    overflow: hidden;
    z-index: 2;
    transition: border-color 0.3s;
}
.button .trash .box:before, .button .trash .box:after {
    content: '';
    position: absolute;
    width: 4px;
    height: var(--h, 20px);
    top: 0;
    left: var(--l, 50%);
    background: var(--b, var(--trash-lines));
}
.button .trash .box:before {
    border-radius: 2px;
    margin-left: -2px;
    transform: translateX(-3px) scale(0.6);
    box-shadow: 10px 0 0 var(--trash-lines);
    opacity: var(--trash-lines-opacity, 1);
    transition: transform 0.4s, opacity 0.4s;
}
.button .trash .box:after {
    --h: 16px;
    --b: var(--paper);
    --l: 1px;
    transform: translate(-0.5px, -16px) scaleX(0.5);
    box-shadow: 7px 0 0 var(--paper), 14px 0 0 var(--paper), 21px 0 0 var(--paper);
}
.button .trash .check {
    padding: 4px 3px;
    border-radius: 50%;
    background: var(--check-background);
    position: absolute;
    left: 2px;
    top: 24px;
    opacity: var(--check-opacity, 0);
    transform: translateY(var(--check-y, 0)) scale(var(--check-scale, 0.2));
    transition: transform var(--check-duration, 0.2s) ease var(--check-delay, 0s), opacity var(--check-duration-opacity, 0.2s) ease var(--check-delay, 0s);
}
.button .trash .check svg {
    width: 8px;
    height: 6px;
    display: block;
    fill: none;
    stroke-width: 1.5;
    stroke-dasharray: 9px;
    stroke-dashoffset: var(--check-offset, 9px);
    stroke-linecap: round;
    stroke-linejoin: round;
    stroke: var(--check);
    transition: stroke-dashoffset 0.4s ease var(--checkmark-delay, 0.4s);
}
.button.delete {
    --span-opacity: 0;
    --span-x: 16px;
    --span-delay: 0s;
    --trash-x: 46px;
    --trash-y: 2px;
    --trash-scale: 1;
    --trash-lines-opacity: 0;
    --trash-line-scale: 0;
    --icon: #fff;
    --check-offset: 0;
    --check-opacity: 1;
    --check-scale: 1;
    --check-y: 16px;
    --check-delay: 1.7s;
    --checkmark-delay: 2.1s;
    --check-duration: 0.55s;
    --check-duration-opacity: 0.3s;
}
.button.delete .trash:before, .button.delete .trash:after {
    --sy: 1;
    --x: 0;
}
.button.delete .trash:before {
    --r: 40deg;
}
.button.delete .trash:after {
    --r: -40deg;
}
.button.delete .trash .top .paper {
    animation: paper 1.5s linear forwards 0.5s;
}
.button.delete .trash .box:after {
    animation: cut 1.5s linear forwards 0.5s;
}
.button.delete, .button:hover {
    --btn: var(--background-hover);
    --shadow-y: 5px;
    --shadow-blur: 9px;
}
.button:active {
    --shadow-y: 2px;
    --shadow-blur: 5px;
    --scale: 0.94;
}
@keyframes paper {
    10%, 100% {
        opacity: 1;
   }
    20% {
        transform: translateY(-16px);
   }
    40% {
        transform: translateY(0);
   }
    70%, 100% {
        transform: translateY(24px);
   }
}
@keyframes cut {
    0%, 40% {
        transform: translate(-0.5px, -16px) scaleX(0.5);
   }
    100% {
        transform: translate(-0.5px, 24px) scaleX(0.5);
   }
}

        /* Specific Button Classes */
        .update {
            background-color: #4CAF50; /* Green */
        }

        .delete {
            background-color: #f44336; /* Red */
        }

        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-lg-9 text-center mx-auto">
                    <h1 class="page-header" style="font-weight:bold;">Videos Box</h1>
                    <button class="button mt-3">
                        <a href="insert_video.php" style="color: #fff; text-decoration: none;">Add Video</a>
                    </button>
                </div>

                <!-- Centering the col-lg-8 -->
                <div class="col-lg-8 mx-auto">
                    <!-- Table -->
                    <div class="table-responsive">
                        <table id="videos-table" class="table display">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Poster</th>
                                    <th>Video</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($videos as $video): ?>
                                <tr>
                                    <td data-label="ID"><?php echo htmlspecialchars($video['v_id']); ?></td>
                                    <td data-label="Title"><?php echo htmlspecialchars($video['v_title']); ?></td>
                                    <td data-label="Description"><?php echo htmlspecialchars($video['v_descr']); ?></td>

                                    <!-- Display Video Poster -->
                                    <td data-label="Poster">
                                        <img class="video-img" src="images/<?php echo htmlspecialchars($video['v_poster']); ?>" alt="Video Poster">
                                    </td>

                                    <!-- Display Video Link with Modal Trigger -->
                                    <td data-label="Video">
                                        <button class="button watch-video" data-video="videos/<?php echo htmlspecialchars($video['video']); ?>">Video</button>
                                    </td>

                                    <td>
                                        <a class="button update" href="update_video.php?id=<?php echo htmlspecialchars($video['v_id']); ?>">
                                            <i class="fa fa-pencil"></i> Update
                                        </a>
                                      </td>
                               <td>
    <a href="delete_video.php?id=<?php echo $video['v_id']; ?>" class="button">
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
    </a>
</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Structure -->
    <div id="videoModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <video id="videoPlayer" controls style="width: 100%;">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("videoModal");

        // Get the button that opens the modal
        var buttons = document.querySelectorAll(".watch-video");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // Get the video player
        var videoPlayer = document.getElementById("videoPlayer");

        // When the user clicks on a button, open the modal and set video source
        buttons.forEach(function(button) {
            button.onclick = function() {
                var videoSrc = this.getAttribute("data-video");
                videoPlayer.src = videoSrc;
                modal.style.display = "block";
            }
        });

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
            videoPlayer.pause();
            videoPlayer.src = ""; // Clear the video source
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
                videoPlayer.pause();
                videoPlayer.src = ""; // Clear the video source
            }
        }
    </script>

    <?php include("footer.php"); ?>
</body>
</html>
