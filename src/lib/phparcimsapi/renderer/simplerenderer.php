<?php
class SimpleRenderer {
	//***************************************************************
	// Set property defaults
	//***************************************************************  
	var $__apiSymbol = '';  
	
	//***************************************************************
	// Constructor
	//***************************************************************
	function SimpleRenderer() {
		$numargs = func_num_args();
		$this->__apiSymbol = $numargs > 0 ? func_get_arg(0) : $__apiSymbol;
	}

	//***************************************************************
	// Public Methods
	//***************************************************************
	function SetSymbol($__apiParam) { $this->__apiSymbol = $__apiParam; }
	
	function WriteXML() {
		$__apiXML = '<SIMPLERENDERER>';
		
		if ($this->__apiSymbol) {
			$__apiXML .= $this->__apiSymbol->WriteXML();
		} else {
			return 'SimpleRenderer() does not contain a symbol object';
		}
		
		$__apiXML .= '</SIMPLERENDERER>';
		
		return $__apiXML;
	}
}	
?>