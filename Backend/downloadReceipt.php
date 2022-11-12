<?php
session_start();
$reqNo = $_GET['reqNo'];
$reqEmail = $_GET['reqEmail'];
?>

<?php
include '../connection.php';
try {
    $sql = $conn->prepare("SELECT tblapplicant.applicant_email, tblrequest.* FROM tblapplicant INNER JOIN tblrequest 
    ON tblapplicant.applicant_id = tblrequest.request_applicant_id
    WHERE tblrequest.request_no = ? AND tblapplicant.applicant_email = ?");
    $sql->bindParam(1, $reqNo);
    $sql->bindParam(2, $reqEmail);
    $sql->execute();
    $key = $sql->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "<script>alert('Something went wrong!');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="clogo.png" type="image/x-icon">
    <title>Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <!-- <script src="html2pdf.bundle.min.js"></script> -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <style>
        #receipt {
            background-color: #fff;
        }

        .image img {
            width: 110px;
        }

        * {
            font-family: Poppins
        }

        .title {
            color: #003975;
            font-weight: 600;
        }

        .table {
            font-size: 14px;
        }

        table tbody th {
            width: 250px;
        }

        table tbody tr {
            line-height: 18px;
        }


        @media print {
            body {
                visibility: hidden;
            }

            #receipt {
                visibility: visible;
            }

            .title {
                font-size: 24px
            }
        }
    </style>
</head>

<body>
    <div class="container" id="receipt">
        <div class="row d-flex justify-content-between text-center">
            <div class="col">
                <img src="http:\\localhost\rti_tracker\uploads\images\logo2.png">
            </div>
            <div class="col pt-3">
                <h2 class="text-dark align-middle" style="font-weight: 800; color:black;">RTI TRACKER</h2>
            </div>
            <div class="col">
                <img src="http:\\localhost\rti_tracker\uploads\images\logo1.png">
            </div>
        </div>
        <br>
        <div class="row mx-auto text-center">
            <h5 style="font-weight : 600">Payment Receipt</h5>
        </div>
        <div class="row mx-auto my-4">
            <table class="table">
                <tbody>
                    <tr>
                        <th scope="row">RTI Reference Number</th>
                        <td><?= $key['request_no'] ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Date & Time</th>
                        <td><?php echo date('d/m/y G.i:s<br>', strtotime($key['request_time'])) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Email ID</th>
                        <td><?= $key['applicant_email'] ?></td>
                    </tr>
                    <tr>
                        <th scope="row">State</th>
                        <td><?= $key['request_state'] ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Request Mode</th>
                        <td><?= $key['request_mode'] ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Request Text</th>
                        <td><?= $key['request_text'] ?></td>
                    </tr>

                    <tr>
                        <th scope="row">Fees Paid</th>
                        <td> ₹
                            <?php echo $key['request_base_pay'] . ' (Application Fees) + ₹ ' . $key['request_add_pay'] . ' (Additional Fees)' ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Remarks</th>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <h6 style="font-family: Courier;">* This is an automatically generated receipt *</h6>
        </div>
    </div>

    <div class="container">
        <div class="text-center">
            <button class="btn btn-primary px-5" id="download">Print</button>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script> -->
    <script>
        window.onload = function() {
            $("#download").on('click', function() {
                window.print();
            })
        }
    </script>
</body>

</html>