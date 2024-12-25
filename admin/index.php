<?php  include '../server_database.php'  ?>
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
                  <div class="container">
            <div class="row">
              <div class="col-lg-12 gy-2 transparent">
                <div class="row">
                  <div class="col-lg-3 mb-4 stretch-card transparent">
                    <div class="card bg-dark-subtle">
                      <div class="card-body">
                        <p class="mb-4 fw-bolder"><i class="fa-regular fa-user"></i> Total teachers</p>
                        <p class="fs-30 mb-2 fw-bolder">4006</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 mb-4 stretch-card transparent">
                    <div class="card bg-info-subtle">
                      <div class="card-body">
                        <p class="mb-4 fw-bolder"><i class="fa-regular fa-user"></i> Total Students</p>
                        <p class="fs-30 mb-2 fw-bolder">61344</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 mb-4 stretch-card transparent">
                    <div class="card bg-success">
                      <div class="card-body">
                        <p class="mb-4 fw-bolder"><i class="fa-regular fa-user  "></i> Total Employers</p>
                        <p class="fs-30 mb-2 fw-bolder">61344</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 mb-4 stretch-card transparent">
                    <div class="card  bg-warning">
                      <div class="card-body">
                        <p class="mb-4 fw-bolder"><i class="fa-regular fa-user"></i> Total staffs</p>
                        <p class="fs-30 mb-2 fw-bolder">61344</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
                  <div class="row justify-content-center p-1">
                    <div class="col-md-12">
                      <div class="search-container align-items-center">
                        <input type="text" class="form-control search-input" id="search" placeholder="Search...">
                        <p class="mx-3 mt-2 text-danger" style="cursor:pointer " data-toggle="modal"
                          data-target="#exampleModalCenter"><i style="font-size:24px;" class="fa text-danger">&#xf0b0;</i><b>filter</b></p>
                      </div>
                    </div>

                    <!-- Modal -->
                    <div class="row d-flex justify-content-center g-4 mx-auto">
                      <!-- Form -->
                      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <form class="forms-sample bg-warning bg-opacity-25 rounded">
                              <div class="form-group col-12 flex-grow-1">
                                <h5 class="modal-title text-danger" id="exampleModalLongTitle" value="jfvhjksd"><b>Filter</b></h5>
                                <div class="col-lg-12 col-md-12 text-center text-lg-start text-md-start mt-3">
                                  <label for="startDate" class="text-danger">Start Date:</label>
                                  <input type="date" class="form-control" id="startDate">
                                  <label for="endDate" class=" text-danger mt-2">End Date:</label>
                                  <input type="date" class="form-control" id="endDate">
                                </div>
                              </div>
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
          <div class="row mt-3">
                    <div class="col-12">
                      <div class="table-responsive">
                        <table id="dataTable" class="display expandable-table col-lg-12">
                          <thead class="text-center text-wrap">
                            <tr>
                              <th>Slno</th>
                              <th>Quote#</th>
                              <th>Product</th>
                              <th>Business type</th>
                              <th>Policy holder</th>
                              <th>Premium</th>
                              <th>Status</th>
                              <th>Updated at</th>
                            </tr>
                          </thead>
                          <tbody class="text-center text-wrap">
                            <tr>
                              <td>John Doe</td>
                              <td>30</td>
                              <td>2024-01-15</td>
                            </tr>
                            <tr>
                              <td>Jane Smith</td>
                              <td>25</td>
                              <td>2023-12-10</td>
                            </tr>
                            <tr>
                              <td>Sam Brown</td>
                              <td>22</td>
                              <td>2024-03-05</td>
                            </tr>
                            <tr>
                              <td>Amy Lee</td>
                              <td>28</td>
                              <td>2024-02-18</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
          <!-- /table header -->
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

      // Function to filter rows based on date range
      $('#startDate, #endDate').on('change', function() {
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();

        $('#dataTable tbody tr').each(function() {
          var row = $(this);
          var dateText = row.find('td').eq(2).text(); // Get the date column (third column)

          if (startDate && new Date(dateText) < new Date(startDate)) {
            row.hide();
            return;
          }
          if (endDate && new Date(dateText) > new Date(endDate)) {
            row.hide();
            return;
          }

          row.show(); // Show the row if within the date range
        });
      });
    });
  </script>
  <!-- custom js -->
  <script src="assets/javascript/script.js"></script>
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