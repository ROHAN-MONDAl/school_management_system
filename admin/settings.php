<?php
include '../server_database.php'; // Include the database connection file

$message = ''; // Initialize message variable

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $username = trim($_POST['username']);
  $password = $_POST['password']; // New password
  $cpassword = $_POST['cpassword']; // Confirm new password
  $old_password = $_POST['old_password']; // Old password

  // Check if password and confirm password match
  if ($password !== $cpassword) {
    $message = "Passwords do not match!";
  } else {
    // Query to fetch the current (old) password from the database
    $sql = "SELECT password FROM user_settings WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($current_password);
    $stmt->fetch();

    // Check if the old password matches the current password
    if (!password_verify($old_password, $current_password)) {
      $message = "Old password is incorrect!";
    } else {
      // Hash the new password before updating it in the database
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      // Handle file upload (Profile Picture)
      $profile_picture = null;
      if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['photo']['tmp_name'];
        $file_name = $_FILES['photo']['name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $target_dir = "assets/images/"; // Directory to save the uploaded files
        $target_file = $target_dir . uniqid() . "." . $file_ext;

        // Check file size (max 5MB)
        if ($_FILES['photo']['size'] > 5 * 1024 * 1024) {
          $message = "File is too large. Maximum file size is 5MB.";
        } else {
          // Move the uploaded file to the target directory
          if (move_uploaded_file($file_tmp, $target_file)) {
            $profile_picture = $target_file; // Save the file path to the database
          } else {
            $message = "There was an error uploading the file.";
          }
        }
      }

      // Update the user settings in the database using MySQLi
      if (empty($message)) {
        try {
          // Prepare the SQL query to update user details (removed new_username)
          $sql = "UPDATE user_settings SET password = ?, profile_picture = ? WHERE username = ?";

          // Prepare the statement
          $stmt = $conn->prepare($sql);

          // Bind parameters
          $stmt->bind_param("sss", $hashed_password, $profile_picture, $username);

          // Execute the query
          if ($stmt->execute()) {
            $message = "Data updated successfully!";
          } else {
            $message = "Error: " . $stmt->error;
          }

          // Close the statement
          $stmt->close();
        } catch (Exception $e) {
          $message = "Error: " . $e->getMessage();
        }
      }
    }
  }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
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
    <?php include 'header.php'; ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.php -->
      <?php include 'navbar.php'; ?>
      <!-- Main Dashboard Panel -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h2 class="font-weight-bold text-primary fw-bolder">Settings</h2>
                </div>
              </div>
            </div>
          </div>
          <!-- main form section -->

          <div class="col-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Admin Details</h4>
                <p class="card-description"> Login verification details </p>

                <?php if (!empty($message)) { ?>
                  <div class="alert alert-info"><?php echo $message; ?></div>
                <?php } ?>
                <form action="settings.php" method="post" enctype="multipart/form-data">
                  <label for="username">Username:</label>
                  <input type="text" class="form-control" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>" required><br>

                  <!-- Old Password field -->
                  <label for="old_password">Old Password:</label>
                  <input type="password" class="form-control" name="old_password" id="old_password" required><br>

                  <!-- New Password field -->
                  <label for="password">New Password:</label>
                  <input type="password" class="form-control" name="password" id="password"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                    title="Must contain at least one number, one uppercase letter, one lowercase letter, and at least 8 or more characters" required><br>

                  <!-- Confirm New Password field -->
                  <label for="cpassword">Confirm New Password:</label>
                  <input type="password" class="form-control" name="cpassword" id="cpassword"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                    title="Must contain at least one number, one uppercase letter, one lowercase letter, and at least 8 or more characters" required><br>

                  <!-- Profile Picture Upload field -->
                  <label for="photo">Upload Profile Picture (Max 5MB):</label>
                  <input type="file" class="form-control" name="photo" id="photo" accept="image/*" /><br>

                  <div class="text-center mb-3">
                    <button type="submit" class="btn btn-primary fs-6 col-4">Submit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- /main form section -->
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.php -->
        <?php include "footer.php"; ?>
        <!-- partial -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
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