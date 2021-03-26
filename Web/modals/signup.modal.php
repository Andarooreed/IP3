<!-- The Modal -->
<div id="signupmodal" class="modal">
  <span onclick="document.getElementById('signupmodal').style.display='none'" class="close" title="Close Modal">&times;</span>

  <!-- Modal Content -->
  <form class="modal-content animate" action="includes/signup.inc.php" method="post">
    <div class="container">
      <label for="name">Name</label>
      <input type="text" placeholder="Enter full name" name=name>

      <label for="email"><b>Email address</b></label>
      <input type="text" placeholder="Enter email" name="email">

      <label for="uid"><b>Username</b></label>
      <input type="text" placeholder="Enter username" name="uid">

      <label for="pwd"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="pwd">
      <input type="password" placeholder="Repeat password" name="pwdrepeat">

      <button type="submit" name="submit" class="button-one">Create account</button>
    </div>
    <div class="container">
      <button type="button" onclick="document.getElementById('signupmodal').style.display='none'" class="cancelbtn button-one">Cancel</button>
    </div>
  </form>
  <?php
  // Error messages
  if (isset($_GET["page"])) {
    if ($_GET["page"] == "emptyinput") {
      echo "<p>Fill in all fields!</p>";
    } else if ($_GET["page"] == "invaliduid") {
      echo "<p>Username is invalid</p>";
    } else if ($_GET["page"] == "invalidemail") {
      echo "<p>Email is invalid</p>";
    } else if ($_GET["page"] == "passwordsdontmatch") {
      echo "<p>Passwords don't match</p>";
    } else if ($_GET["page"] == "stmtfailed") {
      echo "<p>Something went wrong</p>";
    } else if ($_GET["page"] == "usernametaken") {
      echo "<p>Username already taken</p>";
    } else if ($_GET["page"] == "signup-none") {
  ?>
      <script>
        $(document).ready(function() {
          $('.signupalert').removeClass("hide");
          $('.signupalert').addClass("show");
          $('.signupalert').addClass("showAlert");
          setTimeout(function() {
            $('.signupalert').addClass("hide");
            $('.signupalert').removeClass("show");
          }, 5000); //hides the alert automatically after 5 seconds
          setTimeout(function() {
            $('.signupnalert').removeClass("showAlert");
          }, 6000); //hides the alert in the background automatically after 6 seconds

          $('.close-btn').click(function() {
            $('.signupalert').addClass("hide");
            $('.signupalert').removeClass("show");
            setTimeout(function() {
            $('.signupalert').removeClass("showAlert");
          }, 6000); //hides the alert in the background automatically after 6 seconds
          });
        });
      </script>
    <?php
    } 
  }
  ?>
</div>
</form>