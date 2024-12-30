<?php
include '../server_database.php';  // Include your database connection

$student_id = $_GET['id'] ?? null;  // Get student ID

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $class = $_POST['class'];
    $roll_no = $_POST['roll_no'];
    $phone_no = $_POST['phone_no'];
    $whatsapp = $_POST['whatsapp'];
    $optional_phone = $_POST['optional_phone'];
    $branch = $_POST['branch'];
    $city = $_POST['city'];
    $dob = $_POST['dob'];
    $admission_date = $_POST['admission_date'];
    $admission_package = $_POST['admission_package'];
    $password = $_POST['password'];  // New password
    $confirm_password = $_POST['confirm_password'];  // Confirm new password

    // Validate passwords match
    if ($password !== $confirm_password) {
        header('Location: update_students_info.php?id=' . $student_id . '&message=Passwords do not match&message_type=error');
        exit;
    }

    // Fetch the current student data (excluding the old password)
    if ($student_id) {
        $query = "SELECT * FROM students WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $student = $result->fetch_assoc();

        // Check if student exists
        if (!$student) {
            echo "Student not found!";
            exit;
        }

        // Hash the new password before storing
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    } else {
        echo "Student ID is missing!";
        exit;
    }

    // Prepare the update query (update other fields too, not just password)
    $query = "UPDATE students SET name=?, gender=?, class=?, roll_no=?, phone_no=?, whatsapp=?, optional_phone=?, branch=?, city=?, dob=?, admission_date=?, admission_package=?, password=? WHERE id=?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo "Error preparing the query: " . $conn->error;
        exit;
    }

    // Bind the parameters and execute the update
    $stmt->bind_param('sssssssssssssi', $name, $gender, $class, $roll_no, $phone_no, $whatsapp, $optional_phone, $branch, $city, $dob, $admission_date, $admission_package, $hashed_password, $student_id);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        header('Location: update_students_info.php?id=' . $student_id . '&message= Update successfully&message_type=success');
        exit();
    } else {
        header('Location: update_students_info.php?id=' . $student_id . '&message=No changes were made or an error occurred&message_type=error');
        exit();
    }
}
?>
