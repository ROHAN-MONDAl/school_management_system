// auto update footer year
document.addEventListener('DOMContentLoaded', function () {
  const currentYear = new Date().getFullYear();
  document.getElementById('currentYear').textContent = currentYear;
});

// print
document.getElementById('print').addEventListener('click', function () {
  window.print();
});

   // Date update
   n = new Date();
   y = n.getFullYear();
   m = n.getMonth() + 1;
   d = n.getDate();
   document.getElementById("date").innerHTML = d + "-" + m + "-" + y;


