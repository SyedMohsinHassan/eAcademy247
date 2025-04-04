<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $country = htmlspecialchars($_POST['country']);
    $course = htmlspecialchars($_POST['course']);
    $message = htmlspecialchars($_POST['message']);

    // Validate required fields
    if (empty($name) || empty($email) || empty($country) || empty($course)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
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
        $mail->setFrom($email, $name); // From address and name
        $mail->addAddress('info@eacademy247.com'); // To address

        $mail->isHTML(true);
        $mail->Subject = "New Inquiry from $name";
        $mail->Body = "
            <h3>New Inquiry Details</h3>
            <p><b>Name:</b> $name</p>
            <p><b>Email:</b> $email</p>
            <p><b>Phone:</b> $phone</p>
            <p><b>Country:</b> $country</p>
            <p><b>Course Interested:</b> $course</p>
            <p><b>Message:</b><br>$message</p>
        ";

        $mail->send();
        echo json_encode(['success' => true, 'message' => 'Thank you for your inquiry! Our team will reach out to you soon with the information you need.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo]);
    }
}
?>
