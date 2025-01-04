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
    
    $img_path = $img_name ? $upload_dir . basename($img_name) : "assets/images/";
    
    if ($img_name && !move_uploaded_file($img_temp, $img_path)) {
        $img_path = "assets/images/"; // Fallback to default image if upload fails
    }
    
    // Validate required fields
    if ($name && $gender && $class && $roll_no && $phone_no && $whatsapp && $city && $branch && $admission_date && $password) {
        // Check for duplicate roll_no
        $check_roll_no_query = "SELECT roll_no FROM students WHERE roll_no = ?";
        $check_roll_no_stmt = $conn->prepare($check_roll_no_query);
        $check_roll_no_stmt->bind_param("s", $roll_no);
    
        if ($check_roll_no_stmt->execute()) {
            $check_roll_no_stmt->store_result();
            if ($check_roll_no_stmt->num_rows > 0) {
                // Duplicate roll_no found
                header("Location: student_addmission_frm.php?message=Roll number already exists&type=error");
                exit;
            }
        }

        // Check for duplicate phone number
        $check_phone_query = "SELECT phone_no FROM students WHERE phone_no = ?";
        $check_phone_stmt = $conn->prepare($check_phone_query);
        $check_phone_stmt->bind_param("s", $phone_no);

        if ($check_phone_stmt->execute()) {
            $check_phone_stmt->store_result();
            if ($check_phone_stmt->num_rows > 0) {
                // Duplicate phone_no found
                header("Location: student_addmission_frm.php?message=Phone number already exists&type=error");
                exit;
            }
        }

        $check_phone_stmt->close();

        // Check for duplicate whatsapp number
        $check_whatsapp_query = "SELECT whatsapp FROM students WHERE whatsapp = ?";
        $check_whatsapp_stmt = $conn->prepare($check_whatsapp_query);
        $check_whatsapp_stmt->bind_param("s", $whatsapp);

        if ($check_whatsapp_stmt->execute()) {
            $check_whatsapp_stmt->store_result();
            if ($check_whatsapp_stmt->num_rows > 0) {
                // Duplicate whatsapp found
                header("Location: student_addmission_frm.php?message=WhatsApp number already exists&type=error");
                exit;
            }
        }

        $check_whatsapp_stmt->close();

        // Insert query
        $sql = "INSERT INTO students (name, gender, class, roll_no, phone_no, whatsapp, optional_phone, city, dob, branch, admission_date, admission_package, today_date, password, image_path) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sssssssssssssss", $name, $gender, $class, $roll_no, $phone_no, $whatsapp, $optional_phone, $city, $dob, $branch, $admission_date, $admission_package, $today_date, $password, $img_path);

            if ($stmt->execute()) {
                // Redirect with success message
                header("Location: student_addmission_frm.php?message=Form submitted successfully&type=success");
                exit;
            } else {
                // Redirect with database error message
                header("Location: student_addmission_frm.php?message=Database error: " . urlencode($stmt->error) . "&type=error");
                exit;
            }
        } else {
            header("Location: student_addmission_frm.php?message=Unable to prepare statement&type=error");
            exit;
        }
    } else {
        header("Location: student_addmission_frm.php?message=All required fields must be filled out&type=error");
        exit;
    }
}

$conn->close();
?>
