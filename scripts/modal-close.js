// Get the modal
var loginModal = document.getElementById('loginmodal');
var signupModal = document.getElementById('signupmodal');

// When the user clicks anywhere outside of the login or signup modal, close it
window.onclick = function (event) {
  if (event.target == loginModal || event.target == signupModal) {
    loginModal.style.display = "none";
    signupModal.style.display = "none";
  }
}