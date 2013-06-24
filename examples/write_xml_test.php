<?php
/*
This example shows how the API writes out ArcXML by building the Map objects
*/

/// PHP error reporting.  Typically set equal to 'E_ALL' or 'E_ALL ~ E_NOTICE' during development
error_reporting('E_ALL ~ E_NOTICE');

/// Clears out any cache for PHP page
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/// Include the setup file which contains some needed variables
/// as well as the inclusion of PHP ArcIMS API
include('examples_setup.php');

/// Create the ImageSize object and set it's properties
$objImageSize = new ImageSize();
$objImageSize->setWidth(400);
$objImageSize->setHeight(400);

/// Create the Envelope object and set it's properties
$objEnvelope = new Envelope();
$objEnvelope->setMaxX(1111.11);
$objEnvelope->setMaxY(2222.22);
$objEnvelope->setMinX(3333.33);
$objEnvelope->setMinY(4444.44);

/// Create the Properties object and set it's properties
$objProperties = new Properties();
$objProperties->setEnvelopeObject($objEnvelope);
$objProperties->setImageSizeObject($objImageSize);

/// Create the Get_Image object and set it's properties
$objGet_Image = new Get_Image();
$objGet_Image->setPropertyObject($objProperties);

/// Create the Request object and set it's properties
$objRequest = new Request();
$objRequest->setTypeObject($objGet_Image);

/// Write out the ArcXML into the variable strXML
$strXML = $objRequest->writeXML();
?>
<html>
<head>
<title>Write XML Test</title>
</head>																	
<body>
<form>
<textarea cols="50" rows="20"><?php print($strXML); ?></textarea>
</form>
</body>
</html>


