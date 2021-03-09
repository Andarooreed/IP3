<script>
	  function submit_soap(){
		var ip=$("#ip_address").val();
		$.get("form_get.php",{ip:ip},
		function(data){
		  $("#json_response").html(data);
		});
	}
	</script>

<h3>Send HTTP Get Request using PHP</h3>
     <form>
     Get Models : <input name="models" id="models" type="text" /><br />
      <input type="button" value="Submit" onclick="submit_soap()"/>
    </form>
       <br>-----------
	  <div id="json_response"></div>