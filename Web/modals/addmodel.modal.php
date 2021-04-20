<div id="addmodelmodal" class="modal">
  <span onclick="document.getElementById('addmodelmodal').style.display='none'" class="close" title="Close Modal">&times;</span>

  <!-- Modal Content -->
  <form class="modal-content animate" action="includes/addmodel.inc.php" method="post" enctype='multipart/form-data'>
    <div class="container">
      <label for="model_name"><b>Model Name (What's in the photos?)</b></label>
      <input type="text" placeholder="Model name" name="model_name" required>

      <!-- Enable form to select multiple items -->
      <label for="model_location"><b>Training FIles</b></label>
      <input type="file"  name="file[]" multiple="true">

      <label for="simppy"><b>Suppliment Image Set?</b></label>
      <input type="radio"  name="simp_vol" value=0 checked="checked"> Nah. <br/>
      <input type="radio"  name="simp_vol" value=5> +5 <br/>
      <input type="radio"  name="simp_vol" value=100> +100 <br/>
      <input type="radio"  name="simp_vol" value=500> +500 <br/>
      <input type="radio"  name="simp_vol" value=1000> +1,000 <br/>
      <input type="radio"  name="simp_vol" value=2000> +2,000 <br/>

      <button type="submit" name="submit" class="button-one">Add model</button>
    </div>

    <div class="container">
      <button type="button" onclick="document.getElementById('addmodelmodal').style.display='none'" class="cancelbtn button-one">Cancel</button>
    </div>
  </form>
</div>