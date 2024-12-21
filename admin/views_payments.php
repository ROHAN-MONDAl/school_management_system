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
    <div id="header"><?php include 'header.php' ?></div>

    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.php -->
      <nav style="background-color:#1A233A" id="navbar_print">
        <?php include 'navbar.php' ?>
      </nav>


      <!-- Main Dashboard Panel -->
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper bg-light">
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h2 class="font-weight-bold text-primary fw-bolder">Dashboard</h2>
                </div>
              </div>
            </div>
          </div>
          <div class="row text-center">
            <div class="payslip" id="imageToShare">

              <div class="header">
                <h2>School Name</h2>
                <p>Address Line 1, City, State, ZIP</p>
                <p>Contact: 123-456-7890</p>
              </div>
              <div class="details">
                <h3>Student Details</h3>
                <table>
                  <tr>
                    <th>Name</th>
                    <td>John Doe</td>
                  </tr>
                  <tr>
                    <th>Grade</th>
                    <td>10</td>
                  </tr>
                  <tr>
                    <th>Roll Number</th>
                    <td>12345</td>
                  </tr>
                </table>
              </div>
              <div class="summary">
                <h3>Payment Summary</h3>
                <table id="my-table">
                  <td>Sports Fee</td>
                  <td>$50</td>
                  </tr>
                  <tr>
                    <td>Library Fee</td>
                    <td>$30</td>
                  </tr>
                </table>
              </div>
            </div>
            <form>
              <h1>Send Data To WhatsApp</h1>
              <label for="">Name</label>
              <input type="text" class="name">

              <label for="">Email</label>
              <input type="text" class="email">

              <label for="">Country</label>
              <input type="text" class="country">

              <label for="">Message</label>
              <textarea class="message"></textarea>
              <button type="button" onclick="sendwhatsapp();">Send Via WhatsApp</button>
            </form>
            <div class="col-lg-12 col-md-12">
              <button id="print" class="btn btn-success download mx-2 mt-5">Download PDF</button>
              <button id="share-whatsapp" class="btn btn-inverse-info mt-5">Send message</button>
            </div>
          </div>
          <!-- table header -->



          <!-- /table header -->
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.php -->
        <div id="print_footer">
          <?php include "footer.php"  ?>
        </div>


        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- /container-scroller -->

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