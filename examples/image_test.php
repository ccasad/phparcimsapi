<?php
/*
This examples shows a basic Get_Image request which retrieves the image from the
map service
*/

/// PHP error reporting.  Typically set equal to 'E_ALL' or 'E_ALL ~ E_NOTICE' during development
error_reporting('E_ALL ~ E_NOTICE');

/// Clears out any cache for PHP page
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/// Include the setup file which contains some needed variables
/// as well as the inclusion of PHP ArcIMS API
include('examples_setup.php');

/// Create the Map object and set some properties
$objMap = new Map();
$objMap->SetImageSize(400, 400);
$objMap->SetImageBackground('192,192,192');  // gray
$objMap->__apiImageEnvelope = new Envelope($initialExtentMaxX, $initialExtentMaxY, $initialExtentMinX, $initialExtentMinY);

/// Create the Connector object and set some properties
/// The connector object sends and receives the ArcXML 
$objConnector = new Connector('localhost');
$objConnector->__apiServiceName = $serviceName;
$objConnector->__apiMap = &$objMap;

/// Call the custom function below which creates the GET_IMAGE request in ArcXML
/// This function will send the request and the response will end up putting the
/// resulting image path into $objMap->__apiImageURL
GetImageRequest(&$objMap, &$objConnector);
?>

<!-- Start the HTML form -->
<form name="mapform" action="<?php print($_SERVER['PHP_SELF']); ?>" method="get">

<!-- Print out the image that has been set to the __apiImageURL Map property through the ArcXML response -->
<input type="image" name="click" src="<?php print($objMap->__apiImageURL); ?>" border="0">

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
