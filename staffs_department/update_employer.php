<?php
include '../server_database.php';

// Check for messages
$message = $_GET['message'] ?? '';
$message_type = $_GET['type'] ?? ''; // 'success' or 'error'

// Get Employer ID from GET parameters
$employer_id = $_GET['id'] ?? null;
if (!$employer_id) {
    header("Location: update_employer.php?message=Invalid User ID&type=error");
    exit;
}

// Fetch Old Password from Database
$query = "SELECT password FROM employers WHERE id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Database error: Unable to prepare statement");
}
$stmt->bind_param('i', $employer_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    header("Location: update_employer.php?message=User Not Found&type=error");
    exit;
}

$old_password_hash = $user['password'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Verify Old Password
    if (empty($old_password) || !password_verify($old_password, $old_password_hash)) {
        header("Location: update_employer.php?id=$employer_id&message=Old Password is Incorrect&type=error");
        exit;
    }

    // Check if New Password Matches Confirm Password
    if ($new_password !== $confirm_password) {
        header("Location: update_employer.php?id=$employer_id&message=Passwords Do Not Match&type=error");
        exit;
    }

    // Ensure the new password meets a minimum length requirement (optional security measure)
    if (strlen($new_password) < 8) {
        header("Location: update_employer.php?id=$employer_id&message=Password Must Be At Least 8 Characters&type=error");
        exit;
    }

    // Hash New Password and Update
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $update_query = "UPDATE employers SET password = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    if (!$update_stmt) {
        die("Database error: Unable to prepare update statement");
    }
    $update_stmt->bind_param('si', $new_password_hash, $employer_id);

    if ($update_stmt->execute()) {
        header("Location: update_employer.php?id=$employer_id&message=Password Updated Successfully&type=success");
        exit;
    } else {
        header("Location: update_employer.php?id=$employer_id&message=Failed to Update Password&type=error");
        exit;
    }
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
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <p><a href="employers.php"><button type="button" class="btn btn-warning text-white fw-bolder">Back</button></a></p>
                                <h4 class="card-title">Update Password</h4>
                                <p class="card-description">Update your old password</p>
                                <?php if ($message): ?>
                                    <div style="margin-bottom: 20px; padding: 10px; border: 1px solid <?= ($message_type === 'success') ? 'green' : 'red'; ?>; background-color: <?= ($message_type === 'success') ? '#d4edda' : '#f8d7da'; ?>; color: <?= ($message_type === 'success') ? '#155724' : '#721c24'; ?>; border-radius: 5px;">
                                        <?= htmlspecialchars($message); ?>
                                    </div>
                                <?php endif; ?>

                                <form method="POST" action="update_employer.php?id=<?= $employer_id; ?>">
                                    <div class="form-group">
                                        <label for="old_password">Old Password</label>
                                        <input type="password" name="old_password" id="old_password" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">New Password</label>
                                        <input type="password" name="password" id="password" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                            title="Must contain at least one number, one uppercase, one lowercase letter, and at least 8 characters" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password">Confirm Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                                    </div>
                                    <div class="text-center mb-3">
                                    <button type="submit" class="btn btn-primary fs-6">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include 'footer.php'; ?>
            </div>
        </div>
    </div>
    <script>
        // Password confirmation validation
        document.querySelector("form").addEventListener("submit", function(event) {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;

            if (password !== confirmPassword) {
                alert("Passwords do not match. Please try again.");
                event.preventDefault();
            }
        });
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