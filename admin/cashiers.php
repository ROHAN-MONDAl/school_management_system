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

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Daffodils School</title>
    <!-- Include necessary CSS files here -->
    <link rel="stylesheet" href="assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/customs.css">
    <link rel="shortcut icon" href="assets/images/favicon.png" />
</head>

<body>
    <div class="container-scroller">

        <?php include 'header.php' ?>

        <div class="container-fluid page-body-wrapper">
            <?php include 'navbar.php' ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <h2 class="font-weight-bold text-primary fw-bolder">Student Invoice</h2>
                    <div class="col-12 col-lg-12 col-md-12 rounded mt-5" id="invoice">
                        <h3 class="text-center mb-4 text-primary">
                            <img src="assets/images/logo_.svg" style="width: 4rem; object-fit: cover;"><b>Daffodils School</b>
                        </h3>
                        <div class="text-center mb-4">
                            <p class="text-info">Address: Kuchkuchia Rd, Bankura, West Bengal 722101, <br> Phone: 094348 60435</p>
                        </div>
                        <h3 class="text-center mb-4">Invoice</h3>
                        <hr style="color:black">
                        <div class="row d-flex justify-content-between align-items-center">
                            <div class="col-6 col-md-6 mb-5">
                                <img src="<?php echo $student['img_path']; ?>" class="rounded" alt="Student Image" style="width: 100px; height: 130px; object-fit: cover;">
                            </div>
                            <div class="col-6 col-md-6 mb-5 text-end">
                                <p><strong>Date:</strong> <?php echo date('d-m-Y'); ?></p>
                                <p><strong>Invoice no:</strong> DLS <?php echo $student['invo_no']; ?> / <?php echo date('Y'); ?></p>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-12 col-md-6">
                                <p><strong>Student Name:</strong> <?php echo $student['name']; ?></p>
                                <p><strong>Gender:</strong> <?php echo $student['gender']; ?></p>
                                <p><strong>Class:</strong> <?php echo $student['class']; ?></p>
                                <p><strong>Roll no:</strong> <?php echo $student['roll_no']; ?></p>
                                <p><strong>Phone no:</strong> <?php echo $student['phone_no']; ?></p>
                                <p><strong>Whatsapp no:</strong> <?php echo $student['whatsapp']; ?></p>
                                <p><strong>City:</strong> <?php echo $student['city']; ?></p>
                                <p><strong>Date of birth:</strong> <?php echo $student['dob']; ?></p>
                                <p><strong>Admission date:</strong> <?php echo $student['admission_date']; ?></p>
                                <p><strong>Admission Package:</strong> Rs <?php echo $student['admission_package']; ?></p>
                            </div>
                        </div>

                        <hr style="color:black">
                        <!-- Payments Table -->
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Slno</th>
                                        <th>Summary</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $totalAmount = 0;
                                    $result->data_seek(0); // Reset pointer to the first row
                                    while ($row = $result->fetch_assoc()) {
                                        $totalAmount += $row['amount'];
                                    ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo htmlspecialchars($row['summary']); ?></td>
                                        <td>Rs <?php echo number_format($row['amount'], 2); ?></td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="2"><strong>Total Amount</strong></td>
                                        <td><strong>Rs <?php echo number_format($totalAmount, 2); ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <?php
                        // Calculate the admission package dynamically
                        $admissionAmount = max($student['admission_package'] - $totalAmount, 0);
                        ?>

                        <div class="text-center mt-4">
                            <p class="fw-bold">Due Amount: Rs <?php echo number_format($admissionAmount, 2); ?></p>
                        </div>

                        <div class="text-center mt-4">
                            <a href="update_payments.php?id=<?php echo urlencode($id); ?>"><button class="btn btn-primary bg-danger border-0">Edit</button></a>
                            <a href="add_payment_form.php?id=<?php echo $id; ?>"><button class="btn btn-success">Make Payment</button></a>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button class="btn btn-primary" onclick="printInvoice()">Download</button>
                        <button class="btn btn-success" onclick="sendwhatsapp()">
                            <i class="fa-brands fa-whatsapp"></i> Send via WhatsApp
                        </button>
                    </div>
                </div>
            </div>
        </div>
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
            var whatsappNumber = "<?php echo htmlspecialchars($student['whatsapp']); ?>";
            var studentName = "<?php echo htmlspecialchars($student['name']); ?>";
            var dueAmount = "<?php echo number_format($admissionAmount, 2); ?>";

            var formattedNumber = whatsappNumber.replace(/[^0-9]/g, ""); // Remove non-numeric characters
            if (!formattedNumber.startsWith("91")) {
                formattedNumber = "91" + formattedNumber; // Add country code if missing
            }

            var message = encodeURIComponent(
                "Invoice Details:\n" +
                "Daffodils School\n" +
                "Student Name: " + studentName + "\n" +
                "Due Amount: Rs " + dueAmount
            );

            var whatsappUrl = "https://wa.me/" + formattedNumber + "?text=" + message;
            window.open(whatsappUrl, "_blank");
        }
    </script>
</body>
</html>
