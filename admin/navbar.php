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
      <i class="fa-solid fa-school"></i>
        <span class="menu-title">&nbsp;&nbsp;&nbsp;&nbsp;School</span>
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
          <li class="nav-item"> <a class="nav-link" href="employees_Attendence.php">Employees</a></li>
          <li class="nav-item"> <a class="nav-link" href="staffs_Attendence.php">Staffs</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#error" aria-expanded="false" aria-controls="error">
      <i class="fa-solid fa-users"></i> 
        <span class="menu-title">&nbsp;&nbsp;&nbsp;&nbsp;Employers</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="error">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="employers.php"> Employees </a></li>
          <li class="nav-item"> <a class="nav-link" href="staffs.php"> Staffs </a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#e" aria-expanded="false" aria-controls="e">
      <i class="fa-solid fa-hand-holding-dollar"></i> 
        <span class="menu-title">&nbsp;&nbsp;&nbsp;&nbsp;Management</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="e">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="school_funds.php"> Funds </a></li>
          <li class="nav-item"> <a class="nav-link" href="cashiers.php"> Cashiers </a></li>
          <li class="nav-item"> <a class="nav-link" href="expenses.php"> Expenses </a></li>
          <li class="nav-item"> <a class="nav-link" href="barcode.php"> Barcode </a></li>
        </ul>
      </div>
    </li>
  </ul>
</nav>