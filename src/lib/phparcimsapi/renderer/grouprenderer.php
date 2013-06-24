<?php
class GroupRenderer {
	//***************************************************************
	// Set property defaults
	//***************************************************************
	var $__apiCount = 0;  
	var $__apiRendererArray = array();
	
	//***************************************************************
	// Public Methods
	//***************************************************************
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
		$__apiXML = '<GROUPRENDERER>';
		
		if (count($this->__apiRendererArray) > 0) {
			for ($i=0;$i < count($this->__apiRendererArray);$i++) {
				if ($this->__apiRendererArray[$i]) {
					$__apiXML .= $this->__apiRendererArray[$i]->WriteXML();
				}
			}
		}
		
		$__apiXML .= "</GROUPRENDERER>";
		
		return $__apiXML;
	}
}	
?>