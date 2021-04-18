// Get the modal
var loginModal = document.getElementById('loginmodal');
var signupModal = document.getElementById('signupmodal');
var addModelModal = document.getElementById('addmodelmodal');
var runModelModal = document.getElementById('runmodelmodal');
var deleteModelModal = document.getElementById('deletemodelmodal');
var aboutModal = document.getElementById('aboutmodal');

// When the user clicks anywhere outside of the login or signup modal, close it
window.onclick = function(event) {
    if (event.target == loginModal || event.target == signupModal || event.target == addModelModal || event.target == runModelModal || event.target == deleteModelModal || event.target == aboutModal) {
        loginModal.style.display = "none";
        signupModal.style.display = "none";
        addModelModal.style.display = "none";
        runModelModal.style.display = "none";
        deleteModelModal.style.display = "none";
        aboutModal.style.display = "none";
    }
}