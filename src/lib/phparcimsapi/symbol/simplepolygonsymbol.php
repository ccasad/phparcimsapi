<?php
class SimplePolygonSymbol {
	//***************************************************************
	// Set property defaults
	//***************************************************************
	var $__apiAntiAliasing = '';
	var $__apiBoundary = '';
	var $__apiBoundaryCapType = '';
	var $__apiBoundaryColor = '';
	var $__apiBoundaryJoinType = '';
	var $__apiBoundaryTransparency = '';
	var $__apiBoundaryType = '';
	var $__apiBoundaryWidth = '';
	var $__apiFillColor = '';
	var $__apiFillInterval = '';
	var $__apiFillTransparency = '';
	var $__apiFillType = '';
	var $__apiOverlap = '';
	var $__apiTransparency = '';
	
	//***************************************************************
	// Public Methods
	//***************************************************************
	function SetAntiAliasing($__apiParam) { $this->__apiAntiAliasing = $__apiParam; }
	function SetBoundary($__apiParam) { $this->__apiBoundary = $__apiParam; }
	function SetBoundaryCapType($__apiParam) { $this->__apiBoundaryCapType = $__apiParam; }
	function SetBoundaryColor($__apiParam) { $this->__apiBoundaryColor = $__apiParam; }
	function SetBoundaryJoinType($__apiParam) { $this->__apiBoundaryJoinType = $__apiParam; }
	function SetBoundaryTransparency($__apiParam) { $this->__apiBoundaryTransparency = $__apiParam; }
	function SetBoundaryType($__apiParam) { $this->__apiBoundaryType = $__apiParam; }
	function SetBoundaryWidth($__apiParam) { $this->__apiBoundaryWidth = $__apiParam; }
	function SetFillColor($__apiParam) { $this->__apiFillColor = $__apiParam; }
	function SetFillInterval($__apiParam) { $this->__apiFillInterval = $__apiParam; }
	function SetFillTransparency($__apiParam) { $this->__apiFillTransparency = $__apiParam; }
	function SetFillType($__apiParam) { $this->__apiFillType = $__apiParam; }
	function SetOverlap($__apiParam) { $this->__apiOverlap = CheckProperty($__apiParam); }
	function SetTransparency($__apiParam) { $this->__apiTransparency = $__apiParam; }
	
	function WriteXML() {
		$__apiProperties = array();
		$__apiProperties['antialiasing'] = CheckProperty($this->__apiAntiAliasing);
		$__apiProperties['boundary'] = CheckProperty($this->__apiBoundary);
		$__apiProperties['boundarycaptype'] = CheckProperty($this->__apiBoundaryCapType);
		$__apiProperties['boundarycolor'] = CheckProperty($this->__apiBoundaryColor);
		$__apiProperties['boundaryjointype'] = CheckProperty($this->__apiBoundaryJoinType);
		$__apiProperties['boundarytransparency'] = CheckProperty($this->__apiBoundaryTransparency);
		$__apiProperties['boundarytype'] = CheckProperty($this->__apiBoundaryType);
		$__apiProperties['boundarywidth'] = CheckProperty($this->__apiBoundaryWidth);
		$__apiProperties['fillcolor'] = CheckProperty($this->__apiFillColor);
		$__apiProperties['fillinterval'] = CheckProperty($this->__apiFillInterval);
		$__apiProperties['filltransparency'] = CheckProperty($this->__apiFillTransparency);
		$__apiProperties['filltype'] = CheckProperty($this->__apiFillType);
		$__apiProperties['overlap'] = CheckProperty($this->__apiOverlap);
		$__apiProperties['transparency'] = CheckProperty($this->__apiTransparency);
			
		$__apiXML = '<SIMPLEPOLYGONSYMBOL ';
		
		reset($__apiProperties);
		while ($__apiArrayCell = each($__apiProperties)) {
			if (strlen($__apiArrayCell['value']) > 0) {
				$__apiXML .= $__apiArrayCell['key'] . '="' . $__apiArrayCell['value'] . '" ';
			}
		}

		$__apiXML .= '/>';
		
		return $__apiXML;
	}
}	
?>
