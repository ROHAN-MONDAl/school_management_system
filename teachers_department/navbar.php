<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="index.php">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
      <i class="fa-solid fa-school"></i> &nbsp; &nbsp; &nbsp;
        <span class="menu-title"> School</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="auth">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="teachers.php"> Teachers </a></li>
          <li class="nav-item"> <a class="nav-link" href="students.php"> Students </a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#attendence" aria-expanded="false" aria-controls="attendence">
        <i class="icon-head menu-icon"></i>
        <span class="menu-title">Attendance</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="attendence">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="students_Attendences.php">Students</a></li>
          <li class="nav-item"> <a class="nav-link" href="teachers_Attendences.php">Teachers</a></li>
        </ul>
      </div>
    </li>
  </ul>
</nav>