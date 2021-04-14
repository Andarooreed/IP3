<div id="addmodelmodal" class="modal">
  <span onclick="document.getElementById('addmodelmodal').style.display='none'" class="close" title="Close Modal">&times;</span>

  <!-- Modal Content -->
  <form class="modal-content animate" action="includes/addmodel.inc.php" method="post">
    <div class="container">
      <label for="model_name"><strong>Name</strong></label>
      <input type="text" placeholder="Model name" name="model_name">

      <label for="model_location"><strong>Location</strong></label>
      <input type="text" placeholder="Model location" name="model_location">

      <button type="submit" name="submit" class="button-one">Add model</button>
    </div>

    <div class="container">
      <button type="button" onclick="document.getElementById('addmodelmodal').style.display='none'" class="cancelbtn button-one">Cancel</button>
    </div>
  </form>
</div>