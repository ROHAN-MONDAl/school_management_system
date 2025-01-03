<?php
include '../server_database.php';

$id = $_GET['id'] ?? '';  // Getting student ID

// Ensure the ID is valid
if (empty($id)) {
    die('Invalid Student ID.');
}

// Fetch payment history for the student
$query = "SELECT * FROM payments WHERE student_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

// Handle deletion if payment_id is set
if (isset($_GET['payment_id'])) {
    $payment_id = $_GET['payment_id'];
    
    // Delete the payment
    $delete_query = "DELETE FROM payments WHERE payment_id = ? AND student_id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param('ii', $payment_id, $id);
    if ($delete_stmt->execute()) {
        header("Location: students_payment_history.php?id=" . $id . "&message=Payment record deleted successfully.");
        exit();
    } else {
        header("Location: students_payment_history.php?id=" . $id . "&error=Error deleting payment record.");
        exit();
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
        <?php include 'header.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <?php include 'navbar.php'; ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="font-weight-bold text-primary fw-bolder">Payments History</h2>
                            <p class="text-secondary">Student payments history</p>
                            <?php
                            // Display success or error messages
                            if (isset($_GET['message'])) {
                                echo "<p class='text-success'>" . htmlspecialchars($_GET['message']) . "</p>";
                            }
                            if (isset($_GET['error'])) {
                                echo "<p class='text-danger'>" . htmlspecialchars($_GET['error']) . "</p>";
                            }
                            ?>
                            <div class="table-responsive">
                                <table id="dataTable" class="table display expandable-table">
                                    <thead class="text-center">
                                        <th>Slno</th>
                                        <th>Payment Id</th>
                                        <th>Invoice No</th>
                                        <th>Amount</th>
                                        <th>Payment type</th>
                                        <th>Payment Date</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php if ($result->num_rows > 0): ?>
                                            <?php
                                            $i = 1;
                                            while ($row = $result->fetch_assoc()):
                                            ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $row['payment_id']; ?></td>
                                                    <td><?php echo $row['invo_no']; ?></td>
                                                    <td><?php echo $row['amount']; ?></td>
                                                    <td class="text-wrap"><?php echo $row['summary']; ?></td>
                                                    <td><?php echo $row['date']; ?></td>
                                                    <td>
                                                        <a href="students_payment_history.php?id=<?php echo $id; ?>&payment_id=<?php echo $row['payment_id']; ?>">
                                                            <button type="button" class="btn btn-danger text-white fw-bold btn-sm">Delete</button>
                                                        </a>
                                                    </td>
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
                    </div>
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
