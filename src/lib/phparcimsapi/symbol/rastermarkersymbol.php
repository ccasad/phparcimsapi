<?php
class RasterMarkerSymbol {
	//***************************************************************
	// Set property defaults
	//***************************************************************
	var $__apiAntiAliasing = '';
	var $__apiHotSpot = '';
	var $__apiImage = '';
	var $__apiOverlap = '';
	var $__apiShadow = '';
	var $__apiSize = '';
	var $__apiTransparency = '';
	var $__apiUrl = '';
	var $__apiUseCentroid = '';

	//***************************************************************
	// Public Methods
	//***************************************************************
	function SetAntiAliasing($__apiParam) { $this->__apiAntiAliasing = $__apiParam; }
	function SetHotSpot($__apiParam) { $this->__apiHotSpot = $__apiParam; }
	function SetImage($__apiParam) { $this->__apiImage = $__apiParam; }
	function SetOverlap($__apiParam) { $this->__apiOverlap = $__apiParam; }
	function SetShadow($__apiParam) { $this->__apiShadow = $__apiParam; }
	function SetSize($__apiParam) { 
		if (is_array($__apiParam)) {
			$this->__apiSize = $__apiParam['width'] . ' ' . $__apiParam['height'];
		} else {
			$this->__apiSize = $__apiParam; 
		}
	}
	function SetTransparency($__apiParam) { $this->__apiTransparency = $__apiParam; }
	function SetUrl($__apiParam) { $this->__apiUrl = $__apiParam; }
	function SetUseCentroid($__apiParam) { $this->__apiUseCentroid = $__apiParam; }
	
	function WriteXML() {
		$__apiProperties = array();
		$__apiProperties['antialiasing'] = CheckProperty($this->__apiAntiAliasing);
		$__apiProperties['hotspot'] = CheckProperty($this->__apiHotSpot);
		$__apiProperties['image'] = CheckProperty($this->__apiImage);
		$__apiProperties['overlap'] = CheckProperty($this->__apiOverlap);
		$__apiProperties['shadow'] = CheckProperty($this->__apiShadow);
		$__apiProperties['size'] = CheckProperty($this->__apiSize);
		$__apiProperties['transparency'] = CheckProperty($this->__apiTransparency);
		$__apiProperties['url'] = CheckProperty($this->__apiUrl);
		$__apiProperties['usecentroid'] = CheckProperty($this->__apiUseCentroid);
			
		$__apiXML = '<RASTERMARKERSYMBOL ';
		
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
