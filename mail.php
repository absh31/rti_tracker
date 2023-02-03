<?php
// (A) SET MAIL DATA
$to = "mihirsomeshwara0712@gmail.com";
$subject = "Test Email";
$message = "This is a test email message.";

// (B) SEND!
echo mail($to, $subject, $message)
  ? "OK" : "ERROR";
?>
<!-- <!DOCTYPE html>
<html>

<head>
  <style>
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    td,
    th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }

    tr:nth-child(even) {
      background-color: #dddddd;
    }
  </style>
</head>

<body>

  <h2>HTML Table</h2>

  <table>
    <tr>
      <th>
        Request Number
      </th>
      <th>
        Request Date
      </th>
      <th>
        Request Expiry
      </th>
      <th>
        Request Department
      </th>
      <th>
        Concerned Officer
      </th>
      <th>
        Officer Contact
      </th>
    </tr>
    <tr>
      <td>Test one </td>
      <td>Test one </td>
      <td>Test one </td>
      <td>Test one </td>
      <td>Test one </td>
      <td>Test one </td>
    </tr>
    <tr>
      <td>Test one </td>
      <td>Test one </td>
      <td>Test one </td>
      <td>Test one </td>
      <td>Test one </td>
      <td>Test one </td>
    </tr>
    <tr>
      <td>Test one </td>
      <td>Test one </td>
      <td>Test one </td>
      <td>Test one </td>
      <td>Test one </td>
      <td>Test one </td>
    </tr>
    <tr>
      <td>Test one </td>
      <td>Test one </td>
      <td>Test one </td>
      <td>Test one </td>
      <td>Test one </td>
      <td>Test one </td>
    </tr>
  </table>

</body>

</html> -->