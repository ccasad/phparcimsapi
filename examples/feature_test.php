<?php
/*
This example shows how to extract attributes from a query which in this case
is: Where => Bldg_num = '1209T8'
*/

/// PHP error reporting.  Typically set equal to 'E_ALL' or 'E_ALL ~ E_NOTICE' during development
error_reporting('E_ALL ~ E_NOTICE');

/// Clears out any cache for PHP page
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/// Include the setup file which contains some needed variables
/// as well as the inclusion of PHP ArcIMS API
include('examples_setup.php');

/// Create the Connector object and set some properties
/// The connector object sends and receives the ArcXML 
$objConnector = new Connector('localhost');
$objConnector->__apiServiceName = $serviceName;

$value = '1209T8';

/// Call the custom function below which creates the GET_FEATURES request in ArcXML
GetFeatureRequest(&$objConnector, $value);

/// Call the custom function below which retrieves the GET_FEATURES response
$features = GetFeatureResponse(&$objConnector);
if (is_array($features)) {
    if (count($features) > 0) {
        print('<h3 style="text-decoration:underline">Features found for ' . $value . '</h3>');
        for ($i = 0;$i < count($features);$i++) {
            print($features[$i] . '<br>');
        }
    }
} else {
    print('No features found for ' . $value);
}
?>

<!-- Start the HTML form -->
<form name="mapform" action="<?php print($_SERVER['PHP_SELF']); ?>" method="get">

<!-- Show the Request and Response -->
<p>Request:<br>
<textarea cols="40" rows="7"><?php print(str_replace('xml version="1.0" encoding="UTF-8"','',$objConnector->__apiXMLRequest)); ?></textarea>
<p>Response:<br>
<textarea cols="40" rows="7"><?php print(str_replace('xml version="1.0" encoding="UTF-8"','',$objConnector->__apiXMLResponse)); ?></textarea>

<!-- End the HTML Form -->
</form>

<?php
/// CUSTOM FUNCTIONS

/// This function builds the ArcXML for the get_features request
function GetFeatureRequest(&$objConnector, $value) {
    $objSpatialQuery = new SpatialQuery();
    $objSpatialQuery->SetSubFields('#ALL#');
    $objSpatialQuery->SetWhere('Bldg_num = &apos;' . $value . '&apos;');
    
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
