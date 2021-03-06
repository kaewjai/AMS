<style>
textarea {
    resize: none;
}

.ConfigContent div {
	font-weight:bold;
	color:#777777;
	margin-bottom:5px;
}


#ImageSrc {
	width:60px;
	height:60px;
}

#image_storage {
	width:100%;
	height:200px;
	background-color:#FFFFFF;
	border: solid 1px;
	display:none;
	overflow:auto;
}

.icon {
	width:50px;
	height:50px;
	margin:5px;
	cursor:pointer;
}

.icon:hover {
	width:50px;
	height:50px;
	margin:5px;
	cursor:pointer;
	background-color:#0000FF;
}

</style>
<script>
	
	$(function() {	
		$( "input[type=button],input[type=submit], a, button" ).button();		
	});
	
	function cancel() {
		showLoadingPopup();
		loadMenu('<? echo $_SESSION["menu_code"]; ?>');
	}
	
	function save() {
		showLoadingPopup();
		$.post("../ajax/project_materil_estimte.php",
			$('#form').serialize()
		, 
		function(data){
			//loadMenu('<? echo $_SESSION["menu_code"]; ?>');
		});
	}
	
	function showSelectIcon() {
		$("#image_storage").toggle();
	}
	
	function select( imagePath ) {
		$("#image_storage").hide();
		$("#ImageSrc").attr("src", imagePath);
		$("#ImagePath").val(imagePath);
	}

</script>

<div class = "ConfigContent" style = "padding:10px;">
	<form id = "form">
	<input type = "hidden" id = "action" name = "action" value = "Save" >
	<input type = "hidden" id = "id" name = "id" value = "<? echo $MaterialID; ?>" >	
	
	<div>Material name</div>
	<div style = "color:black">Basic Tile</div>		
	<div>Material type</div>
	<div style = "color:black">Tile</div>
	
	<div>Material Info</div>
	<div>
		<table border = '1' style = "border-collapse:collapse;width:100%">
		<tr>
				<th style = "width:30px;">No</th>
				<th style = "width:80px;">JobName</th>
				<th style = "width:80px;">Total</th>
		</tr>
		<tr>
			<td>1</td>
			<td>Job001</td>
			<td>125</td>
		</tr>
		<tr>
			<td>2</td>
			<td>Job002</td>
			<td>346</td>
		</tr>
		</table>
	</div>	
	<div>Estimate Total</div>
	<div><input type = 'text' style = "width:200px;" class = "ui-corner-all"></div>
	<div>
	<input type = "button" value = "Save" class = "button" onclick = "save()">
	<input type = "button" value = "Cancel"  class = "button" onclick = "cancel()">
	</div>
	</form>
</div>

<script>
	$(function() {	
		$( "input[type=button],input[type=submit], a, button" ).button();
		closePopup();		
	});
	
	$(".button").css({
		"width":"100px",
		"font-size":"10px"
	});
</script>
