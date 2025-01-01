<?php
include '../server_database.php'; // Include the database connection file

$username = 'current_user'; // Replace this with the actual username of the logged-in user

// Query to fetch the profile picture path from the database
$sql = "SELECT profile_picture FROM user_settings WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($profile_picture);
$stmt->fetch();

// Close the database connection
$stmt->close();
$conn->close();
?>

<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
    <a class="navbar-brand brand-logo-mini " href="index.php"><img src="assets/images/favicon.png" class="me-2"
        alt="logo" /></a>
    <a class="navbar-brand brand-logo" href="index.php"><img src="assets/images/Daffodils.svg"
        alt="logo" /></a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="icon-menu"></span>
    </button>
    <ul class="navbar-nav mr-lg-2">
    </ul>
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
          <!-- HTML code to display the image -->
          <!-- HTML to display the image -->
          <?php if (!empty($profile_picture)): ?>
            <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="profile" height="100px" />
          <?php else: ?>
            <img src="assets/images/default-profile.png" alt="default profile" height="100px" />
          <?php endif; ?>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
          <a class="dropdown-item" href="settings.php">
            <i class="ti-settings text-primary"></i> Settings </a>
          <a class="dropdown-item" href="logout.php">
            <i class="ti-power-off text-primary"></i> Logout </a>
        </div>
      </li>
      <!-- <li class="nav-item nav-settings d-none d-lg-flex">
        <a class="nav-link" href="#">
          <i class="icon-ellipsis"></i>
        </a>
      </li> -->
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-format-align-center"></span>
    </button>
  </div>
</nav>