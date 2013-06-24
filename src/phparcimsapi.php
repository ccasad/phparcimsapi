<?php
class APIObject {
	//***************************************************************
	// Set property defaults
	//***************************************************************
	var $__apiLoaded = false;
	var $__apiLibraryPath = '';
	var $__apiPackages = array();
	var $__apiErrorHandling = true;
	var $__apiReturnErrors = true;
	
	//***************************************************************
	// Public constructor
	//***************************************************************
    function APIObect() {
		$numargs = func_num_args();
		$this->__apiLoaded = $numargs > 0 ? func_get_arg(0) : $__apiLoaded;
		$this->__apiLibraryPath = $numargs > 1 ? func_get_arg(1) : $__apiLibraryPath;
		$this->__apiPackages = $numargs > 2 ? func_get_arg(2) : $__apiPackages;
		$this->__apiErrorHandling = $numargs > 3 ? func_get_arg(3) : $__apiErrorHandling;
		$this->__apiReturnErrors = $numargs > 4 ? func_get_arg(4) : $__apiReturnErrors;
	}	

	//***************************************************************
	// Public Methods
	//***************************************************************
	function SetLibraryPath($__apiPathParam) {
		if (substr($__apiPathParam,-1) != '/') {
			$__apiPathParam .= '/';
		}
		$this->__apiLibraryPath = $__apiPathParam;
	}
	function AddPackage($__apiPackParam) {
		if ($this->__apiPackages[$__apiPackParam]) {
			return;
		}
		$__apiPackage = new Package();
		$this->__apiPackages[$__apiPackParam] = $__apiPackage->__packageLibs;
	}
	function AddLibrary($__apiPathParam, $__apiFilesParam) {
		$__apiPack = substr($__apiPathParam,0,strpos($__apiPathParam,'.'));
		if (!$__apiPack) {
			print('API Error: Incorrect API.addLibrary usage');
			return;
		}
		$__apiName = substr($__apiPathParam,strpos($__apiPathParam,'.')+1);
		if (!$this->__apiPackages[$__apiPack]) {
			$this->AddPackage($__apiPack);
		}
		if ($this->__apiPackages[$__apiPack]->__apiLibs[$__apiName]) {
			print('API Error: Library ' . $__apiName . ' already exists');
			return;
		}
		$this->__apiPackages[$__apiPack]->__apiLibs[$__apiName] = $__apiFilesParam;
	}	
	function SetInclude($__apiSrcParam) {
		$__apiSrcArray = split('\.', $__apiSrcParam);
		$__apiSrcCount = count($__apiSrcArray);
		if ($__apiSrcArray[$__apiSrcCount-1] == 'php') {
			$__apiSrcCount -= 1;
		}
		
		$__apiPath = $this->__apiLibraryPath;
		if (substr($__apiPath, -1) != '/') {
			$__apiPath .= '/';
		}
		$__apiPck = $__apiSrcArray[0];
		$__apiGrp = $__apiSrcArray[1];
		$__apiFile = $__apiSrcArray[2];
		if ($__apiFile == "*") {
			if ($this->__apiPackages[$__apiPck]) {
				$__apiGroup = $this->__apiPackages[$__apiPck]->__apiLibs[$__apiGrp];
			}
			if ($__apiGroup) {
				for ($i = 0;$i < count($__apiGroup);$i++) {
					include($__apiPath . $__apiPck . '/' . $__apiGrp . '/' . $__apiGroup[$i] . '.php');
				}
			} else {
				echo 'The following package could not be loaded: ' . $__apiSrcArray . ' <br>Make sure you specified the correct path.';
			}
		} else {
			include($__apiPath . $__apiPck . '/' . $__apiGrp . '/' . $__apiFile . '.php');
		}
	}
}

class Package {
	//***************************************************************
	// Set property defaults
	//***************************************************************
	var $__packageLibs = array();
	
	//***************************************************************
	// Public constructor
	//***************************************************************
    function Package() {
		$numargs = func_num_args();
		$this->__packageLibs = $numargs > 0 ? func_get_arg(0) : $__packageLibs;
	}	
}

$phpArcIMSAPI = new APIObject();
$phpArcIMSAPI->AddPackage('phparcimsapi');
$phpArcIMSAPI->AddLibrary('phparcimsapi.acetate', array('acetatelegend','acetateoverviewmap','copyright','northarrow','scalebar'));
$phpArcIMSAPI->AddLibrary('phparcimsapi.api', array('background','connector','constants','functions','get_extract','get_features','get_image','get_service_info','imagesize','properties','recordset','request','stateobject'));
$phpArcIMSAPI->AddLibrary('phparcimsapi.custom', array('floodfunctions','getacetatelayer','pdfmap','receivegetfeaturesresponse','sendgetfeaturesrequest','sendgetimagerequest','sendgetserviceinforequest'));
$phpArcIMSAPI->AddLibrary('phparcimsapi.map', array('buffer','dataset','envelope','layer','layerdef','layerlist','map','query','spatialfilter','spatialquery','targetlayer'));
$phpArcIMSAPI->AddLibrary('phparcimsapi.object', array('line','point','polygon','text','xobject'));
$phpArcIMSAPI->AddLibrary('phparcimsapi.renderer', array('grouprenderer','rangeobject','scaledependentrenderer','simplelabelrenderer','simplerenderer','valuemaprenderer'));
$phpArcIMSAPI->AddLibrary('phparcimsapi.symbol', array('rastermarkersymbol','simplelinesymbol','simplemarkersymbol','simplepolygonsymbol','textmarkersymbol','textsymbol'));
?>