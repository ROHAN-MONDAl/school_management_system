<?php
include '../server_database.php';

// Check for messages
$message = $_GET['message'] ?? '';
$message_type = $_GET['type'] ?? ''; // 'success' or 'error'

$cashiers_id = $_GET['cid'] ?? null;
if (!$cashiers_id) {
    header("Location: update_cash.php?message=Invalid User ID&type=error");
    exit;
}

// Fetch Old Password from Database
$query = "SELECT password FROM cashiers WHERE cid = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Database error: Unable to prepare statement");
}
$stmt->bind_param('i', $cashiers_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    header("Location: update_cash.php?message=User Not Found&type=error");
    exit;
}

$old_password_hash = $user['password'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Verify Old Password
    if (!password_verify($old_password, $old_password_hash)) {
        header("Location: update_cash.php?cid=$cashiers_id&message=Old Password is Incorrect&type=error");
        exit;
    }

    // Check if New Password Matches Confirm Password
    if ($new_password !== $confirm_password) {
        header("Location: update_cash.php?cid=$cashiers_id&message=Passwords Do Not Match&type=error");
        exit;
    }

    // Hash New Password and Update
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $update_query = "UPDATE cashiers SET password = ? WHERE cid = ?";
    $update_stmt = $conn->prepare($update_query);
    if (!$update_stmt) {
        die("Database error: Unable to prepare update statement");
    }
    $update_stmt->bind_param('si', $new_password_hash, $cashiers_id);

    if ($update_stmt->execute()) {
        header("Location: update_cash.php?cid=$cashiers_id&message=Password Updated Successfully&type=success");
        exit;
    } else {
        header("Location: update_cash.php?cid=$cashiers_id&message=Failed to Update Password&type=error");
    }
    exit;
}
?>