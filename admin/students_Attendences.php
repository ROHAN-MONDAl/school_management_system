<?php include '../server_database.php';

$result = $conn->query("SELECT * FROM students");
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
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

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
        <?php include 'header.php' ?>
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
                                            <h2 class="font-weight-bold text-primary fw-bolder">Students Attendance</h2>
                                            <p class="text-secondary">Update students attendances</p>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center p-1">
                                        <div class="col-md-12">
                                            <div class="search-container align-items-center">
                                                <input type="text" class="form-control search-input" id="search"
                                                    placeholder="Search...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                   
                    <div class="row mt-2">
                        <div class="col-lg-12 col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">

                                    <div class="card-title col-12 mx-4 col-md-12 col-lg-12 d-flex justify-content-between">
                                        <span class="col-lg-6" id="date" style="font-size:1em"></span>
                                        
                                        <a href="student_att_history.php">
                                            <button class="btn btn-success btn-sm text-white font-weight-bold me-4">Check
                                                history</button></a>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="table-responsive col-lg-12 col-md-12">
                                                <form action="attendence_table.php" method="POST">
                                                    <table id="dataTable"
                                                        class="display expandable-table text-center col-lg-12 col-md-12 col-sm-6">
                                                        <thead class="text-center text-wrap">
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Class</th>
                                                                <th>Roll no</th>
                                                                <th>Present</th>
                                                                <th>Absent</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-center text-wrap">

                                                            <?php while ($row = $result->fetch_assoc()): ?>
                                                                <tr>
                                                                    <td><?php echo $row['name']; ?></td>
                                                                    <td><?php echo $row['class']; ?></td>
                                                                    <td><?php echo $row['roll_no']; ?></td>
                                                                    <td>
                                                                        <input type="radio"
                                                                            class="form-check-input btn btn-danger"
                                                                            name="status[<?php echo $row['id']; ?>]"
                                                                            value="Present" required> Present
                                                                    </td>
                                                                    <td>
                                                                        <input type="radio"
                                                                            class="form-check-input btn btn-danger"
                                                                            name="status[<?php echo $row['id']; ?>]"
                                                                            value="Absent" required> Absent
                                                                    </td>
                                                                </tr>
                                                            <?php endwhile; ?>
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <button type="reset" class="btn btn-danger fw-bolder btn-sm mt-5 text-white">Reset</button>
                                                <button type="submit" class="btn btn-success btn-sm fw-bolder mt-5 mx-3 text-white">Submit</button>
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
                <!-- partial:partials/_footer.php -->
                <?php include "footer.php" ?>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <script src="assets/js/script.js"></script>
    <!-- search filter -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        // Date update
        n = new Date();
        y = n.getFullYear();
        m = n.getMonth() + 1;
        d = n.getDate();
        document.getElementById("date").innerHTML = d + "-" + m + "-" + y;

        // search function
        $(document).ready(function() {
            // Function to filter rows based on search input
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

            // Function to filter rows based on date range
            $('#startDate, #endDate').on('change', function() {
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();

                $('#dataTable tbody tr').each(function() {
                    var row = $(this);
                    var dateText = row.find('td').eq(2).text(); // Get the date column (third column)

                    if (startDate && new Date(dateText) < new Date(startDate)) {
                        row.hide();
                        return;
                    }
                    if (endDate && new Date(dateText) > new Date(endDate)) {
                        row.hide();
                        return;
                    }

                    row.show(); // Show the row if within the date range
                });
            });
        });
    </script>
    <!-- custom js -->

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