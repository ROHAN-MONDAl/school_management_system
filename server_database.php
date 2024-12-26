<?php

try {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "daffodils_school";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>
