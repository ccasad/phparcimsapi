<?php
class LayerList {
	//***************************************************************
	// Set property defaults
	//***************************************************************
	var $__apiLayerDefArray = array();
	var $__apiCount = 0;
	
	//***************************************************************
	// Public Methods
	//***************************************************************
	function SetDynamicFirst($__apiParam) { $this->__apiDynamicFirst = $__apiParam; }
	function SetNoDefault($__apiParam) { $this->__apiNoDefault = $__apiParam; }
	function SetOrder($__apiParam) { $this->__apiOrder = $__apiParam; }
	
	function Add($__apiParam) {
		$this->__apiLayerDefArray[count($this->__apiLayerDefArray)] = $__apiParam;
		$this->__apiCount++;
	}
	function Clear() {
		unset($this->__apiObjectsArray);
	}
	function Remove($__apiParam) {
		/// 
	}
	
	function WriteXML() {
		$__apiProperties = array();
		$__apiProperties['dynamicfirst'] = CheckProperty($this->__apiDynamicFirst);
		$__apiProperties['nodefault'] = CheckProperty($this->__apiNoDefault);
		$__apiProperties['order'] = CheckProperty($this->__apiOrder);
		
		$__apiXML = '<LAYERLIST ';
		
		reset($__apiProperties);
		while ($__apiArrayCell = each($__apiProperties)) {
			if (strlen($__apiArrayCell['value']) > 0) {
				$__apiXML .= $__apiArrayCell['key'] . '="' . $__apiArrayCell['value'] . '" ';
			}
		}
		$__apiXML .= '>';
		
		if (count($this->__apiLayerDefArray) > 0) {
			for ($i = 0;$i < count($this->__apiLayerDefArray);$i++) {
				if ($this->__apiLayerDefArray[$i]) {
					$__apiXML .= $this->__apiLayerDefArray[$i]->WriteXML();
				}
			}
		}
		
		$__apiXML .= "</LAYERLIST>";
		
		return $__apiXML;
	}
}	
?>