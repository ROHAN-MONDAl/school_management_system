<?php
include '../server_database.php';

// Get the current date
$current_date = date('Y-m-d');

// Query to check if attendance has already been submitted for today
$sql_check_attendance = "SELECT * FROM students_attendance WHERE date = ?";
$stmt_check = $conn->prepare($sql_check_attendance);
$stmt_check->bind_param('s', $current_date);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

// If attendance is already recorded for today, disable the buttons
$attendance_submitted = $result_check->num_rows > 0;

$stmt_check->close();

// Fetch students from the database
$query = "SELECT * FROM students";
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
    <!-- End plugin css for this page -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="shortcut icon" href="assets/images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <?php include 'header.php' ?>
        <div class="container-fluid page-body-wrapper">
            <?php include 'navbar.php' ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row mt-2">
                        <div class="col-lg-12 col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-lg-4 col-md-4">
                                        <input type="text" id="classSearch" class="form-control" placeholder="Search by Class">
                                    </div>
                                    <div class="card-title col-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                                        <span class="col-lg-6 fs-6 text-info" id="date"></span>
                                        <a href="student_att_history.php">
                                            <button class="btn btn-success btn-sm text-white font-weight-bold me-4">Check history</button>
                                        </a>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="table-responsive col-lg-12 col-md-12">
                                                <form action="attendence_table.php" method="POST">
                                                    <table id="dataTable" class="display expandable-table text-center col-lg-12 col-md-12 col-sm-6">
                                                        <thead>
                                                            <tr>
                                                                <th>Slno</th>
                                                                <th>Name</th>
                                                                <th>Class</th>
                                                                <th>Roll no</th>
                                                                <th>Present</th>
                                                                <th>Absent</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if ($result->num_rows > 0): ?>
                                                                <?php $i = 1; ?>
                                                                <?php while ($row = $result->fetch_assoc()): ?>
                                                                    <tr>
                                                                        <td><?php echo $i; ?></td>
                                                                        <td class="text-wrap text-break w-25"><?php echo $row['name']; ?></td>
                                                                        <td>
                                                                            <input type="hidden" class="text-wrap text-break w-25" name="class[<?php echo $row['id']; ?>]" value="<?php echo $row['class']; ?>">
                                                                            <?php echo $row['class']; ?>
                                                                        </td>
                                                                        <td class="text-wrap text-break w-25"><?php echo $row['roll_no']; ?></td>
                                                                        <td>
                                                                            <input type="radio" class=" btn btn-danger" name="status[<?php echo $row['id']; ?>]" value="Present" required> Present
                                                                        </td>
                                                                        <td>
                                                                            <input type="radio" class=" btn btn-danger" name="status[<?php echo $row['id']; ?>]" value="Absent" required> Absent
                                                                        </td>
                                                                    </tr>
                                                                <?php $i++;
                                                                endwhile; ?>
                                                            <?php else: ?>
                                                                <tr>
                                                                    <td colspan="10">No data found</td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>
                                                    <div class="d-flex justify-content-end">
                                                        <button type="reset" class="btn btn-danger fw-bolder btn-sm mt-5 text-white" <?php echo $attendance_submitted ? 'disabled' : ''; ?>>Reset</button>
                                                        <button type="submit" class="btn btn-success btn-sm fw-bolder mt-5 mx-3 text-white" <?php echo $attendance_submitted ? 'disabled' : ''; ?>>Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /table header -->
                </div>
                <!-- content-wrapper ends -->
                <?php include "footer.php" ?>
            </div>
        </div>
    </div>
    <script src="assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Date update
        n = new Date();
        y = n.getFullYear();
        m = n.getMonth() + 1;
        d = n.getDate();
        document.getElementById("date").innerHTML = d + "-" + m + "-" + y;

        // Search function
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                var searchTerm = $(this).val().toLowerCase();
                $('#dataTable tbody tr').each(function() {
                    var row = $(this);
                    var rowText = row.text().toLowerCase();
                    if (rowText.includes(searchTerm)) {
                        row.show();
                    } else {
                        row.hide();
                    }
                });
            });
        });
    </script>
</body>

</html>