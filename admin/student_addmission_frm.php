<?php
include '../server_database.php';
$message = $_GET['message'] ?? '';
$message_type = $_GET['type'] ?? ''; // 'success' or 'error'
?>
<!DOCTYPE php>
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
        <!-- partial:partials/_navbar.php -->
        <?php include 'header.php'   ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.php -->
            <?php include 'navbar.php' ?>
            <!-- Main Dashboard Panel -->
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
                    <!-- main form section -->

                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <p><a href="students.php"><button type="button" class="btn btn-warning text-white fw-bolder">Back</button></a></p>
                                <h4 class="card-title">Admission Form</h4>
                                <p class="card-description">Add students details</p>
                                <?php
                                if (isset($_GET['message'])) {
                                    $message = htmlspecialchars($_GET['message']);
                                    $type = $_GET['type'] === 'success' ? 'green' : 'red';
                                    echo "<h3 style='color: $type;'>$message</h3>";
                                }
                                ?>
                                <form method="post" action="students_form_submit.php" enctype="multipart/form-data" class="forms-sample text-dark">
                                    <div class="form-group">
                                        <label>File upload</label>
                                        <div class="input-group col-xs-12 d-flex align-items-center">
                                            <input type="file" name="img" class="form-control file-upload-info" accept="image/*" placeholder="Upload Image">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName1">Fullname</label>
                                        <input type="text" name="name" class="form-control" id="exampleInputName1" placeholder="Enter your fullname" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleSelectGender">Gender</label>
                                        <select class="form-select text-dark" name="gender" id="exampleSelectGender">
                                            <option>Male</option>
                                            <option>Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="Class">Select class</label>
                                        <select class="form-control text-primary" name="class" id="class" required>
                                            <option value="">--Select a class--</option>
                                            <option value="Toddlers(18 month)">Toddlers(18 month)</option>
                                            <option value="Infant group">Infant group</option>
                                            <option value="Play group">Play group</option>
                                            <option value="Advanced group">Advanced group</option>
                                            <option value="Kg">Kg</option>
                                            <option value="Std-I">Std-I</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="rollno">Roll no</label>
                                        <input type="text" name="roll_no" class="form-control" id="rollno" placeholder="Please Enter the roll no" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone_no">Phone number</label>
                                        <input type="tel" name="phone_no" class="form-control" id="phone_no" pattern="^(\+91[\-\s]?)?[0]?(91)?[6789]\d{9}$" placeholder="Please enter phone number" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="whatsapp">Whatsapp no</label>
                                        <input type="tel" name="whatsapp" class="form-control" id="whatsapp" pattern="^(\+91[\-\s]?)?[0]?(91)?[6789]\d{9}$" placeholder="Please enter whatsapp number" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="optional_phone">Optional number</label>
                                        <input type="number" name="optional_phone" class="form-control" id="optional_phone" placeholder="Please enter optional number">
                                    </div>
                                    <div class="form-group">
                                        <label for="branch">Branch</label>
                                        <select class="form-control text-primary" name="branch" id="branch" required>
                                            <option value="">--Select a branch--</option>
                                            <option value="Kuchkuchia">Kuchkuchia</option>
                                            <option value="Chandmaridanga">Chandmaridanga</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" name="city" class="form-control" id="city" placeholder="Location" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="dob">Date of birth</label>
                                        <input type="date" name="dob" class="form-control text-primary fw-bolder" placeholder="d-m-y" id="dob" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="admission_date">Date of Admission</label>
                                        <input type="date" name="admission_date" class="form-control text-primary fw-bolder" placeholder="d-m-y" id="admission_date" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="admission_package">Admission Package</label>
                                        <input type="number" name="admission_package" class="form-control text-primary fw-bolder" placeholder="Enter your amount" id="admission_package" required>
                                    </div>                   
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" class="form-control" id="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password">Confirm Password</label>
                                        <input type="password" name="confirm_password" class="form-control" id="confirm_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" placeholder="Confirm Password" required>
                                        <div class="form-group text-center mt-4">
                                            <button type="reset" class="btn btn-dark text-light">Reset</button>
                                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                                        </div>
                                </form>



                            </div>
                        </div>
                    </div>

                    <!-- /main form section -->
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- partial:partials/_footer.php -->
            <?php include "footer.php"  ?>
            <!-- partial -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    </div>
    <!-- container-scroller -->
    <script>
        // Password confirmation validation
        document.querySelector("form").addEventListener("submit", function(event) {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;

            if (password !== confirmPassword) {
                alert("Passwords do not match. Please try again.");
                event.preventDefault(); // Prevent form submission
            }
        });
    </script>
    <!-- custom js -->
    <script src="assets/js/script.js"></script>
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/chart.umd.js"></script>
    <script src="assets/vendors/datatables.net/jquery.dataTables.js"></script>
    <!-- <script src="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script> -->
    <script src="assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js"></script>
    <script src="assets/js/dataTables.select.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/template.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
    <script src="assets/js/dashboard.js"></script>
    <!-- <script src="assets/js/Chart.roundedBarCharts.js"></script> -->
    <!-- End custom js for this page-->
</body>

</html>