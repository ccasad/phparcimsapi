<?php
class StateObject {
	//***************************************************************
	// Set property defaults
	//***************************************************************
	var $__apiForceCaseTo = 'UPPER';         // '', UPPER, LOWER
	var $__apiAllowGetMethod = 0;
	
	//***************************************************************
	// Constructor
	//***************************************************************
	function StateObject() {
		$numargs = func_num_args();
		$this->__apiForceCaseTo = $numargs > 0 ? func_get_arg(0) : $this->__apiForceCaseTo;
		$this->__apiAllowGetMethod = $numargs > 1 ? func_get_arg(1) : $this->__apiAllowGetMethod;
	}
	
	//***************************************************************
	// Methods
	//***************************************************************
	function AddParameter($__apiFormParam, &$__apiSetToVariable, $__apiDefaultValue, $__apiCustomFunction) {
		global $HTTP_GET_VARS, $HTTP_POST_VARS;
		
		$numargs = func_num_args();
		$__apiForceCaseTo = $numargs > 4 ? func_get_arg(4) : $this->__apiForceCaseTo;
		$__apiAllowGetMethod = $numargs > 5 ? func_get_arg(5) : $this->__apiAllowGetMethod;
		
		$__apiMethod = '';
		
		/// Check for GET then for POST method ... POST will overwrite GET if both exist
		if ($__apiAllowGetMethod && IsSet($HTTP_GET_VARS[$__apiFormParam]) && strlen($HTTP_GET_VARS[$__apiFormParam]) > 0) {
			$__apiFormParamValue = $HTTP_GET_VARS[$__apiFormParam];
			$__apiMethod = 'GET';
		}
		if (IsSet($HTTP_POST_VARS[$__apiFormParam]) && strlen($HTTP_POST_VARS[$__apiFormParam]) > 0) {
			$__apiFormParamValue = $HTTP_POST_VARS[$__apiFormParam];
			$__apiMethod = 'POST';
		}
		
		if ($__apiMethod == 'POST' || $__apiMethod == 'GET') {
			if ((IsSet($HTTP_POST_VARS[$__apiFormParam]) && strlen($HTTP_POST_VARS[$__apiFormParam]) > 0) || ($__apiAllowGetMethod && IsSet($HTTP_GET_VARS[$__apiFormParam]) && strlen($HTTP_GET_VARS[$__apiFormParam]) > 0)) {
				if (strlen($__apiCustomFunction) > 0) {
					/// call custom function and return value to $__apiSetToVariable
					$__apiSetToVariable = $__apiCustomFunction($__apiFormParamValue);
				} else {
					$__apiSetToVariable = $__apiFormParamValue;
				}
			} else {
				$__apiSetToVariable = $__apiDefaultValue;
			}
		} else {
			$__apiSetToVariable = $__apiDefaultValue;
		}
		if (strlen($__apiForceCaseTo) > 0) {
			if (strtoupper($__apiForceCaseTo) == 'UPPER') {
				$__apiSetToVariable = strtoupper($__apiSetToVariable);
			} else if (strtoupper($__apiForceCaseTo) == 'LOWER') {
				$__apiSetToVariable = strtolower($__apiSetToVariable);
			}
		}
	}
}
?>
