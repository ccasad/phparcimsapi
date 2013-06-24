<?php
class LayerDef {
	//***************************************************************
	// Set property defaults
	//***************************************************************
	var $__apiId = '';  
	var $__apiName = '';   
	var $__apiVisible = '';
	var $__apiRenderer = '';
	
	//***************************************************************
	// Constructor
	//***************************************************************
	function LayerDef() {
		$numargs = func_num_args();
		$this->__apiId = $numargs > 0 ? func_get_arg(0) : $__apiId;
		$this->__apiName = $numargs > 1 ? func_get_arg(1) : $__apiName;
		$this->__apiVisible = $numargs > 2 ? func_get_arg(2) : $__apiVisible;
		$this->__apiRenderer = $numargs > 3 ? func_get_arg(3) : $__apiRenderer;
	}

	//***************************************************************
	// Public Methods
	//***************************************************************
	function SetId($__apiParam) { $this->__apiId = $__apiParam; }
	function SetName($__apiParam) { $this->__apiName = $__apiParam; }
	function SetVisible($__apiParam) { $this->__apiVisible = $__apiParam; }
	function SetRenderer($__apiParam) { $this->__apiRenderer = $__apiParam; }
	
	function WriteXML() {
		$__apiProperties = array();
		$__apiProperties['visible'] = CheckProperty($this->__apiVisible);
		$__apiProperties['name'] = CheckProperty($this->__apiName);
		$__apiProperties['id'] = CheckProperty($this->__apiId);
		
		$__apiXML = '<LAYERDEF ';
		
		reset($__apiProperties);
		while ($__apiArrayCell = each($__apiProperties)) {
			if (strlen($__apiArrayCell['value']) > 0) {
				$__apiXML .= $__apiArrayCell['key'] . '="' . $__apiArrayCell['value'] . '" ';
			}
		}
		$__apiXML .= '>';
		
		if ($this->__apiRenderer) {
			$__apiXML .= $this->__apiRenderer->WriteXML();
		}
		
		$__apiXML .= "</LAYERDEF>";
		
		return $__apiXML;
	}
}	
?>