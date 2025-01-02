<?php include '../server_database.php';

// Fetch totals from the database
$total_teachers = $conn->query("SELECT COUNT(*) as count FROM teachers")->fetch_assoc()['count'];
$total_students = $conn->query("SELECT COUNT(*) as count FROM students")->fetch_assoc()['count'];
$total_employers = $conn->query("SELECT COUNT(*) as count FROM employers")->fetch_assoc()['count'];
$total_staffs = $conn->query("SELECT COUNT(*) as count FROM staffs")->fetch_assoc()['count'];

// Fetch teacher attendance records
$teacher_query = "
SELECT teachers.name, teachers.designation, teachers.branch, teacher_attendance.date, teacher_attendance.status
FROM teacher_attendance
JOIN teachers ON teacher_attendance.teacher_id = tid
ORDER BY teacher_attendance.date DESC
";
$teacher_result = $conn->query($teacher_query);

// Fetch employer attendance records
$employer_query = "
SELECT employers.name, employers.designation, employers.branch,employer_attendance.date, employer_attendance.status
FROM employer_attendance
JOIN employers ON employer_attendance.employer_id = employers.id
ORDER BY employer_attendance.date DESC
";
$employer_result = $conn->query($employer_query);

// Fetch staff attendance records
$staff_query = "
SELECT staffs.name, staffs.designation, staffs.branch, staff_attendance.date, staff_attendance.status
FROM staff_attendance
JOIN staffs ON staff_attendance.staff_id = staffs.id
ORDER BY staff_attendance.date DESC
";
$staff_result = $conn->query($staff_query);
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
  <link rel="stylesheet" href="assets/css/customs.css">
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
                      <h2 class="font-weight-bold text-primary fw-bolder">Dashboard</h2>
                      <p class="text-secondary">Overview all atendance</p>
                    </div>
                  </div>
                  <div class="container">
                    <div class="row">
                      <div class="col-lg-12 gy-2 transparent">
                        <div class="row">
                          <!-- Total Teachers -->
                          <div class="col-lg-3 mb-4 stretch-card transparent">
                            <div class="card bg-dark-subtle">
                              <div class="card-body">
                                <p class="mb-4 fw-bolder"><i class="fa-regular fa-user"></i> Total Teachers</p>
                                <p class="fs-30 mb-2 fw-bolder"><?php echo $total_teachers; ?></p>
                              </div>
                            </div>
                          </div>
                          <!-- Total Students -->
                          <div class="col-lg-3 mb-4 stretch-card transparent">
                            <div class="card bg-info-subtle">
                              <div class="card-body">
                                <p class="mb-4 fw-bolder"><i class="fa-regular fa-user"></i> Total Students</p>
                                <p class="fs-30 mb-2 fw-bolder"><?php echo $total_students; ?></p>
                              </div>
                            </div>
                          </div>
                          <!-- Total Employers -->
                          <div class="col-lg-3 mb-4 stretch-card transparent">
                            <div class="card bg-success">
                              <div class="card-body">
                                <p class="mb-4 fw-bolder"><i class="fa-regular fa-user"></i> Total Employers</p>
                                <p class="fs-30 mb-2 fw-bolder"><?php echo $total_employers; ?></p>
                              </div>
                            </div>
                          </div>
                          <!-- Total Staffs -->
                          <div class="col-lg-3 mb-4 stretch-card transparent">
                            <div class="card bg-warning">
                              <div class="card-body">
                                <p class="mb-4 fw-bolder"><i class="fa-regular fa-user"></i> Total Staffs</p>
                                <p class="fs-30 mb-2 fw-bolder"><?php echo $total_staffs; ?></p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- table header -->
          <div class="row mt-3">
    <!-- Teachers Table -->
    <div class="col-12">
        <h4 class="text-start">Teacher Attendance</h4>
        <div class="table-responsive">
            <table id="teacherTable" class="table table-bordered table-striped">
                <thead class="text-center text-wrap">
                    <tr>
                        <th>Slno</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Branch</th>
                        <th>Date</th>
                        <th>Attendance Status</th>
                    </tr>
                </thead>
                <tbody class="text-center text-wrap">
                    <?php if ($teacher_result->num_rows > 0): ?>
                    <?php
                    $slno = 1;
                    while ($row = $teacher_result->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?php echo $slno++; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['designation']); ?></td>
                        <td><?php echo htmlspecialchars($row['branch']); ?></td>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="6">No data found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Employers Table -->
    <div class="col-12 mt-4">
        <h4 class="text-start">Employer Attendance</h4>
        <div class="table-responsive">
            <table id="employerTable" class="table table-bordered table-striped">
                <thead class="text-center text-wrap">
                    <tr>
                        <th>Slno</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Branch</th>
                        <th>Date</th>
                        <th>Attendance Status</th>
                    </tr>
                </thead>
                <tbody class="text-center text-wrap">
                    <?php if ($employer_result->num_rows > 0): ?>
                    <?php
                    $slno = 1;
                    while ($row = $employer_result->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?php echo $slno++; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['designation']); ?></td>
                        <td><?php echo htmlspecialchars($row['branch']); ?></td>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="6">No data found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Staff Table -->
    <div class="col-12 mt-4">
        <h4 class="text-start">Staff Attendance</h4>
        <div class="table-responsive">
            <table id="staffTable" class="table table-bordered table-striped">
                <thead class="text-center text-wrap">
                    <tr>
                        <th>Slno</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Branch</th>
                        <th>Date</th>
                        <th>Attendance Status</th>
                    </tr>
                </thead>
                <tbody class="text-center text-wrap">
                    <?php if ($staff_result->num_rows > 0): ?>
                    <?php
                    $slno = 1;
                    while ($row = $staff_result->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?php echo $slno++; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['designation']); ?></td>
                        <td><?php echo htmlspecialchars($row['branch']); ?></td>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="6">No data found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

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
  <!-- container-scroller -->
  <!-- custom js -->
  <script src="assets/js/script.js"></script>
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