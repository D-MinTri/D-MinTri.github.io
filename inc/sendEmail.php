<?php

// Replace this with your own email address
$siteOwnersEmail = 'duongminhtri722004@gmail.com';

if ($_POST) {

    $name = trim(stripslashes($_POST['contactName']));
    $email = trim(stripslashes($_POST['contactEmail']));
    $subject = trim(stripslashes($_POST['contactSubject']));
    $contact_message = trim(stripslashes($_POST['contactMessage']));

    $error = []; // Khởi tạo mảng lỗi

    // Kiểm tra Name
    if (strlen($name) < 2) {
        $error['name'] = "Please enter your name.";
    }

    // Kiểm tra Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Please enter a valid email address.";
    }

    // Kiểm tra Message
    if (strlen($contact_message) < 15) {
        $error['message'] = "Message should have at least 15 characters.";
    }

    // Nếu không có subject
    if ($subject == '') { 
        $subject = "Contact Form Submission"; 
    }

    // Tạo nội dung email
    $message = "Email from: " . $name . "<br />";
    $message .= "Email address: " . $email . "<br />";
    $message .= "Message: <br />";
    $message .= $contact_message;
    $message .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

    // Headers
    $from = $name . " <" . $email . ">";
    $headers = "From: " . $from . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    // Nếu không có lỗi, gửi email
    if (!$error) {
        ini_set("sendmail_from", $siteOwnersEmail);
        $mail = mail($siteOwnersEmail, $subject, $message, $headers);

        if ($mail) { 
            echo "OK"; 
        } else { 
            echo "Something went wrong. Please try again."; 
        }
        exit();
    } else {
        $response = implode("<br />\n", $error);
        echo $response;
        exit();
    }
}

?>
