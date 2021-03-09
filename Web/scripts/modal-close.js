// Get the modal
var loginModal = document.getElementById('loginmodal');
var signupModal = document.getElementById('signupmodal');
var infoModal = document.getElementById('infomodal');

// When the user clicks anywhere outside of the login or signup modal, close it
window.onclick = function(event) {
    if (event.target == loginModal || event.target == signupModal || event.target == infoModal) {
        loginModal.style.display = "none";
        signupModal.style.display = "none";
        infoModal.style.display = "none";
    }
}