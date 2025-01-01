<?php
include '../server_database.php';

// Fetch cashier names
$cashiers = [];
$sql_cashiers = "SELECT cid, name FROM cashiers";
$result_cashiers = mysqli_query($conn, $sql_cashiers);

if ($result_cashiers) {
    while ($row = mysqli_fetch_assoc($result_cashiers)) {
        $cashiers[] = $row;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $user = $_POST['user'];
    $particular = $_POST['particular'];
    $price = $_POST['price'];
    $remark = $_POST['remark'];

    // Insert into the new `transactions` table
    $sql_insert = "INSERT INTO transactions (date, user, particular, price, remark) 
                   VALUES ('$date', '$user', '$particular', '$price', '$remark')";

    if (mysqli_query($conn, $sql_insert)) {
        header("Location: index.php"); // Redirect to expenses.php
        exit; // Ensure the script stops after the redirect
    }
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE php>
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
        <?php include 'header.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <?php include 'navbar.php'; ?>
            <!-- Main Dashboard Panel -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                    <h2 class="font-weight-bold text-primary fw-bolder">Trasaction form</h2>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- main form section -->

                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <a href="expenses.php" class="btn btn-warning text-white fw-bolder">Back</a>
                                <h4 class="card-title mt-5">Form</h4>

                                <!-- Form -->
                                <form method="POST" action="">
                                    <div class="mb-3">
                                        <label for="date" class="form-label text-black">Date</label>
                                        <input type="date" class="form-control" id="date" name="date" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="user" class="form-label">Users</label>
                                        <select class="form-select text-black" id="user" name="user" required>
                                            <option value="">Select Cashier</option>
                                            <?php foreach ($cashiers as $cashier): ?>
                                                <option class="text-black" value="<?= $cashier['name'] ?>"><?= $cashier['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="particular" class="form-label">Particular</label>
                                        <input type="text" class="form-control" id="particular" name="particular" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="number" class="form-control" id="price" name="price" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="remark" class="form-label">Remark</label>
                                        <textarea class="form-control" id="remark" name="remark" rows="3"></textarea>
                                    </div>
                                    <div class="text-center mb-3">
                                    <button type="submit" class="btn btn-primary fs-6 col-12">Submit</button>
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