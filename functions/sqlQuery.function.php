<?php

	define('DB_HOST','mysql:host=localhost;dbname=db_lightpearl');
	define('DB_UNAME','root');
	define('DB_PWORD','');

	$con = dbConnect(DB_HOST,DB_UNAME,DB_PWORD);
	
	function getConnection()
	{
		return $GLOBALS['con'];
	}
	
	function dbConnect($host,$uname,$pword)
	{
		return new PDO($host,$uname,$pword);
	}

	function query($query = NULL, $preparedQuery = NULL, $actualValues = NULL, $requestType = NULL, $singleResult = 0)
	{
		$con = getConnection();
		if(!preg_match('/INSERT/',$query))
		{
			if($preparedQuery == NULL)
			{
				$stmt = $con->query($query);
			}else{
				$stmt = $con->prepare($query . ' ' . $preparedQuery);
				$stmt->execute($actualValues);
			}
		}
		else{
			$stmt = $con->prepare($query);
			$stmt->execute($actualValues);
		}
		
		if($requestType != NULL)
		{
			if($requestType == 'variable'){
				
				for ($i = 0; $i < $stmt->columnCount(); $i++) {
					$col = $stmt->getColumnMeta($i);
					$columns[] = $col['name'];
				}	
				
				$result = array();
				$tempResult = array();
				
				while($row = $stmt->fetch()){
					for($i=0;$i<$stmt->columnCount();$i++){
						$tempResult['row'][$columns[$i]] = $row[$i];
					}
					
					if($singleResult == 1){
						return $tempResult;
					}	
					
					array_push($result,$tempResult);
				}
				
				return $result;
			}
			elseif($requestType == 'rows')
				return $stmt->rowCount();
			else
				return NULL;
		}else{
			if($stmt){
				return 1;
			}else{
				return 0;
			}
		}
		
	}
	
?>

