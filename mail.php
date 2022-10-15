<?php
// (A) SET MAIL DATA
$to = "mihirsomeshwara0712@gmail.com";
$subject = "Test Email";
$message = "This is a test email message.";

// (B) SEND!
echo mail($to, $subject, $message)
  ? "OK" : "ERROR" ;
?>
<html>
  <body>
    <h4>EXPIRING RTIs</h4>
    <table>
      <thead>
        <tr>
          <td>Request No</td>
          <td>Request Time</td>
          <td>Request Department</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?=$expRow['request_no'] ?></td>
          <td><?=$expRow['request_time'] ?></td>
          <td><?=$expRow['request_department_id'] ?></td>
        </tr>
      </tbody>
    </table>  
  </body>
</html>