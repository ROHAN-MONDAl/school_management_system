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