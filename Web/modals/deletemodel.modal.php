<div id="deletemodelmodal" class="modal">
  <span onclick="document.getElementById('deletemodelmodal').style.display='none'" class="close" title="Close Modal">&times;</span>

  <!-- Modal Content -->
  <form class="modal-content animate" method="POST" action="./includes/deletemodel.inc.php"  enctype="multipart/form-data">
    <div class="container">
      <input name="model_name" id="model-modal-input-name-delete" type="text" readonly hidden>

      <h4 style="margin-top: 15px;">Are you sure that you want to delete this model?</h4>

      <button type="submit" name="submit" class="button-one">Confirm</button>
    </div>

    <div class="container">
      <button type="button" onclick="document.getElementById('deletemodelmodal').style.display='none'" class="cancelbtn button-one">Cancel</button>
    </div>
  </form>
</div>