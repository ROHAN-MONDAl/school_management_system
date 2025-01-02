<?php
include '../server_database.php'; // Ensure the database connection is included

$id = $_GET['id'] ?? null; // Get the student ID from the URL

if ($id) {
    // Ensure the column name 'id' or 'payment_id' matches your database's column name, e.g., 'student_id'
    // Prepare the query to fetch the latest payment record
    $sql = "SELECT * FROM payments WHERE student_id = ? ORDER BY payment_id DESC LIMIT 1"; // Modify 'payment_id' as per your table schema
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // Bind the student ID parameter as an integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $payment = $result->fetch_assoc(); // Fetch the latest payment record
    } else {
        $payment = null; // Set $payment to null if no record is found
    }

    // Handle form submission for updating payment details
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $payment) {
        // Sanitize and validate user input before using it in the query
        $amount = $_POST['amount'] ?? ''; // Amount
        $summary = $_POST['summary'] ?? ''; // Payment summary

        // Check if the necessary fields are provided
        if (!empty($amount) && !empty($summary)) {
            // Prepare the UPDATE query to update only the last payment entry for the given student_id
            $updateSql = "UPDATE payments SET amount = ?, summary = ? WHERE payment_id = ?";
            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param("dsi", $amount, $summary, $payment['payment_id']); // 'd' for double, 's' for string, 'i' for integer

            if ($stmt->execute()) {
                // Redirect after updating the payment record
                header('Location: views_payments.php?id=' . $id);
                exit();
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            echo "Please fill in all the required fields!";
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
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/js/select.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/customs.css">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/vendors/chart.js/chart.umd.js"></script>
    <script src="assets/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js"></script>
    <script src="assets/js/dataTables.select.min.js"></script>
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/template.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
    <script src="assets/js/dashboard.js"></script>
</body>

</html>