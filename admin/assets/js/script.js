// auto update footer year
document.addEventListener('DOMContentLoaded', function () {
  const currentYear = new Date().getFullYear();
  document.getElementById('currentYear').textContent = currentYear;
});

// print
document.getElementById('print').addEventListener('click', function () {
  window.print();
});


// whatsapp integration

// Share Pdf
function sendwhatsapp() {
  var phonenumber = "";

  var classs = document.querySelector(".classs").value;
  var branch = document.querySelector(".branch").value;
  var duesamt = document.querySelector(".duesamt").value;
  var message = document.querySelector(".message").value;

  var url = "https://wa.me/" + phonenumber + "?text="
    + "1.*Class :* " + classs + "%0a"
    + "2.*Branch :* " + branch + "%0a"
    + "3.*Dues :* " + duesamt + "%0a"
    + "4.*Message :* " + message
    + "%0a%0a"
    + "*Daffodils School*:- *Student Details*";


  window.open(url, '_blank').focus();
}