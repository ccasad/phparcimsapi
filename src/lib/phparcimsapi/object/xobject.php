<?php
class XObject {
	//***************************************************************
	// Set property defaults
	//***************************************************************
	var $__apiUnits = '';
	var $__apiChild = '';
	var $__apiLower = '';
	var $__apiUpper = '';
	
	//***************************************************************
	// Constructor
	//***************************************************************
	function XObject() {
		$numargs = func_num_args();
		$this->__apiUnits = $numargs > 0 ? func_get_arg(0) : $__apiUnits;
		$this->__apiChild = $numargs > 1 ? func_get_arg(1) : $__apiChild;
		$this->__apiLower = $numargs > 2 ? func_get_arg(2) : $__apiLower;
		$this->__apiUpper = $numargs > 3 ? func_get_arg(3) : $__apiUpper;
	}

	//***************************************************************
	// Public Methods
	//***************************************************************
	function SetUnits($__apiParam) { $this->__apiUnits = $__apiParam; }
	function SetChild($__apiParam) { $this->__apiChild = $__apiParam; }
	function SetLower($__apiParam) { $this->__apiLower = $__apiParam; }
	function SetUpper($__apiParam) { $this->__apiUpper = $__apiParam; }
	
	function WriteXML() {
		$__apiProperties = array();
		$__apiProperties['units'] = CheckProperty($this->__apiUnits);
		$__apiProperties['lower'] = CheckProperty($this->__apiLower);
		$__apiProperties['upper'] = CheckProperty($this->__apiUpper);
		
		$__apiXML = '<OBJECT ';
		
		reset($__apiProperties);
		while ($__apiArrayCell = each($__apiProperties)) {
			if (strlen($__apiArrayCell['value']) > 0) {
				$__apiXML .= $__apiArrayCell['key'] . '="' . $__apiArrayCell['value'] . '" ';
			}
		}
		
		$__apiXML .= '>';
		
		if ($this->__apiChild) {
			$__apiXML .= $this->__apiChild->WriteXML();
		} else {
			return 'XObject() object contains no symbols';
		}
		$__apiXML .= '</OBJECT>';
		
		return $__apiXML;
	}
}	
?>
