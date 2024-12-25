<?php include '../server_database.php';

$query = "SELECT * FROM students";
$result = $conn->query($query);
// Fetch attendance records
$result = $conn->query("
SELECT students.roll_no, students.class, students.name, students_attendance.date, students_attendance.status
FROM students_attendance
JOIN students ON students_attendance.student_id = students.id
ORDER BY students_attendance.date DESC
");

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
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                            <h2 class="font-weight-bold text-primary fw-bolder">History</h2>
                                            <p class="text-secondary">Students Attendance history</p>
                                        </div>
                                    </div>

                                    <div class="row justify-content-center p-1">
                                        <div class="col-md-12 me-5">
                                            <div class="search-container align-items-center me-2">
                                                <div class="search-container col-lg-12  align-items-center">
                                                    <input type="text" class="form-control search-input" id="search" placeholder="Search..." onkeyup="filterTable()">
                                                </div>
                                                <p class="mx-3 mt-2 text-danger" style="cursor:pointer" data-toggle="modal" data-target="#exampleModalCenter">
                                                    <i style="font-size:24px;" class="fa text-danger">&#xf0b0;</i><b>Filter</b>
                                                </p>
                                            </div>

                                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form id="dateFilterForm" method="post" class="forms-sample bg-secondary p-5 text-center rounded">
                                                            <h3 class="text-white fx-bolder">Filter</h3>
                                                            <label for="startDate" class="text-black">Start Date:</label>
                                                            <input type="date" id="startDate" class="form-control" name="start_date" required>
                                                            <label for="endDate" class="text-black mt-2">End Date:</label>
                                                            <input type="date" id="endDate" class="form-control" name="end_date" required>
                                                            <button type="button" class="btn btn-primary mt-3" onclick="filterByDate()">Filter</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="dataTable" class="display expandable-table col-lg-12">
                                                    <thead class="text-center text-wrap">
                                                        <tr>
                                                            <th>Slno</th>
                                                            <th>Name</th>
                                                            <th>Class</th>
                                                            <th>Roll no</th>
                                                            <th>Date</th>
                                                            <th>Attendance</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center text-wrap">
                                                        <?php if ($result->num_rows > 0): ?>
                                                            <?php
                                                            $i = 1;
                                                            while ($row = $result->fetch_assoc()): ?>
                                                                <td><?php echo $i; ?></td>
                                                                <td><?php echo $row['name']; ?></td>
                                                                <td><?php echo $row['class']; ?></td>
                                                                <td><?php echo $row['roll_no']; ?></td>
                                                                <td><?php echo $row['date']; ?></td>
                                                                <td><?php echo $row['status']; ?></td>
                                                                </tr>
                                                            <?php
                                                                $i++;
                                                            endwhile; ?>
                                                        <?php else: ?>
                                                            <tr>
                                                                <td colspan="10">No data found</td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include "footer.php"  ?>
            </div>
        </div>
    </div>
    </div>

    </div>
    </div>
    </div>

    <script>
        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            table = document.getElementById("dataTable");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");
                let matchFound = false;

                for (let j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            matchFound = true;
                            break;
                        }
                    }
                }

                if (matchFound) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }

        function filterByDate() {
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();

            $('#dataTable tbody tr').each(function() {
                var row = $(this);
                var rowDate = new Date(row.find('td:eq(3)').text()); // Get date from the 4th column (index 3)

                if (startDate && rowDate < new Date(startDate) || endDate && rowDate > new Date(endDate)) {
                    row.hide();
                } else {
                    row.show();
                }
            });
        }
    </script>

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