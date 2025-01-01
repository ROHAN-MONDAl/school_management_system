<?php
// Assuming a connection to the database is established
include('../server_database.php');

if (isset($_GET['cid'])) {
    $cashiers_id = $_GET['cid'];

    // Then, delete the student record
    $deletecashiersSQL = "DELETE FROM cashiers WHERE cid = ?";
    if ($stmt = $conn->prepare($deletecashiersSQL)) {
        $stmt->bind_param("i", $cashiers_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>
       window.location.href = 'cashiers.php?cid=$cashiers_id'; // Redirect back to the main page
            </script>";
        } else {
            echo "<script>
                alert('Error deleting cashiers record: " . $conn->error . "');
                window.location.href = 'cashiers.php?cid=$cashiers_id';
            </script>";
        }

        $stmt->close();
    } else {
        echo "Error in preparing the query.";
    }
}

$conn->close();
