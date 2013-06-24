<?php
class Get_Features {
	//***************************************************************
	// Set property defaults
	//***************************************************************
	var $__apiAttributes = '';
	var $__apiBeginRecord = '';
	var $__apiCheckEsc = '';
	var $__apiCompact = '';
	var $__apiEnvelope = '';
	var $__apiFeatureLimit = '';
	var $__apiGeometry = '';
	var $__apiGlobalEnvelope = '';
	var $__apiOutputMode = '';
	var $__apiSkipFeatures = '';
	var $__apiLayer = '';
	var $__apiChildObject = '';
	
	//***************************************************************
	// Public Methods
	//***************************************************************
	function SetAttributes($__apiParam) { $this->__apiAttributes = $__apiParam; }
	function SetBeginRecord($__apiParam) { $this->__apiBeginRecord = $__apiParam; }
	function SetCheckEsc($__apiParam) { $this->__apiCheckEsc = $__apiParam; }
	function SetCompact($__apiParam) { $this->__apiCompact = $__apiParam; }
	function SetEnvelope($__apiParam) { $this->__apiEnvelope = $__apiParam; }
	function SetFeatureLimit($__apiParam) { $this->__apiFeatureLimit = $__apiParam; }
	function SetGeometry($__apiParam) { $this->__apiGeometry = $__apiParam; }
	function SetGlobalEnvelope($__apiParam) { $this->__apiGlobalEnvelope = $__apiParam; }
	function SetOutputMode($__apiParam) { $this->__apiOutputMode = $__apiParam; }
	function SetSkipFeatures($__apiParam) { $this->__apiSkipFeatures = $__apiParam; }
	function SetLayer($__apiParam) { $this->__apiLayer = $__apiParam; }
	function SetChildObject($__apiParam) { $this->__apiChildObject = $__apiParam; }
	
	function WriteXML() {
		$__apiProperties = array();
		$__apiProperties['attributes'] = CheckProperty($this->__apiAttributes);
		$__apiProperties['beginrecord'] = CheckProperty($this->__apiBeginRecord);
		$__apiProperties['checkesc'] = CheckProperty($this->__apiCheckEsc);
		$__apiProperties['compact'] = CheckProperty($this->__apiCompact);
		$__apiProperties['envelope'] = CheckProperty($this->__apiEnvelope);
		$__apiProperties['featurelimit'] = CheckProperty($this->__apiFeatureLimit);
		$__apiProperties['geometry'] = CheckProperty($this->__apiGeometry);
		$__apiProperties['globalenvelope'] = CheckProperty($this->__apiGlobalEnvelope);
		$__apiProperties['outputmode'] = CheckProperty($this->__apiOutputMode);
		$__apiProperties['skipfeatures'] = CheckProperty($this->__apiSkipFeatures);
		
		$__apiXML = '<GET_FEATURES ';
		
		reset($__apiProperties);
		while ($__apiArrayCell = each($__apiProperties)) {
			if (strlen($__apiArrayCell['value']) > 0) {
				$__apiXML .= $__apiArrayCell['key'] . '="' . $__apiArrayCell['value'] . '" ';
			}
		}
		$__apiXML .= '>';
		
		if ($this->__apiLayer) {
			$__apiXML .= $this->__apiLayer->WriteXML();
		} else {
			return 'Get_Features() object contains no layer';
		}
		
		if ($this->__apiChildObject) {
			$__apiXML .= $this->__apiChildObject->WriteXML();
		} else {
			return 'Get_Features() object contains no child object';
		}
		
		$__apiXML .= '</GET_FEATURES>';
		
		return $__apiXML;
	}
}	
?>