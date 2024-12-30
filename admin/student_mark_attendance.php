<?php
include '../server_database.php';

// Check if class is passed via URL
if (empty($_GET['class'])) {
    die('No class selected.');
}

$class = $conn->real_escape_string($_GET['class']); // Sanitize input
date_default_timezone_set('Asia/kolkata');
$date_today = date('Y-m-d');

// Fetch students from the selected class
$query_students = "SELECT * FROM students WHERE class = '$class'";
$result_students = $conn->query($query_students);
if (!$result_students) {
    die("Error fetching students: " . $conn->error);
}

// Fetch the total number of students
$total_students = $result_students->num_rows;

// Check if attendance has already been partially or fully marked
$query_get_marked_students = "SELECT student_id FROM school_attendance WHERE class = ? AND date = ?";
$stmt = $conn->prepare($query_get_marked_students);
$stmt->bind_param('ss', $class, $date_today);
$stmt->execute();
$result_marked_students = $stmt->get_result();

$marked_student_ids = [];
while ($row = $result_marked_students->fetch_assoc()) {
    $marked_student_ids[] = $row['student_id'];
}
$stmt->close();

$attendance_done = (count($marked_student_ids) === $total_students); // Check if attendance is fully done

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST['status'] as $student_id => $status) {
        $student_id = $conn->real_escape_string($student_id); // Sanitize input
        $status = $conn->real_escape_string($status); // Sanitize input

        // Insert attendance for the student
        $query_insert = "INSERT INTO school_attendance (student_id, class, status, date) 
                         VALUES ('$student_id', '$class', '$status', '$date_today')";
        if (!$conn->query($query_insert)) {
            die("Error inserting attendance: " . $conn->error);
        }
    }

    // Redirect to refresh the attendance status
    header("Location: students_Attendences.php?class=$class");
    exit();
}
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
        <?php include 'header.php' ?>
        <div class="container-fluid page-body-wrapper">
            <?php include 'navbar.php' ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title col-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                                        <span class="col-lg-6 fs-6 text-info" id="date"></span>
                                        <a href="student_att_history.php">
                                            <button class="btn btn-success btn-sm text-white font-weight-bold me-4">Check history</button>
                                        </a>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="table-responsive col-lg-12 col-md-12">
                                                <h3>Mark Attendance for Class: <?php echo htmlspecialchars($class); ?></h3>
                                                <?php if ($attendance_done): ?>
                                                    <div class="alert alert-warning mt-5">
                                                        Attendance for today has already been fully marked for this class.
                                                    </div>
                                                <?php else: ?>
                                                    <form action="" method="POST">
                                                        <table class="table display expandable-table col-lg-12 mt-4">
                                                            <div class="table-responsive">
                                                                <thead class="text-center text-wrap">
                                                                    <tr>
                                                                        <th>Slno</th>
                                                                        <th>Name</th>
                                                                        <th>Roll No</th>
                                                                        <th>Present</th>
                                                                        <th>Absent</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="text-center text-wrap">
                                                                    <?php
                                                                    $slno = 1;
                                                                    $result_students->data_seek(0); // Reset the result pointer
                                                                    while ($row = $result_students->fetch_assoc()):
                                                                        if (!in_array($row['id'], $marked_student_ids)): // Only show unmarked students
                                                                    ?>
                                                                            <tr>
                                                                                <td><?php echo $slno++; ?></td>
                                                                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                                                                <td><?php echo htmlspecialchars($row['roll_no']); ?></td>
                                                                                <td>
                                                                                    <input type="radio" name="status[<?php echo $row['id']; ?>]" value="Present">
                                                                                </td>
                                                                                <td>
                                                                                    <input type="radio" name="status[<?php echo $row['id']; ?>]" value="Absent">
                                                                                </td>
                                                                            </tr>
                                                                    <?php
                                                                        endif;
                                                                    endwhile; ?>
                                                                </tbody>
                                                            </div>
                                                        </table>
                                                        <div class="form-group text-center mt-4">
                                                            <button type="submit" class="btn btn-primary fw-bolder">Submit Attendance</button>
                                                        </div>

                                                    </form>
                                                <?php endif; ?>
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