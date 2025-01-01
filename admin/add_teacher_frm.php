<?php
include '../server_database.php';

// Initialize variables for error messages and success messages
$errorMessage = "";
$successMessage = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle file upload
    $targetDir = "assets/images/";
    $allowedExtensions = ['jpg', 'png'];
    $maxFileSize = 5 * 1024 * 1024; // 5MB

    // Ensure the uploads directory exists, create if it doesn't
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true); // Create directory with read/write permissions
    }

    // Check if file is uploaded
    if (!isset($_FILES['photo'])) {
        $errorMessage = "Error: No file uploaded.";
    } else {
        $fileName = basename($_FILES['photo']['name']);
        $fileSize = $_FILES['photo']['size'];
        $fileTmpName = $_FILES['photo']['tmp_name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Validate file size
        if ($fileSize > $maxFileSize) {
            $errorMessage = "Error: File size exceeds 5MB.";
        }

        // Validate file type
        if (!in_array($fileExtension, $allowedExtensions)) {
            $errorMessage = "Error: Only JPG and PNG files are allowed.";
        }

        // Move file to target directory
        $photo = $targetDir . uniqid() . "_" . $fileName;
        if (!move_uploaded_file($fileTmpName, $photo)) {
            $errorMessage = "Error: Failed to upload file.";
        }
    }

    // Check password fields
    if (empty($_POST['password']) || empty($_POST['cpassword'])) {
        $errorMessage = "Password and confirm password are required.";
    } elseif ($_POST['password'] !== $_POST['cpassword']) {
        $errorMessage = "Password and confirm password do not match.";
    }

    // If there are no errors, proceed with database insertion
    if (!$errorMessage) {
        // Sanitize and validate other inputs
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "Invalid email format.";
        }

        // Check if email already exists
        $emailCheck = "SELECT * FROM teachers WHERE email = '$email'";
        $emailResult = $conn->query($emailCheck);
        if ($emailResult->num_rows > 0) {
            $errorMessage = "This email is already registered.";
        }

        // Check if phone number already exists
        $phoneCheck = "SELECT * FROM teachers WHERE phone = '$phone'";
        $phoneResult = $conn->query($phoneCheck);
        if ($phoneResult->num_rows > 0) {
            $errorMessage = "This phone number is already registered.";
        }

        // If there are no errors, proceed to insert data into the database
        if (!$errorMessage) {
            // Hash the password
            $passwordHash = password_hash($_POST['password'], PASSWORD_BCRYPT);

            // Insert into database if there are no errors
            $sql = "INSERT INTO teachers (photo, name, phone, email, designation, joining_date, branch, salary, password)
                    VALUES ('$photo', '$name', '$phone', '$email', '" . $_POST['designation'] . "', '" . $_POST['joining_date'] . "', '" . $_POST['branch'] . "', '" . $_POST['salary'] . "', '$passwordHash')";

            if ($conn->query($sql)) {
                $successMessage = "Record inserted successfully!";
            } else {
                $errorMessage = "Error executing the query: " . $conn->error;
            }
        }
    }
}

// Fetch branches from the students table
$branchOptions = "";
$sql = "SELECT DISTINCT branch FROM students"; // Assuming "branch" column exists in the "students" table
$result = $conn->query($sql);

// Check if there are results and populate the dropdown options
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $branchOptions .= "<option value='" . $row['branch'] . "'>" . $row['branch'] . "</option>";
    }
} else {
    $branchOptions = "<option value=''>No branches available</option>";
}

// Close the database connection
$conn->close();
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
            <!-- Main Dashboard Panel -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <!-- table header -->
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <a href="teachers.php" class="btn btn-warning text-white fw-bolder">Back</a>
                                <h4 class="card-title mt-5">Form</h4>
                                <p class="card-description text-danger"><b>Warning: Be careful while filling details</b></p>

                                <!-- Display the error message if there is one -->
                                <?php if ($errorMessage): ?>
                                    <div class="alert alert-danger">
                                        <strong>Error!</strong> <?php echo $errorMessage; ?>
                                    </div>
                                <?php elseif ($successMessage): ?>
                                    <div class="alert alert-success">
                                        <strong>Success!</strong> <?php echo $successMessage; ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Form -->
                                <form action="" method="post" enctype="multipart/form-data">
                                    <label for="photo">Photo:</label>
                                    <input type="file" class="form-control" name="photo" id="photo" accept="image/*"><br>

                                    <label for="name">Name:</label>
                                    <input type="text" class="form-control" name="name" autocomplete="off" autofocus autocapitalize="words" id="name" required><br>

                                    <label for="phone">Phone No:</label>
                                    <input type="tel" class="form-control" pattern="^(\+91[\-\s]?)?[0]?(91)?[6789]\d{9}$"
                                        oninput="if (typeof this.reportValidity === 'function') {this.reportValidity();}" name="phone" autocomplete="off" id="phone" required><br>

                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" name="email" id="email" required><br>

                                    <label for="designation">Designation:</label>
                                    <input type="text" class="form-control" name="designation"  autocomplete="on" autofocus autocapitalize="words" id="designation" required><br>

                                    <label for="joining_date">Joining Date:</label>
                                    <input type="date" class="form-control" name="joining_date" id="joining_date" required><br>

                                    <label for="branch">Branch:</label>
                                    <select name="branch" class="form-control" id="branch" required>
                                        <?php echo $branchOptions; ?>
                                    </select><br>

                                    <label for="salary">Salary:</label>
                                    <input type="number" class="form-control" name="salary" autocomplete="off" id="salary" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="departmentPassword"
                                    title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required><br>

                                    <label for="password">Password:</label>
                                    <input type="password" class="form-control" name="password" autocomplete="off" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="departmentPassword"
                                    title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required><br>

                                    <label for="cpassword">Confirm Password:</label>
                                    <input type="password" class="form-control" name="cpassword" autocomplete="off" id="cpassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                        title="Must contain at least one number, one uppercase letter, one lowercase letter, and at least 8 or more char" required><br>

                                    <div class="text-center mb-3">
                                    <button type="submit" class="btn btn-primary fs-6 col-4">Submit</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <!-- /main form section -->
                    </div>
                </div>
                <?php include "footer.php"  ?>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

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