<?php
include("admin/db.php");
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form data
    $sender_name = $_POST['name'];
    $sender_email = $_POST['email'];
    $sender_subject = $_POST['subject'];
    $sender_message = $_POST['message'];

    // Your email (where you'll receive the contact form messages)
    $your_email = "hasaninteshar@gmail.com"; // Change this to your email address

    // Instantiate PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com"; // Your SMTP server host
        $mail->SMTPAuth = true;
        $mail->Username = "hasaninteshar@gmail.com"; // Change this to your email address
        $mail->Password = "srwj nctv qhgy fxnc"; // Change this to your email app-specific password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Set sender details (your email as the sender)
        $mail->setFrom($sender_email, $sender_name);

        // Set reply-to (the user's email)
        $mail->addReplyTo($sender_email, $sender_name);

        // Set recipient (your email)
        $mail->addAddress($your_email);

        // Email content
        $mail->isHTML(false);
        $mail->Subject = $sender_subject;
        $mail->Body = "You have received a new message from: \n\n" .
                      "Name: " . $sender_name . "\n" .
                      "Email: " . $sender_email . "\n\n" .
                      "Subject: " . $sender_subject . "\n\n" .
                      "Message:\n" . $sender_message;

        // Send email
        $mail->send();

        // Insert data into the 'contact' table (Database insertion starts here)
        if (!isset($conn)) {
            die(json_encode(array("success" => false, "error" => "Database connection error.")));
        }

        // Sanitize and insert form data into the database
        $name = $conn->real_escape_string($sender_name);
        $email = $conn->real_escape_string($sender_email);
        $subject = $conn->real_escape_string($sender_subject);
        $message = $conn->real_escape_string($sender_message);

        // Insert query
        $query = "INSERT INTO contact (name, email, subject, msz) VALUES ('$name', '$email', '$subject', '$message')";

        // Execute the query and check for errors
        if ($conn->query($query) === TRUE) {
            // Success response (both email sent and database insertion successful)
            echo json_encode(array("success" => true));
        } else {
            // Log and return database error
            error_log("Error inserting data: " . $conn->error);
            echo json_encode(array("success" => false, "error" => "Database error: " . $conn->error));
        }
    } catch (Exception $e) {
        // Return error response as JSON for email sending failure
        echo json_encode(array("success" => false, "error" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"));
    }
}
?>




