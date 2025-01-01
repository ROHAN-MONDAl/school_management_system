<?php
// Include the database connection file
include 'server_database.php';
// Start a new session to handle login
session_start();

// Initialize an empty error message variable
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture form input values
    $role = $_POST['role'] ?? '';
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // List of valid roles
    $valid_roles = ['teachers', 'employers', 'staffs', 'cashiers'];

    // Check if the selected role is valid
    if (!in_array($role, $valid_roles)) {
        $error_message = "Invalid role selected.";
    } else {
        // Prepare SQL query for the selected role
        $query = "SELECT * FROM $role WHERE email = '$email'"; // No prepared statement to use here for MySQLi
        $result = $conn->query($query); // Execute the query

        // Check if user exists
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc(); // Fetch the user record

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Store user data in session
                $_SESSION['user'] = $user;
                $_SESSION['role'] = $role;

                // Redirect based on the role using switch-case
                switch ($role) {
                    case 'teachers':
                        header('Location: ./staffs_department/index.php');
                        break;
                    case 'employers':
                        header('Location: ./staffs_department/index.php');
                        break;
                    case 'staffs':
                        header('Location: ./staffs_department/index.php');
                        break;
                    case 'cashiers':
                        header('Location: ./staffs_department/index.php');
                        break;
                    default:
                        $error_message = "Role redirection not found.";
                        break;
                }
                exit;
            } else {
                $error_message = "Invalid password.";
            }
        } else {
            $error_message = "Invalid email or role.";
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

            // Check if the hashed password matches using password_verify
            if (password_verify($password, $user['password'])) {
                // If successful, store the user data in the session and redirect to admin dashboard
                $_SESSION['user'] = $user;
                header('Location: ./admin/index.php');
                exit;
            } else {
                // If password doesn't match, set an error message
                $error_message = 'Invalid password.';
            }
        } else {
            // If no matching user is found, set an error message
            $error_message = 'Invalid username or password.';
        }
    }

    // Close the database connection
    mysqli_close($conn);
}
?>