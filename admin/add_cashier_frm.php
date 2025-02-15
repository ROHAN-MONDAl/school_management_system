<?php
include '../server_database.php'; // Include your database connection file

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $message = "Passwords do not match!";
    } else {
        // Check for duplicate email
        $check_email_query = "SELECT email FROM cashiers WHERE email = ?";
        if ($stmt = mysqli_prepare($conn, $check_email_query)) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                $message = "Error: Email already exists!";
            } else {
                // Check for duplicate phone number
                $check_phone_query = "SELECT phone FROM cashiers WHERE phone = ?";
                if ($phone_stmt = mysqli_prepare($conn, $check_phone_query)) {
                    mysqli_stmt_bind_param($phone_stmt, "s", $phone);
                    mysqli_stmt_execute($phone_stmt);
                    mysqli_stmt_store_result($phone_stmt);

                    if (mysqli_stmt_num_rows($phone_stmt) > 0) {
                        $message = "Error: Phone number already exists!";
                    } else {
                        // Hash the password for security
                        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                        // Prepare the SQL query
                        $insert_query = "INSERT INTO cashiers (date, name, email, phone, password) VALUES (?, ?, ?, ?, ?)";
                        if ($insert_stmt = mysqli_prepare($conn, $insert_query)) {
                            // Bind parameters to the query
                            mysqli_stmt_bind_param($insert_stmt, "sssss", $date, $name, $email, $phone, $hashed_password);

                            // Execute the statement
                            if (mysqli_stmt_execute($insert_stmt)) {
                                $message = "Record inserted successfully!";
                            } else {
                                $message = "Error: Could not execute query. " . mysqli_error($conn);
                            }

                            // Close the insert statement
                            mysqli_stmt_close($insert_stmt);
                        } else {
                            $message = "Error: Could not prepare query. " . mysqli_error($conn);
                        }
                    }

                    // Close the check phone statement
                    mysqli_stmt_close($phone_stmt);
                } else {
                    $message = "Error: Could not prepare phone check query. " . mysqli_error($conn);
                }
            }

            // Close the check email statement
            mysqli_stmt_close($stmt);
        } else {
            $message = "Error: Could not prepare email check query. " . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);
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
            <div class="main-panel">
                <div class="content-wrapper">
                    <!-- main form section -->

                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <p><a href="cashiers.php"><button type="button" class="btn btn-warning text-white fw-bolder">Back</button></a></p>
                                <h4 class="card-title mt-3">Cashier Registration Form</h4>
                                <p class="card-description">Add Casier details</p>
                                <?php if (!empty($message)): ?>
                                    <div class="alert alert-info text-center">
                                        <?= htmlspecialchars($message) ?>
                                    </div>
                                <?php endif; ?>

                                <form method="POST">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Date</label>
                                        <input type="date" class="form-control text-primary" id="date" name="date" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" autocomplete="off" autocapitalize="words" autofocus id="name" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">email</label>
                                        <input type="email" class="form-control" autocomplete="on" id="email" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone" name="phone"
                                            pattern="[6-9]{1}[0-9]{9}"
                                            title="Phone number must be a 10-digit number starting with 6, 7, 8, or 9."
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                        title="Must contain at least one number, one uppercase letter, one lowercase letter, and at least 8 or more characters" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                        title="Must contain at least one number, one uppercase letter, one lowercase letter, and at least 8 or more characters" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- /main form section -->
                </div>
                <!-- partial:partials/_footer.php -->
                <?php include "footer.php"  ?>
                <!-- partial -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
    </div>
    <!-- container-scroller -->
    <script>
        // Password confirmation validation
        document.querySelector("form").addEventListener("submit", function(event) {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;

            if (password !== confirmPassword) {
                alert("Passwords do not match. Please try again.");
                event.preventDefault(); // Prevent form submission
            }
        });
    </script>
    <!-- custom js -->
    <script src="assets/js/script.js"></script>
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