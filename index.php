<?php
// Include the database connection file
include 'server_database.php';

// Start the session
session_start();

// Initialize an empty error message variable
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture form input values for user login
    $role = $_POST['role'] ?? '';
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    // List of valid roles
    $valid_roles = ['teachers', 'employers', 'staffs', 'cashiers'];

    // Check if the selected role is valid
    if (!in_array($role, $valid_roles)) {
        $error_message = "Invalid role selected.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } else {
        // Prepare SQL query for the selected role using prepared statements
        $query = $conn->prepare("SELECT * FROM $role WHERE email = ?");
        $query->bind_param('s', $email);
        $query->execute();
        $result = $query->get_result();

        // Check if user exists
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc(); // Fetch the user record

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Store user data in session
                $_SESSION['user'] = $user;
                $_SESSION['role'] = $role;

                // Redirect based on the role using switch-case
                $redirects = [
                    'teachers' => './teachers_department/index.php',
                    'employers' => './employers_department/index.php',
                    'staffs' => './staffs_department/index.php',
                    'cashiers' => './cashiers_department/index.php'
                ];
                header('Location: ' . $redirects[$role]);
                exit;
            } else {
                $error_message = "Invalid password.";
            }
        } else {
            $error_message = "Invalid email or role.";
        }
    }

    // Admin Login
    if (isset($_POST['adminUsername'], $_POST['adminPassword'])) {
        $username = trim($_POST['adminUsername']);
        $password = $_POST['adminPassword'];

        // Prepare and execute the admin query
        $query = $conn->prepare("SELECT * FROM user_settings WHERE username = ?");
        $query->bind_param('s', $username);
        $query->execute();
        $result = $query->get_result();

        // If a matching record is found
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Check if the hashed password matches
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                header('Location: ./admin/index.php');
                exit;
            } else {
                $error_message = 'Invalid password.';
            }
        } else {
            $error_message = 'Invalid username or password.';
        }
    }

    // Close the database connection
    $query->close();
    $conn->close();
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Daffodils School</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body onload="myFunction()" style="margin:0;">
    <div id="loader"></div>

    <header>
        <nav class="navbar bg-primary">
            <div class="container d-flex justify-content-center">
                <a class="head_name d-flex align-items-center">
                    <img src="images/logo.png" class="img-fluid" alt="Logo" style="width: 80px; height: auto;">
                    <span class="ms-2">Daffodils School</span>
                </a>

            </div>
        </nav>
    </header>

    <div style="display:none;" id="myDiv" class="animate-bottom">
        <main>
            <section class="hero-section" id="home">
                <div class="container">
                    <div class="row col-12 justify-content-center align-items-center">
                        <div class="col-lg-7 col-md-12 order-2 order-lg-1 gy-lg-5 gy-4">
                            <img src="images/loginBanner.jpg" class="img-fluid login_image" alt="">
                        </div>

                        <div class="form col-lg-5 col-md-12 gy-lg-5 order-1 order-lg-2 gy-5">
                            <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist"
                                style="background-color:#434852;border-radius: 10px;">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" data-target="#usersLogin" id="tab-register" role="tab"
                                        style="color: white;">Department</a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-target="#adminlogin" id="tab-login" role="tab"
                                        style="color: white;">Admin</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <!-- Department Sign in -->
                                <div class="tab-pane show active" id="usersLogin">
                                    <form action="" method="post" id="departmentform">
                                        <h3>Department Login</h3>

                                        <!-- Display Error Message -->
                                        <?php if (!empty($error_message)): ?>
                                            <div class="alert alert-danger text-center">
                                                <?= htmlspecialchars($error_message) ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="mb-3">
                                            <label class="form-label" for="role"><i class="fa-regular fa-circle-user"></i> Set your Role</label>
                                            <select class="form-select" id="role" name="role" required>
                                                <option value="" disabled selected>Select your role</option>
                                                <option value="teachers">Teachers</option>
                                                <option value="employers">Employers</option>
                                                <option value="staffs">Staffs</option>
                                                <option value="cashiers">Cashiers</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="email"><i class="fa-solid fa-envelope"></i> Email</label>
                                            <input type="email" class="form-control" name="email" placeholder="Enter your email" required />
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="password"><i class="fa-solid fa-key"></i> Password</label>
                                            <input type="password" class="form-control" name="password" placeholder="Enter your password" required />
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-success col-12 fa-2x fw-bold rounded">Log in</button>
                                        </div>

                                    </form>
                                </div>

                                <!-- Admin sign in -->
                                <div class="tab-pane" id="adminlogin">
                                    <form action="" method="post" id="admin_form">
                                        <h3>Admin Login</h3>

                                        <!-- Display Error Message -->
                                        <?php if (!empty($error_message)): ?>
                                            <div class="alert alert-danger text-center">
                                                <?= htmlspecialchars($error_message) ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="form-outline mb-4">
                                            <i class="fa-solid fa-user"></i>
                                            <label class="form-label" for="Username">Username</label>
                                            <input type="text" id="Username" name="adminUsername" class="form-control"
                                                placeholder="Admin" autocomplete="off" required minlength="8" maxlength="20" />
                                        </div>

                                        <div class="form-outline mb-4">
                                            <i class="fa-solid fa-key"></i>
                                            <label class="form-label" for="Password">Password</label>
                                            <input type="password" id="UserPassword" name="adminPassword"
                                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                                                class="form-control" placeholder="Please enter your password" autocomplete="off" required />
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-success col-12 fa-2x fw-bold rounded">Log in</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="text-center text-lg-start text-white mt-5" style="background-color: #434852;">
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
                © <span id="currentYear"></span> Copyright:
                <a class="text-white" href="" style="text-decoration: none;">Created by web2infinity</a>
            </div>
        </footer>
    </div>

    <script>
        var myVar;

        function myFunction() {
            myVar = setTimeout(showPage, 1500);
        }

        function showPage() {
            document.getElementById("loader").style.display = "none";
            document.getElementById("myDiv").style.display = "block";
        }

        const tabs = document.querySelectorAll("[data-target]");
        const tabContents = document.querySelectorAll(".tab-pane");

        tabs.forEach((tab) => {
            tab.addEventListener("click", () => {
                const target = document.querySelector(tab.dataset.target);

                tabContents.forEach((tc) => {
                    tc.classList.remove("show", "active");
                });

                target.classList.add("show", "active");
            });
        });
    </script>

    <script src="script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script src="jquery_classes/custom_jquery.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>