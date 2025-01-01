// on screen loading
var myVar;

function myFunction() {
  myVar = setTimeout(showPage, 2000);
}

function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("myDiv").style.display = "block";
}



// auto update footer year
document.addEventListener('DOMContentLoaded', function () {
    const currentYear = new Date().getFullYear();
    document.getElementById('currentYear').textContent = currentYear;
});


    // Handle form validation
    document.getElementById('signinForm').addEventListener('submit', function (event) {
      event.preventDefault();
      const email = document.getElementById('email');
      const password = document.getElementById('password');
      const userType = document.getElementById('userType');
      const errorMessage = document.getElementById('errorMessage');

      // Clear previous error messages
      email.classList.remove('is-invalid');
      password.classList.remove('is-invalid');
      errorMessage.classList.add('d-none');

      // Simple validation checks
      if (!email.value || !password.value || !userType.value) {
        if (!email.value) email.classList.add('is-invalid');
        if (!password.value) password.classList.add('is-invalid');
        if (!userType.value) {
          alert('Please select your role.');
        }
        errorMessage.classList.remove('d-none');
        return;
      }

      // Dummy check for valid email and password (this can be extended)
      if (email.value !== 'test@example.com' || password.value !== 'password123') {
        errorMessage.classList.remove('d-none');
      } else {
        alert('Logged in successfully');
        // Redirect or perform any post-login action
      }
    });