<?php
class Request {
	//***************************************************************
	// Set property defaults
	//***************************************************************
	var $__apiTypeObject = '';
	
	//***************************************************************
	// Constructor
	//***************************************************************
	function Request() {
		$numargs = func_num_args();
		$this->__apiTypeObject = $numargs > 0 ? func_get_arg(0) : $__apiTypeObject;
	}
	
	//***************************************************************
	// Public Methods
	//***************************************************************
	function SetTypeObject($__apiParam) { $this->__apiTypeObject = $__apiParam; }

	function WriteXML() {
		$__apiXML = '<REQUEST>';
		if (is_object($this->__apiTypeObject)) {
			$__apiXML .= $this->__apiTypeObject->WriteXML();	
		} else {
			return 'Error: Request() object contains no types';	
		}
		$__apiXML .= '</REQUEST>';

		return $__apiXML;
	}
}	
?>