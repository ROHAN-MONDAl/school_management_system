<?php
include '../server_database.php';

// Retrieve student ID from URL
$student_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $student_id) {
    // Sanitize form data
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
    $class = filter_input(INPUT_POST, 'class', FILTER_SANITIZE_STRING);
    $roll_no = filter_input(INPUT_POST, 'roll_no', FILTER_SANITIZE_STRING);
    $phone_no = filter_input(INPUT_POST, 'phone_no', FILTER_SANITIZE_STRING);
    $whatsapp = filter_input(INPUT_POST, 'whatsapp', FILTER_SANITIZE_STRING);
    $optional_phone = filter_input(INPUT_POST, 'optional_phone', FILTER_SANITIZE_STRING);
    $branch = filter_input(INPUT_POST, 'branch', FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $dob = filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_STRING);
    $admission_date = filter_input(INPUT_POST, 'admission_date', FILTER_SANITIZE_STRING);
    $admission_package = filter_input(INPUT_POST, 'admission_package', FILTER_SANITIZE_NUMBER_INT);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING);

    // Check if passwords match
    if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
        header("Location: update_students_info.php?id=$student_id&message=$message&type=error");
        exit;
    }

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Handle image upload
    $image_url = '';
    if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] === UPLOAD_ERR_OK) {
        // Check if the file size exceeds 5MB
        if ($_FILES['image_path']['size'] > 5 * 1024 * 1024) {
            $message = "Image size exceeds 5MB. Please upload a smaller image.";
            header("Location: update_students_info.php?id=$student_id&message=$message&type=warning");
            exit;
        }

        $target_dir = "assets/images/";
        $target_file = $target_dir . basename($_FILES['image_path']['name']);
        if (move_uploaded_file($_FILES['image_path']['tmp_name'], $target_file)) {
            $image_url = $target_file; // Save image URL
        } else {
            $message = "Error uploading image.";
            header("Location: update_students_info.php?id=$student_id&message=$message&type=error");
            exit;
        }
    } else {
        // If no new image, use existing one
        $image_url = filter_input(INPUT_POST, 'existing_image', FILTER_SANITIZE_STRING);
    }

    // Prepare SQL query for update
    $query = "UPDATE students SET name = '$name', gender = '$gender', class = '$class', roll_no = '$roll_no', phone_no = '$phone_no', whatsapp = '$whatsapp', optional_phone = '$optional_phone', branch = '$branch', city = '$city', dob = '$dob', admission_date = '$admission_date', admission_package = '$admission_package', password = '$hashed_password', image_path = '$image_url' WHERE id = $student_id";

    // Execute query
    if (mysqli_query($conn, $query)) {
        $message = "Student data updated successfully.";
        header("Location: update_students_info.php?id=$student_id&message=$message&type=success");
    } else {
        $message = "Error updating student data.";
        header("Location: update_students_info.php?id=$student_id&message=$message&type=error");
    }
    exit;
} else {
    $message = "Invalid request.";
    header("Location: update_students_info.php?id=$student_id&message=$message&type=error");
    exit;
}
?>
