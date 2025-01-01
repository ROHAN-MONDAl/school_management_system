# school_management_system
This real world project for school project management system


<!-- LOGIN FILES  -->
<!-- <?php 

<!-- // Start a new session to handle login
session_start();

// Initialize an empty error message variable
$error_message = '';

// Check if the form has been submitted using POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Establish a connection to the MySQL database
   // Include the database connection file
include 'server_database.php';


    // Student Login
    // Check if both student phone number and password are submitted
    if (isset($_POST['sPhone'], $_POST['sPassword'])) {
        // Escape special characters in the phone number to prevent SQL injection
        $phone = mysqli_real_escape_string($conn, $_POST['sPhone']);
        // Get the submitted password
        $password = $_POST['sPassword'];

        // Query the database to find a student with the submitted phone number
        $query = "SELECT * FROM students WHERE phone_no = '$phone'";
        $result = mysqli_query($conn, $query);

        // If a matching record is found
        if ($result && mysqli_num_rows($result) > 0) {
            // Fetch the student's record
            $user = mysqli_fetch_assoc($result);
            // Check if the password matches
            if ($user['password'] === $password) {
                // If successful, store the user data in the session and redirect to student dashboard
                $_SESSION['user'] = $user;
                header('Location: ./index.php');
                exit;
            } else {
                // If password doesn't match, set an error message
                $error_message = 'Invalid phone number or password.';
            }
        } else {
            // If no matching user is found, set an error message
            $error_message = 'Invalid phone number or password.';
        }
    }

    // Admin Login
    // Check if both admin username and password are submitted
    if (isset($_POST['adminUsername'], $_POST['adminPassword'])) {
        // Escape special characters in the username to prevent SQL injection
        $username = mysqli_real_escape_string($conn, $_POST['adminUsername']);
        // Get the submitted password
        $password = $_POST['adminPassword'];

        // Query the database to find an admin with the submitted username
        $query = "SELECT * FROM user_settings WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        // If a matching record is found
        if ($result && mysqli_num_rows($result) > 0) {
            // Fetch the admin's record
            $user = mysqli_fetch_assoc($result);
            // Check if the password matches
            if ($user['password'] === $password) {
                // If successful, store the user data in the session and redirect to admin dashboard
                $_SESSION['user'] = $user;
                header('Location: ./index.php');
                exit;
            } else {
                // If password doesn't match, set an error message
                $error_message = 'Invalid username or password.';
            }
        } else {
            // If no matching user is found, set an error message
            $error_message = 'Invalid username or password.';
        }
    }

    // Department Login
    // Check if both department email and password are submitted
    if (isset($_POST['departmentEmail'], $_POST['departmentPassword'])) {
        // Escape special characters in the email to prevent SQL injection
        $email = mysqli_real_escape_string($conn, $_POST['departmentEmail']);
        // Get the submitted password
        $password = $_POST['departmentPassword'];

        // Query the database to find a department with the submitted email
        $query = "SELECT * FROM departments WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        // If a matching record is found
        if ($result && mysqli_num_rows($result) > 0) {
            // Fetch the department's record
            $user = mysqli_fetch_assoc($result);
            // Check if the password matches
            if ($user['password'] === $password) {
                // If successful, store the user data in the session and redirect to department dashboard
                $_SESSION['user'] = $user;
                header('Location: department_dashboard.php');
                exit;
            } else {
                // If password doesn't match, set an error message
                $error_message = 'Invalid email or password.';
            }
        } else {
            // If no matching user is found, set an error message
            $error_message = 'Invalid email or password.';
        }
    }

    // Close the database connection
    mysqli_close($conn);
}
?> -->