<?php
$active = "index.php";
include("db.php");
include("sidebar.php");

// Check if the current page is 'contact.php'
$current_page = basename($_SERVER['PHP_SELF']);
$show_notification = true;

if ($current_page == 'contact.php') {
    $show_notification = false; // Don't show notification on contact page
}

// Check for new messages in the contact table
$new_messages_query = "SELECT COUNT(*) as count FROM contact WHERE seen = 0";

$new_messages_result = mysqli_query($conn, $new_messages_query);
$new_messages_count = mysqli_fetch_assoc($new_messages_result)['count'];

// Notification display logic
?>

<style>
.quickview__item-total {
    color: #ffb400 !important;
}
.quickview__item:hover {
    background-color: rgba(181, 248, 248, 0.37);
}
.quickview__item:hover .quickview__item-total {
    color: #ff5733 !important;
}
.quickview__item:hover p {
    color: #ffffff !important;
}
.card {
    margin-top: 20px;
}
.card__header {
    color: black !important;
    padding: 10px;
    border-radius: 5px 5px 0 0;
}
.card__header-title {
    font-size: 18px;
    color: #000000 !important;
}
.card__row {
    display: flex;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #ddd;
}
.card__icon {
    margin-right: 15px;
    text-align: center;
}
.card__icon img {
    width: 100px;
    height: auto;
    border-radius: 5px;
    display: block;
}
.card__detail .card__description {
    font-size: 14px;
}
.card__note {
    font-size: 12px;
    color: #666;
}
.card__link {
    color: #007bff;
    text-decoration: none;
}
.card__link:hover {
    text-decoration: underline;
}
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #ffb400;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    transition: opacity 0.5s ease;
}
</style>

<div class="m">
    <div class="main-header">
        <div class="main-header__intro-wrapper">
            <?php
            // Fetch the user data
            $sql = "SELECT name, job FROM home WHERE h_id = 1"; // Adjust h_id as needed
            $result = $conn->query($sql);
            $user = $result->fetch_assoc();

            if ($user) {
                $name = htmlspecialchars($user['name']);
                $job = htmlspecialchars($user['job']);
            } else {
                $name = "User";
                $job = "Position";
            }

            // Fetch the first three rows from the ab_box table
            $sql = "SELECT number, descr FROM ab_box LIMIT 3";
            $result = $conn->query($sql);
            $items = [];
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
            ?>

            <div class="main-header__welcome">
                <div class="main-header__welcome-title text-light">Welcome, <strong><?php echo $name; ?></strong></div>
                <div class="main-header__welcome-subtitle text-light">How are you today as a <?php echo $job; ?>?</div>
            </div>

            <div class="quickview">
                <?php foreach ($items as $item): ?>
                    <div class="quickview__item">
                        <div class="quickview__item-total"><?php echo htmlspecialchars($item['number']); ?>+</div>
                        <div class="quickview__item-description">
                            <p class="text-dark" style="font-weight:bold;"><?php echo $item['descr']; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="main__cards">
        <?php
        // Fetch the recent 5 books
        $query = "SELECT b_id, b_name, b_descr, b_pic, b_link FROM book ORDER BY b_id DESC LIMIT 5";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Database query failed: " . mysqli_error($conn));
        }

        $books = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $books[] = $row;
        }
        mysqli_free_result($result);
        ?>

        <div class="card">
            <div class="card__header">
                <div class="card__header-title text-light">Recent <strong>Books</strong></div>
                <a href="book.php" class="card__header-link text-bold">View All</a>
            </div>
            <div class="card__main">
                <?php foreach ($books as $book): ?>
                <div class="card__row">
                    <div class="card__icon">
                        <?php if (!empty($book['b_pic'])): ?>
                            <img src="images/<?php echo htmlspecialchars($book['b_pic']); ?>" alt="<?php echo htmlspecialchars($book['b_name']); ?>">
                        <?php else: ?>
                            <i class="fas fa-book"></i>
                        <?php endif; ?>
                    </div>
                    <div class="card__detail">
                        <div class="card__source text-bold"><?php echo htmlspecialchars($book['b_name']); ?></div>
                        <div class="card__description"><?php echo $book['b_descr']; ?></div>
                        <div class="card__note">
                            <a href="<?php echo htmlspecialchars($book['b_link']); ?>" target="_blank" class="card__link">Read More</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php
        // Fetch the recent 5 documents
        $query = "SELECT c_id, title, c_descr, c_pic, c_date FROM `column` ORDER BY c_date DESC LIMIT 5";
        $result = mysqli_query($conn, $query);

        $documents = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $documents[] = $row;
        }

        // Fetch existing values from the database
        $w_link = "";
        $sql = "SELECT w_link FROM social WHERE id = 1"; // Adjust as necessary
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $w_link = $row['w_link'];
        }

        mysqli_close($conn);
        ?>
        
        <div class="card">
            <div class="card__header">
                <div class="card__header-title text-light">Recent <strong>Columns</strong></div>
                <a href="column.php" class="card__header-link text-bold">View All</a>
            </div>
            <div class="card__main">
                <div class="documents">
                    <?php foreach ($documents as $document): ?>
                    <a href="<?php echo htmlspecialchars($w_link); ?>column.php?id=<?php echo htmlspecialchars($document['c_id']); ?>" 
                       target="_blank" rel="noopener noreferrer" class="document">
                        <?php if (!empty($document['c_pic'])): ?>
                            <div class="document__img" style="background-image: url('images/<?php echo htmlspecialchars($document['c_pic']); ?>'); background-size: cover; background-position: center;"></div>
                        <?php else: ?>
                            <div class="document__img"></div>
                        <?php endif; ?>
                        <div class="document__title"><?php echo htmlspecialchars($document['title']); ?></div>
                        <div class="document__date"><?php echo htmlspecialchars(date('m/d/Y', strtotime($document['c_date']))); ?></div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div> <!-- /.main-cards -->
</div>

<?php
// Check if there are new messages
if ($new_messages_count > 0 && $show_notification) {
    echo "<div class='notification' id='notification'>You have new messages</div>";
}
?>

<script>
    // Show the notification if it exists
    window.onload = function() {
        var notification = document.getElementById('notification');
        if (notification) {
            notification.style.display = 'block';
            setTimeout(function() {
                notification.style.opacity = '0';
                setTimeout(function() {
                    notification.style.display = 'none';
                }, 500);
            }, 3000);
        }
    };
</script>

<?php include("footer.php"); ?>