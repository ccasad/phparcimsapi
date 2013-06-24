<?php
/*
 * connector.php
 *
 * Author:  Christopher Casad
 *
 * Creation Date: 01 August 2002
 *	
 * Modified: 09 August 2002
 *
 * Purpose: 
 *
 * Notes: 
 *
 */
 
class Connector {	
	//***************************************************************
	// Set property defaults
	//***************************************************************
	var $__apiServerName = '';
	var $__apiServiceName = '';
	var $__apiServerPort = 5300;
	var $__apiVersion = 0;
	var $__apiBuild = '';
	var $__apiMap = '';
	var $__apiErrorNum = '';
	var $__apiErrorStr = '';
	var $__apiIMSError = '';
	var $__apiXMLRequest = '';
	var $__apiXMLResponse = '';
	var $__apiDepth = 0;
	var $__apiMaxDepth = 0;
	var $__apiParent = array();
	var $__apiProlog = '<?xml version="1.0" encoding="UTF-8" ?>';
	var $__apiXMLStart = '<ARCXML version="1.1">';
	var $__apiXMLEnd = '</ARCXML>';
	var $__apiEncodeType = 'UTF-8';
	var $__apiRootType = '';
	var $__apiXMLParser = '';
	var $__apiPObject = '';
	var $__apiWorkspaces = array();
	var $__apiQuery = '';
	var $__apiServices = array();  // services run on the server, populated after a GETCLIENTSERVICES request
	var $__apiFeatures = array();
	var $__apiCurrentFeature = '';  //used when feature info is read from the responds
	var $__apiEnvironment = '';
	var $__apiLayers = array();
	var $__apiLayerObjects = array();
	var $__apiRecordset = array();
	var $__apiRecord = '';
	var $__apiNumLayers = 0;
	
	//***************************************************************
	// Constructor
	//***************************************************************
	function Connector($__apiServerNameParam='',$__apiServiceNameParam='') {
		if ($__apiServerNameParam) {
			$this->__apiServerName = $__apiServerNameParam;
		}
		if ($__apiServiceNameParam) {
			$this->__apiServiceName = $__apiServiceNameParam;
		}
		return 1;
	}
	
	//***************************************************************
	// Private Methods
	//***************************************************************
	//// Start of Response Parsing Functionality /////
	function ParseXML($__apiXMLTextParam) {
		/// need to do this replace cause ampersand in the response seems to screw up the parser
		$__apiXMLTextParam = str_replace("&", "and", $__apiXMLTextParam);
		//print('<textarea cols="40" rows="7">' . str_replace('xml version="1.0" encoding="UTF-8"','',$__apiXMLTextParam) . '</textarea><br>');
		
		$__apiXMLParser = xml_parser_create($this->__apiEncodeType);
		xml_set_object($__apiXMLParser, &$this);
		xml_set_element_handler($__apiXMLParser, "StartElement", "EndElement");
		xml_set_character_data_handler($__apiXMLParser, "CData");
		$this->__apiDepth = 0;
		$this->__apiParent = array();
		$this->__apiPObject = array();
		$this->__apiIMSError = array();
		xml_parse($__apiXMLParser, $__apiXMLTextParam);
		xml_parser_free($__apiXMLParser);
		return 1;
	}
    function StartElement($__apiParserParam, $__apiNameParam, $__apiAttsParam=''){
		switch ($__apiNameParam) {
		    case 'ARCXML':
		        $this->__apiArcXmlVersion = $__apiAttsParam['VERSION'];
		        break;
		    case 'RESPONSE':
				break;
		    case 'CONFIG':
				break;
		    case 'MARKUP':
				break;
		    case 'REQUEST':
		        $this->__apiRootType = $__apiNameParam;
		        break;
			// aje 7/06/2002 error handling
			case 'ERROR':
				$this->__apiErrorNum = 1;
				if ($__apiAttsParam['MACHINE']) $this->__apiIMSError['MACHINE'] = $__apiAttsParam['MACHINE'];
				if ($__apiAttsParam['PROCESSID']) $this->__apiIMSError['PROCESSID'] = $__apiAttsParam['PROCESSID'];
				if ($__apiAttsParam['THREADID']) $this->__apiIMSError['THREADID'] = $__apiAttsParam['THREADID'];
				break;
			case 'IMAGE':
				break;
		    case 'SERVICEINFO':
				break;
		    case 'ENVIRONMENT':
		        //  no attributes
		        break;
			case 'LOCALE':
				/*
				switch ($this->__apiParent[$this->__apiDepth-2]) {
				case 'SERVICE':
				   $tmp=$this->__apiServices[count($this->__apiServices)-1]['Environment'];
				   $tmp['LOCALE']['language']=$__apiAttsParam['LANGUAGE'];
				   if ($__apiAttsParam['COUNTRY']) $tmp['LOCALE']['country']=$__apiAttsParam['COUNTRY'];
				   if ($__apiAttsParam['VARIANT']) $tmp['LOCALE']['variant']=$__apiAttsParam['VARIANT'];
				   $this->__apiServices[count($this->__apiServices)-1]['Environment']=$tmp;
				   break;
				default:
				   $this->__apiEnvironment['LOCALE']['language']=$__apiAttsParam['LANGUAGE'];
				   if ($__apiAttsParam['COUNTRY']) $this->__apiEnvironment['LOCALE']['country']=$__apiAttsParam['COUNTRY'];
				   if ($__apiAttsParam['VARIANT']) $this->__apiEnvironment['LOCALE']['variant']=$__apiAttsParam['VARIANT'];
				   break;
				}
				*/
			    break;
			case 'UIFONT':
				/*
				switch ($this->__apiParent[$this->__apiDepth-2]) {
				case 'SERVICE':
				   $tmp=$this->__apiServices[count($this->__apiServices)-1]['Environment'];
				   $tmp['UIFONT']['name']=$__apiAttsParam['NAME'];
				   if ($__apiAttsParam['COLOR']) $tmp['UIFONT']['color']=$__apiAttsParam['COLOR'];
				   if ($__apiAttsParam['SIZE']) $tmp['UIFONT']['size']=$__apiAttsParam['SIZE'];
				   if ($__apiAttsParam['STYLE']) $tmp['UIFONT']['size']=$__apiAttsParam['STYLE'];
				   $this->__apiServices[count($this->__apiServices)-1]['Environment']=$tmp;
				   break;
				default:
				   $this->__apiEnvironment['UIFONT']['name']=$__apiAttsParam['NAME'];
				   if ($__apiAttsParam['COLOR']) $this->__apiEnvironment['UIFONT']['color']=$__apiAttsParam['COLOR'];
				   if ($__apiAttsParam['SIZE']) $this->__apiEnvironment['UIFONT']['size']=$__apiAttsParam['SIZE'];
				   if ($__apiAttsParam['STYLE']) $this->__apiEnvironment['UIFONT']['style']=$__apiAttsParam['STYLE'];
				   break;
				}
				*/
				break;
			case 'SCREEN':
				/*
				switch ($this->__apiParent[$this->__apiDepth-2]) {
				case 'SERVICE':
				   $tmp=$this->__apiServices[count($this->__apiServices)-1]['Environment'];
				   $tmp['SCREEN']['dpi']=$__apiAttsParam['DPI'];
				   $this->__apiServices[count($this->__apiServices)-1]['Environment']=$tmp;
				   break;
				default:
				   $this->__apiEnvironment['SCREEN']['dpi']=$__apiAttsParam['DPI'];
				   break;
				}
				*/
				break;
			case 'SEPARATORS':
				/*
				switch ($this->__apiParent[$this->__apiDepth-2]) {
				case 'SERVICE':
				   $tmp=$this->__apiServices[count($this->__apiServices)-1]['Environment'];
				   if ($__apiAttsParam['CS']) $tmp['SEPARATORS']['cs']=$__apiAttsParam['CS'];
				   if ($__apiAttsParam['TS']) $tmp['SEPARATORS']['ts']=$__apiAttsParam['TS'];
				   $this->__apiServices[count($this->__apiServices)-1]['Environment']=$tmp;
				   break;
				default:
				   if ($__apiAttsParam['CS']) $this->__apiEnvironment['SEPARATORS']['cs']=$__apiAttsParam['CS'];
				   if ($__apiAttsParam['TS']) $this->__apiEnvironment['SEPARATORS']['ts']=$__apiAttsParam['TS'];
				   break;
				}
				*/
				break;
			case 'SERVICE':
				/*
				$tmp['NAME']=$__apiAttsParam['NAME'];
				$tmp['SERVICEGROUP']=$__apiAttsParam['SERVICEGROUP'];
				$tmp['ACCESS']=$__apiAttsParam['ACCESS'];
				$tmp['TYPE']=$__apiAttsParam['TYPE'];
				$tmp['DESC']=$__apiAttsParam['DESC'];
				$tmp['STATUS']=$__apiAttsParam['STATUS'];
				$this->__apiServices[]=$tmp;
				*/
				break;
			case 'SERVICES':
			    /*
			    $this->__apiServices=array();
			    */
			    break;
			case 'ENVELOPE':
				$__apiEnvelope = new Envelope($__apiAttsParam['MAXX'],$__apiAttsParam['MAXY'],$__apiAttsParam['MINX'],$__apiAttsParam['MINY']);
				switch ($this->__apiParent[$this->__apiDepth-1]) {
					/*
					case 'FCLASS':
					   $this->__apiLayers[count($this->__apiLayers)-1]->setEnvelope($__apiEnvelope);
					   break;
					case 'PARTITION':
					   break;
					case 'SPATIALFILTER':
					   break;
					case 'LAYERINFO':
					   break;
					case 'PARTITION':
					   break;
					*/
					case 'EXTRACT':
						break;
					case 'FEATURES':
					   unset($this->__apiMap->__apiTempImageEnvelope);
					   $this->__apiMap->__apiTempImageEnvelope = $__apiEnvelope;
					   break;
					case 'FEATURE':
					   unset($this->__apiMap->__apiTempImageEnvelope);
					   $this->__apiMap->__apiTempImageEnvelope = $__apiEnvelope;
					   $this->__apiFeatures['DATASET'][$this->__apiCurrentFeature]['ENVELOPE'] = $__apiEnvelope;
					   //$__apiTmpEnvelope = $__apiEnvelope;
					   break;
					case 'PROPERTIES':
					   unset($this->__apiMap->__apiImageEnvelope);
					   $this->__apiMap->__apiImageEnvelope = $__apiEnvelope;
					   break;
					case 'IMAGE':
					   unset($this->__apiMap->__apiImageEnvelope);
					   $this->__apiMap->__apiImageEnvelope = $__apiEnvelope;
					   break;
					default:
					   return 0;
				}
				break;
			case 'FEATURECOORDSYS':
				/*
				if ($__apiAttsParam['ID']) $p1 = $__apiAttsParam['ID'];
				else $p1 = $__apiAttsParam['STRING'];
				if (count($__apiAttsParam)==1) {
				   $l = new arcFeatureCoordsys($p1);
				} else {
				   if ($__apiAttsParam['DATUMTRANSFORMID']) $l = new arcFeatureCoordsys($p1,$__apiAttsParam['DATUMTRANSFORMID']);
				   else $l = new arcFeatureCoordsys($p1,$__apiAttsParam['DATUMTRANSFORMSTRING']);
				}
				$this->FeatureCoordsys=$l;
				*/
				break;
			case 'FILTERCOORDSYS':
				/*
				if ($__apiAttsParam['ID']) $p1 = $__apiAttsParam['ID'];
				else $p1 = $__apiAttsParam['STRING'];
				if (count($__apiAttsParam)==1) {
				   $l = new arcFilterCoordsys($p1);
				} else {
				   if ($__apiAttsParam['DATUMTRANSFORMID']) $l = new arcFilterCoordsys($p1,$__apiAttsParam['DATUMTRANSFORMID']);
				   else $l = new arcFilterCoordsys($p1,$__apiAttsParam['DATUMTRANSFORMSTRING']);
				}
				$this->FilterCoordsys=$l;
				*/
				break;
			case 'FEATURECOUNT':
			    $this->__apiFeatures['COUNT'] = $__apiAttsParam['COUNT'];
			    $this->__apiFeatures['HASMORE'] = $__apiAttsParam['HASMORE'];
				if ($this->__apiRecordset) {
					$this->__apiRecordset->__apiRecordCount = $this->__apiFeatures['COUNT'];
				}
			    break;
			case 'FEATURES':
				$this->__apiCurrentFeature = 0;
			    $this->__apiRecordset = new Recordset();
				break;
			case 'FEATURE':
				switch ($this->__apiParent[$this->__apiDepth-1]) {
				 case 'FEATURES':
				    $this->__apiRecord = array();
				    break;
				 case 'GEOCODE':
				    break;
				}
				break;
			case 'FIELD':
				switch ($this->__apiParent[$this->__apiDepth-1]) {
					case 'FIELDS':
						if ($__apiAttsParam['NAME'] != '#ID#' && $__apiAttsParam['NAME'] != '#SHAPE#') {
							$this->__apiRecord[$__apiAttsParam['NAME']] = $__apiAttsParam['VALUE'];
							$this->__apiRecordset->AddField($__apiAttsParam['NAME']);
						}
				    	break;
				 	default:
						/*
					    $l = new arcField($__apiAttsParam['NAME']);
					    $l->Type=$__apiAttsParam['TYPE'];
					    if (isset($__apiAttsParam['PRECISION'])) $l->Precision=$__apiAttsParam['PRECISION'];
					    if (isset($__apiAttsParam['SIZE'])) $l->Size=$__apiAttsParam['SIZE'];
					    $this->__apiLayers[count($this->__apiLayers)-1]->addField($l);
						*/
				}
				break;
			case 'FIELDS':
				/// this is for outputmode=xml
				/// echo '<br> BLDG_NUM=' . $__apiAttsParam['BLDG_NUM'];
			    break;
			case 'LAYERINFO':
				//parent tag is always RESPONSE
				/*
				$l = new arcLayer($__apiAttsParam['ID'], $__apiAttsParam['TYPE'], ($__apiAttsParam['NAME']?$__apiAttsParam['NAME']:''),($__apiAttsParam['MINSCALE']?$__apiAttsParam['MINSCALE']:0),($__apiAttsParam['MAXSCALE']?$__apiAttsParam['MAXSCALE']:0), (strtolower($__apiAttsParam['VISIBLE'])=='true'?1:0), 1);
				if ($this->returnLayer($l->Name,$index)) {
				   if ($this->__apiLayers[$index]->Service)
				      $this->__apiLayers[$index]=$l;
				}else{
				   $this->__apiLayers[]=$l;
				}
				*/
				break;
			case 'LEGEND':
				/*
				switch ($this->__apiParent[$this->__apiDepth-1]) {
				case 'IMAGE':
				   $this->LegendURL=$__apiAttsParam['URL'];
				   $this->LegendFile=$__apiAttsParam['FILE'];
				   break;
				case 'PROPERTIES':
				   $this->LegendInfo=$__apiAttsParam;
				   break;
				default:
				   return 0;
				}
				*/
				break;
			case 'FCLASS':
				//parent tag is always LAYERINFO
				/*
				$d = new arcDataset('unkown','unkown',$__apiAttsParam['TYPE']);
				$this->__apiLayers[count($this->__apiLayers)-1]->setDataset($d);
				*/
				break;
			case 'LAYER':
				/*
				$l = new arcLayer($__apiAttsParam['ID'], $__apiAttsParam['TYPE'], ($__apiAttsParam['NAME']?$__apiAttsParam['NAME']:''),($__apiAttsParam['MAXSCALE']?$__apiAttsParam['MAXSCALE']:0),($__apiAttsParam['MINSCALE']?$__apiAttsParam['MINSCALE']:0), ($__apiAttsParam['VISIBLE']?$__apiAttsParam['VISIBLE']:1), 1);
				if ($this->returnLayer($l->Name,$index)) {
				   if ($this->__apiLayers[$index]->Service)
				      $this->__apiLayers[$index]=$l;
				}else{
				   $this->__apiLayers[]=$l;
				}
				*/
				break;
			case 'DATASET':
				/*
				$this->returnWorkspace($__apiAttsParam['WORKSPACE'],$wIndex);
				$d = new arcDataset($__apiAttsParam['NAME'],$this->__apiWorkspaces[$wIndex],$__apiAttsParam['TYPE']);
				$this->__apiLayers[(count($this->__apiLayers)-1)]->setDataset($d);
				*/
				break;
			case 'SHAPEWORKSPACE':
				/*
				$w = new arcShapeWorkspace($__apiAttsParam['NAME'],$__apiAttsParam['DIRECTORY'],
				                                 ($__apiAttsParam['CODEPAGE']?$__apiAttsParam['CODEPAGE']:''),
				                                 ($__apiAttsParam['GEOINDEXDIR']?$__apiAttsParam['GEOINDEXDIR']:''),
				                                 ($__apiAttsParam['SHARED']?$__apiAttsParam['SHARED']:''));
				$this->__apiWorkspaces[]=$w;
				*/
				break;
			case 'IMAGEWORKSPACE':
				/*
				$w = new arcShapeWorkspace($__apiAttsParam['NAME'],$__apiAttsParam['DIRECTORY']);
				$this->__apiWorkspaces[]=$w;
				*/
				break;
			case 'SDEWORKSPACE':
				/*
				$w = new arcSDEWorkspace($__apiAttsParam['NAME'],$__apiAttsParam['INSTANCE'],$__apiAttsParam['SERVER'],$__apiAttsParam['USER'],$__apiAttsParam['PASSWORD'],
				                         ($__apiAttsParam['DATABASE']?$__apiAttsParam['DATABASE']:''),
				                         ($__apiAttsParam['ENCRYPTED']?$__apiAttsParam['ENCRYPTED']:''),
				                         ($__apiAttsParam['GEOINDEXDIR']?$__apiAttsParam['GEOINDEXDIR']:''));
				$this->__apiWorkspaces[]=$w;
				*/
				break;
			case 'POINT':
				break;
			case 'MULTIPOINT':
			    break;
			case 'POLYGON':
			    break;
			case 'LINE':
			    break;
			case 'POLYLINE':
			    break;
			case 'MAPUNITS':
			    $this->__apiMap->__apiUnits = $__apiAttsParam['UNITS'];
			    break;
			case 'OUTPUT':
				switch ($this->__apiParent[$this->__apiDepth-1]){
					case 'PROPERTIES':
				    	break;
					case 'IMAGE':
					    $this->__apiMap->__apiImageURL = $__apiAttsParam['URL'];
					    $this->__apiMap->__apiImageFile = $__apiAttsParam['FILE'];
					    if ($__apiAttsParam['WIDTH']) $this->__apiMap->__apiImageSize['width'] = $__apiAttsParam['WIDTH'];
					    if ($__apiAttsParam['HEIGHT']) $this->__apiMap->__apiImageSize['height'] = $__apiAttsParam['HEIGHT'];
						break;
				 	case 'EXTRACT':
						$this->__apiMap->__apiExtractZipURL = $__apiAttsParam['URL'];
				    	break;
				 	default:
				    	return 0;
				}
				break;

			default:
		}
		$__apiCP = $__apiAttsParam;
		$this->__apiParent[$this->__apiDepth] = $__apiNameParam;
		$this->__apiPObject[$this->__apiDepth] = $__apiCP;
		$this->__apiDepth++;
		if ($this->__apiDepth > $this->__apiMaxDepth) $this->__apiMaxDepth = $this->__apiDepth;
	}
	function EndElement($__apiParserParam, $__apiNameParam){
		$this->__apiDepth--;
		$__apiCP = $this->__apiPObject[$this->__apiDepth];  //get object of current tag
		$l = $this->__apiPObject[$this->__apiDepth-1]; //get parent object of current tag
		//check to make sure that other child tag which same name does not exist
		$this->__apiPObject[$this->__apiDepth-1] = $l;

		switch ($__apiNameParam) {
			case 'SIMPLERENDERER':
				//adding other renderers as well for future use
			   switch ($this->__apiPObject[$this->__apiDepth-1]) {
				   case 'LAYER':
				      $lo=$this->__apiLayerObjects[$this->__apiNumLayers-1];
				      $lo['RENDERER']=$__apiCP;
				      $this->__apiLayerObjects[$this->__apiNumLayers-1]=$lo;
				      break;
			   }
			   break;
			case 'FEATURE':
			   switch ($this->__apiParent[$this->__apiDepth-1]) {
				   case 'GEOCODE':
				      break;
				   case 'FEATURES':
						$this->__apiCurrentFeature++;
						$this->__apiRecordset->AddRecord($this->__apiRecord);
						$this->__apiRecord = array();
				      	break;
				   case 'DELETEDFEATURES':
				      break;
				   case 'ADDEDFEATURES':
				      break;
				   case 'MODIFIEDFEATURES':
			   }
			   break;
			case 'FIELD':
			   switch ($this->__apiParent[$this->__apiDepth-1]) {
			   case 'FIELDS':
			      break;
			   case 'SQVAR':
			      break;
			   case 'FCLASS':
			      break;
			   case 'FEATURE':
			      break;
			   }
			   break;
			case 'FIELDS':
				break;
			case 'ENVELOPE':
			   switch ($this->__apiParent[$this->__apiDepth-1]) {
				   case 'FCLASS':
				      break;
				   case 'PROPERTIES':
				      break;
				   case 'PARTITION':
				      break;
				   case 'EXTRACT':
				      break;
				   case 'SPATIALFILTER':
				      break;
				   case 'FEATURE':
				      break;
				   case 'IMAGE':
				      break;
				   default:
				      return 0;
				}
		}
	}
	function CData($__apiParserParam,$cdata='') {
		switch ($this->__apiParent[$this->__apiDepth-1]) {
			case 'ERROR':
				//echo "IMS error: $cdata<br>";
				$this->__apiIMSError['ERROR']=$cdata;
				break;
		}
	}
	//// End of Response Parsing Functionality /////
	
	//***************************************************************
	// Public Methods
	//***************************************************************
	function SendRequest($__apiRequestParam) {	
		if (stristr($__apiRequestParam,'GET_FEATURE')) $__apiType='f';
		else if (stristr($__apiRequestParam,'GET_IMAGE')) $__apiType='i';
		else if (stristr($__apiRequestParam,'GET_GEOCODE')) $__apiType='g';
		else if (stristr($__apiRequestParam,'GET_SERVICE_INFO'))  $__apiType='s';
		else if (stristr($__apiRequestParam,'GET_EXTRACT')) $__apiType='e';
		else if (stristr($__apiRequestParam,'GETCLIENTSERVICES')) $__apiType='c';
		else return 0;
		
		$this->__apiXMLRequest = $this->__apiProlog."\r\n";
        $this->__apiXMLRequest .= $this->__apiXMLStart;
		$this->__apiXMLRequest .= str_replace("><",">\r\n<",$__apiRequestParam);
		$this->__apiXMLRequest .= $this->__apiXMLEnd;
		
		$fp=fsockopen($this->__apiServerName,$this->__apiServerPort,$this->__apiErrorNum,$this->__apiErrorStr,30);
        if (!$fp) {
 			return 0;
        }
		
	    switch ($__apiType) {
	        case 'c':
	           //service information  GETCLIENTSERVICES
	           $pkg1='ServiceName=catalog&Form=true&Encode=true';
	           $pkg2=$this->__apiXMLRequest.chr(0).chr(0).chr(0).'1AllowRequestOutput=False&AllowResponsePath=False&';
	           break;
	        case 's':
	           //service information  GET_SERVICE_INFO
	           $pkg1='ServiceName='.$this->__apiServiceName.'&Form=true&Encode=true';
	           $pkg2=$this->__apiXMLRequest.chr(0).chr(0).chr(0).'1AllowRequestOutput=False&AllowResponsePath=False&';
	           break;
	        case 'i':
	           //catalog information   GET_IMAGE/GET_LEGEND
	           $pkg1='ServiceName='.$this->__apiServiceName.'&Form=true&Encode=true';
	           $pkg2=$this->__apiXMLRequest.chr(0).chr(0).chr(0).'1AllowRequestOutput=False&AllowResponsePath=False&';
	           break;
	        case 'f':
	           //GET_FEATURES
	           $pkg1='ServiceName='.$this->__apiServiceName.'&CustomService=Query&Form=true&Encode=true';
	           $pkg2=$this->__apiXMLRequest.chr(0).chr(0).chr(0).'1AllowRequestOutput=False&AllowResponsePath=False&';
	           break;
	        case 'g':
	           //GET_GEOCODE
	           $pkg1='ServiceName='.$this->__apiServiceName.'&CustomService=Geocode&Form=true&Encode=true';
	           $pkg2=$this->__apiXMLRequest.chr(0).chr(0).chr(0).'1AllowRequestOutput=False&AllowResponsePath=False&';
	        case 'e':
	           //GET_EXTRACT
	           $pkg1='ServiceName='.$this->__apiServiceName.'&CustomService=Extract&Form=true&Encode=true';
	           $pkg2=$this->__apiXMLRequest.chr(0).chr(0).chr(0).'1AllowRequestOutput=False&AllowResponsePath=False&';
		}
		
        //send the first package to initiate communication
        fputs($fp,'',0);

        //new calculate the length of the XMLRequest header (1st package), it's sent along with the first package
        $n=base_convert(strlen($pkg1),10,16);
        $s='';
        for ($i=strlen($n)-2;$i>=0;$i-=2) $s=chr(base_convert(substr($n,$i,2),16,10)).$s;
        if (!is_long((strlen($n)/2))) $s=chr(base_convert(substr($n,0,1),16,10)).$s;
        $s=str_pad($s,4,chr(0),STR_PAD_LEFT);
        $pkg1=$s.$pkg1.chr(0).chr(0).chr(0).chr(3);

        //now calculate the length of the XMLRequest, since it's send in the header of the first package
        $n=base_convert(strlen($this->__apiXMLRequest),10,16);
        $s='';
        for ($i=strlen($n)-2;$i>=0;$i-=2) $s=chr(base_convert(substr($n,$i,2),16,10)).$s;
        if (!is_long((strlen($n)/2))) $s=chr(base_convert(substr($n,0,1),16,10)).$s;
        $s=str_pad($s,4,chr(0),STR_PAD_LEFT);

        //send the first package to let the server know of the type and size (in bytes) of the request
        fputs($fp,$pkg1.$s,strlen($pkg1.$s));
        $null=fgets($fp,0);
		
		//print('<br>//__apiServiceName(in connector)=' . $this->__apiServiceName);
        //send the actuall ArcXML request and read response (is the response ArcXML)
        fputs($fp,$pkg2,strlen($pkg2));
		
		//print('<br>//REQUEST_SENT=' . Date('H:i:s') . ' ' . number_format(microtime(),3) . ' type=' . $__apiType);
		
        $this->__apiXMLResponse='';
        while (!feof($fp)) {
			//$this->__apiXMLResponse.=fgets($fp,128);
			$this->__apiXMLResponse.=fgets($fp,1024);
		   //$this->__apiXMLResponse .= fread($fp, 4096);
        }

        fclose($fp);
		
		//print('<br>//RESPONSE_RECEIVED=' . Date('H:i:s') . ' ' . number_format(microtime(),3) . ' type=' . $__apiType . '<br><br>');
		
		/// Deal with the response
        $this->ParseXML($this->__apiXMLResponse);
		
        return 1;
	}
	
	function GetArcIMSVersion() {
		$fp = fsockopen($this->__apiServerName,$this->__apiServerPort,$this->__apiErrorNum,$this->__apiErrorStr,1);
		if (!$fp) {
			return 0;
		}else{
			fputs($fp,'',0);
			$str=chr(0).chr(0).chr(0).chr(14).'Cmd=getVersion'.chr(0).chr(0).chr(0).chr(2).chr(0).chr(0).chr(0).chr(1);
			$len=strlen($str);
			fputs($fp,$str,$len);
			$null=fgets($fp,0);
			fputs($fp,chr(1),1);
		}
		/* getting response */
		$ver=array();
		$rec=array();
		while (!feof($fp)) {
		   $rec[] = fgets($fp,128);
		   if (strpos($rec[count($rec)-1],'uild')) $ver[0]=$rec[count($rec)-1];
		   if (strpos($rec[count($rec)-1],'ersion=')) $ver[1]=$rec[count($rec)-1];
		}

		if (is_array($rec)) {
		   if (count($ver)==2) {
		      $this->__apiErrorNum = 1;
		      $this->__apiErrorStr = 'OK';
		      $this->__apiBuild=substr($ver[0],strpos($ver[0],'=')+1);
		      $this->__apiVersion=substr($ver[1],strpos($ver[1],'=')+1);
		      fclose($fp);
		      return 1;
		   } else {
		      $this->__apiErrorNum = -11;
		      $this->__apiErrorStr = 'Not correct responds from web server';
		   }
		} else {
		   $this->__apiErrorNum = -10;
		   $this->__apiErrorStr = 'ArcIMS error';
		}
		fclose($fp);
		return 0;
	}
}
?>
