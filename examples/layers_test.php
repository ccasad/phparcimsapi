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

/// Get all the URL param values if any have been passed
if (IsSet($_GET['roads']) && strlen($_GET['roads']) > 0) {
    $roadsLayer = $_GET['roads'];
} else {
    $roadsLayer = false;
}
if (IsSet($_GET['buildings']) && strlen($_GET['buildings']) > 0) {
    $buildingsLayer = $_GET['buildings'];
} else {
    $buildingsLayer = false;
}
if (IsSet($_GET['selectedbuilding']) && strlen($_GET['selectedbuilding']) > 0) {
    $selectedBuildingLayer = $_GET['selectedbuilding'];
} else {
    $selectedBuildingLayer = false;
}

/// Create the Map object and set some properties
$objMap = new Map();
$objMap->SetImageSize(400, 400);
$objMap->SetImageBackground('192,192,192');
$objMap->__apiImageEnvelope = new Envelope($zoomedInExtentMaxX, $zoomedInExtentMaxY, $zoomedInExtentMinX, $zoomedInExtentMinY);

/// Create the Connector object and set some properties
/// The connector object sends and receives the ArcXML 
$objConnector = new Connector('localhost');
$objConnector->__apiServiceName = $serviceName;
$objConnector->__apiMap = &$objMap;

/// Call the custom function below which creates the GET_IMAGE request in ArcXML
/// This function will send the request and the response will end up putting the
/// resulting image path into $objMap->__apiImageURL
GetImageRequest(&$objMap, &$objConnector, $roadsLayer, $buildingsLayer, $selectedBuildingLayer);
?>

<!-- Start the HTML form -->
<form name="mapform" action="<?php print($_SERVER['PHP_SELF']); ?>" method="get">

<!-- Print out the image that has been set to the __apiImageURL Map property through the ArcXML response -->
<input type="image" name="click" src="<?php print($objMap->__apiImageURL); ?>" border="0">

<!-- Allow the user to turn on/off the layers -->
<p>Layers:<br>
<input type="checkbox" name="roads" value="true" <?php $roadsLayer ? print('checked') : print(''); ?>> Roads<br>
<input type="checkbox" name="buildings" value="true" <?php $buildingsLayer ? print('checked') : print(''); ?>> Buildings<br>
<input type="checkbox" name="selectedbuilding" value="true" <?php $selectedBuildingLayer ? print('checked') : print(''); ?>> Selected Building (Dynamic Layer)<br>

<!-- A button to refresh the map -->
<p>
<input type="submit" value="Refresh Map">

<!-- Show the Request and Response -->
<p>Request:<br>
<textarea cols="40" rows="7"><?php print(str_replace('xml version="1.0" encoding="UTF-8"','',$objConnector->__apiXMLRequest)); ?></textarea>
<p>Response:<br>
<textarea cols="40" rows="7"><?php print(str_replace('xml version="1.0" encoding="UTF-8"','',$objConnector->__apiXMLResponse)); ?></textarea>

<!-- End the HTML Form -->
</form>

<?php
/// This function builds the ArcXML for the get_image request
function GetImageRequest(&$objMap, &$objConnector, $roadsLayerVisible, $buildingsLayerVisible, $selectedBuildingLayerVisible) { 
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

    $layerDef0 = new LayerDef('0'); // Roads
    $layerDef0->SetVisible($roadsLayerVisible);
    
    $layerDef1 = new LayerDef('1'); // Buildings
    $layerDef1->SetVisible($buildingsLayerVisible);
    
    $layerList = new LayerList();
    $layerList->Add($layerDef0);
    $layerList->Add($layerDef1);
    
    $objProperties->SetLayerListObject($layerList);

    $objGetImage = new Get_Image($objProperties);

    if ($selectedBuildingLayerVisible) {
        $selectedBldgLayer = GetSelectedBldgLayer();
        if ($selectedBldgLayer) {
            $objGetImage->Add($selectedBldgLayer);
        }
    }
    
    $objRequest = new Request($objGetImage);
    $strRequest = $objRequest->WriteXML();
    
    $objConnector->SendRequest($strRequest);
}
/// This function builds the ArcXML that creates a dynamic layer
function GetSelectedBldgLayer() {
    global $__apiConstants;

    $simplePolygonSymbol = new SimplePolygonSymbol();
    $simplePolygonSymbol->SetAntiAliasing(true);

    $simplePolygonSymbol->SetBoundaryColor($__apiConstants->__apiCRed);
    $simplePolygonSymbol->SetFillColor($__apiConstants->__apiCYellow);

    $simplePolygonSymbol->SetOverlap(true);

    $simpleRenderer = new SimpleRenderer($simplePolygonSymbol);

    $objSpatialQuery = new SpatialQuery();
    $objSpatialQuery->SetWhere('BLDG_NUM = &apos;1219&apos;');

    $objDataSet = new DataSet();
    $objDataSet->SetFromLayer('1');

    $objLayer = new Layer();
    $objLayer->SetParentElement('GET_IMAGE');
    $objLayer->SetId('999');
    $objLayer->SetName('Selected Building');
    $objLayer->SetType($__apiConstants->__apiCFeatureClass);
    $objLayer->SetDataset($objDataSet);
    $objLayer->SetSpatialQuery($objSpatialQuery);
    $objLayer->SetRenderer($simpleRenderer);
    
    return $objLayer;
}
?>
