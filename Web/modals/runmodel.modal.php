<div id="runmodelmodal" class="modal">
  <span onclick="document.getElementById('runmodelmodal').style.display='none'" class="close" title="Close Modal">&times;</span>

  <!-- Modal Content -->
  <form class="modal-content animate" method="POST" action="./includes/upload.inc.php"  enctype="multipart/form-data">
    <div class="container">
      <label for="model_name"><b>Name</b></label>
      <input name="select" id="model-modal-input-name" type="text" readonly>

      <label for="fileToUpload"><b>Image</b></label>
      <input type="file" name="fileToUpload" id="fileToUpload">

      <button class="button-one">Run Model</button>
    </div>

    <div class="container">
      <button type="button" onclick="document.getElementById('runmodelmodal').style.display='none'" class="cancelbtn button-one">Cancel</button>
    </div>
  </form>
</div>