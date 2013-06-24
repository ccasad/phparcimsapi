<?php
class TargetLayer {
	//***************************************************************
	// Set property defaults
	//***************************************************************
	var $__apiId = '';
	
	//***************************************************************
	// Constructor
	//***************************************************************
	function TargetLayer() {
		$numargs = func_num_args();
		$this->__apiId = $numargs > 0 ? func_get_arg(0) : $__apiId;
	}

	//***************************************************************
	// Public Methods
	//***************************************************************
	function SetId($__apiParam) { $this->__apiId = $__apiParam; }
	
	function WriteXML() {
		$__apiProperties = array();
		$__apiProperties['id'] = CheckProperty($this->__apiId);
		
		$__apiXML = '<TARGETLAYER ';
		
		reset($__apiProperties);
		while ($__apiArrayCell = each($__apiProperties)) {
			if (strlen($__apiArrayCell['value']) > 0) {
				$__apiXML .= $__apiArrayCell['key'] . '="' . $__apiArrayCell['value'] . '" ';
			}
		}
		$__apiXML .= '>';
		
		$__apiXML .= '</TARGETLAYER>';
		
		return $__apiXML;
	}
}	
?>