<?php
include '../server_database.php';

// Fetch teacher attendance records
$query = "
SELECT teachers.name, teachers.designation, teachers.branch, teacher_attendance.date, teacher_attendance.status
FROM teacher_attendance
JOIN teachers ON teacher_attendance.teacher_id = teachers.tid
ORDER BY teacher_attendance.date DESC
";
$result = $conn->query($query);
?>
<!DOCTYPE php>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Daffodils School</title>
    <!-- Include your CSS and JS files -->
    <link rel="stylesheet" href="assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/js/select.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                            <h2 class="font-weight-bold text-primary fw-bolder">History</h2>
                                            <p class="text-secondary">Teachers attendance History</p>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center p-1">
                                        <div class="col-12 col-md-10 col-lg-8">
                                            <!-- Search Container -->
                                            <div class="search-container d-flex flex-column flex-md-row align-items-center">
                                                <div class="col-12 col-md-10 mb-2 mb-md-0">
                                                    <input type="text" class="form-control search-input" id="search" placeholder="Search..." onkeyup="filterTable()">
                                                </div>
                                                <p class="mx-md-3 mt-2 mt-md-0 text-danger" style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                                                    <i class="fa text-danger" style="font-size:24px;">&#xf0b0;</i> <b>Filter</b>
                                                </p>
                                            </div>

                                            <!-- Modal for Date Filter -->
                                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form id="dateFilterForm" method="post" class="forms-sample bg-white p-3 p-md-5 text-start rounded">
                                                            <h3 class="text-center text-primary fw-bold">Filter by Date</h3>
                                                            <label for="startDate" class="text-black">Start Date:</label>
                                                            <input type="date" id="startDate" class="form-control" name="start_date" required>
                                                            <label for="endDate" class="text-black mt-2">End Date:</label>
                                                            <input type="date" id="endDate" class="form-control" name="end_date" required>
                                                            <button type="button" class="btn btn-primary w-100 mt-3" onclick="filterByDate()">Filter</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                            <table id="dataTable" class="table table-striped table-bordered">
                                            <thead class="text-center table-warning">
                                                        <tr>
                                                            <th>Slno</th>
                                                            <th>Name</th>
                                                            <th>Designation</th>
                                                            <th>Branch</th>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center text-wrap">
                                                        <?php if ($result->num_rows > 0): ?>
                                                            <?php
                                                            $slno = 1;
                                                            while ($row = $result->fetch_assoc()):
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $slno++; ?></td>
                                                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['designation']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['branch']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                                                </tr>
                                                            <?php endwhile; ?>
                                                        <?php else: ?>
                                                            <tr>
                                                                <td colspan="6">No data found</td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>

                                            </div>
                                            <!-- PDF Download Button -->
                                            <div class="text-center mt-3">
                                                <button id="downloadPDF" class="btn btn-success text-white">
                                                    <i class="fa fa-download"></i> Download PDF
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include "footer.php" ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspdf-autotable"></script>


    <script>
        $(document).ready(function() {
            // Function to filter rows based on search input
            $('#search').on('keyup', function() {
                var searchTerm = $(this).val().toLowerCase();
                $('#dataTable tbody tr').each(function() {
                    var row = $(this);
                    var rowText = row.text().toLowerCase();
                    if (rowText.includes(searchTerm)) {
                        row.show();
                    } else {
                        row.hide();
                    }
                });
            })
        });


        function filterByDate() {
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();

            $('#dataTable tbody tr').each(function() {
                var row = $(this);
                var rowDate = new Date(row.find('td:eq(4)').text()); // Get date from the 3rd column (index 2)

                if (startDate && rowDate < new Date(startDate) || endDate && rowDate > new Date(endDate)) {
                    row.hide();
                } else {
                    row.show();
                }
            });
        }



        document.getElementById('downloadPDF').addEventListener('click', function() {
            const {
                jsPDF
            } = window.jspdf; // Destructure jsPDF from the jspdf library
            const doc = new jsPDF(); // Create a new PDF document instance

            // Add a title to the PDF
            doc.text("Teachers Attendance History", 105, 10, {
                align: 'center'
            });

            // Generate the table with custom header styles
            doc.autoTable({
                html: '#dataTable', // Reference the table in the HTML
                startY: 20, // Starting position for the table (y-coordinate)
                theme: 'grid', // Table theme
                headStyles: {
                    fillColor: [255, 195, 0], // Header background color (RGB: Royal Blue)
                    textColor: [255, 255, 255], // Header text color (white)
                    fontStyle: 'bold', // Make the header text bold
                    halign: 'center', // Center-align header text
                },
                bodyStyles: {
                    textColor: [0, 0, 0], // Body text color (black)
                    halign: 'center', // Center-align body text
                },
            });

            // Save the PDF document
            doc.save('Attendance_History.pdf');
        });
    </script>
    <!-- Include JS and other script files here -->

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