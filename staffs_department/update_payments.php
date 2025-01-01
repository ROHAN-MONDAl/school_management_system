<?php
include '../server_database.php'; // Make sure to include the database connection

$id = $_GET['id'] ?? null; // Get the student ID from the URL

if ($id) {
    // Ensure the column name 'id' or 'payment_id' matches your database's column name, e.g., 'student_id'
    // Assuming you have an auto-increment 'payment_id' or timestamp to find the latest entry
    $sql = "SELECT * FROM payments WHERE student_id = '$id' ORDER BY payment_id DESC LIMIT 1"; // Modify 'payment_id' as per your table schema
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $payment = $result->fetch_assoc(); // Fetch the latest payment record
    } else {
        $payment = null; // Set $payment to null if no record is found
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $payment) {
        // Collect the data from the form submission
        $amount = $_POST['amount'] ?? '';
        $summary = $_POST['summary'] ?? '';

        // Prepare the UPDATE query to update only the last payment entry for the given student_id
        $updateSql = "UPDATE payments SET amount = '$amount', summary = '$summary' WHERE payment_id = '{$payment['payment_id']}'";

        if ($conn->query($updateSql) === TRUE) {
            // Redirect after updating the payment record
            header('Location: views_payments.php?id=' . $id);
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Daffodils School</title>
    <link rel="stylesheet" href="assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="shortcut icon" href="assets/images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
         <?php include 'header.php'   ?>
        <div class="container-fluid page-body-wrapper">
            <?php include 'navbar.php' ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                    <h2 class="font-weight-bold text-primary fw-bolder">Edit Payment</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- main form section -->
                    <div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <a href="views_payments.php?id=<?php echo $id; ?>" class="btn btn-warning text-white fw-bolder">Back</a>
            <h4 class="card-title mt-5">Update Payment</h4>
            <p class="card-description text-danger"><b>Warning: Be careful while filling in details</b></p>

            <!-- Show message if no payment record is found -->
            <?php if (!$payment): ?>
                <div class="alert alert-danger">
                    <strong>No Payment Found!</strong> There are no payment records for this student.
                </div>
            <?php else: ?>
                <!-- Render the form with fetched data if a payment record exists -->
                <form method="post" class="forms-sample text-dark">
                    <div class="form-group">
                        <label for="amount"><b>Amount</b></label>
                        <input type="number" name="amount" class="form-control" id="amount" value="<?= htmlspecialchars($payment['amount'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="summary"><b>Summary</b></label>
                        <textarea name="summary" class="form-control" id="summary" rows="3" required><?= htmlspecialchars($payment['summary'] ?? '') ?></textarea>
                    </div>
                    <div class="form-group text-center mt-4">
                        <button type="reset" class="btn btn-dark fw-bold">Reset</button>
                        <button type="submit" class="btn btn-success text-white fw-bold">Update</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
                    <!-- main form section ends -->
                </div>
                <?php include "footer.php" ?>
            </div>
        </div>

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