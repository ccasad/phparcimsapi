<?php
$serviceName = 'test6';

/// This is the initial extent for some of the examples which is the
/// full extent of your map
$initialExtentMaxX = 3692209.7207;
$initialExtentMaxY = 1087874.2335;
$initialExtentMinX = 3687172.1185;
$initialExtentMinY = 1082707.873;

/// This is used in the Identify (and PDF and layers) example ... it is the extents zoomed into
/// an area that makes it easy to click on the desired feature to identify
$zoomedInExtentMaxX = 3688552.5054461;
$zoomedInExtentMaxY = 1086385.67588095;
$zoomedInExtentMinX = 3688229.6079148;
$zoomedInExtentMinY = 1086062.77834965;

/// ----- Include the PHP ArcIMS API -----
///
/// Set the path to where the main PHP API file is located.
/// Should be able to set it to a virtual directory but php.ini file
/// may be prohibiting it
include('../src/phparcimsapi.php');

/// Set the path to where the library of include files are located.
/// Should be able to set it to a virtual directory but php.ini file
/// may be prohibiting it
$phpArcIMSAPI->SetLibraryPath('../src/lib/');

/// You are able to use a * in the SetInclude to include all files in the
/// directory but you may want to explicity write out each file we want
/// just in case in files get added to the API that you really don't want for
/// this application (ie $phpArcIMSAPI->SetInclude('phparcimsapi.map.spatialquery.php'); )
$phpArcIMSAPI->SetInclude('phparcimsapi.acetate.*');
$phpArcIMSAPI->SetInclude('phparcimsapi.api.*');
$phpArcIMSAPI->SetInclude('phparcimsapi.custom.*');
$phpArcIMSAPI->SetInclude('phparcimsapi.map.*');
$phpArcIMSAPI->SetInclude('phparcimsapi.object.*');
$phpArcIMSAPI->SetInclude('phparcimsapi.renderer.*');
$phpArcIMSAPI->SetInclude('phparcimsapi.symbol.*');

/// Initialize the constant class so we can use the constant like a global
$__apiConstants = new Constants();
?>