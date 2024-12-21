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
function sendwhatsapp(){
  var phonenumber = "";

  var name = document.querySelector(".name").value;
  var email = document.querySelector(".email").value;
  var country = document.querySelector(".country").value;
  var message = document.querySelector(".message").value;

  var url = "https://wa.me/" + phonenumber + "?text="
  +"*Name :* "+name+"%0a"
  +"*Email :* "+email+"%0a"
  +"*Country:* "+country+"%0a"
  +"*Message :* "+message
  +"%0a%0a"
  +"This is an example of send HTML form data to WhatsApp";

  window.open(url, '_blank').focus();
}
  