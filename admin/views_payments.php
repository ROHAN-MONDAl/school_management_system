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
        <div id="header">
            <?php include 'header.php' ?>
        </div>

        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.php -->
            <nav style="background-color:#1A233A" id="navbar_print">
                <?php include 'navbar.php' ?>
            </nav>


            <!-- Main Dashboard Panel -->
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center">
                            <div class="row">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                    <h2 class="font-weight-bold text-primary fw-bolder">Payments</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row col-12 col-lg-12 d-flex justify-content-center mx-auto">
                        <div class="payslip col-lg-12 bg-warning bg-opacity-25">
                            <div class="header mb-5 fs-2">
                                <div><b>Daffodils School</b></div>
                                <p>Address Line 1, City, State, ZIP</p>
                                <p>Contact: 123-456-7890</p>
                                <hr class="border border-black">
                            </div>

                            <div class="">
                                <div class="details">
                                    <table>
                                        <tr class="rounded float-start">
                                            <td><img src="assets/images/faces/face15.jpg" class="border rounded" alt="" srcset="" width="200px"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Name</th>
                                            <td class="colspan-2">John Doe</td>
                                        </tr>
                                        <tr>
                                            <th>Phone number</th>
                                            <td>10</td>
                                        </tr>
                                        <tr>
                                            <th>Whats app Number</th>
                                            <td>12345</td>
                                        </tr>
                                        <tr>
                                            <th>Branch name</th>
                                            <td>Bankura</td>
                                        </tr>
                                        <tr>
                                            <th>Admission daye</th>
                                            <td>12.12.2001</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 d-flex justify-content-center grid gap-0 column-gap-3 g-4 mb-5 data">
                                <div class="col-lg-6 col-md-6 ">
                                    <div class="fs-5"><b>Summary</b></div>
                                    <div>fsdf</div>
                                    <div>fsdf</div>
                                    <div>fsdf</div>
                                    <div>lorem3000</div>
                                </div>
                                <div class="col-lg-6 col-md-6 text-center justify-content-center">
                                    <div class="fs-5"><b>Amount</b></div>
                                    <div>Rs fsdf</div>
                                    <div>Rs fsdf</div>
                                    <div>Rs fsdf</div>
                                    <div>Rs fsdf</div>
                                    <div>Rs fsdf</div>
                                </div>


                            </div>
                            <div class="col-lg-12 col-md-12 d-flex justify-content-center grid gap-0 column-gap-3 g-4 mb-5">
                                <div class="col-lg-6 col-md-6 ">
                                    <div class="fs-5"><b>Total</b></div>
                                </div>
                                <div class="col-lg-6 col-md-6 text-center justify-content-center">
                                    <div class="fs-5"><b>Rs 5500</b></div>
                                </div>

                            </div>


                        </div>
                        <!-- Button trigger modal -->
                        <div class="row d-flex justify-content-center g-4 mx-auto">
                            <div class="col-lg-12 col-md-12 d-flex justify-content-center grid gap-0 column-gap-3 g-4">
                                <button type="button" id="print" class="btn btn-danger text-light col-lg-3 col-md-3 download mx-1">Download PDF</button>
                                <button type="button" id="print" class="btn btn-success text-light col-lg-3 col-md-3 download" data-toggle="modal"
                                    data-target="#exampleModalCenter">Shares dues</button>

                            </div>
                            <a href="http://" target="_blank" class="row d-flex justify-content-center g-4 mx-auto" style="text-decoration: none;" rel="noopener noreferrer"><button type="button" id="print"
                                    class="btn btn-info text-light col-lg-6 g-2 mt-3 fs-5">Edit</button></a>


                            <!-- Form -->
                            <div class="modal fade bg-white" id="exampleModalCenter" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">


                                        <form class="forms-sample  bg-warning bg-opacity-25 border rounded border-dark">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle" value="jfvhjksd">Message box</h5>
                                            </div>
                                            <div class="form-group col-12 flex-grow-1">
                                                <div class="col-lg-12 col-md-12 text-lg-start text-md-start mt-3">
                                                    <label for="" class="form-label ">Class:</label>
                                                    <select name="" class="form-control form-select text-black classs border border-dark">
                                                        <option value="Nursury">Nursury</option>
                                                        <option value="Pre nursury">Pre nursury</option>
                                                        <option value="Kg">Kg</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>

                                                <div class="col-lg-12 col-md-12 text-lg-start text-md-start mt-3">
                                                    <label for="">Branch name</label>
                                                    <select name="" class="form-control form-select text-black branch border border-dark">
                                                        <option value="a">A</option>
                                                        <option value="b">B</option>
                                                    </select>
                                                </div>

                                                <div class="col-lg-12 col-md-12 text-lg-start text-md-start mt-3">
                                                    <label for="" class="form-label">Amount</label>
                                                    <input type="number" class="form-control duesamt border border-dark">
                                                </div>

                                                <div class="col-lg-12 col-md-12 text-lg-start text-md-start mt-3">
                                                    <label for="" class="form-label">Message</label>
                                                    <textarea class="form-control message border border-dark"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button" id="share-whatsapp" class="btn btn-success bg-opacity-25"
                                                    data-bs-toggle="button" data-dismiss="modal" autocomplete="off"
                                                    onclick="sendwhatsapp();">Send</button>
                                            </div>
                                        </form>




                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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