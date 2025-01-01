<?php
include '../server_database.php';

// Get the current date
date_default_timezone_set('Asia/Kolkata');
$date_today = date('Y-m-d');

// Fetch employers from the database
$query_employers = "SELECT id, name, designation FROM employers";
$result_employers = $conn->query($query_employers);
if (!$result_employers) {
    die("Error fetching employers: " . $conn->error);
}

// Fetch already marked employers' attendance for today
$query_get_marked_employers = "SELECT employer_id FROM employer_attendance WHERE date = ?";
$stmt = $conn->prepare($query_get_marked_employers);
$stmt->bind_param('s', $date_today);
$stmt->execute();
$result_marked_employers = $stmt->get_result();

$marked_employer_ids = [];
while ($row = $result_marked_employers->fetch_assoc()) {
    $marked_employer_ids[] = $row['employer_id'];
}
$stmt->close();

// Fetch the total number of employers
$total_employers = $result_employers->num_rows;

// Check if attendance is fully marked
$attendance_done = (count($marked_employer_ids) === $total_employers);

// Handle form submission for attendance marking
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Loop through the form data to insert attendance
    foreach ($_POST['status'] as $employer_id => $status) {
        $employer_id = $conn->real_escape_string($employer_id); // Sanitize input
        $status = $conn->real_escape_string($status); // Sanitize input

        // Insert attendance record
        $query_insert = "INSERT INTO employer_attendance (employer_id, status, date) 
                         VALUES ('$employer_id', '$status', '$date_today')";
        if (!$conn->query($query_insert)) {
            die("Error inserting attendance: " . $conn->error);
        }
    }

    // Redirect to refresh the attendance status page
    header("Location: employees_Attendence.php");
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
    <link rel="stylesheet" href="assets/css/customs.css">
    <link rel="shortcut icon" href="assets/images/favicon.png" />
    <style>
        .card-lg {
            width: 100%;
            /* Or set to a specific max-width like 80% */
            padding: 2rem;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <?php include 'header.php'; ?>

        <!-- Full-width container for body content -->
        <div class="container-fluid page-body-wrapper">
            <?php include 'navbar.php'; ?>

            <!-- Main Panel Content -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="mb-3 text-center text-primary">Mark Employer Attendance for Today</h4>

                            <!-- Row for Date and Attendance Status -->
                            <div class="row justify-content-between align-items-center">
                                <!-- Date Section -->
                                <div class="col-12 col-md-6 mb-3 mb-md-0">
                                    <span class="fs-6 text-info" id="date"><?php echo $date_today; ?></span>
                                </div>
                                <!-- Attendance Status Section -->
                                <div class="col-12 col-md-6 text-center text-md-end">
                                    <?php if ($attendance_done): ?>
                                        <p class="mb-0 text-success">All employers have marked attendance today.</p>
                                    <?php else: ?>
                                        <p class="mb-0 text-warning">Some employers have not marked attendance yet.</p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Attendance Table -->
                            <form action="" method="POST">
                                <div class="table-responsive">
                                    <table class="table table-hover mt-4" style="font-size: 1.2rem; border-spacing: 0.5rem;">
                                        <thead class="text-center bg-info text-white">
                                            <tr>
                                                <th>Slno</th>
                                                <th>Designation</th>
                                                <th>Name</th>
                                                <th>Present</th>
                                                <th>Absent</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php
                                            $slno = 1;
                                            while ($row = $result_employers->fetch_assoc()):
                                            ?>
                                                <tr>
                                                    <td><?php echo $slno++; ?></td>
                                                    <td><?php echo htmlspecialchars($row['designation']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['name']); ?></td>

                                                    <td>
                                                        <input type="checkbox" name="status[<?php echo $row['id']; ?>]" value="Present" <?php echo in_array($row['id'], $marked_employer_ids) ? 'disabled' : ''; ?>>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" name="status[<?php echo $row['id']; ?>]" value="Absent" <?php echo in_array($row['id'], $marked_employer_ids) ? 'disabled' : ''; ?>>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="form-group text-center mt-4">
                                    <button type="submit" class="btn btn-primary fw-bolder" <?php echo $attendance_done ? 'disabled' : ''; ?>>Submit Attendance</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <?php include "footer.php"; ?>
            </div>

        </div>
    </div>


    <!-- Include JS and other script files here -->

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