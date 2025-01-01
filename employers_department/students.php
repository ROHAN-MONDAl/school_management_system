<?php include '../server_database.php';
// Query to fetch student data from the database
$query = "SELECT * FROM students";
$result = $conn->query($query);
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
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                      <h2 class="font-weight-bold text-primary fw-bolder">Students</h2>
                      <p class="text-secondary">Students Admision and Attendence</p>
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

                      <!-- Modal -->
                      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <form id="dateFilterForm" method="post" class="forms-sample bg-white p-3 p-md-5 text-start rounded">
                              <h3 class="text-center text-primary fw-bold">Admission date</h3>
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

          <!-- table header -->
          <div class="row mt-2">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="card-title col-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                    <span class="col-lg-6 fs-6 text-info">Data</span>

                    <a href="student_addmission_frm.php">
                      <button class="btn btn-success btn-sm text-white font-weight-bold me-4">Add Students</button>
                    </a>
                  </div>
                  <div class="row mt-3">
                    <div class="col-12">
                        <div class="table-responsive">
                          <table id="dataTable" class="table table-striped table-bordered col-lg-12">
                            <thead class="text-center text-wrap">
                              <tr>
                                <th>Slno</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Class</th>
                                <th>Gender</th>
                                <th>Roll no</th>
                                <th>Phone no</th>
                                <th>Whatsapp</th>
                                <th>City</th>
                                <th>DOB</th>
                                <th>Branch</th>
                                <th>Admission Date</th>
                                <th>Admission Package</th>
                                <th>Optinal Phone</th>
                                <th>Edit</th>
                                <th>Action</th>
                                <th>View</th>
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
                                    <td><img src="<?php echo $row['img_path']; ?>" alt="Student Image" style="width: 50px; height: 50px; object-fit: cover;"></td>
                                    <td  class="text-wrap"><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['class']; ?></td>
                                    <td><?php echo $row['gender']; ?></td>
                                    <td><?php echo $row['roll_no']; ?></td>
                                    <td><?php echo $row['phone_no']; ?></td>
                                    <td><?php echo $row['whatsapp']; ?></td>
                                    <td><?php echo $row['city']; ?></td>
                                    <td><?php echo $row['dob']; ?></td>
                                    <td><?php echo $row['branch']; ?></td>
                                    <td><?php echo $row['admission_date']; ?></td>
                                    <td>Rs <?php echo $row['admission_package']; ?></td>
                                    <td><?php echo $row['optional_phone']; ?></td>
                                    <td>
                                      <a href="javascript:void(0);" onclick="confirmUpadte(<?php echo $row['id']; ?>)">
                                        <button type="button" class="btn btn-info btn-sm text-white fw-bold">Update</button>
                                      </a>
                                    </td>
                                    <td>
                                      <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['id']; ?>)">
                                        <button type="button" class="btn btn-danger btn-sm text-white fw-bold">Delete</button>
                                      </a>
                                    </td>
                                    <td>
                                      <a href="views_payments.php?id=<?php echo $row['id']; ?>" rel="noopener noreferrer">
                                        <button type="button" class="btn btn-success btn-sm text-white fw-bolder">View</button>
                                      </a>
                                    </td>
                                  </tr>
                                <?php endwhile; ?>
                              <?php else: ?>
                                <tr>
                                  <td colspan="10">No data found</td>
                                </tr>
                              <?php endif; ?>
                            </tbody>
                          </table>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.php -->
        <?php include "footer.php"  ?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- search filter -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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
      });
    });


    function filterByDate() {
      var startDate = new Date($('#startDate').val()); // Convert start date input to Date object
      var endDate = new Date($('#endDate').val()); // Convert end date input to Date object

      $('#dataTable tbody tr').each(function() {
        var row = $(this);
        var rowDateText = row.find('td:eq(1)').text(); // Get text from the 10th column (index 9)
        var rowDate = new Date(rowDateText); // Convert the text to a Date object

        if ((startDate && rowDate < startDate) || (endDate && rowDate > endDate)) {
          row.hide(); // Hide rows outside the range
        } else {
          row.show(); // Show rows within the range
        }
      });
    }

    // students update feature
    function confirmUpadte(studentId) {
      // Show a confirmation dialog to the user
      if (confirm("Are you sure you want to update this student?")) {
        // If the user confirms, redirect to the delete PHP script with the student ID
        window.location.href = "update_students_info.php?id=" + studentId;
      }
    }

// students delete feature
    function confirmDelete(studentId) {
      // Show a confirmation dialog to the user
      if (confirm("Are you sure you want to delete this student? This action cannot be undone.")) {
        // If the user confirms, redirect to the delete PHP script with the student ID
        window.location.href = "delete_students.php?id=" + studentId;
      }
    }
  </script>
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