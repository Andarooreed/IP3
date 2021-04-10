<div id="addmodelmodal" class="modal">
  <span onclick="document.getElementById('addmodelmodal').style.display='none'" class="close" title="Close Modal">&times;</span>

  <!-- Modal Content -->
  <form class="modal-content animate" action="includes/addmodel.inc.php" method="post" enctype='multipart/form-data'>
    <div class="container">
      <label for="model_name"><b>Name</b></label>
      <input type="text" placeholder="Model name" name="model_name">

      <!-- Enable form to select multiple items -->
      <label for="model_location"><b>Files, Bitch</b></label>
      <input type="file"  name="file[]" multiple="true">

      <button type="submit" name="submit" class="button-one">Add model</button>
    </div>

    <div class="container">
      <button type="button" onclick="document.getElementById('addmodelmodal').style.display='none'" class="cancelbtn button-one">Cancel</button>
    </div>
  </form>
</div>