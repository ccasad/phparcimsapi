<?php
class Copyright {
	//***************************************************************
	// Set property defaults
	//***************************************************************
	var $__apiCoords = '';
	var $__apiLabel = '';
	var $__apiAngle = '';
	var $__apiAntiAliasing = '';
	var $__apiBlockout = '';
	var $__apiFont = '';
	var $__apiFontColor = '';
	var $__apiFontSize = '';
	var $__apiFontStyle = '';
	var $__apiGlowing = '';
	var $__apiHAlignment = '';
	var $__apiInterval = '';
	var $__apiOutline = '';
	var $__apiOverlap = '';
	var $__apiPrintMode = '';
	var $__apiTransparency = '';
	var $__apiVAlignment = '';

	//***************************************************************
	// Constructor
	//***************************************************************
	function Copyright() {
		$numargs = func_num_args();
		$this->__apiX = $numargs > 0 ? func_get_arg(0) : $__apiX;
		$this->__apiY = $numargs > 1 ? func_get_arg(1) : $__apiY;
		$this->__apiLabel = $numargs > 2 ? func_get_arg(2) : $__apiLabel;
		
		if ($this->__apiX && $this->__apiY) {
			$this->__apiCoords = $this->__apiX . ' ' . $this->__apiY;
		}
	}
	
	//***************************************************************
	// Public Methods
	//***************************************************************
	function SetX($__apiParam) { $this->__apiX = $__apiParam; }
	function SetY($__apiParam) { $this->__apiY = $__apiParam; }
	function SetCoords($__apiParam) { 
		$this->__apiCoords = $__apiParam; 
		$__apiCoordsArray = split(" ", $__apiParam); 
		$this->SetX($__apiCoordsArray[0]);
		$this->SetY($__apiCoordsArray[1]);
	}
	function SetLabel($__apiParam) { $this->__apiLabel = $__apiParam; }
	function SetAngle($__apiParam) { $this->__apiAngle = $__apiParam; }
	function SetAntiAliasing($__apiParam) { $this->__apiAntiAliasing = $__apiParam; }
	function SetBlockout($__apiParam) { $this->__apiBlockout = $__apiParam; }
	function SetFont($__apiParam) { $this->__apiFont = $__apiParam; }
	function SetFontColor($__apiParam) { $this->__apiFontColor = $__apiParam; }
	function SetFontSize($__apiParam) { $this->__apiFontSize = $__apiParam; }
	function SetFontStyle($__apiParam) { $this->__apiFontStyle = $__apiParam; }
	function SetGlowing($__apiParam) { $this->__apiGlowing = $__apiParam; }
	function SetHAlignment($__apiParam) { $this->__apiHAlignment = $__apiParam; }
	function SetInterval($__apiParam) { $this->__apiInterval = $__apiParam; }
	function SetOutline($__apiParam) { $this->__apiOutline = $__apiParam; }
	function SetOverlap($__apiParam) { $this->__apiOverlap = $__apiParam; }
	function SetPrintMode($__apiParam) { $this->__apiPrintMode = $__apiParam; }
	function SetTransparency($__apiParam) { $this->__apiTransparency = $__apiParam; }
	function SetVAlignment($__apiParam) { $this->__apiVAlignment = $__apiParam; }
	
	function WriteXML() {
		$textMarkerSymbol = new TextMarkerSymbol();
		$textMarkerSymbol->SetAngle($this->__apiAngle);
		$textMarkerSymbol->SetAntiAliasing($this->__apiAntiAliasing);
		$textMarkerSymbol->SetBlockout($this->__apiBlockout);
		$textMarkerSymbol->SetFont($this->__apiFont);
		$textMarkerSymbol->SetFontColor($this->__apiFontColor);
		$textMarkerSymbol->SetFontSize($this->__apiFontSize);
		$textMarkerSymbol->SetFontStyle($this->__apiFontStyle);
		$textMarkerSymbol->SetGlowing($this->__apiGlowing);
		$textMarkerSymbol->SetHAlignment($this->__apiHAlignment);
		$textMarkerSymbol->SetInterval($this->__apiInterval);
		$textMarkerSymbol->SetOutline($this->__apiOutline);
		$textMarkerSymbol->SetOverlap($this->__apiOverlap);
		$textMarkerSymbol->SetPrintMode($this->__apiPrintMode);
		$textMarkerSymbol->SetTransparency($this->__apiTransparency);
		$textMarkerSymbol->SetVAlignment($this->__apiVAlignment);
			
		$text = new Text();
		$text->SetCoords($this->__apiX . ' ' . $this->__apiY);
		$text->SetLabel($this->__apiLabel);
		$text->SetTextMarkerSymbol($textMarkerSymbol);
		
		$__apiXML = $text->WriteXML();
		
		return $__apiXML;
	}
}	
?>