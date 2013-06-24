<?php
function CheckProperty($__apiPropertyParam) {
	switch (gettype($__apiPropertyParam)) {
		case 'integer':
			$__apiPropertyParam = strval($__apiPropertyParam);
			break;
		case 'double':
			$__apiPropertyParam = strval($__apiPropertyParam);
			break;
		case 'boolean':
			$__apiPropertyParam = $__apiPropertyParam ? 'true' : 'false';
			break;
	}
	return $__apiPropertyParam;
}
function BuildingSortCompare ($a, $b) { 
	if (is_array($a)) {
		if ($a['building'] == $b['building']) return 0;
		return ($a['building'] > $b['building']) ? 1 : -1;
	} else {
		if ($a == $b) return 0;
    	return ($a > $b) ? 1 : -1;
	}
} 
function UniqueBldgs($bldgArr) {
	$newBldgArr = array(); 
	
	$k = 0;
	$exists = false;
	for ($i = 0;$i < count($bldgArr);++$i) { 
		for ($j = 0;$j < count($newBldgArr);$j++) { 
			if ($bldgArr[$i]['building'] == $newBldgArr[$j]['building']) {
				$exists = true;
			}
		}
		if (!$exists) {
			$newBldgArr[$k]['building'] = $bldgArr[$i]['building']; 
			$newBldgArr[$k]['elevation'] = $bldgArr[$i]['elevation']; 
			$k++;
		} 
		$exists = false;
	} 
	return $newBldgArr;
}
?>