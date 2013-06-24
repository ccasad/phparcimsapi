<?php

$tempImageName = 'tempimage2.' . $imageType;
		
		if ($remoteImage = fopen($mapfile, 'rb')) {
			if ($localImage = fopen($this->__apiImageFilePath . $tempImageName, 'wb')) {	
				$buffer = '';	
				while(!feof($remoteImage)) {
					$buffer .= fread($remoteImage, 4096);
				}
				fwrite($localImage, $buffer, strlen($buffer));
				fclose($localImage);
			}
		}
		fclose($remoteImage);
		
?>

