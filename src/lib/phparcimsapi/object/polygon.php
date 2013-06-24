<?php
class Polygon {
	//***************************************************************
	// Set property defaults
	//***************************************************************
	var $__apiCoords = '';
	var $__apiSymbol = '';
	var $__apiParentElement = '';
	
	//***************************************************************
	// Constructor
	//***************************************************************
	function Polygon() {
		$numargs = func_num_args();
		$this->__apiCoords = $numargs > 0 ? func_get_arg(0) : $__apiCoords;
		$this->__apiSymbol = $numargs > 1 ? func_get_arg(1) : $__apiSymbol;
		$this->__apiParentElement = $numargs > 2 ? func_get_arg(2) : $__apiParentElement;
	}

	//***************************************************************
	// Public Methods
	//***************************************************************
	function SetCoords($__apiParam) { $this->__apiCoords = $__apiParam; }
	function SetSymbol($__apiParam) { $this->__apiSymbol = $__apiParam; }
	function SetParentElement($__apiParam) { $this->__apiParentElement = $__apiParam; }
	
	function WriteXML() {
		$__apiProperties = array();
		if (strtoupper($this->__apiParentElement) == 'OBJECT') {
			$__apiProperties['coords'] = CheckProperty($this->__apiCoords);
		}
		
		$__apiXML = '<POLYGON ';
		
		reset($__apiProperties);
		while ($__apiArrayCell = each($__apiProperties)) {
			if (strlen($__apiArrayCell['value']) > 0) {
				$__apiXML .= $__apiArrayCell['key'] . '="' . $__apiArrayCell['value'] . '" ';
			}
		}
		
		if (strtoupper($this->__apiParentElement) == 'OBJECT') {
			if ($this->__apiSymbol) {
				$__apiXML .= '>';
				$__apiXML .= $this->__apiSymbol->WriteXML();
				$__apiXML .= '</POLYGON>';
			} else {
				return 'Polygon() object contains no symbols';	
			}
		} else {
			$__apiXML .= '/>';
		}
		
		return $__apiXML;
	}
}	
?>
