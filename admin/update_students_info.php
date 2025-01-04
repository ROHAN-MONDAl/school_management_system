<?php
include '../server_database.php';

// Retrieve student ID from URL
$student_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$message = filter_input(INPUT_GET, 'message', FILTER_SANITIZE_STRING);
$message_type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);

// Fetch existing student data from the database
if ($student_id) {
    // Query to fetch student data
    $query = "SELECT * FROM students WHERE id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param('i', $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $student = $result->fetch_assoc();
        if (!$student) {
            header('Location: students.php?message=Student not found&message_type=error');
            exit;
        }
    } else {
        header('Location: students.php?message=Database query error&message_type=error');
        exit;
    }
} else {
    header('Location: students.php?message=Invalid request. No student ID provided&message_type=error');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Daffodils School</title>
    <link rel="stylesheet" href="assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/js/select.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/customs.css">
    <link rel="shortcut icon" href="assets/images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <?php include 'header.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <?php include 'navbar.php'; ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                    <h2 class="font-weight-bold text-primary fw-bolder">Admission Form</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <p><a href="students.php"><button type="button" class="btn btn-warning text-white fw-bolder">Back</button></a></p>
                                <h4 class="card-title">Admission Form</h4>
                                <p class="card-description">Update student details</p>
                                <?php
                                // Check if there is a message to display
                                if (isset($_GET['message']) && isset($_GET['type'])) {
                                    $message = htmlspecialchars($_GET['message']);
                                    $message_type = htmlspecialchars($_GET['type']);

                                    // Display the message based on its type
                                    if ($message_type == 'error') {
                                        echo "<h3 style='color: red;'>$message</h3>";
                                    } elseif ($message_type == 'warning') {
                                        echo "<h3 style='color: orange;'>$message</h3>";
                                    } elseif ($message_type == 'success') {
                                        echo "<h3 style='color: green;'>$message</h3>";
                                    }
                                }
                                ?>

                                <form method="POST" action="update_form_submit.php?id=<?php echo $student_id; ?>" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="image_path">File Upload</label>
                                        <input type="file" name="image_path" id="image_path" class="form-control" accept="image/*" onchange="previewImage(event)">
                                        <small class="form-text text-muted">Only JPEG, PNG, and GIF images are allowed. Max file size: 5 MB.</small>
                                        <div id="image-preview-container" style="margin-top: 10px;">
                                            <?php if ($student['image_path']) : ?>
                                                <img id="image-preview" src="<?php echo htmlspecialchars($student['image_path']); ?>" alt="Image Preview" style="max-width: 100px; max-height: 100px;">
                                            <?php else: ?>
                                                <img id="image-preview" src="#" alt="Image Preview" style="display: none; max-width: 100px; max-height: 100px;">
                                            <?php endif; ?>
                                        </div>
                                        <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($student['image_path']); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Fullname</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter your fullname" value="<?php echo htmlspecialchars($student['name']); ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <select name="gender" id="gender" class="form-select text-dark" required>
                                            <option value="Male" <?php echo ($student['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                                            <option value="Female" <?php echo ($student['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="class">Select Class</label>
                                        <select name="class" id="class" class="form-control text-primary" required>
                                            <option value="Toddlers(18 month)" <?php echo ($student['class'] === 'Toddlers(18 month)') ? 'selected' : ''; ?>>Toddlers (18 months)</option>
                                            <option value="Infant group" <?php echo ($student['class'] === 'Infant group') ? 'selected' : ''; ?>>Infant Group</option>
                                            <option value="Play group" <?php echo ($student['class'] === 'Play group') ? 'selected' : ''; ?>>Play Group</option>
                                            <option value="Advanced group" <?php echo ($student['class'] === 'Advanced group') ? 'selected' : ''; ?>>Advanced Group</option>
                                            <option value="Kg" <?php echo ($student['class'] === 'Kg') ? 'selected' : ''; ?>>Kg</option>
                                            <option value="Std-I" <?php echo ($student['class'] === 'Std-I') ? 'selected' : ''; ?>>Std-I</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="roll_no">Roll No</label>
                                        <input type="text" name="roll_no" id="roll_no" class="form-control" placeholder="Enter the roll number" value="<?php echo htmlspecialchars($student['roll_no']); ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone_no">Phone Number</label>
                                        <input type="tel" name="phone_no" id="phone_no" class="form-control" pattern="^(\+91[\-\s]?)?[0]?(91)?[6789]\d{9}$" placeholder="Enter phone number" value="<?php echo htmlspecialchars($student['phone_no']); ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="whatsapp">WhatsApp Number</label>
                                        <input type="tel" name="whatsapp" id="whatsapp" class="form-control" pattern="^(\+91[\-\s]?)?[0]?(91)?[6789]\d{9}$" placeholder="Enter WhatsApp number" value="<?php echo htmlspecialchars($student['whatsapp']); ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="optional_phone">Optional Number</label>
                                        <input type="number" name="optional_phone" id="optional_phone" class="form-control" placeholder="Enter optional number" value="<?php echo htmlspecialchars($student['optional_phone']); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="branch">Branch</label>
                                        <select name="branch" id="branch" class="form-control text-primary" required>
                                            <option value="Kuchkuchia" <?php echo ($student['branch'] === 'Kuchkuchia') ? 'selected' : ''; ?>>Kuchkuchia</option>
                                            <option value="Chandmaridanga" <?php echo ($student['branch'] === 'Chandmaridanga') ? 'selected' : ''; ?>>Chandmaridanga</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" name="city" id="city" class="form-control" placeholder="Enter city" value="<?php echo htmlspecialchars($student['city']); ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="dob">Date of Birth</label>
                                        <input type="date" name="dob" id="dob" class="form-control text-primary" value="<?php echo htmlspecialchars($student['dob']); ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="admission_date">Date of Admission</label>
                                        <input type="date" name="admission_date" id="admission_date" class="form-control text-primary" value="<?php echo htmlspecialchars($student['admission_date']); ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="admission_package">Admission Package</label>
                                        <input type="number" name="admission_package" id="admission_package" class="form-control text-primary" placeholder="Enter admission package" value="<?php echo htmlspecialchars($student['admission_package']); ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="confirm_password">Confirm Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm password" required>
                                    </div>

                                    <div class="text-center mb-3">
                                    <button type="submit" class="btn btn-primary col-12 fs-6">Update</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const imagePreview = document.getElementById('image-preview');
                imagePreview.src = reader.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    <!-- custom js -->
    <script src="assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/vendors/chart.js/chart.umd.js"></script>
    <script src="assets/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js"></script>
    <script src="assets/js/dataTables.select.min.js"></script>
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/template.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
    <script src="assets/js/dashboard.js"></script>
</body>

</html>