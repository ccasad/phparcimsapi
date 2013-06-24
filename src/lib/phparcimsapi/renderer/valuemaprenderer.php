<?php
class ValueMapRenderer {
	//***************************************************************
	// Set property defaults
	//***************************************************************
	var $__apiLookupField = '';
	var $__apiCount = 0;  
	var $__apiRendererArray = array();

	//***************************************************************
	// Constructor
	//***************************************************************
	function ValueMapRenderer() {
		$numargs = func_num_args();
		$this->__apiLookupField = $numargs > 0 ? func_get_arg(0) : $__apiLookupField;
	}
	
	//***************************************************************
	// Public Methods
	//***************************************************************
	function SetLookupField($__apiParam) { $this->__apiLookupField = $__apiParam; }
	function SetRendererArray($__apiParam) { $this->__apiRendererArray = $__apiParam; }
	
	function Add($__apiParam) {
		$this->__apiRendererArray[count($this->__apiRendererArray)] = $__apiParam;
		$this->__apiCount++;
	}
	function Clear() {
		unset($this->__apiRendererArray);
	}
	function Remove($__apiParam) {
		/// 
	}
	
	function WriteXML() {
		$__apiProperties = array();
		$__apiProperties['lookupfield'] = CheckProperty($this->__apiLookupField);
		
		$__apiXML = '<VALUEMAPRENDERER ';
		
		reset($__apiProperties);
		while ($__apiArrayCell = each($__apiProperties)) {
			if (strlen($__apiArrayCell['value']) > 0) {
				$__apiXML .= $__apiArrayCell['key'] . '="' . $__apiArrayCell['value'] . '" ';
			}
		}
		$__apiXML .= '>';
		
		if (count($this->__apiRendererArray) > 0) {
			for ($i=0;$i < count($this->__apiRendererArray);$i++) {
				if ($this->__apiRendererArray[$i]) {
					$__apiXML .= $this->__apiRendererArray[$i]->WriteXML();
				}
			}
		}
		
		$__apiXML .= "</VALUEMAPRENDERER>";
		
		return $__apiXML;
	}
}	
?>