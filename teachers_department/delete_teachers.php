<?php
// Include your database connection file
include('../server_database.php'); // Make sure the connection is established correctly using MySQLi

if (isset($_GET['tid'])) {
    $tid = $_GET['tid'];

    // SQL delete query
    $query = "DELETE FROM teachers WHERE tid = ?";

    // Prepare and bind the query
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameter to the SQL query
        $stmt->bind_param("i", $tid); // "i" is for integer
        
        // Execute the query
        if ($stmt->execute()) {
            // Redirect to the page where you want after the deletion (e.g., teachers.php)
            header('Location: teachers.php');
        } else {
            echo "Error: Unable to delete the record.";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: Failed to prepare the query.";
    }
}

// Close the database connection
$conn->close();
?>

