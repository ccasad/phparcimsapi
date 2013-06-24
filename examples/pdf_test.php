<?php
/*
This example allows allows the user to export a PDF of the current map.
NOTE: Need to make sure the mapservice allows for very large image output because
the PDF images need to be large which means that it may take up to a minute or
more to generate the pdf
*/

/// PHP error reporting.  Typically set equal to 'E_ALL' or 'E_ALL ~ E_NOTICE' during development
error_reporting('E_ALL ~ E_NOTICE');

/// Clears out any cache for PHP page
header ('Cache-Control: no-cache, must-revalidate');
header ('Pragma: no-cache');

/// Include the setup file which contains some needed variables
/// as well as the inclusion of PHP ArcIMS API
include('examples_setup.php');

/// Get the URL param values if any have been passed
if (IsSet($_GET['getpdf']) && strlen($_GET['getpdf']) > 0) {
	$getPDF = $_GET['getpdf'];
} else {
	$getPDF = '';
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

/// Call the custom function below which creates the GET_IMAGE request in ArcXML
GetImageRequest(&$objMap, &$objConnector);

if (strlen($getPDF) > 0) {
    /// store the current map's width and height 
    $tempWidth = $objMap->__apiImageSize['width'];
    $tempHeight = $objMap->__apiImageSize['height'];

    /// create the PDFMap object and set the PageSize and PageOrientation
    $pdfMap = new PDFMap();
    $pageType = 2;  // 2=ledger (17x11)
    $pageOrientation = 1;  // 1=landscape
    $pdfMap->SetPageSize($pageType);
    $pdfMap->SetPageOrientation($pageOrientation);
    
    /// Set the printing Width and Heights by calling the PDFMap methods
    $printingWidth = $pdfMap->GetPrintingWidth();
    $printingHeight = $pdfMap->GetPrintingHeight();
    
    /// Destroy the PDFMap object
    unset($pdfMap);
    
    /// Set the map width and height to the new calulated printing width and height
    $objMap->SetImageSize($printingWidth, $printingHeight);
    
    /// Make the Get_Image request with the new image size and set it to a variable
    GetImageRequest(&$objMap, &$objConnector);
    $printPdfMapURL = $objMap->__apiImageURL;
    
    /// Set the map's width and height back to the original values
    $objMap->SetImageSize($tempWidth, $tempHeight);
    
    /// Set a title for the PDF Map
    $title = 'PDF Map Test';
    
    /// Send the image to Trident (windows server) to process and create the PDF file
    /// Need to do this right now cause we don't have the PHP PDF library installed
    /// on the Solaris server yet
    if (strlen($printPdfMapURL) > 0) {
            /// Redirects the current HTML page to the Windows server
            header('Location: http://trident.larc.nasa.gov/pdf/createpdf_generic.php?mapimage=' . $printPdfMapURL . '&title=' . urlencode($title) . '&pagetype=' . urlencode($pageType) . '&orientation=' . $pageOrientation);
            exit;
    } else {
            print('Error generating map image for PDF');
    }
}
?>

<!-- Start the HTML form -->
<form name="mapform" action="<?php print($_SERVER['PHP_SELF']); ?>" method="get">

<!-- Print out the image that has been set to the __apiImageURL Map property through the ArcXML response -->
<input type="image" name="click" src="<?php print($objMap->__apiImageURL); ?>" border="0">

<!-- Button to generate the PDF of the current map -->
<p>
<input type="hidden" name="getpdf" value="">
<input type="button" name="pdfbutton" value="Generate PDF" onclick="this.form.getpdf.value='1';this.form.submit();">

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
?>
