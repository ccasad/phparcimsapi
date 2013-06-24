<?php
class Properties {
	//***************************************************************
	// Set property defaults
	//***************************************************************
	var $__apiBackgroundObject = '';
	var $__apiDrawObject = '';
	var $__apiEnvelopeObject = '';
	var $__apiFeatureCoordsysObject = '';
	var $__apiFilterCoordsysObject = '';
	var $__apiImageSizeObject = '';
	var $__apiLayerListObject = '';
	var $__apiLegendObject = '';
	var $__apiOutputObject = '';
	var $__apiCustom = '';
	
	//***************************************************************
	// Public Methods
	//***************************************************************
	function SetBackgroundObject($__apiParam) { $this->__apiBackgroundObject = $__apiParam; }
	function SetDrawObject($__apiParam) { $this->__apiDrawObject = $__apiParam; }
	function SetEnvelopeObject($__apiParam) { $this->__apiEnvelopeObject = $__apiParam; }
	function SetFeatureCoordsysObject($__apiParam) { $this->__apiFeatureCoordsysObject = $__apiParam; }
	function SetFilterCoordsysObject($__apiParam) { $this->__apiFilterCoordsysObject = $__apiParam; }
	function SetImageSizeObject($__apiParam) { $this->__apiImageSizeObject = $__apiParam; }
	function SetLayerListObject($__apiParam) { $this->__apiLayerListObject = $__apiParam; }
	function SetLegendObject($__apiParam) { $this->__apiLegendObject = $__apiParam; }
	function SetOutputObject($__apiParam) { $this->__apiOutputObject = $__apiParam; }
	function SetCustom($__apiParam) { $this->__apiCustom = $__apiParam; }
	
	function WriteXML() {
		$__apiXML = '<PROPERTIES>';
		
		if (is_object($this->__apiBackgroundObject)) {
			$__apiXML .= $this->__apiBackgroundObject->WriteXML();
		}
		if (is_object($this->__apiDrawObject)) {
			$__apiXML .= $this->__apiDrawObject->WriteXML();
		}
		if (is_object($this->__apiEnvelopeObject)) {
			$__apiXML .= $this->__apiEnvelopeObject->WriteXML();
		}
		if (is_object($this->__apiFeatureCoordsysObject)) {
			$__apiXML .= $this->__apiFeatureCoordsysObject->WriteXML();
		}
		if (is_object($this->__apiFilterCoordsysObject)) {
			$__apiXML .= $this->__apiFilterCoordsysObject->WriteXML();
		}
		if (is_object($this->__apiImageSizeObject)) {
			$__apiXML .= $this->__apiImageSizeObject->WriteXML();
		}
		if (is_object($this->__apiLayerListObject)) {
			$__apiXML .= $this->__apiLayerListObject->WriteXML();
		}
		if (is_object($this->__apiLegendObject)) {
			$__apiXML .= $this->__apiLegendObject->WriteXML();
		}
		if (is_object($this->__apiOutputObject)) {
			$__apiXML .= $this->__apiOutputObject->WriteXML();
		}
		if ($this->__apiCustom) {
			$__apiXML .= $this->__apiCustom;
		}
		
		$__apiXML .= '</PROPERTIES>';
		
		return $__apiXML;
	}
}	
?>