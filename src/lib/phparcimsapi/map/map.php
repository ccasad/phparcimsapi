<?php
class Map {
	//***************************************************************
	// Set property defaults
	//***************************************************************
	var $__apiName = '';
	var $__apiImageEnvelope = '';
	var $__apiImageURL = '';
	var $__apiImageFile = '';
	var $__apiImageSize = '';
	var $__apiImageBackground = '';
	var $__apiUnits = '';
	var $__apiInitialImageEnvelope = '';
	var $__apiBufferedImageEnvelope = '';
	var $__apiMaxImageEnvelope = '';
	var $__apiMinImageEnvelope = '';
	var $__apiTempImageEnvelope = '';
	var $__apiLegendURL = '';
	var $__apiLegendFile = '';
	var $__apiMessage = '';
	var $__apiOverviewMap = 0;
	var $__apiExtractZipURL = '';
	var $__apiScreenDPI = 96;
	var $__apiMapScale = '';
	var $__apiPrintSize = array('width' => 400, 'height' => 400);
	var $__apiScaleSymbols = false;
	
	//***************************************************************
	// Public Methods
	//***************************************************************
	function SetImageBackground($__apiParam) {
		$this->__apiImageBackground = $__apiParam;
	}
	function SetImageSize($__apiWidthParam, $__apiHeightParam) {
		$this->__apiImageSize['width'] = $__apiWidthParam;
		$this->__apiImageSize['height'] = $__apiHeightParam;
	}
	function GetImageWidth() {
		return $this->__apiImageSize['width'];
	}
	function GetImageHeight() {
		return $this->__apiImageSize['height'];
	}
	function GetMapWidth(){
		return abs($this->__apiImageEnvelope->__apiMaxX - $this->__apiImageEnvelope->__apiMinX);
	}
	function GetMapHeight(){
		return abs($this->__apiImageEnvelope->__apiMaxY - $this->__apiImageEnvelope->__apiMinY);
	}
	function GetMaxMapWidth(){
		return abs($this->__apiMaxImageEnvelope->__apiMaxX - $this->__apiMaxImageEnvelope->__apiMinX);
	}
	function GetMaxMapHeight(){
		return abs($this->__apiMaxImageEnvelope->__apiMaxY - $this->__apiMaxImageEnvelope->__apiMinY);
	}
	function GetMinMapWidth(){
		return abs($this->__apiMinImageEnvelope->__apiMaxX - $this->__apiMinImageEnvelope->__apiMinX);
	}
	function GetMinMapHeight(){
		return abs($this->__apiMinImageEnvelope->__apiMaxY - $this->__apiMinImageEnvelope->__apiMinY);
	}
	function GetMapMinX(){
		return $this->__apiImageEnvelope->__apiMinX;
	}
	function GetMapMaxX(){
		return $this->__apiImageEnvelope->__apiMaxX;
	}
	function GetMapMinY(){
		return $this->__apiImageEnvelope->__apiMinY;
	}
	function GetMapMaxY(){
		return $this->__apiImageEnvelope->__apiMaxY;
	}
	function GetPrintWidth() {
            return $this->__apiPrintSize['width'];
        }
        function GetPrintHeight() {
            return $this->__apiPrintSize['height'];
        }
        function GetScaleSymbols() {
            return $this->__apiScaleSymbols;
        }
        function SetPrintSize($__apiWidthParam, $__apiHeightParam) {
            $this->__apiPrintSize['width'] = $__apiWidthParam;
            $this->__apiPrintSize['height'] = $__apiHeightParam;
        }
        function SetScaleSymbols($__apiParam) {
            $this->__apiScaleSymbols = $__apiParam;
        }
	function GetMapScale($__apiParam){
		$pixelsPerInch = 97.69230769;
        $pixelsPerMile = 63360 * $pixelsPerInch;
        $pixelsPerFoot = 12.0 * $pixelsPerInch;
        $pixelsPerKilometer = 39370.07874016 * $pixelsPerInch;
        $pixelsPerMeter = 39.37007874 * $pixelsPerInch;
        $pixelsPerCentimeter = 0.39370079 * $pixelsPerInch;

		$mapScaleFactor = $this->GetMapWidth() / $this->GetImageWidth();
		
		switch ($__apiParam) {
			case 'centimeters':
				$this->__apiMapScale = $mapScaleFactor * $pixelsPerCentimeter;
		        break;
			case 'decimaldegrees':
				// not implemented
				break;
			case 'feet':
		        $this->__apiMapScale = $mapScaleFactor * $pixelsPerFoot;
		        break;
			case 'inches':
				$this->__apiMapScale = $mapScaleFactor * $pixelsPerInch;
		        break;
			case 'kilometers':
				$this->__apiMapScale = $mapScaleFactor * $pixelsPerKilometer;
		        break;
			case 'meters':
				$this->__apiMapScale = $mapScaleFactor * $pixelsPerMeter;
		        break;
			case 'miles':
				$this->__apiMapScale = $mapScaleFactor * $pixelsPerMile;
		        break;
		}
		
		//$inchesPerFoot = 12;
		//$this->__apiMapScale = $mapScaleFactor * $inchesPerFoot * $this->__apiScreenDPI;
		
		return $this->__apiMapScale;
	}
	function SetMessage($__apiParam) {
		$this->__apiMessage = $__apiParam;
	}
	function IsAtFullExtent() {
		if ($this->__apiImageEnvelope == $this->__apiMaxImageEnvelope) {
			return 1;
		} else {
			return 0;
		}
	}
	function ZoomFullExtent() { 
		$this->__apiImageEnvelope->__apiMaxX = $this->__apiMaxImageEnvelope->__apiMaxX;
		$this->__apiImageEnvelope->__apiMinX = $this->__apiMaxImageEnvelope->__apiMinX;
		$this->__apiImageEnvelope->__apiMaxY = $this->__apiMaxImageEnvelope->__apiMaxY;
		$this->__apiImageEnvelope->__apiMinY = $this->__apiMaxImageEnvelope->__apiMinY;
	}
	function Pan() {
		return $this->Zoom(1);
	}
	function ZoomIn($__apiFactorParam=2) {
		return $this->Zoom($__apiFactorParam);
	}
	function ZoomOut($__apiFactorParam=2){
		return $this->Zoom(1/$__apiFactorParam);
	}
	function Zoom($__apiFactorParam){
		$__apiWidth = $this->GetMapWidth();
		$__apiHeight = $this->GetMapHeight();
		
		$__apiCenterX = $this->__apiImageEnvelope->__apiMinX + ($__apiWidth / 2);
		$__apiCenterY = $this->__apiImageEnvelope->__apiMinY + ($__apiHeight / 2);
		
		$__apiWidth = $__apiWidth / ($__apiFactorParam * 2);
		$__apiHeight = $__apiHeight / ($__apiFactorParam * 2);
		
		$this->__apiImageEnvelope->__apiMinX = $__apiCenterX - $__apiWidth;
		$this->__apiImageEnvelope->__apiMaxX = $__apiCenterX + $__apiWidth;
		$this->__apiImageEnvelope->__apiMinY = $__apiCenterY - $__apiHeight;
		$this->__apiImageEnvelope->__apiMaxY = $__apiCenterY + $__apiHeight;
	}
	function Identify($__apiXParam, $__apiYParam) {	
		$__apiPixelTolerance = 1 / 100;
 		$__apiTolerance = ($this->GetMapWidth() / $this->GetImageWidth()) * $__apiPixelTolerance;
 		
		$__apiBufferedImageEnvelope = new Envelope();
 		$this->__apiBufferedImageEnvelope->__apiMinX = $__apiXParam - $__apiTolerance;
 		$this->__apiBufferedImageEnvelope->__apiMinY = $__apiYParam - $__apiTolerance;
 		$this->__apiBufferedImageEnvelope->__apiMaxX = $__apiXParam + $__apiTolerance;
 		$this->__apiBufferedImageEnvelope->__apiMaxY = $__apiYParam + $__apiTolerance;
	}
	function CenterAt($__apiXParam, $__apiYParam){
		$__apiWidth = $this->GetMapWidth() / 2;
		$__apiHeight = $this->GetMapHeight() / 2;

		$this->__apiImageEnvelope->__apiMaxX = $__apiXParam + $__apiWidth;
		$this->__apiImageEnvelope->__apiMinX = $__apiXParam - $__apiWidth;
		$this->__apiImageEnvelope->__apiMaxY = $__apiYParam + $__apiHeight;
		$this->__apiImageEnvelope->__apiMinY = $__apiYParam - $__apiHeight;
	}
	function ToMapPoint($__apiXParam, $__apiYParam){
        $__apiPixelX = $this->GetMapWidth() / $this->GetImageWidth();
        $__apiMapX = $__apiPixelX * $__apiXParam + $this->__apiImageEnvelope->__apiMinX;

        $__apiPixelY = $this->GetMapHeight() / $this->GetImageHeight();
        $__apiMapY = $__apiPixelY * ($this->GetImageHeight() - $__apiYParam) + $this->__apiImageEnvelope->__apiMinY;

		$objPoint = new Point($__apiMapX, $__apiMapY);
		
		return $objPoint;
	}
	function ToImagePoint($__apiXParam, $__apiYParam){
		$__apiImageX = ($this->GetImageWidth() * ($__apiXParam - $this->__apiImageEnvelope->__apiMinX)) / $this->GetMapWidth();
		//$__apiImageX = ($__apiXParam - $this->__apiImageEnvelope->__apiMinX) / ($this->GetMapWidth() / $this->GetImageWidth());
		$__apiImageY = (($__apiYParam - $this->__apiImageEnvelope->__apiMinY) / ($this->GetMapHeight() / $this->GetImageHeight())) - $this->GetImageHeight();
        
		echo "imagex=" . $__apiImageX . " imagey=" . $__apiImageY . "<P>";
		
		$objPoint = new Point($__apiImageX, $__apiImageY);
		
		return $objPoint;
	}
	function CheckMapEnvelope() {
		$__apiWidth = $this->GetMapWidth();
		$__apiHeight = $this->GetMapHeight();
		
		$__apiCenterX = $this->__apiImageEnvelope->__apiMinX + ($__apiWidth / 2);
		$__apiCenterY = $this->__apiImageEnvelope->__apiMinY + ($__apiHeight / 2);
		
		$__apiMaxWidth = $this->GetMaxMapWidth();
		$__apiMaxHeight = $this->GetMaxMapHeight();
		
		$__apiMinWidth = $this->GetMinMapWidth();
		$__apiMinHeight = $this->GetMinMapHeight();
		
		if ($__apiWidth > $__apiMaxWidth || $__apiHeight > $__apiMaxHeight) {
			$this->__apiImageEnvelope->__apiMaxX = $this->__apiMaxImageEnvelope->__apiMaxX;
			$this->__apiImageEnvelope->__apiMinX = $this->__apiMaxImageEnvelope->__apiMinX;
			$this->__apiImageEnvelope->__apiMinY = $this->__apiMaxImageEnvelope->__apiMinY;
			$this->__apiImageEnvelope->__apiMaxY = $this->__apiMaxImageEnvelope->__apiMaxY;
		} else if ($__apiWidth < $__apiMinWidth || $__apiHeight < $__apiMinHeight) {
			$this->__apiImageEnvelope->__apiMaxX = $__apiCenterX + ($__apiMinWidth / 2);
			$this->__apiImageEnvelope->__apiMinX = $__apiCenterX - ($__apiMinWidth / 2);
			$this->__apiImageEnvelope->__apiMinY = $__apiCenterY - ($__apiMinHeight / 2);
			$this->__apiImageEnvelope->__apiMaxY = $__apiCenterY + ($__apiMinHeight / 2);
		} else {
			if ($this->__apiImageEnvelope->__apiMinX < $this->__apiMaxImageEnvelope->__apiMinX) {
				$this->__apiImageEnvelope->__apiMinX = $this->__apiMaxImageEnvelope->__apiMinX;
				$this->__apiImageEnvelope->__apiMaxX = $this->__apiMaxImageEnvelope->__apiMinX + $__apiWidth;
			}
			if ($this->__apiImageEnvelope->__apiMaxY > $this->__apiMaxImageEnvelope->__apiMaxY) {
				$this->__apiImageEnvelope->__apiMinY = $this->__apiMaxImageEnvelope->__apiMaxY - $__apiHeight;
				$this->__apiImageEnvelope->__apiMaxY = $this->__apiMaxImageEnvelope->__apiMaxY;
			}	
			if ($this->__apiImageEnvelope->__apiMaxX > $this->__apiMaxImageEnvelope->__apiMaxX) {
				$this->__apiImageEnvelope->__apiMinX = $this->__apiMaxImageEnvelope->__apiMaxX - $__apiWidth;
				$this->__apiImageEnvelope->__apiMaxX = $this->__apiMaxImageEnvelope->__apiMaxX;
			}
			if ($this->__apiImageEnvelope->__apiMinY < $this->__apiMaxImageEnvelope->__apiMinY) {
				$this->__apiImageEnvelope->__apiMinY = $this->__apiMaxImageEnvelope->__apiMinY;
				$this->__apiImageEnvelope->__apiMaxY = $this->__apiMaxImageEnvelope->__apiMinY + $__apiHeight;
			}
		}
	}
	/*
	function ZoomInByEnvelope($xRTop,$yRTop,$xLBottom,$yLBottom) {
		$__apiPoint = array();
		$M[0] = ($xRTop + $xLBottom) / 2;
		$M[1] = ($yRTop + $yLBottom) / 2;
		$rX = abs($this->ImageEnvelope->xRTop-$this->ImageEnvelope->xLBottom) / abs($xRTop-$xLBottom);
		$rY = abs($this->ImageEnvelope->yRTop-$this->ImageEnvelope->yLBottom) / abs($yRTop-$yLBottom);
		$__apiFactor = $rX<$rY ? $rX*$rX : $rY*$rY;
		return $this->Zoom(-1, $__apiFactor, $__apiPoint);
	}
	function ZoomOutByEnvelope($xRTop,$yRTop,$xLBottom,$yLBottom) {
		$__apiPoint = array();
		$__apiPoint[0] = ($xRTop + $xLBottom) / 2;
		$__apiPoint[1] = ($yRTop + $yLBottom) / 2;
		$rX = abs($this->ImageEnvelope->xRTop-$this->ImageEnvelope->xLBottom) / abs($xRTop-$xLBottom);
		$rY = abs($this->ImageEnvelope->yRTop-$this->ImageEnvelope->yLBottom) / abs($yRTop-$yLBottom);
		$__apiFactor = $rX<$rY ? ($rX*$rX) : ($rY*$rY);
		return $this->Zoom(1, $__apiFactor, $__apiPoint);
	}
	*/
}
?>