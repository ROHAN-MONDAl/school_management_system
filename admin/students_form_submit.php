<?php
include '../server_database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect form data
    $name = $_POST['name'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $class = $_POST['class'] ?? '';
    $roll_no = $_POST['roll_no'] ?? '';
    $phone_no = $_POST['phone_no'] ?? '';
    $whatsapp = $_POST['whatsapp'] ?? '';
    $optional_phone = $_POST['optional_phone'] ?? '';
    $city = $_POST['city'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $branch = $_POST['branch'] ?? '';
    $admission_date = $_POST['admission_date'] ?? '';
    $admission_package = $_POST['admission_package'] ?? '';
    $today_date = date('Y-m-d');
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    // Validate the password
    if (empty($password) || strlen($_POST['password']) < 6) {
        header("Location: student_addmission_frm.php?message=Password must be at least 6 characters&type=error");
        exit;
    }

    // Handle file upload
    $upload_dir = "assets/images/";
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $img_name = $_FILES['img']['name'] ?? '';
    $img_temp = $_FILES['img']['tmp_name'] ?? '';
    $img_size = $_FILES['img']['size'] ?? 0;
    $max_size = 5 * 1024 * 1024; // 5 MB in bytes

    // Check if the file size exceeds 5 MB
    if ($img_size > $max_size) {
        header("Location: student_addmission_frm.php?message=Image size must not exceed 5 MB&type=error");
        exit;
    }

    // Check for JPG file extension and MIME type
    $allowed_extensions = ['jpg', 'jpeg'];
    $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));

    if (!in_array($img_ext, $allowed_extensions)) {
        header("Location: student_addmission_frm.php?message=Only JPG images are allowed&type=error");
        exit;
    }

    $img_mime = mime_content_type($img_temp);
    if ($img_mime !== 'image/jpeg') {
        header("Location: student_addmission_frm.php?message=Invalid image type. Only JPG images are allowed&type=error");
        exit;
    }

    $img_path = $img_name ? $upload_dir . basename($img_name) : "assets/images/";

    if ($img_name && !move_uploaded_file($img_temp, $img_path)) {
        $img_path = "assets/images/"; // Fallback to default image if upload fails
    }

    // Validate required fields
    if ($name && $gender && $class && $roll_no && $phone_no && $whatsapp && $city && $branch && $admission_date && $password) {
        // Insert query
        $sql = "INSERT INTO students 
                (name, gender, class, roll_no, phone_no, whatsapp, optional_phone, city, dob, branch, admission_date, admission_package, today_date, password, image_path) 
                VALUES 
                ('$name', '$gender', '$class', '$roll_no', '$phone_no', '$whatsapp', '$optional_phone', '$city', '$dob', '$branch', '$admission_date', '$admission_package', '$today_date', '$password', '$img_path')";

        if ($conn->query($sql) === TRUE) {
            // Redirect with success message
            header("Location: student_addmission_frm.php?message=Form submitted successfully&type=success");
            exit;
        } else {
            // Handle database errors
            $error_message = $conn->error;
            header("Location: student_addmission_frm.php?message=Database error: " . urlencode($error_message) . "&type=error");
            exit;
        }
    } else {
        header("Location: student_addmission_frm.php?message=All required fields must be filled out&type=error");
        exit;
    }
}

$conn->close();
?>
