<?php

$active="achive.php";
include("db.php");
include("sidebar.php");
// Fetch achievements from database
$query = "SELECT * FROM ab_box"; // Adjust table name and columns as needed
$result = mysqli_query($conn, $query);
$achievements = [];

while ($row = mysqli_fetch_assoc($result)) {
    $achievements[] = $row;
}
?>

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
     display: flex;
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

thead {
  background: #52459d;
  color: #fff;
}
    .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
  border: none !important;
}
.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
  padding: 8px;
  
  vertical-align: middle;
  border-top: none !important;
}
      
    .button.update:hover{
        background: var(--background-hover);
    }
        .table-responsive {
            width: 100%;
            padding: 0 15px;
        }
        
        .container, .container-fluid, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
            padding: 50px;
        }
    </style>

    <div class="main-content">
        <!-- Header and Button Row -->
        <div class="container-fluid"> <!-- Use container-fluid to cover the full width -->
            <div class="row mb-4">
                <div class="col-lg-9 text-center mx-auto">
                    <h1 class="page-header" style="font-weight:bold;">Achivements & Experience Box</h1>
                    <button class="button dele mt-3"><a href="insert_achive.php" style="color: #fff; text-decoration: none;">Add More</a></button>
                </div>

                <!-- Centering the col-lg-8 -->
                <div class="col-lg-8 mx-auto"> <!-- mx-auto class centers the column -->
                    <!-- Table -->
                    <div class="table-responsive">
                        <table id="achievements-table" class="table display">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Number</th>
                                    <th>Description</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($achievements as $achievement): ?>
                                <tr>
                                    <td data-label="ID"><?php echo htmlspecialchars($achievement['ab_id']); ?></td>
                                    <td data-label="Number"><?php echo htmlspecialchars($achievement['number']); ?></td>
                                    <td data-label="Description"><?php echo htmlspecialchars($achievement['descr']); ?></td>
                                    <td>
    <a class="button update" href="update_achive.php?id=<?php echo $achievement['ab_id']; ?>" style="display:flex">
        <i class="fa fa-pencil"></i> Update
    </a>
</td>

<td>
    <a href="delete_achive.php?id=<?php echo $achievement['ab_id']; ?>" class="button">
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

<?php include("footer.php"); ?>
