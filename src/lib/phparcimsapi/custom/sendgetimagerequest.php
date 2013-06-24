<?php
/// This function builds the ArcXML for the get_image request
function SendGetImageRequest(&$objMap, &$objConnector, &$objFlood) { 
	$objProperties = new Properties();
	
	if ($objMap->__apiImageBackground) {
		$objBackground = new Background($objMap->__apiImageBackground);
		$objProperties->SetBackgroundObject($objBackground);
	}
	if ($objMap->__apiImageEnvelope) {
		$objEnvelope = new Envelope($objMap->__apiImageEnvelope->__apiMaxX,$objMap->__apiImageEnvelope->__apiMaxY,$objMap->__apiImageEnvelope->__apiMinX,$objMap->__apiImageEnvelope->__apiMinY);
		$objProperties->SetEnvelopeObject($objEnvelope);
	}
	if ($objMap->__apiImageSize) {
		$objImageSize = new ImageSize($objMap->GetImageWidth(), $objMap->GetImageHeight());
		$objProperties->SetImageSizeObject($objImageSize);
	}
	
	/// for the flood tool
	$objProperties->SetCustom(WriteFloodXML(&$objFlood));
	
	$objAcetateLayer = GetAcetateLayer(&$objMap);
	
	$objGetImage = new Get_Image($objProperties);
	$objGetImage->Add($objAcetateLayer);
	
	$objRequest = new Request($objGetImage);
	$strRequest = $objRequest->WriteXML();
	
	$objConnector->SendRequest($strRequest);
}
?>
