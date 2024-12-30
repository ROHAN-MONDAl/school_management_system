<?php
include '../server_database.php';

// Check if the 'id' parameter exists in the GET request
$id = $_GET['id'] ?? null;
if (!$id) {
    exit("<p class='text-danger'>Invalid student ID.</p>");
}

// Prepare the query to fetch student details and payment info
$query = $conn->prepare("
    SELECT 
        students.img_path,
        students.name, 
        students.class, 
        students.gender, 
        students.roll_no, 
        students.phone_no, 
        students.whatsapp, 
        students.branch, 
        students.city, 
        students.dob, 
        students.admission_date,
        students.admission_package,
        payments.invo_no, 
        payments.amount, 
        payments.summary 
    FROM students
    LEFT JOIN payments ON students.id = payments.student_id
    WHERE students.id = ?");

$query->bind_param("i", $id);  // Bind the student ID as an integer
$query->execute();  // Execute the query
$result = $query->get_result();  // Get the result of the query

$totalAmount = 0;  // Initialize the total amount variable

// If no payments are found, display a message
if ($result->num_rows == 0) {
    exit("<p class='text-danger'>No payments found for this student.</p>");
}

// Fetch the student details
$student = $result->fetch_assoc();  // Assuming only one student is fetched

// Display student details
?>

<!DOCTYPE php>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Daffodils School</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- <link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css"> -->
    <link rel="stylesheet" href="assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/js/select.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
    <style>
        /* Optional styling for the invoice */
        #invoice {
            background-color: white;
            width: 100%;
            padding: 20px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>
    <div class="container-scroller">

        <?php include 'header.php'   ?>

        <div class="container-fluid page-body-wrapper">

            <?php include 'navbar.php' ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                            <h2 class="font-weight-bold text-primary fw-bolder">Students Invoice</h2>
                                            <p class="text-secondary">Students payments form</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                            <a href="students_payment_history.php?id=<?php echo $id; ?>"><button class="btn btn-success text-white fw-bolder btn-sm mt-2 mb-2">Student history</button></a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- table header -->
                    <div class="col-12 col-lg-12 col-md-12 rounded mt-5" id="invoice">
                        <h3 class="text-center mb-4 text-primary d-flex justify-content-center align-items-center">
                            <img src="assets/images/logo_.svg" style="width: 4rem;  object-fit: cover;"><b>Daffodils School</b>
                        </h3>
                        <div class="text-center mb-4 d-flex justify-content-center align-items-center" style="margin-top:-30px">
                            <p class="mt-3 text-info">Address: Kuchkuchia Rd, Bankura, West Bengal 722101, <br> Phone number: 094348 60435, </p>
                            </p>

                        </div>

                        <h3 class="text-center mb-4">Invoice</h3>
                        <hr style="color:black">

                        <div class="row d-flex justify-content-between align-items-center">
                            <div class="col-6 col-md-6 mb-5">
                                <img src="<?php echo $student['img_path']; ?>" class="rounded" alt="Student Image" style="width: 100px; height: 130px; object-fit: cover;">
                            </div>
                            <div class="col-6 col-md-6 mb-5 text-end">
                                <p><strong>Date:</strong> <?php
                                                            date_default_timezone_set('Asia/kolkata');
                                                            echo date('d-m-Y'); ?></p>
                                <?php
                                // Check if there are any rows in the result
                                if ($result->num_rows > 0) {
                                    // Get the first row
                                    $firstRow = $result->fetch_assoc();
                                    // Reset the result pointer to the first row
                                    $result->data_seek(0); // This resets the pointer back to the first row

                                    // Initialize a variable to hold the last row
                                    $lastRow = null;

                                    // Loop through the result to get the last row
                                    while ($row = $result->fetch_assoc()) {
                                        $lastRow = $row;  // Store the last row's data
                                    }

                                    // Display the last row invoice number
                                    if ($lastRow) {
                                        echo "<p><strong>Invoice no:</strong> DLS {$lastRow['invo_no']} / " . date('Y') . "</p>";
                                    } else {
                                        echo "<p>No invoice records found.</p>";
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-12 col-md-6">
                                <p><strong>Student Name:</strong> &nbsp; &nbsp; <?php echo $student['name']; ?></p>
                                <p><strong>Gender:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; <?php echo $student['gender']; ?></p>
                                <p><strong>Class:</strong> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $student['class']; ?></p>
                                <p><strong>Roll no:</strong> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $student['roll_no']; ?></p>
                                <p><strong>Phone no:</strong> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $student['phone_no']; ?></p>
                                <p><strong>Whatsapp no:</strong> &nbsp; &nbsp; <?php echo $student['whatsapp']; ?></p>
                                <p><strong>City:</strong> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; <?php echo $student['city']; ?></p>
                                <p><strong>Date of birth:</strong> &nbsp; &nbsp;&nbsp; &nbsp;<?php echo $student['dob']; ?></p>
                                <p><strong>Admission date:</strong> &nbsp;<?php echo $student['admission_date']; ?></p>
                                <strong class="text-wrap">Admission
                                    <p>Package:
                                </strong> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Rs <?php echo $student['admission_package']; ?></p>
                            </div>
                        </div>

                        <hr style="color:black">

                        <!-- Table to show all payments -->
                        <div class="table-responsive">
                            <table class="col-lg-12 mt-3 mx-5">
                                <thead class="text-center text-wrap">
                                    <tr>
                                        <th>Slno</th>
                                        <th style="width: 50%;">Summary</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center text-wrap">
                                    <?php
                                    $i = 1;
                                    $lastRow = null;
                                    $totalAmount = 0; // Initialize total amount

                                    // Set the initial admission package and scaling factor
                                    $baseAdmissionPackage = $student['admission_package']; // Starting admission package
                                    $scalingFactor = 1; // Amount to deduct per payment (adjust as needed)

                                    // Reset the result pointer and loop through all rows
                                    $result->data_seek(0); // Reset the pointer to the first row
                                    while ($row = $result->fetch_assoc()) {
                                        $lastRow = $row; // Keep track of the last row
                                        $totalAmount += $row['amount']; // Accumulate the total paid amount
                                    ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td class="text-wrap text-break"><?php echo htmlspecialchars($row['summary']); ?></td>
                                            <td class="text-wrap text-break">Rs <?php echo number_format($row['amount'], 2); ?></td>
                                        </tr>
                                    <?php } ?>

                                    <tr>
                                        <td colspan="2" class="text-start"><strong>Total</strong></td>
                                        <td class="text-wrap text-break"><strong>Rs <?php echo number_format($totalAmount, 2); ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <hr style="color:black">


                        <?php
                        // Calculate the admission package dynamically
                        $admissionAmount = max($baseAdmissionPackage - $totalAmount, 0);

                        // Display the last row as today's paid amount
                        if ($lastRow) {
                            $todayPaidAmount = $lastRow['amount'];
                            echo '<div class="text-center mt-3">';
                            echo '<p class="fw-bold">Today\'s Paid Amount: Rs ' . number_format($todayPaidAmount, 2) . '</p>';
                            echo '</div>';
                        }
                        ?>
                        <div class="text-center mt-5 d-flex justify-content-center align-items-center">
                            <p class="fw-bolder"><b>This invoice is computer generated</b></p>
                        </div>

                    </div>
                    <div class="text-center mt-4 me-4">
                        <div class="fw-bolder text-wrap">Due Amount: Rs <?php echo number_format($admissionAmount, 2); ?> </div>
                    </div>

                    <div class="text-center mt-4 me-4">
                        <a href="update_payments.php?id=<?php echo urlencode($id); ?>"><button class="btn btn-primary bg-danger border-0 fw-bolder mt-2 mb-2"><i class="fa-solid fa-pen-to-square"></i> Edit</button></a>
                        <a href="add_payment_form.php?id=<?php echo $id; ?>"><button class="btn btn-success text-white fw-bolder mt-2 mb-2"><i class="fa-solid fa-file-circle-plus"></i> Add form</button></a>
                    </div>

                    <div class="text-center mt-4">
                        <button class="btn btn-primary fw-bolder mt-2 mb-2" onclick="printInvoice()"><i class="fa-solid fa-download"></i> Download</button>
                        <button class="btn btn-success fw-bolder text-white mt-2 mb-2" onclick="sendwhatsapp()">
                            <i class="fa-brands fa-whatsapp"></i> Send via WhatsApp
                        </button>
                    </div>
                </div>
                <?php include "footer.php"  ?>

            </div>


            <script>
                // Function to download the invoice as a PDF
                function printInvoice() {
                    const originalContent = document.body.innerHTML;
                    const invoiceContent = document.getElementById('invoice').outerHTML;

                    // Temporarily replace body content with the invoice
                    document.body.innerHTML = invoiceContent;

                    // Trigger the print dialog
                    window.print();

                    // Restore the original body content
                    document.body.innerHTML = originalContent;
                }

                function sendwhatsapp() {
                    // Get the student's WhatsApp number and other details from PHP
                    var whatsappNumber = "<?php echo htmlspecialchars($student['whatsapp']); ?>";
                    var studentName = "<?php echo htmlspecialchars($student['name']); ?>";
                    var studentClass = "<?php echo htmlspecialchars($student['class']); ?>";
                    var branch = "<?php echo htmlspecialchars($student['branch']); ?>";
                    var rollNo = "<?php echo htmlspecialchars($student['roll_no']); ?>";
                    var dueAmount = "<?php echo number_format($admissionAmount, 2); ?>";
                    var totalAmount = "<?php echo number_format($totalAmount, 2); ?>";
                    var todayPaidAmount = "<?php echo number_format($todayPaidAmount, 2); ?>";
                    var currentDate = "<?php echo date('d-m-Y'); ?>";

                    // Ensure the number is numeric and includes country code
                    var formattedNumber = whatsappNumber.replace(/[^0-9]/g, ""); // Remove non-numeric characters
                    if (!formattedNumber.startsWith("91")) {
                        formattedNumber = "91" + formattedNumber; // Add country code if missing
                    }

                    // Prepare the message content
                    var message = encodeURIComponent(
                        "Invoice Details:\n" +
                        "Daffodils School\n" +
                        "Student Name: " + studentName + "\n" +
                        "Branch Name: " + branch + "\n" +
                        "Class: " + studentClass + "\n" +
                        "Roll No: " + rollNo + "\n" +
                        "Due Amount: Rs " + dueAmount + "\n" +
                        "Total Amount: Rs " + totalAmount + "\n" +
                        "Today paid Amount: Rs " + todayPaidAmount + "\n" +
                        "Date: " + currentDate
                    );

                    // Construct the WhatsApp URL
                    var whatsappUrl = "https://wa.me/" + formattedNumber + "?text=" + message;

                    // Open the WhatsApp link in a new tab
                    window.open(whatsappUrl, "_blank");
                }
            </script>
            <!-- custom js -->
            <script src="assets/js/script.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
            <!-- bootstrap Library -->
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
                integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
                crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
                integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
                crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
                integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
                crossorigin="anonymous"></script>
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