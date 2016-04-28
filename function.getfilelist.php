<?php
	function getFileList($path = ""){
		try{
			$content = array();
			if(file_exists($path)){
				if(is_dir($path)){
					$content[$path] = array();
					$i = 0; 
					$contentArray = scandir($path);
					foreach ($contentArray as $key => $value) {
						if(is_file($path.DIRECTORY_SEPARATOR.$value)){
							if($value != '.' || $value != '..'){
								$content[$path][$i] = $value;
								$i++;
							}
						}else{
							if(strpos($value, '.') === false){
								$content[$path][$i] = getFileList($path.DIRECTORY_SEPARATOR.$value);
								$i++;
							}
						}
					}
					return $content;
				}else{
					exit;
				}

			}

			return array();
		}catch(Exception $e){
			die($e->getMessage());
		}
	}
?>