<!-- The Modal -->
<div id="loginmodal" class="modal">
    <span onclick="document.getElementById('loginmodal').style.display='none'" class="close" title="Close Modal">&times;</span>

    <!-- Modal Content -->
    <form class="modal-content animate" action="includes/login.inc.php" method="post">
      <div class="container">
        <label for="username"><b>Username/email</b></label>
        <input type="text" placeholder="Enter username or email" name="username" required>

        <label for="pwd"><b>Password</b></label>
        <input type="password" placeholder="Enter password" name="pwd" required>

        <button type="submit" name="submit">Login</button>
        <label>
          <input type="checkbox" checked="checked" name="remember"> Remember me
        </label>
      </div>

      <div class="container">
        <button type="button" onclick="document.getElementById('loginmodal').style.display='none'" class="cancelbtn">Cancel</button>
        <span class="psw">Forgot <a href="#">password?</a></span>
      </div>
    </form>
  </div>
  </form>