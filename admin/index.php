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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- <link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css"> -->
  <link rel="stylesheet" href="assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css">
  <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" type="text/css" href="assets/js/select.dataTables.min.css">
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
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h2 class="font-weight-bold text-primary fw-bolder">Dashboard</h2>
                </div>
              </div>

            </div>
          </div>
          <!-- Cards -->
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

          <!-- search bar -->
          <div class="row justify-content-center p-1">
            <div class="col-md-12">
              <div class="search-container align-items-center">
                <input type="text" class="form-control search-input" placeholder="Search...">
                <p class="mx-3 mt-2" style="cursor:pointer"><i style="font-size:24px;" class="fa text-danger">&#xf0b0;</i></p>
              </div>
            </div>
          </div>

          <!-- table header -->
          <div class="row mt-2">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Teachers Attendence</p>
                  <div class="row">
                    <div class="col-12">
                      <div class="table-responsive">
                        <table id="example" class="display expandable-table col-lg-12">
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
                              <td>5</td>
                              <td>Search Engine Marketing</td>
                              <td class="font-weight-bold">$362</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td class="font-weight-medium">
                                <div class="badge badge-success">Completed</div>
                              </td>
                            </tr>
                            <tr>
                              <td>5</td>
                              <td>Search Engine Marketing</td>
                              <td class="font-weight-bold">$362</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td class="font-weight-medium">
                                <div class="badge badge-success">Completed</div>
                              </td>
                            </tr>
                            <tr>
                              <td>5</td>
                              <td>Search Engine Marketing</td>
                              <td class="font-weight-bold">$362</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td class="font-weight-medium">
                                <div class="badge badge-success">Completed</div>
                              </td>
                            </tr>
                            <tr>
                              <td>5</td>
                              <td>Search Engine Marketing</td>
                              <td class="font-weight-bold">$362</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td class="font-weight-medium">
                                <div class="badge badge-success">Completed</div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Employers attendence -->
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Employers Attendence</p>
                  <div class="row">
                    <div class="col-12">
                      <div class="table-responsive">
                        <table id="example" class="display expandable-table col-lg-12">
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
                              <td>1</td>
                              <td>Search Enginf Marketing</td>
                              <td class="font-weight-bold">$362</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 18</td>
                              <td class="font-weight-medium">
                                <div class="badge badge-success">Completed</div>
                              </td>
                            </tr>
                            <tr>
                              <td>2</td>
                              <td>Search Engine Marketing</td>
                              <td class="font-weight-bold">$362</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td class="font-weight-medium">
                                <div class="badge badge-success">Completed</div>
                              </td>
                            </tr>
                            <tr>
                              <td>3</td>
                              <td>Search Engine Marketing</td>
                              <td class="font-weight-bold">$362</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td class="font-weight-medium">
                                <div class="badge badge-success">Completed</div>
                              </td>
                            </tr>
                            <tr>
                              <td>4</td>
                              <td>Search Engine Marketing</td>
                              <td class="font-weight-bold">$362</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td class="font-weight-medium">
                                <div class="badge badge-success">Completed</div>
                              </td>
                            </tr>
                            <tr>
                              <td>5</td>
                              <td>Search Engine Marketing</td>
                              <td class="font-weight-bold">$362</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td>21 Sep 2018</td>
                              <td class="font-weight-medium">
                                <div class="badge badge-success">Completed</div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
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