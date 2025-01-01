<?php
// Include your database connection file
include('../server_database.php'); // Make sure the connection is established correctly using MySQLi

if (isset($_GET['id'])) {
    $tid = $_GET['id'];

    // SQL delete query
    $query = "DELETE FROM staffs WHERE id = ?";

    // Prepare and bind the query
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameter to the SQL query
        $stmt->bind_param("i", $tid); // "i" is for integer
        
        // Execute the query
        if ($stmt->execute()) {
            // Redirect to the page where you want after the deletion (e.g., teachers.php)
            header('Location: staffs.php');
        } else {
            echo "Error: Unable to delete the record.";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: Failed to prepare the query.";
    }
}

?>

