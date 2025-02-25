<?php
include '../server_database.php';

// Set timezone and fetch selected date or use today's date
date_default_timezone_set('Asia/Kolkata');
$date_today = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// Get selected branch from GET
$selected_branch = isset($_GET['class']) ? $_GET['class'] : '';

// Fetch employers from the database regardless of attendance status
$query_employers = "SELECT id, name, designation, branch FROM employers WHERE branch = '$selected_branch'";
$result_employers = $conn->query($query_employers);
if (!$result_employers) {
    die("Error fetching employers: " . $conn->error);
}

// Fetch already marked employers' attendance for the selected date
$query_get_marked_employers = "SELECT employer_id FROM employer_attendance WHERE date = '$date_today'";
$result_marked_employers = $conn->query($query_get_marked_employers);
if (!$result_marked_employers) {
    die("Error fetching attendance: " . $conn->error);
}

$marked_employer_ids = [];
while ($row = $result_marked_employers->fetch_assoc()) {
    $marked_employer_ids[] = $row['employer_id'];
}

// Check if attendance is fully marked
$total_employers = $result_employers->num_rows;
$attendance_done = ($total_employers > 0 && count($marked_employer_ids) === $total_employers);

// Handle form submission for attendance marking
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST['status'] as $employer_id => $status) {
        $employer_id = $conn->real_escape_string($employer_id);
        $status = $conn->real_escape_string($status);

        // Prevent duplicate entries for the same date and employer
        if (!in_array($employer_id, $marked_employer_ids)) {
            $query_insert = "INSERT INTO employer_attendance (employer_id, status, date) VALUES ('$employer_id', '$status', '$date_today')";
            if (!$conn->query($query_insert)) {
                die("Error inserting attendance: " . $conn->error);
            }
        }
    }
    header("Location: employees_Attendence.php?date=$date_today&class=$selected_branch");
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
                            <h3 class="mb-3 text-center fw-bold text-primary">Mark Employer Attendance</h3>
                            <!-- Attendance Status Section -->
                            <div class="text-center">
                                <?php if ($attendance_done): ?>
                                    <p class="text-success">All teachers have marked attendance for <?php echo $date_today; ?>.</p>
                                <?php else: ?>
                                    <p class="text-info">Some teachers have not marked attendance yet for <?php echo $date_today; ?>.</p>
                                <?php endif; ?>
                            </div>

                            <!-- Row for Date and Attendance Status -->
                            <div class="row justify-content-between align-items-center">
                                <!-- Date Picker HTML -->
                                <form method="GET" action="">
                                    <label for="attendance-date" class="text-gray-700 font-medium">Select Date:</label>
                                    <input type="date" id="attendance-date" name="date" class="form-control w-full sm:w-auto rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3" value="<?php echo $date_today; ?>" onchange="this.form.submit()">
                                    <input type="hidden" name="class" value="<?php echo $selected_branch; ?>">
                                </form>
                            </div>

                            <!-- Attendance Table HTML Update -->
                            <form action="" method="POST">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-striped table-bordered col-lg-12 mt-3">
                                        <thead class="text-center">
                                            <tr class="table-warning">
                                                <th>Slno</th>
                                                <th>Branch</th>
                                                <th>Designation</th>
                                                <th>Name</th>
                                                <th>Present</th>
                                                <th>Absent</th>
                                                <th>Halfday</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php
                                            $slno = 1;
                                            $result_employers->data_seek(0); // Reset pointer for new date selection
                                            while ($row = $result_employers->fetch_assoc()):
                                                $is_marked = in_array($row['id'], $marked_employer_ids);
                                            ?>
                                                <tr>
                                                    <td><?php echo $slno++; ?></td>
                                                    <td><?php echo htmlspecialchars($row['branch']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['designation']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                                    <?php if ($is_marked): ?>
                                                        <td colspan="3">Already marked</td>
                                                        <td class="text-success">Marked</td>
                                                    <?php else: ?>
                                                        <td><input type="radio" name="status[<?php echo $row['id']; ?>]" value="Present" required></td>
                                                        <td><input type="radio" name="status[<?php echo $row['id']; ?>]" value="Absent" required></td>
                                                        <td><input type="radio" name="status[<?php echo $row['id']; ?>]" value="Halfday" required></td>
                                                        <td class="text-warning">Pending</td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="form-group text-center mt-4">
                                    <button type="submit" class="btn btn-primary fw-bolder" <?php echo $attendance_done ? 'disabled' : ''; ?>>
                                        Submit Attendance
                                    </button>
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