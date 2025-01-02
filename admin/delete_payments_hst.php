<?php
if (isset($_GET['payment_id'])) {
    $payment_id = $_GET['payment_id'];

    // Database connection
    include '../server_database.php';

    // Delete query
    $sql = "DELETE FROM payments WHERE payment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $payment_id);

    if ($stmt->execute()) {
        // Redirect back to the students payment history page with success message
        header("Location: students_payment_history.php?id=" . $_GET['id'] . "&message=Payment record deleted successfully.");
        exit(); // Ensure the script ends after the redirect
    } else {
        // Redirect with error message if deletion fails
        header("Location: students_payment_history.php?id=" . $_GET['id'] . "&error=Error deleting payment record.");
        exit();
    }
}
?>

