<?php
/*
This example allows the user to click anywhere in the image and receive building
attributes if a building is clicked on.
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

/// Create the Map object and set some properties
$objMap = new Map();
$objMap->SetImageSize(400, 400);
$objMap->SetImageBackground('192,192,192');

/// Set the Map's extent envelope
$objMap->__apiImageEnvelope = new Envelope($zoomedInExtentMaxX, $zoomedInExtentMaxY, $zoomedInExtentMinX, $zoomedInExtentMinY);

/// Create the Connector object and set some properties
/// The connector object sends and receives the ArcXML 
$objConnector = new Connector('localhost');
$objConnector->__apiServiceName = $serviceName;
$objConnector->__apiMap = &$objMap;

if (strlen($clickx) > 0 && strlen($clicky) > 0) {
    /// Call the custom function below which creates the GET_FEATURES request in ArcXML
    GetFeatureRequest(&$objMap, &$objConnector, $clickx, $clicky);
    
    /// Capture the Feature request and response so we can see it below in the form textareas
    $featureRequest = $objConnector->__apiXMLRequest;
    $featureResponse = $objConnector->__apiXMLResponse;
    
    /// Call the custom function below which retrieves the GET_FEATURES response
    /// and print out the selected feature's attributes
    $features = GetFeatureResponse(&$objConnector);
    print('<h3 style="text-decoration:underline">Features found:</h3>');
    if (is_array($features)) {
        if (count($features) > 0) {
            for ($i = 0;$i < count($features);$i++) {
                print($features[$i] . '<br>');
            }
        }
    } else {
        print('No features found');
    }
}

/// Call the custom function below which creates the GET_IMAGE request in ArcXML
GetImageRequest(&$objMap, &$objConnector);
?>

<!-- Start the HTML form -->
<form name="mapform" action="<?php print($_SERVER['PHP_SELF']); ?>" method="get">

<!-- Print out the image that has been set to the __apiImageURL Map property through the ArcXML response -->
<input type="image" name="click" src="<?php print($objMap->__apiImageURL); ?>" border="0">

<!-- Show the Request and Response -->
<p>Request:<br>
<textarea cols="40" rows="7"><?php print(str_replace('xml version="1.0" encoding="UTF-8"','',$featureRequest)); ?></textarea>
<p>Response:<br>
<textarea cols="40" rows="7"><?php print(str_replace('xml version="1.0" encoding="UTF-8"','',$featureResponse)); ?></textarea>
<p>

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
/// This function builds the ArcXML for the get_image request
function GetFeatureRequest(&$objMap, &$objConnector, $clickx, $clicky) {
    $objPoint = $objMap->ToMapPoint($clickx, $clicky);
    
    $mapX = $objPoint->__apiX;
    $mapY = $objPoint->__apiY;

    $pixelTolerance = 2;
    $searchTolerance = ($objMap->GetImageWidth()/$objMap->GetMapWidth()) * $pixelTolerance;
    
    $maxX = $mapX - $searchTolerance;
    $maxY = $mapY + $searchTolerance;
    $minX = $mapX + $searchTolerance;
    $minY = $mapY - $searchTolerance;
    
    $objEnvelope = new Envelope($maxX, $maxY, $minX, $minY);

    $objSpatialFilter = new SpatialFilter();
    $objSpatialFilter->SetRelation('area_intersection');
    $objSpatialFilter->SetChildObject($objEnvelope);
    
    $objSpatialQuery = new SpatialQuery();
    $objSpatialQuery->SetSubFields('#ALL#');
    $objSpatialQuery->SetSpatialFilter($objSpatialFilter);
    
    $objLayer = new Layer();
    $objLayer->SetId('1');
    
    $objGetFeatures = new Get_Features();
    $objGetFeatures->SetOutputMode('newxml');
    $objGetFeatures->SetEnvelope(false);
    $objGetFeatures->SetGlobalEnvelope(false);
    $objGetFeatures->SetGeometry(false);
    $objGetFeatures->SetLayer($objLayer);
    $objGetFeatures->SetChildObject($objSpatialQuery);

    $objRequest = new Request($objGetFeatures);
    $strRequest = $objRequest->WriteXML();

    $objConnector->SendRequest($strRequest);
}
/// This function gets the resulting recordset from the get_features response
function GetFeatureResponse(&$objConnector) {
    $objRec = &$objConnector->__apiRecordset;
    if ($objRec->__apiRecordCount > 0) {
            $objRec->MoveFirst();
            for ($i = 0;$i < $objRec->__apiRecordCount;$i++) {
                for ($j = 0;$j < $objRec->__apiFieldCount;$j++) {
                    $field = $objRec->__apiFields[$j];
                    $featureArr[$j] = '<strong>' . $field . '</strong>=' . $objRec->__apiRecords[$i][$field];
                }
            }
            return $featureArr;
    } else {
            return 0;
    }
}
?>
