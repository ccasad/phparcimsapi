<?php
class AcetateLegend {
	//***************************************************************
	// Set property defaults
	//***************************************************************
	var $__apiAntiAliasing = '';
	var $__apiOverlap = '';
	var $__apiSize = '';
	var $__apiWidth = '';
	var $__apiHeight = '';
	var $__apiMap = '';
	var $__apiImage = '';
	var $__apiUrl = '';
	var $__apiUnits = '';
	var $__apiBoundaryColor = '';
	var $__apiTransparency = '';
	
	//***************************************************************
	// Public Methods
	//***************************************************************
	function SetAntiAliasing($__apiParam) { $this->__apiAntiAliasing = $__apiParam; }
	function SetOverlap($__apiParam) { $this->__apiOverlap = $__apiParam; }
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
	
	function WriteXML() {
		/// LEGEND IMAGE
		$acetateObject1 = new XObject($this->__apiUnits);
		
		$rasterMarkerSymbol = new RasterMarkerSymbol();
		$rasterMarkerSymbol->SetAntiAliasing($this->__apiAntiAliasing);
		$rasterMarkerSymbol->SetOverlap($this->__apiOverlap);
		$rasterMarkerSymbol->SetSize($this->__apiSize);
		$rasterMarkerSymbol->SetImage($this->__apiImage); 
		$rasterMarkerSymbol->SetUrl($this->__apiUrl);
		$rasterMarkerSymbol->SetTransparency($this->__apiTransparency);
		
		$objPoint = new Point();
		$objPoint->SetCoords(($this->__apiMap->GetImageWidth() - ($this->__apiSize['width'] / 2)) . ' ' . ($this->__apiMap->GetImageHeight() - ($this->__apiSize['height'] / 2)));
		$objPoint->SetMarkerSymbol($rasterMarkerSymbol);
		$objPoint->SetParentElement('OBJECT');
		
		$acetateObject1->SetChild($objPoint);
		$__apiXML .= $acetateObject1->WriteXML();
		
		/// LEGEND BORDER
		if ($this->__apiBoundaryColor) {
			$acetateObject2 = new XObject($this->__apiUnits);
			
			$simplePolygonSymbol = new SimplePolygonSymbol();
			$simplePolygonSymbol->SetAntiAliasing(true);
			$simplePolygonSymbol->SetBoundaryColor($this->__apiBoundaryColor);
			$simplePolygonSymbol->SetFillColor($__apiConstants->__apiCWhite);
			$simplePolygonSymbol->SetFillTransparency('0.0');
			$simplePolygonSymbol->SetOverlap(false);
			
			$legendBorder = new Polygon();
			$legendBorder->SetCoords(($this->__apiMap->GetImageWidth() - $this->__apiSize['width']) . ' ' . ($this->__apiMap->GetImageHeight() + 2) . ';' . ($this->__apiMap->GetImageWidth() + 1) . ' ' . ($this->__apiMap->GetImageHeight() + 2) . ';' . ($this->__apiMap->GetImageWidth() + 1) . ' ' . ($this->__apiMap->GetImageHeight() - $this->__apiSize['height']) . ';' . ($this->__apiMap->GetImageWidth() - $this->__apiSize['width']) . ' ' . ($this->__apiMap->GetImageHeight() - $this->__apiSize['height']) . ';' . ($this->__apiMap->GetImageWidth() - $this->__apiSize['width']) . ' ' . ($this->__apiMap->GetImageHeight() + 2));  
			$legendBorder->SetSymbol($simplePolygonSymbol);
			$legendBorder->SetParentElement('OBJECT');
			
			$acetateObject2->SetChild($legendBorder);
			
			$__apiXML .= $acetateObject2->WriteXML();
		}
		
		return $__apiXML;
	}
}	
?>
