<?php
session_start(); // Start the session

// Include the database connection file
include '../server_database.php'; // This file should contain the connection details to your database

// Set session timeout to 50 hours (50 hours)
$session_timeout = 180000; // 50 hours (50 hours)

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
  // If not logged in, redirect to the index page
  header("Location: ../index.php");
  exit(); // Stop the script from running further
}

// Get the logged-in username
$username = $_SESSION['user']['username']; // Get the logged-in username from the session

// Query to fetch the profile picture (no need to check session_id anymore)
$sql = "SELECT profile_picture FROM user_settings WHERE username = '$username'"; 

// Execute the query
$results = $conn->query($sql);

// Check if the query executed successfully and the user exists
if ($results && $results->num_rows > 0) {
  // If user found, fetch the profile picture
  $rowe = $results->fetch_assoc();
  $profile_picture = $rowe['profile_picture'];
} else {
  // If no profile picture found or user doesn't exist, use default image
  $profile_picture = 'assets/images/favicon.png';
}

// Close the database connection
$conn->close(); // Close the connection to the database

// Set session timeout and check for inactivity
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $session_timeout) {
  // Session has expired, destroy the session and redirect to the login page
  session_unset();
  session_destroy();
  header("Location: ../index.php?error=Session expired.");
  exit();
}

// Update the last activity timestamp
$_SESSION['last_activity'] = time();
?>

<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
    <a class="navbar-brand brand-logo-mini" href="index.php"><img src="assets/images/favicon.png" class="me-2" alt="logo" /></a>
    <a class="navbar-brand brand-logo" href="index.php"><img src="assets/images/Daffodils.svg" alt="logo" /></a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="icon-menu"></span>
    </button>
    <ul class="navbar-nav mr-lg-2"></ul>
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item">
        <!-- Timer display -->
        <span id="session-timer" class="nav-link" style="font-size: 14px; font-weight: bold; color: white ;"></span>
      </li>
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
          <!-- Display the profile picture -->
          <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="profile" height="100px" />
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
          <a class="dropdown-item" href="settings.php">
            <i class="ti-settings text-primary"></i> Settings
          </a>
          <a class="dropdown-item" href="logout.php">
            <i class="ti-power-off text-primary"></i> Logout
          </a>
        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-format-align-center"></span>
    </button>
  </div>
</nav>

<script>
  // Set session timeout duration (in seconds) to 4 minutes
  var sessionTimeout = <?php echo $session_timeout; ?>; // 240 seconds or 4 minutes

  // Get the session's last activity time from PHP
  var lastActivityTime = <?php echo isset($_SESSION['last_activity']) ? $_SESSION['last_activity'] : 0; ?>;

  // Convert PHP time to JavaScript-compatible (milliseconds)
  var expirationTime = (lastActivityTime + sessionTimeout) * 1000;

  // Function to update the session timer
  function updateSessionTimer() {
    var currentTime = Date.now(); // Current time in milliseconds
    var remainingTime = expirationTime - currentTime; // Remaining time in milliseconds

    // If remaining time is less than or equal to zero (session expired)
    if (remainingTime <= 0) {
      document.getElementById('session-timer').textContent = "Session Expired! Logging out...";
      clearInterval(timerInterval); // Stop the timer

      // Automatically log out after session expires
      setTimeout(function() {
        window.location.href = 'logout.php'; // Redirect to logout page
      }, 2000); // Wait 2 seconds before redirecting to allow the message to show
    } else {
      // Calculate minutes and seconds from the remaining time
      var minutes = Math.floor(remainingTime / 60000); // Divide by 60,000 to get minutes
      var seconds = Math.floor((remainingTime % 60000) / 1000); // Get the remaining seconds
      // document.getElementById('session-timer').textContent = "Timeout: " + minutes + "m " + seconds + "s";
    }
  }

  // Update the timer every second
  var timerInterval = setInterval(updateSessionTimer, 1000);

  // Initial update to display time immediately on page load
  updateSessionTimer();
</script>
