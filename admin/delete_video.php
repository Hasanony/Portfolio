<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
include("db.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Prepare the SQL statement to fetch the video details
    $stmt = $conn->prepare("SELECT video, v_poster FROM videos WHERE v_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->store_result();
        $stmt->bind_result($video_file, $poster_file);

        if ($stmt->fetch()) {
            // Delete the video and poster files from the server
            if (file_exists("videos/" . $video_file)) {
                unlink("videos/" . $video_file);
            }
            if (file_exists("images/" . $poster_file)) {
                unlink("images/" . $poster_file);
            }

            // Prepare and execute the delete statement
            $stmt = $conn->prepare("DELETE FROM videos WHERE v_id = ?");
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                // Success message with redirect
            echo "<script>window.open('video.php','_self')</script>";
            } else {
                // Error message if deletion failed
                echo "
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'Error deleting video',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location.href = 'video.php'; // Redirect to videos page
                            });
                        });
                    </script>";
            }
        } else {
            // Video not found error
            echo "
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Video not found',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            window.location.href = 'video.php'; // Redirect to videos page
                        });
                    });
                </script>";
        }
    } else {
        // Error message if the fetch failed
        echo "
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Error fetching video details',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = 'video.php'; // Redirect to videos page
                    });
                });
            </script>";
    }

    $stmt->close();
} else {
    // Redirect to videos page if no ID is provided
    header('Location: video.php');
}

$conn->close();
?>
