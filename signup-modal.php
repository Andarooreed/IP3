<!-- The Modal -->
<div id="signupmodal" class="modal">
    <span onclick="document.getElementById('signupmodal').style.display='none'" class="close" title="Close Modal">&times;</span>

    <!-- Modal Content -->
    <form class="modal-content animate" action="includes/signup.inc.php" method="post">
      <div class="container">
        <label for="username"><b>Username</b></label>
        <input type="text" placeholder="Enter username" name="username" required>
        <label for="emailadd"><b>Email address</b></label>
        <input type="text" placeholder="Enter email" name="emailadd" required>
        <label for="pwd"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="pwd" required>
        <input type="password" placeholder="Repeat password" name="pwdrepeat" required>

        <button type="submit" name="submit">Create account</button>   
      </div>
      <div class="container">
        <button type="button" onclick="document.getElementById('signupmodal').style.display='none'" class="cancelbtn">Cancel</button>
      </div>
    </form>
  </div>
  </form>