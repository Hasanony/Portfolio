<?php
include 'admin/db.php'; // Ensure this path is correct

// Get the ID from the query string
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die("Invalid ID");
}

// Prepare and execute query to fetch the column data
$stmt = $conn->prepare("SELECT * FROM `column` WHERE `c_id` = ?");
if (!$stmt) {
    die("Error preparing the statement: " . $conn->error);
}
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$column = $result->fetch_assoc();
$stmt->close();

if (!$column) {
    die("Column not found");
}

// Fetch name from home table
$stmt_home = $conn->prepare("SELECT `name` FROM `home` LIMIT 1");
if (!$stmt_home) {
    die("Error preparing the statement: " . $conn->error);
}
$stmt_home->execute();
$result_home = $stmt_home->get_result();
$home = $result_home->fetch_assoc();
$stmt_home->close();

if (!$home) {
    die("Home data not found");
}

// Prepare and execute query to fetch related articles (3 random articles for the Related Articles section)
$stmt_related = $conn->prepare("SELECT * FROM `column` WHERE `c_id` != ? ORDER BY RAND() LIMIT 3");
if (!$stmt_related) {
    die("Error preparing the statement: " . $conn->error);
}
$stmt_related->bind_param("i", $id);
$stmt_related->execute();
$result_related = $stmt_related->get_result();
$related_columns = $result_related->fetch_all(MYSQLI_ASSOC);
$stmt_related->close();

// Prepare and execute query to fetch more news (4 random articles for the More News section)
$stmt_more_news = $conn->prepare("SELECT * FROM `column` WHERE `c_id` != ? ORDER BY RAND() LIMIT 3");
if (!$stmt_more_news) {
    die("Error preparing the statement: " . $conn->error);
}
$stmt_more_news->bind_param("i", $id);
$stmt_more_news->execute();
$result_more_news = $stmt_more_news->get_result();
$more_news_columns = $result_more_news->fetch_all(MYSQLI_ASSOC);
$stmt_more_news->close();

// Function to truncate text
function truncateText($text, $length) {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}

// Function to extract the first two letters
function getFirstTwoLetters($text) {
    return mb_substr($text, 0, 2);
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

// Extract the first two letters and remaining part
$first_two_letters = isset($home['name']) ? getFirstTwoLetters($home['name']) : '';
$remaining_letters = isset($home['name']) ? mb_substr($home['name'], 2) : '';

// Convert column date to both English and Bengali formats
$column_date = isset($column['c_date']) ? new DateTime($column['c_date']) : null;
$english_date = $column_date ? $column_date->format('F j, Y') : 'Date not available';
$bengali_date = $column_date ? convertToBengaliDate($column['c_date']) : 'তারিখ উপলব্ধ নয়';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($column['title']); ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 18px; /* Global font size increased */
            background-color: #f8f9fa; /* Lighter background for readability */
        }

        .container {
            max-width: 1140px;
        }

        .main-article h2 {
          
            font-weight: bold;
            margin-bottom: 20px;
        }

        .article-meta p {
            margin: 0;
            font-size: 1.1rem; /* Slightly larger font for metadata */
        }

        p {
            line-height: 1.7; /* Increased line height for readability */
            margin-bottom: 1.5rem;
            font-size: 1.4rem;
        }

        .related-articles ul {
            list-style-type: none;
            padding: 0;
            font-size: 1.2rem; /* Larger font for related articles */
        }

        .related-articles ul li {
            margin: 15px 0;
        }

        .related-articles ul li a {
            color: #007bff;
            text-decoration: none;
        }
      ul {
    
    padding-left: 20px;
    font-size: 1.7rem;
}

ul li {
    margin-bottom: 10px;
}

ul li a {
    font-size: 1.7rem;
    color: #007bff;
    font-weight: bold;
    text-decoration: none;
}

ul li a:hover {
    color: #0056b3;
}

        .related-articles ul li a:hover {
            text-decoration: underline;
        }

        footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 15px 0;
            margin-top: 40px;
        }

        footer p {
            margin: 0;
            font-size: 1.2rem;
        }

        .post-thumb img {
            transition: transform 0.4s ease;
        }

        .post-thumb:hover img {
            transform: scale(1.07);
        }

        .post-container:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
        }

        .card-title a {
            font-size: 1.4rem;
            color: #333;
        }

        .card-title a:hover {
            color: #0056b3;
        }

        .btn-primary {
            padding: 0.9rem 1.6rem;
            font-size: 1.2rem;
        }

        @media (max-width: 992px) {
            .main-article h2 {
                font-size: 2.1rem;
            }

            .card-title a {
                font-size: 1.3rem;
            }

            .related-articles ul li {
                font-size: 1rem;
            }

            footer p {
                font-size: 1rem;
            }
        }
        .bg-l{
            background:#e8e8e8;
            font-weight: 100;
        }
        .social-btn {
    width: 50px;        /* Set the width of the circle */
    height: 50px;       /* Set the height of the circle */
    display: flex;      /* Use flexbox to center the icon */
    align-items: center; /* Center the icon vertically */
    justify-content: center; /* Center the icon horizontally */
    border-radius: 50%; /* Make the button circular */
    text-align: center; /* Center the text inside the button */
    font-size: 1.5rem;  /* Adjust icon size if needed */
    padding: 0;         /* Remove default padding */
    transition: transform 0.3s; /* Add a transition effect for hover */
}

.social-btn:hover {
    transform: scale(1.1); /* Slightly scale up the button on hover */
}

.social-btn i {
    color: #fff; /* Ensure the icon color is white */
}
        .article-description {
    white-space: pre-wrap; /* Allows the text to wrap */
    word-break: break-word; /* Breaks long words to prevent overflow */
    overflow-wrap: break-word; /* Breaks words when necessary */
    font-size: 1rem; /* Adjust font size as needed */
    line-height: 1.6; /* Adjust line height for readability */
    margin: 0; /* Remove default margin */
    padding: 0; /* Remove default padding */
}


    </style>
</head>
<body>
    <section class="bg-l py-2">
        <div class="container d-flex justify-content-between align-items-center">
            <p class="mb-0" style="font-size:18px;"><strong><?php echo date('d F, Y'); ?></strong></p>
        </div>
    </section>

    <!-- Main Content Section -->
    <div class="container my-4">
        <div class="row">
            <!-- Left Column (Main Article) -->
            <div class="col-lg-12">
              <div class="main-article mb-4">
    <h2><?php echo htmlspecialchars($column['title']); ?></h2>
    
    <div class="article-meta d-flex justify-content-between">
        <p style="font-size:0.85rem"><i class="fa-regular fa-clock" style="color: #ff0909;"></i> <strong> <?php echo htmlspecialchars($english_date); ?> |  <?php echo htmlspecialchars($bengali_date); ?></strong></p>
        <h4 style="font-size:1.2rem"><strong><?php echo htmlspecialchars($home['name']); ?></strong></h4>
    </div>
    <img src="admin/images/<?php echo htmlspecialchars($column['c_pic']); ?>" alt="Article Image" class="img-fluid mb-3">
    <p class="article-description"><?php echo $column['c_descr']; ?></p>
</div>


                <!-- Related Articles Section -->
            <!-- Related Articles Section (3 Random Articles) -->
        <div class="related-articles">
            <h2 style="font-weight:bold; text-align:center;">Related Articles</h2>
            <ul>
                <?php foreach ($related_columns as $related): ?>
                    <li style="font-size:1.7rem; list-style-type: disc;"><a href="column.php?id=<?php echo $related['c_id']; ?>"><?php echo htmlspecialchars($related['title']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
            </div>

                    <?php


// Fetch social media links
$social_query = "SELECT * FROM social WHERE id = 1"; // Adjust the query as needed
$social_result = $conn->query($social_query);
$social = $social_result->fetch_assoc();



?>
        
           <!-- Right Column (Social Media) -->
<div class="col-lg-4">
    <h2>Follow Us</h2>
    <div class="d-flex">
        <a href="<?php echo htmlspecialchars($social['facebook']); ?>" class="btn btn-primary me-2 social-btn"><i class="fab fa-facebook-f"></i></a>
        <a title="Youtube" href="<?php echo htmlspecialchars($social['ytube']); ?>" class="btn btn-info me-2 social-btn"> <i class="fab fa-youtube"></i></a>
        <a href="https://wa.me/<?php echo htmlspecialchars($social['c_code']); ?><?php echo htmlspecialchars($social['w_app']); ?>" class="btn btn-success social-btn"><i class="fab fa-whatsapp"></i></a>
    </div>
</div>


 <div class="more-news">
    <div class="title-section text-left text-sm-center mb-4">
        <h2 style="font-weight:bold;">More <span>News</span></h2>
        <span class="title-bg">Updates</span>
    </div>

    <div class="main-content">
        <div class="container">
            <div id="moreNewsCarousel" class="carousel slide"  data-bs-interval="false">
                <!-- Carousel items -->
                <div class="carousel-inner">
                    <?php
                    $chunked_news = array_chunk($more_news_columns, 3); // Divide into chunks of 3 news items per slide
                    foreach ($chunked_news as $index => $news_group): ?>
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <div class="row">
                                <?php foreach ($news_group as $news): ?>
                                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                                        <article class="post-container card shadow-sm border-0 rounded">
                                            <div class="post-thumb position-relative overflow-hidden" style="height:250px">
                                                <a href="column.php?id=<?php echo $news['c_id']; ?>" class="d-block">
                                                    <img src="admin/images/<?php echo htmlspecialchars($news['c_pic']); ?>" class="card-img-top" alt="News Image" style="height:250px;">
                                                    <div class="image-overlay"></div>
                                                </a>
                                            </div>
                                            <div class="card-body p-3">
                                                <h3 class="card-title mb-3"><a href="column.php?id=<?php echo $news['c_id']; ?>" class="text-dark font-weight-bold"><?php echo htmlspecialchars($news['title']); ?></a></h3>
                                                <hr>
                                                <p class="card-text" style="font-size: 1.25rem;">
                                                    <span style="font-size:1.5rem; font-weight:600;">
                                                        <?php echo htmlspecialchars(getFirstTwoLetters($home['name'])); ?>
                                                    </span>
                                                    <?php echo htmlspecialchars(mb_substr($home['name'], 2)); ?> :
                                                    <?php echo htmlspecialchars(truncateText($news['c_descr'], 54)); ?>
                                                    <a href="column.php?id=<?php echo $news['c_id']; ?>" style="font-size: 1.25rem;">...বিস্তারিত</a>
                                                </p>
                                                <hr>
                                                <div class="d-flex justify-content-between align-items-center text-muted small mt-3 text-center">
                                                    <span class="w-100 text-center"><i class="fa fa-calendar"></i> <?php echo date('d M, Y', strtotime($news['c_date'])); ?></span>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

             
            </div>
        </div>
    </div>
</div>
    </div>

    <!-- Footer Section -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 News Website. All Rights Reserved.</p>
    </footer>

    <!-- Bootstrap JS and Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
