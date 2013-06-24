<?php
/*
This example allows the user to click on the map to zoom in, zoom out and pan
*/

/// PHP error reporting.  Typically set equal to 'E_ALL' or 'E_ALL ~ E_NOTICE' during development
error_reporting('E_ALL ~ E_NOTICE');

/// Clears out any cache for PHP page
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/// Include the setup file which contains some needed variables
/// as well as the inclusion of PHP ArcIMS API
include('examples_setup.php');

/// Get all the URL param values if any have been passed
if (IsSet($_GET['mapaction']) && strlen($_GET['mapaction']) > 0) {
	$mapAction = strtoupper($_GET['mapaction']);
} else {
	$mapAction = 'ZOOMIN';
}
if (IsSet($_GET['fullextent']) && strlen($_GET['fullextent']) > 0) {
	$fullExtent = strtoupper($_GET['fullextent']);
} else {
	$fullExtent = '';
}
if (IsSet($_GET['click_x']) && strlen($_GET['click_x']) > 0) {
	$clickx = $_GET['click_x'];
} else {
	$clickx = '';
}
if (IsSet($_GET['click_y']) && strlen($_GET['click_y']) > 0) {
	$clicky = $_GET['click_y'];
} else {
	$clicky = '';
}
if (IsSet($_GET['minx']) && strlen($_GET['minx']) > 0) {
	$minX = $_GET['minx'];
} else {
	$minX = '';
}
if (IsSet($_GET['maxx']) && strlen($_GET['maxx']) > 0) {
	$maxX = $_GET['maxx'];
} else {
	$maxX = '';
}
if (IsSet($_GET['miny']) && strlen($_GET['miny']) > 0) {
	$minY = $_GET['miny'];
} else {
	$minY = '';
}
if (IsSet($_GET['maxy']) && strlen($_GET['maxy']) > 0) {
	$maxY = $_GET['maxy'];
} else {
	$maxY = '';
}

/// Create the Map object and set some properties
$objMap = new Map();
$objMap->SetImageSize(400, 400);
$objMap->SetImageBackground('192,192,192');
$objMap->__apiMaxImageEnvelope = new Envelope($initialExtentMaxX, $initialExtentMaxY, $initialExtentMinX, $initialExtentMinY);

/// Set the Map's extent envelope ... if no value is passed via URL string then use default
/// Create a new Envelope object to contain the extents new Envelope(maxx,maxy,minx,miny)
if (strlen($minX) > 0 && strlen($maxX) > 0 && strlen($minY) > 0 && strlen($maxY) > 0) {
    $objMap->__apiImageEnvelope = new Envelope($maxX, $maxY, $minX, $minY);
} else {
    $objMap->__apiImageEnvelope = $objMap->__apiMaxImageEnvelope;
}

/// Create the Connector object and set some properties
/// The connector object sends and receives the ArcXML 
$objConnector = new Connector('localhost');
$objConnector->__apiServiceName = $serviceName;
$objConnector->__apiMap = &$objMap;

/// Respond to the user's action on the map ... zoom
if (strlen($fullExtent) == 0) {
    if (strlen($mapAction) > 0) {
        if (strlen($clickx) > 0 && strlen($clicky) > 0) {
            $objPoint = $objMap->ToMapPoint($clickx, $clicky);
            $objMap->CenterAt($objPoint->__apiX, $objPoint->__apiY);
            if ($mapAction == 'PAN') {
                $objMap->Pan();
            } else if ($mapAction == 'ZOOMIN') {
                /// Zoom In 2X
                $objMap->ZoomIn(2);
            } else if ($mapAction == 'ZOOMOUT') {
                /// Zoom Out 2X
                $objMap->ZoomOut(2);
            }
            /// Make sure that a zoom or pan does not go past the MaxImageEnvelope
            $objMap->CheckMapEnvelope();
        }
    }
} else {
    $objMap->ZoomFullExtent();
}

/// Call the custom function below which creates the GET_IMAGE request in ArcXML
GetImageRequest(&$objMap, &$objConnector);
?>

<!-- Start the HTML form -->
<form name="mapform" action="<?php print($_SERVER['PHP_SELF']); ?>" method="get">

<!-- Keep track of the map's extents using hidden HTML tags ... could also keep track of extents in a session -->
<input type="hidden" name="minx" value="<?php print($objMap->__apiImageEnvelope->__apiMinX); ?>">
<input type="hidden" name="maxx" value="<?php print($objMap->__apiImageEnvelope->__apiMaxX); ?>">
<input type="hidden" name="miny" value="<?php print($objMap->__apiImageEnvelope->__apiMinY); ?>">
<input type="hidden" name="maxy" value="<?php print($objMap->__apiImageEnvelope->__apiMaxY); ?>">

<!-- Print out the image that has been set to the __apiImageURL Map property through the ArcXML response -->
<input type="image" name="click" src="<?php print($objMap->__apiImageURL); ?>" border="0">

<!-- Zoom the map to full extent -->
<p>
<input type="hidden" name="fullextent" value="">
<input type="button" name="FullExtentButton" value="Full Extent" onclick="this.form.fullextent.value='1';this.form.submit();">

<!-- Give the user the choice of Zoom In, Zoom Out or Pan -->
<input type="radio" name="mapaction" value="zoomin" <?php strtoupper($mapAction) == 'ZOOMIN' ? print('checked') : print(''); ?>> Zoom In 
<input type="radio" name="mapaction" value="zoomout" <?php strtoupper($mapAction) == 'ZOOMOUT' ? print('checked') : print(''); ?>> Zoom Out 
<input type="radio" name="mapaction" value="pan" <?php strtoupper($mapAction) == 'PAN' ? print('checked') : print(''); ?>> Pan

<!-- Show the Request and Response -->
<p>Request:<br>
<textarea cols="40" rows="7"><?php print(str_replace('xml version="1.0" encoding="UTF-8"','',$objConnector->__apiXMLRequest)); ?></textarea>
<p>Response:<br>
<textarea cols="40" rows="7"><?php print(str_replace('xml version="1.0" encoding="UTF-8"','',$objConnector->__apiXMLResponse)); ?></textarea>

<!-- End the HTML Form -->
</form>

<?php
/// This function builds the ArcXML for the get_image request
function GetImageRequest(&$objMap, &$objConnector) { 
    $objProperties = new Properties();
    
    if ($objMap->__apiImageBackground) {
            $objProperties->SetBackgroundObject(new Background($objMap->__apiImageBackground));
    }
    if ($objMap->__apiImageEnvelope) {
            $objProperties->SetEnvelopeObject($objMap->__apiImageEnvelope);
    }
    if ($objMap->__apiImageSize) {
            $objProperties->SetImageSizeObject(new ImageSize($objMap->GetImageWidth(), $objMap->GetImageHeight()));
    }
    
    $objGetImage = new Get_Image($objProperties);
    
    $objRequest = new Request($objGetImage);
    $strRequest = $objRequest->WriteXML();
    
    $objConnector->SendRequest($strRequest);
}
?>
