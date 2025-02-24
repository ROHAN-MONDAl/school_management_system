<?php
include '../server_database.php';

// Validate and retrieve `class` and `branch`
if (empty($_GET['class']) || empty($_GET['branch'])) {
    die('Error: Class or branch not selected.');
}

$class = $conn->real_escape_string($_GET['class']);
$branch = $conn->real_escape_string($_GET['branch']);

// Set default date or get selected date
$date_today = isset($_POST['attendance_date']) ? $conn->real_escape_string($_POST['attendance_date']) : date('Y-m-d');

// Fetch students from the selected class and branch
$query_students = "SELECT * FROM students WHERE class = '$class' AND branch = '$branch' ORDER BY CAST(roll_no AS UNSIGNED) ASC";
$result_students = $conn->query($query_students);

if (!$result_students) {
    die("Error fetching students: " . $conn->error);
}

// Fetch marked attendance for the selected date
$query_get_marked_students = "SELECT student_id FROM school_attendance WHERE class = '$class' AND branch = '$branch' AND date = '$date_today'";
$result_marked_students = $conn->query($query_get_marked_students);

$marked_student_ids = [];
while ($row = $result_marked_students->fetch_assoc()) {
    $marked_student_ids[] = $row['student_id'];
}

$attendance_done = ($result_students->num_rows === count($marked_student_ids));

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status'])) {
    foreach ($_POST['status'] as $student_id => $status) {
        $student_id = $conn->real_escape_string($student_id);
        $status = $conn->real_escape_string($status);

        $query_check = "SELECT * FROM school_attendance WHERE student_id = '$student_id' AND date = '$date_today'";
        $result_check = $conn->query($query_check);

        if ($result_check->num_rows === 0) {
            $query_insert = "INSERT INTO school_attendance (student_id, class, branch, status, date) 
                             VALUES ('$student_id', '$class', '$branch', '$status', '$date_today')";
            if (!$conn->query($query_insert)) {
                die("Error inserting attendance: " . $conn->error);
            }
        }
    }

    header("Location: students_Attendences.php?class=$class&branch=$branch");
    exit();
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
    <style>
        .table-sm td,
        .table-sm th {
            padding: 5px;
            /* Adjust padding for even smaller rows */
            font-size: 0.875rem;
            /* Reduce font size */
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <?php include 'header.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <?php include 'navbar.php'; ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="bg-info shadow-lg rounded-xl p-1 rounded">
                                        <h3 class="text-light text-center sm:text-left fw-bold mt-2">
                                            Attendance for Class:
                                            <p><?php echo htmlspecialchars($class); ?></p>
                                        </h3>
                                    </div>

                                    <div class="bg-white p-4 rounded-lg shadow-md">
                                        <form method="POST" class="flex flex-col sm:flex-row items-center justify-center gap-4">
                                            <label for="attendance_date" class="text-gray-700 font-medium">Select Date:</label>
                                            <input type="date" name="attendance_date" id="attendance_date" class="form-control w-full sm:w-auto rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 
                                            focus:border-blue-500 p-3" value="<?php echo htmlspecialchars($date_today); ?>" onchange="this.form.submit()">
                                        </form>
                                    </div>
                                    <?php if ($attendance_done): ?>
                                        <p class="text-success text-center">Attendance is already marked for this date.</p>
                                    <?php else: ?>
                                        <form method="POST">
                                            <input type="hidden" name="attendance_date" value="<?php echo htmlspecialchars($date_today); ?>">
                                            <div class="table-responsive">
                                                <table id="dataTable" class="table table-striped table-bordered col-lg-12">
                                                    <thead class="text-center">
                                                        <tr class="table-warning">
                                                            <th>Roll No</th>
                                                            <th>Name</th>
                                                            <th>Present</th>
                                                            <th>Absent</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center text-wrap">
                                                        <?php while ($student = $result_students->fetch_assoc()): ?>
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($student['roll_no']); ?></td>
                                                                <td><?php echo htmlspecialchars($student['name']); ?></td>
                                                                <td>
                                                                    <?php if (in_array($student['id'], $marked_student_ids)): ?>
                                                                        <span class="text-danger">Already Marked</span>
                                                                    <?php else: ?>
                                                                        <label><input type="radio" name="status[<?php echo $student['id']; ?>]" class="form-check-input"  value="Present"> Present</label>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if (in_array($student['id'], $marked_student_ids)): ?>
                                                                        <span class="text-danger">Already Marked</span>
                                                                    <?php else: ?>
                                                                        <label><input type="radio" name="status[<?php echo $student['id']; ?>]" class="form-check-input"  value="Absent"> Absent</label>
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                        <?php endwhile; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-center mt-5">
                                                <button type="submit" class="btn btn-primary fw-bold">Submit Attendance</button>
                                            </div>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <?php include 'footer.php'; ?> -->
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        const today = new Date();
        document.getElementById('date').innerText = today.toLocaleDateString('en-IN');
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