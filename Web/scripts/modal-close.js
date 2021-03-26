// Get the modal
var loginModal = document.getElementById('loginmodal');
var signupModal = document.getElementById('signupmodal');
var addModelModal = document.getElementById('addmodelmodal');

// When the user clicks anywhere outside of the login or signup modal, close it
window.onclick = function(event) {
    if (event.target == loginModal || event.target == signupModal || event.target == addModelModal) {
        loginModal.style.display = "none";
        signupModal.style.display = "none";
        addModelModal.style.display = "none";
    }
}