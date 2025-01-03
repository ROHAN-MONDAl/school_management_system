<?php
include '../server_database.php';

// Fetch total amount from the payments table
$sql = "SELECT SUM(amount) AS total_amount FROM payments";
$result = mysqli_query($conn, $sql);

$totalAmount = 0;
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $totalAmount = $row['total_amount'];
}

// Handling the Search and Date Range Filter
$searchTerm = '';
$startDate = '';
$endDate = '';

// Collect search data
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
}

if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $startDate = $_GET['start_date'];
    $endDate = $_GET['end_date'];
}

// Build dynamic query based on filters
$query = "SELECT payments.*, students.name FROM payments 
          JOIN students ON payments.student_id = students.id 
          WHERE 1";

// Apply search filter
if ($searchTerm != '') {
    $query .= " AND (students.name LIKE '%$searchTerm%' OR payments.invo_no LIKE '%$searchTerm%')";
}

// Apply date range filter
if ($startDate != '' && $endDate != '') {
    $query .= " AND payments.date BETWEEN '$startDate' AND '$endDate'";
}

// Execute the query
$result = mysqli_query($conn, $query);
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
    <!-- Add necessary stylesheets here -->
</head>

<body>
    <div class="container-scroller">
        <?php include 'header.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <?php include 'navbar.php'; ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <section class="row justify-content-center">
                        <h2 class="text-center fw-bolder text-primary">Daffodils School Funds</h2>
                        <div class="col-12 col-sm-6 mb-3">
                            <div class="card mx-auto" style="max-width: 400px;">
                                <div class="card-body text-center">
                                    <h4 class="card-title">Lifetime Earning</h4>
                                    <p class="display-4 fw-bolder text-success">Rs <?= number_format($totalAmount, 2) ?></p>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Filters Section -->
                    <form method="get" class="mb-3 mt-2">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-3 mb-2 mb-sm-0">
                                <input type="text" name="search" value="<?php echo $searchTerm; ?>" class="form-control" placeholder="Search by name or invoice">
                            </div>
                            <div class="col-12 col-sm-6 col-md-3 mb-2 mb-sm-0">
                                <input type="date" name="start_date" value="<?php echo $startDate; ?>" class="form-control">
                            </div>
                            <div class="col-12 col-sm-6 col-md-3 mb-2 mb-sm-0">
                                <input type="date" name="end_date" value="<?php echo $endDate; ?>" class="form-control">
                            </div>
                            <div class="col-12 col-sm-6 col-md-3 mt-2 mt-sm-0">
                                <button type="submit" class="btn btn-primary w-100 w-sm-auto mt-2">Apply Filters</button>
                            </div>
                        </div>
                    </form>


                    <!-- Balance Overview Section -->
                    <section class="mb-2">
                        <div class="row justify-content-center">
                            <div class="table-responsive">
                                <table id="dataTable" class="table display expandable-table">
                                    <thead class="text-center">
                                        <th>Slno</th>
                                        <th>Name</th>
                                        <th>Invoice No</th>
                                        <th>Amount</th>
                                        <th>Payment Type</th>
                                        <th>Payment Date</th>
                                        <!-- <th>Action</th> -->
                                    </thead>
                                    <tbody class="text-center">
                                        <?php if (mysqli_num_rows($result) > 0): ?>
                                            <?php
                                            $i = 1;
                                            while ($row = mysqli_fetch_assoc($result)):
                                            ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $row['name']; ?></td>
                                                    <td><?php echo $row['invo_no']; ?></td>
                                                    <td><?php echo $row['amount']; ?></td>
                                                    <td class="text-wrap"><?php echo $row['summary']; ?></td>
                                                    <td><?php echo $row['date']; ?></td>
                                                    <!-- <td>
                                                        <a href="students_payment_history.php?id=<?php echo $id; ?>&payment_id=<?php echo $row['payment_id']; ?>">
                                                            <button type="button" class="btn btn-danger text-white fw-bold btn-sm">Delete</button>
                                                        </a>
                                                    </td> -->
                                                </tr>
                                            <?php
                                                $i++;
                                            endwhile;
                                            ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="7">No data found</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
                <?php include "footer.php"; ?>
            </div>
        </div>
    </div>
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