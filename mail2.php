<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;


    // Load Composer's autoloader
    require 'vendor/autoload.php';

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_OFF;                      // Enable verbose debug output
        // $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->Port       = 587;        
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        
        $mail->Username   = 'techtreasuremag@gmail.com';                     // SMTP username
        $mail->Password   = 'kerhpxbhcoffnfxa';                               // SMTP password
                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('techtreasuremag@gmail.com', 'Tech Treasure Magazine', 0);
        $mail->addAddress('mihirsomeshwara0712@gmail.com', 'Mihir Someshwara');

        $string = "This was a test mail sent using PHP Mailer";

        $mail->isHTML(true); 
        $mail->Subject = 'Test Mail';
        $mail->Body = $string;

        if($mail->send()){
            echo "Mail Sent Successfully";
        }
    }
    catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
?>