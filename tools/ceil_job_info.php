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
		$("#action").val("saveJobInfo");
		$.post("../ajax/ceil_job.php",
			$('#form').serialize()
		, 
		function(data){
			$("#imageResult").html(data);
			loadMenu('<? echo $_SESSION["menu_code"]; ?>');
		});
	}
	
	function showImage() {
		$("#imageResult").html("");
		$("#action").val("getImageInfo");
		$.post("../ajax/ceil_job.php",
			$('#form').serialize()
		, 
		function(data){		
			$("#imageResult").html(data);
		});
	}	
	
	function loadObjectDetailInfo() {
		$.post("../ajax/ceil_job.php",
			{
				"action" : "loadObjectDetailInfo",
				"NumObject" : $("#ObjectWall").val()
			}
		, 
		function(data){		
			$("#ObjectDetail").html(data);
		});
	}
	
	function LoadProjectMaterial( projectID , materialSelect) {
		$.post("../ajax/ceil_job.php",
			{
				"action" : "LoadProjectMaterial",
				"ProjectID" : projectID , 
				"materialSelect" : materialSelect 
			}
		, 
		function(data){		
			$("#Material").html(data);
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
	<input type = "hidden" id = "action" name = "action" value = "getImageInfo" >
	<input type = "hidden" id = "id" name = "id" value = "<? echo $JobID; ?>" >	
	<input type = "hidden" id = "JobType" name = "JobType" value = "3" >	
	
	<div style = "width:30%;height:auto;float:left;">
	<div>Project</div>
	<div>
	<select id = "ProjectID" name = "ProjectID" class = "ui-corner-all" style = "width:200px;" onchange = "LoadProjectMaterial( this.value , '')">
	<option value = "">Select Project</option>
	<?
		for($i =0;$i < count($ProjectArray);$i++) {
			?>
			<option value = "<? echo $ProjectArray[$i]->id;?>"><? echo $ProjectArray[$i]->ProjectName;?></option>
			<?
		}
	?>
	</select>
	</div>
	
	<div>Job name</div>
	<div><input type = "text" id = "JobName" name = "JobName" value = "<? echo $JobInfo->JobName; ?>"  style = "width:200px;" class = "ui-corner-all"></div>		
	
	<div>Width</div>
	<div><input type = "text" id = "Width" name = "Width" value = "<? echo $JobInfo->FloorJobList["Width"]; ?>"  style = "width:200px;" class = "ui-corner-all"  ></div>		
	
	<div>Long</div>
	<div><input type = "text" id = "Long" name = "Long" value = "<? echo $JobInfo->FloorJobList["Long"]; ?>"  style = "width:200px;" class = "ui-corner-all"  ></div>
	
	<div>Start Point X</div>
	<div><input type = "text" id = "StartX" name = "StartX" value = "<? echo $JobInfo->FloorJobList["StartX"]; ?>"  style = "width:200px;" class = "ui-corner-all"  ></div>	
	
	<div>Start Point Y</div>
	<div><input type = "text" id = "StartY" name = "StartY" value = "<? echo $JobInfo->FloorJobList["StartY"]; ?>"  style = "width:200px;" class = "ui-corner-all"  ></div>	
	
	<div>Material</div>
	<div>
	<select id = "Material" name = "Material" class = "ui-corner-all" style = "width:200px;">
	<option value = "">Select Material</option>
	</select>
	</div>
	
	<div>ObjectWall</div>
	<div><input type = "text" id = "ObjectWall" name = "ObjectWall" value = "<? echo $JobInfo->FloorJobList["ObjectWall"]; ?>"  style = "width:200px;" class = "ui-corner-all" onblur = "loadObjectDetailInfo()"></div>	
	
	<div id = "ObjectDetail">
	<?
		for($i =0;$i < $JobInfo->FloorJobList["ObjectWall"] ;$i++) {
			?>
			<div>Object Width</div>
			<div><input type = "text" name = "ObjectWidth[]" value = "<? echo $JobInfo->FloorJobList["ObjectWidth"][$i]; ?>"  style = "width:200px;" class = "ui-corner-all" ></div>		
			<div>Object Long</div>
			<div><input type = "text" name = "ObjectLong[]" value = "<? echo $JobInfo->FloorJobList["ObjectLong"][$i]; ?>"  style = "width:200px;" class = "ui-corner-all" ></div>
			<div>Object Location X</div>
			<div><input type = "text" name = "ObjectX[]" value = "<? echo $JobInfo->FloorJobList["ObjectX"][$i]; ?>"  style = "width:200px;" class = "ui-corner-all" ></div>
			<div>Object Location Y</div>
			<div><input type = "text" name = "ObjectY[]" value = "<? echo $JobInfo->FloorJobList["ObjectY"][$i]; ?>"  style = "width:200px;" class = "ui-corner-all" ></div>
			<?
		}
	?>
	</div>
	
	
	</div>
	<div style = "width:70%;height:500px;float:left;overflow:auto;">
	<div id = "imageResult">
	<?
		if(!empty($JobInfo->JobName)) {		
			?>
			<div><img src = '../resource/image/<? echo $JobInfo->JobName.".png?".rand(0,32000); ?>' /></div>
			<input type = "hidden" name = "MaterialAmount" value = "">
			<div>Total material = <? echo $JobInfo->FloorJobList["MaterialAmount"]; ?></div>
			<?
		}
	?>
	</div>
	</div>
	
	<div>
	<input type = "button" value = "Preview" class = "button" onclick = "showImage()">
	<input type = "button" value = "Save" class = "button" onclick = "save()">
	<input type = "button" value = "Cancel"  class = "button" onclick = "cancel()">
	</div>
	
	</form>
</div>

<script>
	$(function() {	
		$( "input[type=button],input[type=submit], a, button" ).button();
		<?
			if(!empty($JobInfo->ProjectID)) {
				?>
				$("#ProjectID").val("<? echo $JobInfo->ProjectID; ?>");
				<?
				if(!empty($JobInfo->FloorJobList["Material"])) {
					?>
					LoadProjectMaterial( "<? echo $JobInfo->ProjectID; ?>" , "<? echo $JobInfo->FloorJobList["Material"]; ?>");
					<?
				}
			}
		?>		
		closePopup();		
	});
	
	$(".button").css({
		"width":"100px",
		"font-size":"10px"
	});
</script>
