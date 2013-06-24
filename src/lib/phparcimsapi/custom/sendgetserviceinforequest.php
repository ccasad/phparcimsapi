<?php
/// This function builds the ArcXML for the service_info request
function SendGetServiceInfoRequest(&$objConnector) {
	$numargs = func_num_args();
	$dpi = $numargs > 0 ? func_get_arg(0) : '';
	$envelope = $numargs > 1 ? func_get_arg(1) : '';
	$extensions = $numargs > 2 ? func_get_arg(2) : '';
	$fields = $numargs > 3 ? func_get_arg(3) : '';
	$renderer = $numargs > 4 ? func_get_arg(4) : '';
	
	$objGetServiceInfo = new Get_Service_Info();
	$objGetServiceInfo->SetDPI($dpi);
	$objGetServiceInfo->SetEnvelope($envelope);
	$objGetServiceInfo->SetExtensions($extensions);
	$objGetServiceInfo->SetFields($fields);
	$objGetServiceInfo->SetRenderer($renderer);
	
	$objRequest = new Request($objGetServiceInfo);
	$strRequest = $objRequest->WriteXML();
	
	$objConnector->SendRequest($strRequest);
}
?>
