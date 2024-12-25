<?php
// ... (database connection code) ...
include '../server_database.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    date_default_timezone_set("Asia/kolkata");
    $date = date('Y-m-d H:i:s');
    $status = $_POST['status'];

    // Check if "class" is provided
    if (isset($_POST['class']) && !empty($_POST['class'])) {
        $class = $_POST['class']; 
    } else {
        // Handle the case where "class" is not provided
        // For example, set a default value or display an error
        $class = 'Unknown'; // Or another appropriate default value
    }

    foreach ($status as $student_id => $attendance_status) {
        $stmt = $conn->prepare("INSERT INTO attendance (student_id, date, status, class) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issi", $student_id, $date, $attendance_status, $class);
        $stmt->execute();
    }

    header("Location: students_Attendences.php");
}

// ... (database connection close) ...
?>