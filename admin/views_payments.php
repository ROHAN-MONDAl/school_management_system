<?php include '../server_database.php';
$id = $_GET['id'];
// Query to fetch student data from the database
$query = "SELECT * FROM students where id = '$id'";
$result = $conn->query($query);
?>
<!DOCTYPE php>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Daffodils School</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- <link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css"> -->
    <link rel="stylesheet" href="assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/js/select.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.php -->
        <?php include 'header.php'   ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.php -->
            <?php include 'navbar.php' ?>
            <!-- Main Dashboard Panel -->
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                            <h2 class="font-weight-bold text-primary fw-bolder">Students</h2>
                                            <p class="text-secondary">Students Admision and Attendence</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- table header -->
                    <div class="col-12 col-lg-12 col-md-12 rounded mt-5" id="invoice">
                        <div class="card col-lg-12 col-md-12">
                            <div class="card-body me-5">

                                <h1 class="text-center mb-4 text-primary d-flex justify-content-center align-items-center">
                                    <img src="assets/images/favicon.png" style="width: 80px;  object-fit: cover;"><b>Daffodils School</b>

                                </h1>
                                <div class="text-center mb-4 d-flex justify-content-center align-items-center" style="margin-top:-30px">
                                    <p class="mt-3">Address: 63MG+G5J, 237, Kuchkuchia Rd, Bankura, West Bengal 722101, <br> Phone number: 094348 60435, </p>
                                    </p>

                                </div>

                                <h3 class="text-center mb-4">Invoice</h3>
                                <hr style="color:black">
                                <?php
                                while ($row = $result->fetch_assoc()):
                                ?>
                                    <div class="row">
                                        <div class="col-md-6 mb-5">
                                            <img src="<?php echo $row['img_path']; ?>" class="rounded" alt="Student Image" style="width: 100px; height: 130px; object-fit: cover;">
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-6">
                                            <p><strong>Student Name:</strong> &nbsp; &nbsp; <?php echo $row['name']; ?></p>
                                            <p><strong>Class:</strong> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $row['class']; ?></p>
                                            <p><strong>Student Roll no:</strong> &nbsp;<?php echo $row['roll_no']; ?></p>
                                            <p><strong>Phone no:</strong> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $row['phone_no']; ?></p>
                                            <p><strong>Whatsapp no:</strong> &nbsp; &nbsp; <?php echo $row['whatsapp']; ?></p>
                                            <p><strong>City:</strong> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; <?php echo $row['city']; ?></p>
                                            <p><strong>Admission date:</strong> &nbsp;<?php echo $row['admission_date']; ?></p>
                                            <p><strong>Date:</strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<?php echo date('d-m-Y')  ?></p>


                                        </div>
                                    <?php endwhile; ?>
                                    <div class="col-md-6 text-md-end">
                                        <p><strong>Invoice no:</strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 01 /<?php echo date('Y')  ?></p>
                                    </div>
                                    </div>
                                    <hr style="color:black">
                                    <div class="table-responsive">
                                        <table class=" col-lg-12 mt-3 mx-5">
                                            <thead class="text-center text-wrap">
                                                <tr>
                                                    <th>Slno</th>
                                                    <th style="width: 50%;">Summary</th>
                                                    <th colspan="4">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center text-wrap">
                                                <tr>
                                                    <td><br></td>
                                                </tr>
                                                <tr class="mt-5">
                                                    <td class="text-wrap text-break">1</td>
                                                    <td class="text-wrap text-break">
                                                        lorem100
                                                    </td>
                                                    <td colspan="4" class="text-wrap text-break">Rs 500</td>
                                                </tr>
                                                <tr>
                                                <tr>
                                                    <td>
                                                        <br>
                                                    </td>
                                                </tr>
                                                <td colspan="0"><strong>Total</strong></td>
                                                <td colspan="1"><strong></strong></td>
                                                <td class="text-wrap text-break"><strong>Rs 550</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <hr style="color:black">
                                        <div class="text-center mt-5 d-flex justify-content-center align-items-center">
                                            <p>This invoice is computer generated</p>
                                        </div>

                                    </div>
                            </div>
                        </div>
                        <!-- /table header -->
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button class="btn btn-danger text-white mt-2 mb-2" onclick="sendWhatsApp()">Edit</button>
                    <button class="btn btn-info text-white mt-2 mb-2" onclick="printInvoice()">Add Form</button>
                </div>
                <div class="text-center mt-4">
                    <button class="btn btn-primary mt-2 mb-2" onclick="printInvoice()"><i class="fa-solid fa-download"></i> Download</button>
                    <button class="btn btn-success text-white mt-2 mb-2" onclick="sendWhatsApp()"><i class="fa-brands fa-whatsapp"></i> Send via WhatsApp</button>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.php -->
                <?php include "footer.php"  ?>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- /container-scroller -->
    <script>
        // Function to download the invoice as a PDF
        function printInvoice() {
            const originalContent = document.body.innerHTML;
            const invoiceContent = document.getElementById('invoice').outerHTML;

            // Temporarily replace body content with the invoice
            document.body.innerHTML = invoiceContent;

            // Trigger print
            window.print();

            // Restore the original body content
            document.body.innerHTML = originalContent;
        }

        // Function to send the invoice via WhatsApp
        function sendWhatsApp() {
            const phoneNumber = prompt("Enter the recipient's WhatsApp number:");
            if (phoneNumber) {
                const message = encodeURIComponent(`Hello,\n\nPlease find your invoice below:\n\nStudent Name: John Doe\nInvoice #: <?php echo "heloo" ?>\n\nYour due amount: $200\nTotal Amount: $550`);
                const whatsappUrl = `https://wa.me/${phoneNumber}?text=${message}`;
                window.open(whatsappUrl, '_blank');
            }
        }
    </script>
    <!-- custom js -->
    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <!-- bootstrap Library -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/chart.umd.js"></script>
    <script src="assets/vendors/datatables.net/jquery.dataTables.js"></script>
    <!-- <script src="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script> -->
    <script src="assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js"></script>
    <script src="assets/js/dataTables.select.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/template.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
    <script src="assets/js/dashboard.js"></script>
    <!-- <script src="assets/js/Chart.roundedBarCharts.js"></script> -->
    <!-- End custom js for this page-->
</body>

</html>