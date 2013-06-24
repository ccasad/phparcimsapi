<?php
class Get_Extract {	
	//***************************************************************
	// Set property defaults
	//***************************************************************
	var $__apiPropertyObject = '';
	var $__apiEnvironmentObject = '';
	var $__apiWorkspacesObject = '';
	var $__apiCount = 0;
	var $__apiLayerArray = array();
	
	//***************************************************************
	// Constructor
	//***************************************************************
	function Get_Extract() {
		$numargs = func_num_args();
		$this->__apiPropertyObject = $numargs > 0 ? func_get_arg(0) : $__apiPropertyObject;
	}
	
	//***************************************************************
	// Public Methods
	//***************************************************************
	function SetPropertyObject($__apiParam) { $this->__apiPropertyObject = $__apiParam; }
	function SetEnvironmentObject($__apiParam) { $this->__apiEnvironmentObject = $__apiParam; }
	function SetWorkspacesObject($__apiParam) { $this->__apiWorkspacesObject = $__apiParam; }
	function Add($__apiParam) {
		$this->__apiLayerArray[count($this->__apiLayerArray)] = $__apiParam;
		$this->__apiCount++;
	}
	function Clear() {
		unset($this->__apiLayerArray);
	}
	function Remove($__apiParam) {
		/// 
	}
	
	function WriteXML() {
		
		$__apiXML = '<GET_EXTRACT>';
		
		if (is_object($this->__apiPropertyObject)) {
			$__apiXML .= $this->__apiPropertyObject->writeXML();
		} else {
			return 'Error: Get_Extract() object contains no properties';	
		}
		if (is_object($this->__apiEnvironmentObject)) {
			$__apiXML .= $this->__apiEnvironmentObject->writeXML();
		}
		if (is_object($this->__apiWorkspacesObject)) {
			$__apiXML .= $this->__apiWorkspacesObject->writeXML();
		}
		if (count($this->__apiLayerArray) > 0) {
			for ($i=0;$i < count($this->__apiLayerArray);$i++) {
				if ($this->__apiLayerArray[$i]) {
					$__apiXML .= $this->__apiLayerArray[$i]->WriteXML();
				}
			}
		}
		$__apiXML .= '</GET_EXTRACT>';
		
		return $__apiXML;
	}
}	
?>