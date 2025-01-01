<?php
// ... (database connection code) ...
include '../server_database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    date_default_timezone_set("Asia/kolkata");
    $date = date('Y-m-d');

    foreach ($_POST['status'] as $student_id => $attendance_status) {
        // Get the class for the current student
        $sql = "SELECT class FROM students WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) { 
            $class = $row['class']; 
        } else {
            $class = 'Unknown'; // Handle case where student ID is not found
        }

        // Insert attendance record
        $stmt = $conn->prepare("INSERT INTO students_attendance (student_id, date, status, class) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issi", $student_id, $date, $attendance_status, $class);
        $stmt->execute();
    }

    header("Location: students_Attendences.php");
}

// ... (database connection close) ...
?>