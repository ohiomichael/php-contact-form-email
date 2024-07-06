<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once 'Composer/vendor/autoload.php';//Change to location of your PHPMailer Install


// Function to validate email address
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and validate data
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    // Validate email address
    if (!empty($email) && !isValidEmail($email)) {
        die("Invalid email address Please Try Again.");
    }
        
    // Start PHPMailer
    $mail = new PHPMailer();
    // configure SMTP
    $mail->isSMTP(); 
    $mail->Host = '%EMAIL SERVER%';
    $mail->SMTPAuth = true;
    $mail->Username = '%EMAIL USER%';
    $mail->Password = '%EMAIL PASSWORD%';

    // Remove this line to disable allowing self signed ssl certs
    $mail->SMTPOptions = array('ssl' => array('verify_peer' => false,'verify_peer_name' => false,'allow_self_signed' => true));

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //USE SSL
    $mail->Port = 587; //SSL PORT
    
    // configure email
    $mail->setFrom('%EMAIL USER%', '%EMAIL USER%');
    $mail->addAddress('%EMAIL RECIEVE%', '%EMAIL RECIEVE%');
    $mail->Subject = '%SUBJECT%';

    // Set HTML 
    $mail->isHTML(False); //Set to true to send email as html

    // Build the email body
    $mail->Body = "
    name: $name\n
    email: $email\n
    message: $message\n";

    // send the email
    if(!$mail->send()){
        echo "Error: C-002\n - Message failed to send.";
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        // Display a thank you message
        echo "<p>Thank you, $name! We have received your message.</p>";
        header("%REDIRECT LOCATION%"); // redirect user to new page after form is proccessed
        die(); 
    }
}?>
