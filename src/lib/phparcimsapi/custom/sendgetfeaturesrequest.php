<?php
/// This function builds the ArcXML for the get_features request
function SendGetFeaturesRequest(&$objMap, &$objConnector) { 
	$layerId = '10';
	$layerName = 'BUILDING';
	$layerFields = 'BLDG_NUM LAFB_NUM';
	
	$objEnvelope = new Envelope($objMap->__apiBufferedImageEnvelope->__apiMaxX,$objMap->__apiBufferedImageEnvelope->__apiMaxY,$objMap->__apiBufferedImageEnvelope->__apiMinX,$objMap->__apiBufferedImageEnvelope->__apiMinY);
	
	$showAll = true;
	if ($showAll) {
		$objQuery = new Query();
		$objQuery->SetSubFields($layerFields);
		$objQuery->SetWhere('');
	} else {
		$objSpatialFilter = new SpatialFilter();
		$objSpatialFilter->SetRelation('area_intersection');
		$objSpatialFilter->SetChildObject($objEnvelope);
		
		$objSpatialQuery = new SpatialQuery();
		$objSpatialQuery->SetSubFields($layerFields);
		$objSpatialQuery->SetSpatialFilter($objSpatialFilter);
	}
	
	$objLayer = new Layer();
	$objLayer->SetId($layerId);
	$objLayer->SetName($layerName);
	
	$objGetFeatures = new Get_Features();
	$objGetFeatures->SetOutputMode('newxml');
	$objGetFeatures->SetEnvelope(false);
	$objGetFeatures->SetGeometry(false);
	$objGetFeatures->SetLayer($objLayer);
	
	if ($showAll) {
		$objGetFeatures->SetChildObject($objQuery);
	} else {
		$objGetFeatures->SetChildObject($objSpatialQuery);
	}
	
	$objRequest = new Request($objGetFeatures);
	$strRequest = $objRequest->WriteXML();
	
	$objConnector->SendRequest($strRequest);
}
?>
