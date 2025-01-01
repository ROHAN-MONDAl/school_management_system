<?php
// Include the database connection file
include 'server_database.php';
?>


<!doctype html>
<html lang="en">

<head>
    <title>Daffodils School</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom css -->
    <link rel="stylesheet" href="style.css">
</head>

<body onload="myFunction()" style="margin:0;">

    <div id="loader"></div>

    <header>
        <!-- place navbar here -->
        <nav class="navbar bg-primary">
            <div class="container d-flex justify-content-center">
                <a class="head_name"><img src="images/logo.png" class="img-fluid" alt="" srcset="" width="80vw">
                    Daffodils School</a>
            </div>

        </nav>
    </header>

    <div style="display:none;" id="myDiv" class="animate-bottom">
        <main>
            <section class="hero-section" id="home">
                <div class="container">
                    <div class="row col-12 justify-content-center align-items-center">
                        <!-- Images -->
                        <div class="col-lg-7 col-md-12 order-2 order-lg-1 gy-lg-5 gy-4">
                            <img src="images/loginBanner.jpg" class="img-fluid login_image" alt="" srcset="">
                        </div>
                        <!-- /Images -->

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
                            <?php if (!empty($error_message)): ?>
                                <div class="alert alert-danger text-center">
                                    <?= htmlspecialchars($error_message) ?>
                                </div>
                            <?php endif; ?>
                            <div class="tab-content">

                                <!-- Department Sign in -->
                                <div class="tab-pane show active" id="usersLogin">
                                    <form action="login_handler.php" method="post" id="loginForm">
                                        <h3>Department Login</h3>

                                        <!-- Role Selection -->
                                        <div class="mb-3">
                                            <label class="form-label" for="role">Set your Role</label>
                                            <select class="form-select fw-bold" id="role" name="role" required>
                                                <option value="" disabled selected>Select your role</option>
                                                <option value="teachers">Teacher</option>
                                                <option value="employers">Employer</option>
                                                <option value="staffs">Staff</option>
                                                <option value="cashiers">Cashier</option>
                                            </select>
                                        </div>

                                        <!-- Email Input -->
                                        <div class="mb-3">
                                            <label class="form-label" for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required />
                                        </div>

                                        <!-- Password Input -->
                                        <div class="mb-3">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required />
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Log in</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Department Sign in -->

                                <!-- Admin sign in -->
                                <div class="tab-pane" id="adminlogin">
                                    <form action="login_handler.php" method="post" id="admin_form">
                                        <h3>Admin Login</h3>
                                        <!-- Usersname input -->
                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <i class="fa-solid fa-user"></i>
                                            <label class="form-label" for="Username">Username</label>
                                            <input type="text" id="Username" name="adminUsername" class="form-control"
                                                placeholder="Admin" autocomplete="off" required minlength="8"
                                                maxlength="20" />
                                        </div>

                                        <!-- Password input -->
                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <i class="fa-solid fa-key"></i>
                                            <label class="form-label" for="Password">Password</label>
                                            <input type="password" id="UserPassword" name="adminPassword"
                                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                                                class="form-control" placeholder="Please enter your password"
                                                autocomplete="off" required />
                                        </div>
                                        <!-- Submit button -->
                                        <div class="text-center mb-3">
                                            <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-primary btn-block mb-4">Log in</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- Admin sign in -->


                            </div>
                            <!-- Tabs content -->
                        </div>
                    </div>
                </div>
            </section>

        </main>

        <!-- Footer -->
        <footer class="text-center text-lg-start text-white mt-5" style="background-color: #434852;">
            <!-- Copyright -->
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
                © <span id="currentYear"></span> Copyright:
                <a class="text-white" href="" style="text-decoration: none;">Created by web2infinity</a>
            </div>
            <!-- Copyright -->
        </footer>
        <!-- Footer -->
    </div>
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

    <!-- Custom js script -->
    <script src="script.js"></script>

    <!--jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

    <!-- custom jQuery -->
    <script src="jquery_classes/custom_jquery.js"></script>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>