<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email']);

    // Validate the email field
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Please provide a valid email address.']);
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'mail.eacademy247.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'info@eacademy247.com'; // Your email
        $mail->Password = 'e3GBfwhSB7AyfWZ'; // Your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Email Content
        $mail->setFrom($email, 'eAcademy247 Newsletter'); // From address and name
        $mail->addAddress('info@eacademy247.com'); // To address

        $mail->isHTML(true);
        $mail->Subject = "New Newsletter Subscription";
        $mail->Body = "
            <h3>Newsletter Subscription</h3>
            <p><b>Email:</b> $email</p>
        ";

        $mail->send();
        echo json_encode(['success' => true, 'message' => 'Thank you for subscribing to our newsletter!']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
