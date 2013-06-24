<?php
function GetAcetateLayer(&$objMap) {
	global $__apiConstants;
	
	/// Acetate Layer
	$acetateLayer = new Layer();
	$acetateLayer->SetType($__apiConstants->__apiCAcetate);
	$acetateLayer->SetParentElement('MAP');
	$acetateLayer->SetName('Acetate');
	
	/// Bottom Box
	$simplePolygonSymbol = new SimplePolygonSymbol();
	$simplePolygonSymbol->SetAntiAliasing(true);
	$simplePolygonSymbol->SetBoundaryColor($__apiConstants->__apiCGray);
	$simplePolygonSymbol->SetFillColor($__apiConstants->__apiCLightGray);
	$simplePolygonSymbol->SetFillTransparency(0.5);
	$simplePolygonSymbol->SetOverlap(false);
	
	$bottomPolygon = new Polygon();
	$bottomPolygon->SetCoords('-1 -1;-1 20;' . ($objMap->GetImageWidth() + 1) . ' 20;' . ($objMap->GetImageWidth() + 1) . ' -1;-1 -1');
	$bottomPolygon->SetSymbol($simplePolygonSymbol);
	$bottomPolygon->SetParentElement("OBJECT");
	
	$acetateObject1 = new XObject($__apiConstants->__apiCPixel);
	$acetateObject1->SetChild($bottomPolygon);
	$acetateLayer->Add($acetateObject1);
	
	/// North Arrow
	$northArrow = new NorthArrow();
	$northArrow->SetAntiAliasing(true);
	$northArrow->SetCoords("20 25");
	$northArrow->SetOverlap(false);
	$northArrow->SetType(3);
	$northArrow->SetSize(25);
	$northArrow->SetTransparency(0.75);
	
	$acetateObject2 = new XObject($__apiConstants->__apiCPixel);
	$acetateObject2->SetChild($northArrow);
	$acetateLayer->Add($acetateObject2);
	
	/// Copyright Info
	$copyright = new Copyright();
	$copyright->SetCoords('40 5');
	$copyright->SetLabel('NASA LaRC GIS Team');
	$copyright->SetAntiAliasing(true);
	$copyright->SetOverlap(false);
	
	$acetateObject3 = new XObject($__apiConstants->__apiCPixel);
	$acetateObject3->SetChild($copyright);
	$acetateLayer->Add($acetateObject3);
	
	/// Scalebar
	$scaleBar = new Scalebar();
	$scaleBar->SetAntiAliasing(true);
	$scaleBar->SetCoords(($objMap->GetImageWidth() * (6.4/10)) . ' 5');
	$scaleBar->SetMapUnits($__apiConstants->__apiCMeters);
	$scaleBar->SetScaleUnits($__apiConstants->__apiCMeters);
	$scaleBar->SetPrecision(2);
	$scaleBar->SetBarColor($__apiConstants->__apiCWhite);
	$scaleBar->SetScreenLength($objMap->GetImageWidth() * (2/10));
	$scaleBar->SetBarWidth(7);
	$scaleBar->SetOverlap(false);
	
	$acetateObject4 = new XObject($__apiConstants->__apiCPixel);
	$acetateObject4->SetChild($scaleBar);
	$acetateLayer->Add($acetateObject4);
	
	if ($objMap->__apiAddedDisplay == 'OVERVIEWMAP') {
		/// Acetate Overview Map
	
	} else if ($objMap->__apiAddedDisplay == 'LEGEND') {
		/// Acetate Legend
		$objLegend = new AcetateLegend();
		$objLegend->SetMap(&$objMap);
		$objLegend->SetSize(103,172);
		$objLegend->SetBoundaryColor($__apiConstants->__apiCGray);
		$objLegend->SetTransparency(1);
		$objLegend->SetImage('D:/My Documents/Web/ArcIMS/Website/floodtool/images/legend.gif');
		$objLegend->SetUrl('/website/floodtool/images/legend.gif');
		$objLegend->SetUnits($__apiConstants->__apiCPixel);
		
		$acetateLayer->Add($objLegend);
	}
	
	return $acetateLayer;
}
?>
