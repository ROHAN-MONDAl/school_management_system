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
        echo "<script>
            window.location.href = 'students_payment_history.php?id=<?php echo $id; ?>'; // Redirect back to the main page
        </script>";
    } else {
        echo "<script>
            alert('Error deleting record: " . $conn->error . "');
            window.location.href = 'students_payment_history.php?id=<?php echo $id; ?>';
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
