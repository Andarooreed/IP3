function openNav() {
    document.getElementById("leftside-nav").style.width = "370px";
    document.getElementById("main").style.marginLeft = "370px";
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav() {
    document.getElementById("leftside-nav").style.width = "72px";
    document.getElementById("main").style.marginLeft = "72px";
}

// element fade animations

$("#open-nav").click(function() {
    $("#closebtn").fadeIn(500);
    $(".leftside-nav-wording").fadeIn(500);
    $("#add-model-btn").fadeIn(500);
});

$("#closebtn").click(function() {
    $("#closebtn").fadeOut(500);
    $(".leftside-nav-wording").fadeOut(500);
    $("#add-model-btn").fadeOut(500);
});