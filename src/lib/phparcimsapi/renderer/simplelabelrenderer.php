<?php
class SimpleLabelRenderer {
	//***************************************************************
	// Set property defaults
	//*************************************************************** 
	var $__apiField = '';  
	var $__apiFeatureWeight = '';  
	var $__apiHowManyLabels = '';  
	var $__apiLabelBufferRatio = '';
	var $__apiLabelPriorities = '';
	var $__apiLabelWeight = '';
	var $__apiLineLabelPosition = '';
	var $__apiRotationalAngles = '';
	var $__apiSymbol = '';
	
	//***************************************************************
	// Constructor
	//***************************************************************
	function SimpleLabelRenderer() {
		$numargs = func_num_args();
		$this->__apiField = $numargs > 0 ? func_get_arg(0) : $__apiField;
	}

	//***************************************************************
	// Public Methods
	//***************************************************************
	function SetField($__apiParam) { $this->__apiField = $__apiParam; }
	function SetFeatureWeight($__apiParam) { $this->__apiFeatureWeight = $__apiParam; }
	function SetHowManyLabels($__apiParam) { $this->__apiHowManyLabels = $__apiParam; }
	function SetLabelBufferRatio($__apiParam) { $this->__apiLabelBufferRatio = $__apiParam; }
	function SetLabelPriorities($__apiParam) { $this->__apiLabelPriorities = $__apiParam; }
	function SetLabelWeight($__apiParam) { $this->__apiLabelWeight = $__apiParam; }
	function SetLineLabelPosition($__apiParam) { $this->__apiLineLabelPosition = $__apiParam; }
	function SetRotationalAngles($__apiParam) { $this->__apiRotationalAngles = $__apiParam; }
	function SetSymbol($__apiParam) { $this->__apiSymbol = $__apiParam; }
	
	function WriteXML() {
		$__apiProperties = array();
		$__apiProperties['field'] = CheckProperty($this->__apiField);
		$__apiProperties['featureweight'] = CheckProperty($this->__apiFeatureWeight);
		$__apiProperties['howmanylabels'] = CheckProperty($this->__apiHowManyLabels);
		$__apiProperties['labelbufferratio'] = CheckProperty($this->__apiLabelBufferRatio);
		$__apiProperties['labelpriorities'] = CheckProperty($this->__apiLabelPriorities);
		$__apiProperties['labelweight'] = CheckProperty($this->__apiLabelWeight);
		$__apiProperties['linelabelposition'] = CheckProperty($this->__apiLineLabelPosition);
		$__apiProperties['rotationalangles'] = CheckProperty($this->__apiRotationalAngles);
		
		$__apiXML = '<SIMPLELABELRENDERER ';
		
		reset($__apiProperties);
		while ($__apiArrayCell = each($__apiProperties)) {
			if (strlen($__apiArrayCell['value']) > 0) {
				$__apiXML .= $__apiArrayCell['key'] . '="' . $__apiArrayCell['value'] . '" ';
			}
		}
		$__apiXML .= '>';
		
		if ($this->__apiSymbol) {
			$__apiXML .= $this->__apiSymbol->WriteXML();
		} else {
			return 'SimpleLabelRenderer() does not contain a symbol object';
		}
		
		$__apiXML .= '</SIMPLELABELRENDERER>';
		
		return $__apiXML;
	}
}	
?>