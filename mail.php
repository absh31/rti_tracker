<?php
// (A) SET MAIL DATA
$to = "mihirsomeshwara0712@gmail.com";
$subject = "Test Email";
$message = "This is a test email message.";

// (B) SEND!
echo mail($to, $subject, $message)
  ? "OK" : "ERROR" ;
?>