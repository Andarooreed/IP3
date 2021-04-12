// Get the modal
var loginModal = document.getElementById('loginmodal');
var signupModal = document.getElementById('signupmodal');
var addModelModal = document.getElementById('addmodelmodal');
var runModelModal = document.getElementById('runmodelmodal');
var editModelModal = document.getElementById('editmodelmodal');

// When the user clicks anywhere outside of the login or signup modal, close it
window.onclick = function(event) {
    if (event.target == loginModal || event.target == signupModal || event.target == addModelModal || event.target == runModelModal || event.target == editModelModal) {
        loginModal.style.display = "none";
        signupModal.style.display = "none";
        addModelModal.style.display = "none";
        runModelModal.style.display = "none";
        editModelModal.style.display = "none";
    }
}