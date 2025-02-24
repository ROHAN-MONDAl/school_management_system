<?php
include '../server_database.php';

// Fetch available classes
$query_classes = "SELECT DISTINCT class FROM students";
$result_classes = $conn->query($query_classes);
if (!$result_classes) {
    die("Error fetching classes: " . $conn->error);
}

// Fetch available branches
$query_branches = "SELECT DISTINCT branch FROM students";
$result_branches = $conn->query($query_branches);
if (!$result_branches) {
    die("Error fetching branches: " . $conn->error);
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
                    <div class="row mt-2">
                        <div class="col-lg-12 col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="text-center text-info"><b>Students Attendance</b></h3>
                                    <form action="student_mark_attendance.php" method="GET" class="mt-4">
                                        <div class="form-group">
                                            <label for="class">Select Class:</label>
                                            <select name="class" id="class" class="form-control" required>
                                                <option value="">Select a class</option>
                                                <?php while ($row = $result_classes->fetch_assoc()): ?>
                                                    <option value="<?php echo htmlspecialchars($row['class']); ?>">
                                                        <?php echo htmlspecialchars($row['class']); ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="branch">Select Branch:</label>
                                            <select name="branch" id="branch" class="form-control" required>
                                                <option value="">Select a branch</option>
                                                <?php while ($row = $result_branches->fetch_assoc()): ?>
                                                    <option value="<?php echo htmlspecialchars($row['branch']); ?>">
                                                        <?php echo htmlspecialchars($row['branch']); ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>

                                        <div class="form-group text-center float-end col-12 col-lg-6 d-flex flex-column flex-lg-row justify-content-center">
                                            <a class="mb-2 mb-lg-0 col-12 col-lg-6">
                                                <button type="submit" class="btn btn-primary col-12 text-white fw-bold">Proceed</button>
                                            </a>
                                            <a href="student_att_history.php" class="mb-2 mb-lg-0 col-12 col-lg-6">
                                                <button type="button" class="btn btn-success col-12 text-white fw-bold">Check history</button>
                                            </a>
                                        </div>

                                    </form>
                                </div>
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