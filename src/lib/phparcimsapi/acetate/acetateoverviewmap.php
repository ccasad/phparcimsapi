<?php
class AcetateOverviewMap {
	//***************************************************************
	// Set property defaults
	//***************************************************************
	var $__apiVisible = '';
	var $__apiSize = '';
	var $__apiWidth = '';
	var $__apiHeight = '';
	var $__apiMap = '';
	var $__apiImage = '';
	var $__apiUrl = '';
	var $__apiUnits = '';
	var $__apiBoundaryColor = '';
	var $__apiTransparency = '';
	var $__apiExtentBoxColor = '';
	
	//***************************************************************
	// Constructor
	//***************************************************************
	function AcetateOverviewMap() {
		$this->__apiExtentBoxColor = '255,0,0';
	}
	
	//***************************************************************
	// Public Methods
	//***************************************************************
	function SetVisible($__apiParam) { $this->__apiVisible = $__apiParam; }
	function SetSize($__apiWidthParam, $__apiHeightParam) {
		$this->__apiSize['width'] = $__apiWidthParam;
		$this->__apiSize['height'] = $__apiHeightParam;
	}
	function SetWidth($__apiParam) { $this->__apiSize['width'] = $__apiParam; }
	function SetHeight($__apiParam) { $this->__apiSize['height'] = $__apiParam; }
	function SetMap($__apiParam) { $this->__apiMap = $__apiParam; }
	function SetImage($__apiParam) { $this->__apiImage = $__apiParam; }
	function SetUrl($__apiParam) { $this->__apiUrl = $__apiParam; }
	function SetUnits($__apiParam) { $this->__apiUnits = $__apiParam; }
	function SetBoundaryColor($__apiParam) { $this->__apiBoundaryColor = $__apiParam; }
	function SetTransparency($__apiParam) { $this->__apiTransparency = $__apiParam; }
	function SetExtentBoxColor($__apiParam) { $this->__apiExtentBoxColor = $__apiParam; }
	
	function GetWidth() { return $this->__apiSize['width']; }
	function GetHeight() { return $this->__apiSize['height']; }
	
	function GetExtentCoords(&$__apiMapParam) {		
		$__apiXRatio = $this->GetWidth() / $__apiMapParam->GetMaxMapWidth();
		$__apiYRatio = $this->GetHeight() / $__apiMapParam->GetMaxMapHeight();
		
		$__apiMinX = $__apiMapParam->GetMaxMapWidth() - ($__apiMapParam->GetMapMinX() - $__apiMapParam->__apiMaxImageEnvelope->__apiMinX);
		$__apiMaxX = $__apiMapParam->GetMaxMapWidth() - ($__apiMapParam->GetMapMaxX() - $__apiMapParam->__apiMaxImageEnvelope->__apiMinX);
		$__apiMaxY = $__apiMapParam->GetMaxMapHeight() - ($__apiMapParam->__apiMaxImageEnvelope->__apiMaxY - $__apiMapParam->GetMapMaxY());
		$__apiMinY = $__apiMapParam->GetMaxMapHeight() - ($__apiMapParam->__apiMaxImageEnvelope->__apiMaxY - $__apiMapParam->GetMapMinY());

		$__apiVMinX = -(($__apiXRatio * $__apiMinX) - $this->GetWidth());
		$__apiVMaxX = -(($__apiXRatio * $__apiMaxX) - $this->GetWidth());
		$__apiVMaxY = -(($__apiYRatio * $__apiMaxY) - $this->GetHeight());
		$__apiVMinY = -(($__apiYRatio * $__apiMinY) - $this->GetHeight());
		
		$__apiCoords = (str_replace(',', '', strval(number_format(($__apiMapParam->GetImageWidth()-$this->GetWidth()+$__apiVMinX), 2))) . ' ' . 
		str_replace(',', '', strval(number_format(($__apiMapParam->GetImageHeight()-$__apiVMaxY), 2))) . ';' . 
		str_replace(',', '', strval(number_format(($__apiMapParam->GetImageWidth()-$this->GetWidth()+$__apiVMaxX), 2))) . ' ' . 
		str_replace(',', '', strval(number_format(($__apiMapParam->GetImageHeight()-$__apiVMaxY), 2))) . ';' . 
		str_replace(',', '', strval(number_format(($__apiMapParam->GetImageWidth()-$this->GetWidth()+$__apiVMaxX), 2))) . ' ' . 
		str_replace(',', '', strval(number_format(($__apiMapParam->GetImageHeight()-$__apiVMinY), 2))) . ';' . 
		str_replace(',', '', strval(number_format(($__apiMapParam->GetImageWidth()-$this->GetWidth()+$__apiVMinX), 2))) . ' ' . 
		str_replace(',', '', strval(number_format(($__apiMapParam->GetImageHeight()-$__apiVMinY), 2))) . ';' . 
		str_replace(',', '', strval(number_format(($__apiMapParam->GetImageWidth()-$this->GetWidth()+$__apiVMinX), 2))) . ' ' . 
		str_replace(',', '', strval(number_format(($__apiMapParam->GetImageHeight()-$__apiVMaxY), 2))));
		
		/*
		$__apiCoords = (number_format(($__apiMapParam->GetImageWidth()-$this->GetWidth()+$__apiVMinX), 2) . ' ' . 
		number_format(($__apiMapParam->GetImageHeight()-$__apiVMaxY), 2) . ';' . 
		number_format(($__apiMapParam->GetImageWidth()-$this->GetWidth()+$__apiVMaxX), 2) . ' ' . 
		number_format(($__apiMapParam->GetImageHeight()-$__apiVMaxY), 2) . ';' . 
		number_format(($__apiMapParam->GetImageWidth()-$this->GetWidth()+$__apiVMaxX), 2) . ' ' . 
		number_format(($__apiMapParam->GetImageHeight()-$__apiVMinY), 2) . ';' . 
		number_format(($__apiMapParam->GetImageWidth()-$this->GetWidth()+$__apiVMinX), 2) . ' ' . 
		number_format(($__apiMapParam->GetImageHeight()-$__apiVMinY), 2) . ';' . 
		number_format(($__apiMapParam->GetImageWidth()-$this->GetWidth()+$__apiVMinX), 2) . ' ' . 
		number_format(($__apiMapParam->GetImageHeight()-$__apiVMaxY), 2));
		*/
		
		return $__apiCoords;
	}
	
	function WriteXML() {
		$__apiXML = '';
		
		$acetateObject = new XObject();
		$acetateObject->SetUnits($this->__apiUnits);

		/// OVERVIEW MAP IMAGE
		$rasterMarkerSymbol = new RasterMarkerSymbol();
		$rasterMarkerSymbol->SetAntiAliasing(false);
		$rasterMarkerSymbol->SetOverlap(true);
		$rasterMarkerSymbol->SetSize($this->__apiSize);
		$rasterMarkerSymbol->SetImage($this->__apiImage); 
		$rasterMarkerSymbol->SetUrl($this->__apiUrl);
		$rasterMarkerSymbol->SetTransparency($this->__apiTransparency);
		
		$pointObj = new Point();
		$pointObj->SetCoords(($this->__apiMap->GetImageWidth()-$this->GetWidth() / 2) . ' ' . ($this->__apiMap->GetImageHeight()-$this->GetHeight() / 2));
		$pointObj->SetMarkerSymbol($rasterMarkerSymbol);
		$pointObj->SetParentElement('OBJECT');
		
		$acetateObject->SetChild($pointObj);

		$__apiXML .= $acetateObject->WriteXML();
	
		/// OVERVIEW MAP BORDER 
		$simplePolygonSymbol = new SimplePolygonSymbol();
		$simplePolygonSymbol->SetAntiAliasing(true);
		$simplePolygonSymbol->SetBoundaryColor($this->__apiBoundaryColor);
		$simplePolygonSymbol->SetFillColor('255,255,255');
		$simplePolygonSymbol->SetFillTransparency('0');
		$simplePolygonSymbol->SetOverlap(false);
	
		$overviewMapBorder = new Polygon();
		$overviewMapBorder->SetCoords(($this->__apiMap->GetImageWidth()-$this->GetWidth()) . ' ' . ($this->__apiMap->GetImageHeight()+2) . ';' . ($this->__apiMap->GetImageWidth()+1) . ' ' . ($this->__apiMap->GetImageHeight()+2) . ';' . ($this->__apiMap->GetImageWidth()+1) . ' ' . ($this->__apiMap->GetImageHeight()-$this->GetHeight()) . ';' . ($this->__apiMap->GetImageWidth()-$this->GetWidth()) . ' ' . ($this->__apiMap->GetImageHeight()-$this->GetHeight()) . ';' . ($this->__apiMap->GetImageWidth()-$this->GetWidth()) . ' ' . ($this->__apiMap->GetImageHeight()+2));  
		$overviewMapBorder->SetSymbol($simplePolygonSymbol);
		$overviewMapBorder->SetParentElement('OBJECT');
		
		$acetateObject->SetChild($overviewMapBorder);
		
		$__apiXML .= $acetateObject->WriteXML();
		
		/// OVERVIEW MAP EXTENT BOX 
		$simplePolygonSymbol = new SimplePolygonSymbol();
		$simplePolygonSymbol->SetAntiAliasing(true);
		$simplePolygonSymbol->SetBoundaryColor($this->__apiExtentBoxColor);
		$simplePolygonSymbol->SetFillColor('255,255,255');
		$simplePolygonSymbol->SetFillTransparency('0');
		$simplePolygonSymbol->SetOverlap(false);
	
		$overviewMapExtentBox = new Polygon();
		$overviewMapExtentBox->SetCoords($this->GetExtentCoords(&$this->__apiMap));  
		$overviewMapExtentBox->SetSymbol($simplePolygonSymbol);
		$overviewMapExtentBox->SetParentElement('OBJECT');
		
		$acetateObject->SetChild($overviewMapExtentBox);
		
		$__apiXML .= $acetateObject->WriteXML();
		
		return $__apiXML;
	
	}
}	
?>
