<?php
include '../server_database.php';

// Check if the 'id' parameter exists in the GET request
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<p class='text-danger'>Invalid student ID.</p>";
    exit;
}

// Generate a random 6-digit invoice number
$randomInvoiceNumber = mt_rand(100000, 999999);

// Initialize response message
$responseMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_id = $id;
    $date = date('Y-m-d');
    $invo_no = $randomInvoiceNumber; // Use the generated random invoice number
    $amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $summary = filter_input(INPUT_POST, 'summary', FILTER_SANITIZE_STRING);

    // Validate inputs
    if (empty($amount) || $amount <= 0) {
        $responseMessage = "<p class='text-danger'>Amount must be a positive number.</p>";
    } elseif (empty($summary)) {
        $responseMessage = "<p class='text-danger'>Summary is required.</p>";
    } else {
        // Check for duplicate invoice number
        $check_sql = "SELECT invo_no FROM payments WHERE invo_no = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $invo_no);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $responseMessage = "<p class='text-danger'>Invoice number already exists. Please try again.</p>";
        } else {
            // Insert new payment record
            $sql = "INSERT INTO payments (student_id, invo_no, amount, summary, date) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("sidss", $student_id, $invo_no, $amount, $summary, $date);
                if ($stmt->execute()) {
                    header("Location: views_payments.php?id=" . urlencode($id));
                    exit; // Ensure the script stops after the redirect
                } else {
                    $responseMessage = "<p class='text-danger'>Error: {$stmt->error}</p>";
                }
                $stmt->close();
            } else {
                $responseMessage = "<p class='text-danger'>Error preparing statement: {$conn->error}</p>";
            }
        }
        $check_stmt->close();
    }
}
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
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                    <h2 class="font-weight-bold text-primary fw-bolder">Payment Form</h2>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- main form section -->

                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <a href="views_payments.php?id=<?php echo $id; ?>" class="btn btn-warning text-white fw-bolder">Back</a>
                                <h4 class="card-title mt-5">Form</h4>
                                <p class="card-description text-danger"><b>Warning: Be carefull while fill details</b></p>

                                <!-- Form -->
                                <!-- Display the response message -->
                                <?php if (!empty($responseMessage)) echo $responseMessage; ?>
                                <form id="paymentForm" method="post" enctype="multipart/form-data" class="forms-sample text-dark">
                                    <div class="form-group">
                                        <label for="invo_no" class="text-info"> Invoice Number: * The Invoice number generate automatically *</label>
                                        <input type="text" id="invo_no" class="form-control" name="invo_no" value="<?php echo $randomInvoiceNumber; ?>" readonly disabled>
                                    </div>

                                    <div class="form-group">
                                        <label for="amount"><b>Amount</b></label>
                                        <input type="number" name="amount" class="form-control" id="amount" placeholder="Enter amount" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="summary"><b>Summary</b></label>
                                        <textarea class="form-control" id="summary" name="summary" rows="3" placeholder="Enter your payment details" required></textarea>
                                    </div>

                                    <div class="form-group text-center mt-4">
                                        <button type="reset" class="btn btn-dark fw-bolder">Reset</button>
                                        <button type="submit" class="btn btn-success text-white fw-bolder">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /main form section -->
                    </div>
                    <!-- content-wrapper ends -->
                </div>
                <!-- partial:partials/_footer.php -->
                <?php include "footer.php"  ?>
                <!-- partial -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
    </div>
    <!-- container-scroller -->
    <!-- Inline JavaScript for Real-Time Response -->
    <script>
        document.getElementById('paymentForm').onsubmit = function(e) {
            const responseMessage = document.getElementById('response-message');
            if (responseMessage.innerHTML.trim() === '') {
                responseMessage.style.display = 'none';
            } else {
                responseMessage.style.display = 'block';
            }
        };
    </script>

    </script>
    <!-- custom js -->
    <script src="assets/js/script.js"></script>
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