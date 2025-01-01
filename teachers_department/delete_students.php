<?php
// Assuming a connection to the database is established
include('../server_database.php');

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // First, delete any related records in the payments table
    $deletePaymentsSQL = "DELETE FROM payments WHERE student_id = ?";
    if ($stmt = $conn->prepare($deletePaymentsSQL)) {
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $stmt->close();
    }

    // Then, delete the student record
    $deleteStudentSQL = "DELETE FROM students WHERE id = ?";
    if ($stmt = $conn->prepare($deleteStudentSQL)) {
        $stmt->bind_param("i", $student_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>
                alert('Student deleted successfully.');
                window.location.href = 'students.php?id=$student_id'; // Redirect back to the main page
            </script>";
        } else {
            echo "<script>
                alert('Error deleting student record: " . $conn->error . "');
                window.location.href = 'students.php?id=$student_id';
            </script>";
        }

        $stmt->close();
    } else {
        echo "Error in preparing the query.";
    }
}

$conn->close();
?>

