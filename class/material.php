<?
	class Material {
		var $db;
		
		var $id;
		
		var $MaterialCode;
		var $MaterialName;
		var $MaterialType;
		var $MaterialWidth;
		var $MaterialHeight;
		var $MaterialPrice;
		var $CreatedBy;
		var $CreatedDate;
		var $UpdatedBy;
		var $UpdatedDate;
		var $Status;
		
		var $ProjectList = array();
		
		function __construct( $MaterialID , $db ){
			$this->db = $db;
			$this->id = $MaterialID;
			$this->loadMaterialInfo();
		}
		
		function loadMaterialInfo() {
			
			$params = array();
			$sql = "SELECT * FROM material WHERE id = ? ";
			$params["id"] = $this->id;
			$resultArray = $this->db->select ( $sql , $params );
			$result = $resultArray["datas"];
			$numrows = $resultArray["numrows"];
			
			$datas = mysql_fetch_array($result);
			
			$this->id = $datas["id"];
			$this->MaterialCode = $datas["MaterialCode"];
			$this->MaterialName = $datas["MaterialName"];
			$this->MaterialWidth = $datas["MaterialWidth"];
			$this->MaterialHeight = $datas["MaterialHeight"];
			$this->MaterialPrice = $datas["MaterialPrice"];
			$this->CreatedBy = $datas["CreatedBy"];
			$this->CreatedDate = $datas["CreatedDate"];
			$this->UpdatedBy = $datas["UpdatedBy"];
			$this->UpdatedDate = $datas["UpdatedDate"];
			
			$params = array();
			$sql = "SELECT * FROM project_material WHERE MaterialID = ? ";
			$params["id"] = $this->id;
			$resultArray = $this->db->select ( $sql , $params );
			$result = $resultArray["datas"];
			$numrows = $resultArray["numrows"];
			
			for($i =0;$i < $numrows;$i++) {
				$datas = mysql_fetch_array($result);
				$this->ProjectList[$i] = $datas["ProjectID"];
			}
			
		}
		
		function saveMaterial() {
			
			if(!empty($this->id)) {
				
				$params = array();
				
				$sql = "UPDATE material SET 
						MaterialCode = ? , 
						MaterialName = ?  , 
						MaterialWidth = ?  ,
						MaterialHeight = ?  ,
						MaterialPrice = ? ,
						UpdatedBy = ?  ,
						UpdatedDate = NOW() 
						WHERE id = ?
						";
				$params["MaterialCode"] = $this->MaterialCode;
				$params["MaterialName"] = $this->MaterialName;
				$params["MaterialWidth"] = $this->MaterialWidth;
				$params["MaterialHeight"] = $this->MaterialHeight;
				$params["MaterialPrice"] = $this->MaterialPrice;
				$params["UpdatedBy"] = $this->CreatedBy;
				$params["id"] = $this->id;
				
				$this->db->execute ( $sql , $params );
				
			} else {
			
				$params = array();
				
				$sql = "INSERT INTO material (id ,MaterialCode , MaterialName  , MaterialWidth , MaterialHeight  , MaterialPrice , CreatedBy , CreatedDate , UpdatedBy , UpdatedDate )
						VALUES (NULL , ? , ? , ? , ? , ? , ? , NOW() , ? , NOW())";
				$params["MaterialCode"] = $this->MaterialCode;
				$params["MaterialName"] = $this->MaterialName;
				$params["MaterialWidth"] = $this->MaterialWidth;
				$params["MaterialHeight"] = $this->MaterialHeight;
				$params["MaterialPrice"] = $this->MaterialPrice;
				$params["CreatedBy"] = $this->CreatedBy;
				$params["UpdatedBy"] = $this->CreatedBy;
				
				$this->db->execute ( $sql , $params );
								
			}
			
		}
		
		function deleteMaterial() {
			
			$sql = "UPDATE material SET Status = 'N' WHERE id = ? ";
			$params["id"] = $this->id;
				
			$this->db->execute ( $sql , $params );
		}
				
	}
?>