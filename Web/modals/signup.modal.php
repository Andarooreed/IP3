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

      <button type="submit" name="submit">Create account</button>
    </div>
    <div class="container">
      <button type="button" onclick="document.getElementById('signupmodal').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
  </form>
  <?php
  // Error messages
  if (isset($_GET["error"])) {
    if ($_GET["error"] == "emptyinput") {
      echo "<p>Fill in all fields!</p>";
    } else if ($_GET["error"] == "invaliduid") {
      echo "<p>Username is invalid</p>";
    } else if ($_GET["error"] == "invalidemail") {
      echo "<p>Email is invalid</p>";
    } else if ($_GET["error"] == "passwordsdontmatch") {
      echo "<p>Passwords don't match</p>";
    } else if ($_GET["error"] == "stmtfailed") {
      echo "<p>Something went wrong</p>";
    } else if ($_GET["error"] == "usernametaken") {
      echo "<p>Username already taken</p>";
    } else if ($_GET["error"] == "signup-none") {
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

          $('.close-btn').click(function() {
            $('.signupalert').addClass("hide");
            $('.signupalert').removeClass("show");
          });
        });
      </script>
    <?php
    } else if ($_GET["error"] == "logout-none") {
    ?>
      <script>
        $(document).ready(function() {
          $('.logoutalert').removeClass("hide");
          $('.logoutalert').addClass("show");
          $('.logoutalert').addClass("showAlert");
          setTimeout(function() {
            $('.logoutalert').addClass("hide");
            $('.logoutalert').removeClass("show");
          }, 5000); //hides the alert automatically after 5 seconds

          $('.close-btn').click(function() {
            $('.logoutalert').addClass("hide");
            $('.logoutalert').removeClass("show");
          });
        });
      </script>
  <?php
    }
  }
  ?>
</div>
</form>