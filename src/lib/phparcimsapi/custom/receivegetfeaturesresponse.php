<?php
/// This function builds the ArcXML for the get_features request
function ReceiveGetFeaturesResponse(&$objConnector) { 
	$objRec = &$objConnector->__apiRecordset;
	
	$objRec->MoveFirst();
	
	/// Need to sort and remove duplicates
	
	for ($i = 0;$i < $objRec->__apiRecordCount;$i++) {
		if ($objRec->__apiRecords[$i]['BLDG_NUM']) {
			$bldgNum = $objRec->__apiRecords[$i]['BLDG_NUM'];
		} else if ($objRec->__apiRecords[$i]['LAFB_NUM']) {
			$bldgNum = $objRec->__apiRecords[$i]['LAFB_NUM'];
		}
		if ($bldgNum) {
			echo '<br>' . $bldgNum;
		}
	}
}
?>
