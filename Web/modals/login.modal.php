<!-- The Modal -->
<div id="loginmodal" class="modal">
  <span onclick="document.getElementById('loginmodal').style.display='none'" class="close" title="Close Modal">&times;</span>

  <!-- Modal Content -->
  <form class="modal-content animate" action="includes/login.inc.php" method="post">
    <div class="container">
      <label for="uid"><b>Username/email</b></label>
      <input type="text" placeholder="Enter username or email" name="uid">

      <label for="pwd"><b>Password</b></label>
      <input type="password" placeholder="Enter password" name="pwd">

      <button type="submit" name="submit" class="button-one">Login</button>
    </div>

    <div class="container">
      <button type="button" onclick="document.getElementById('loginmodal').style.display='none'" class="cancelbtn button-one">Cancel</button>
      <span class="psw">Forgot <a href="#">password?</a></span>
    </div>
  </form>
  <?php
  // Error messages
  if (isset($_GET["page"])) {
    if ($_GET["page"] == "emptyinput") {
      echo "<p>Fill in all fields</p>";
    } else if ($_GET["page"] == "wronglogin") { ?>
      <script>
        $(document).ready(function() {
          $('.credentialalert').removeClass("hide");
          $('.credentialalert').addClass("show");
          $('.credentialalert').addClass("showAlert");
          setTimeout(function() {
            $('.credentialalert').addClass("hide");
            $('.credentialalert').removeClass("show");
          }, 5000); //hides the alert automatically after 5 seconds
          setTimeout(function() {
            $('.credentialalert').removeClass("showAlert");
          }, 6000); //hides the alert in the background automatically after 6 seconds

          $('.close-btn').click(function() {
            $('.credentialalert').addClass("hide");
            $('.credentialalert').removeClass("show");
            setTimeout(function() {
              $('.credentialalert').removeClass("showAlert");
            }, 6000); //hides the alert in the background automatically after 6 seconds
          });
        });
      </script>
    <?php
    } else if ($_GET["page"] == "login-none") {
    ?>
      <script>
        $(document).ready(function() {
          $('.loginalert').removeClass("hide");
          $('.loginalert').addClass("show");
          $('.loginalert').addClass("showAlert");
          setTimeout(function() {
            $('.loginalert').addClass("hide");
            $('.loginalert').removeClass("show");
          }, 5000); //hides the alert automatically after 5 seconds
          setTimeout(function() {
            $('.loginalert').removeClass("showAlert");
          }, 6000); //hides the alert in the background automatically after 6 seconds

          $('.close-btn').click(function() {
            $('.loginalert').addClass("hide");
            $('.loginalert').removeClass("show");
            setTimeout(function() {
              $('.loginalert').removeClass("showAlert");
            }, 6000); //hides the alert in the background automatically after 6 seconds
          });
        });
      </script>
  <?php
    } else if ($_GET["page"] == "logout-none") {
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
            setTimeout(function() {
              $('.logoutalert').removeClass("showAlert");
            }, 6000); //hides the alert in the background automatically after 6 seconds
  
            $('.close-btn').click(function() {
              $('.logoutalert').addClass("hide");
              $('.logoutalert').removeClass("show");
              setTimeout(function() {
              $('.logoutalert').removeClass("showAlert");
            }, 6000); //hides the alert in the background automatically after 6 seconds
            });
          });
        </script>
    <?php
      }
  }
  ?>
</div>