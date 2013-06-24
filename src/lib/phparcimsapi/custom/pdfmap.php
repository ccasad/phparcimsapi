<?php
class PDFMap {
    //***************************************************************
    // Set property defaults
    //***************************************************************
    var $__apiAuthor = 'Author';  
    var $__apiCreator = 'Creator';  
    var $__apiTitle = 'Title';  
    var $__apiSubject = 'Subject';  
    var $__apiKeywords = 'Keywords';
    var $__apiDate = '';
    var $__apiMapImage = '';
    var $__apiPDFFilePath = '/local/www/arcims/pdf/';
    var $__apiPrintPdfMapDpi = 300;
    var $__apiPageSize = 2;
    var $__apiPageShortSide = '';
    var $__apiPageLongSide = '';
    var $__apiPageOrientation = 1;
    var $__apiPageSizes = array(0 => array(name=>'Letter',shortside=>215.9,longside=>279.4,description=>'8.5" x 11"'),
                                1 => array(name=>'Legal',shortside=>215.9,longside=>355.6,description=>'8.5" x 14"'),
                                2 => array(name=>'Ledger',shortside=>279.4,longside=>431.8,description=>'11" x 17"'),
                                3 => array(name=>'US Government',shortside=>203.2,longside=>279.4,description=>'8" x 11"'),
                                4 => array(name=>'Statement',shortside=>139.7,longside=>215.9,description=>'5.5" x 8.5"'),
                                5 => array(name=>'Executive',shortside=>184.2,longside=>266.7,description=>'7.25" x 10.5"'),
                                6 => array(name=>'Folio',shortside=>215.9,longside=>330.2,description=>'8.5" x 13"'),
                                7 => array(name=>'Quarto',shortside=>215.0,longside=>275.0,description=>'8.45" x 10.75"'),
                                8 => array(name=>'Tabloid',shortside=>279.4,longside=>431.8,description=>'11" x 17"'),
                                9 => array(name=>'A0',shortside=>841,longside=>1189),
                                10 => array(name=>'A1',shortside=>594,longside=>841),
                                11 => array(name=>'A2',shortside=>420,longside=>594),
                                12 => array(name=>'A3',shortside=>297,longside=>420),
                                13 => array(name=>'A4',shortside=>210,longside=>297),
                                14 => array(name=>'A5',shortside=>148,longside=>210),
                                15 => array(name=>'A6',shortside=>105,longside=>148),
                                16 => array(name=>'B0',shortside=>1000,longside=>1414),
                                17 => array(name=>'B1',shortside=>707,longside=>1000),
                                18 => array(name=>'B2',shortside=>500,longside=>700),
                                19 => array(name=>'B3',shortside=>353,longside=>500),
                                20 => array(name=>'B4',shortside=>250,longside=>353),
                                21 => array(name=>'B5',shortside=>176,longside=>250),
                                22 => array(name=>'B6',shortside=>125,longside=>176),
                                23 => array(name=>'C0',shortside=>917,longside=>1296),
                                24 => array(name=>'C1',shortside=>648,longside=>917),
                                25 => array(name=>'C2',shortside=>458,longside=>648),
                                26 => array(name=>'C3',shortside=>324,longside=>458),
                                27 => array(name=>'C4',shortside=>229,longside=>324),
                                28 => array(name=>'C5',shortside=>162,longside=>229),
                                29 => array(name=>'C6',shortside=>114,longside=>162)
                                );
    
    //***************************************************************
    // Constructor
    //***************************************************************
    function PDFMap() {
        /// Switched around the order of the params coming in because
        /// filepath are most likely getting the default
        /// as well as pagesize and added pageorientation to the list of params
        /// (06 June 2003)
        
        $numargs = func_num_args();
        $this->__apiMapImage = $numargs > 0 ? func_get_arg(0) : '';
        $this->__apiTitle = $numargs > 1 ? func_get_arg(1) : '';
        $this->__apiPageSize = ($numargs > 2 && strlen(func_get_arg(2)) > 0) ? func_get_arg(2) : $this->__apiPageSize;
        $this->__apiPageOrientation = ($numargs > 3 && strlen(func_get_arg(3)) > 0) ? func_get_arg(3) : $this->__apiPageOrientation;
	$this->__apiPDFFilePath = $numargs > 4 ? func_get_arg(4) : $this->__apiPDFFilePath;

        $this->__apiDate = date('d M Y');
        
        $this->SetPageSize($this->__apiPageSize);
        $this->SetPageOrientation($this->__apiPageOrientation);
    }
    
    //***************************************************************
    // Public Methods
    //***************************************************************
    function SetAuthor($__apiParam) { $this->__apiAuthor = $__apiParam; }
    function SetCreator($__apiParam) { $this->__apiCreator = $__apiParam; }
    function SetTitle($__apiParam) { $this->__apiTitle = $__apiParam; }
    function SetSubject($__apiParam) { $this->__apiSubject = $__apiParam; }
    function SetKeywords($__apiParam) { $this->__apiKeywords = $__apiParam; }
    function SetDate($__apiParam) { $this->__apiDate = $__apiParam; }
    function SetMapImage($__apiParam) { $this->__apiMapImage = $__apiParam; }
    function SetPDFFilePath($__apiParam) { $this->__apiPDFFilePath = $__apiParam; }
    function SetPageSize($__apiParam) { 
        if (strlen($__apiParam) > 0) {
            for ($i = 0;$i < count($this->__apiPageSizes);$i++) {
                if (strtoupper($__apiParam) == strtoupper($this->__apiPageSizes[$i]['name']) || $__apiParam == $i) {
                    $this->__apiPageShortSide = round($this->__apiPageSizes[$i]['shortside'] * 2.834);
                    $this->__apiPageLongSide = round($this->__apiPageSizes[$i]['longside'] * 2.834);
                    $this->__apiPageSize = $i;
                    break;
                }
            } 
        }
    }
    function SetPageShortSide($__apiParam) { $this->__apiPageShortSide = $__apiParam; }
    function SetPageLongSide($__apiParam) { $this->__apiPageLongSide = $__apiParam; }
    function SetPageOrientation($__apiParam) { 
        if (strtoupper($__apiParam) == 'PORTRAIT' || $__apiParam == 0) {
            $this->__apiPageOrientation = 0;
        } else if (strtoupper($__apiParam) == 'LANDSCAPE' || $__apiParam == 1) {
            $this->__apiPageOrientation = 1;
        }
    }
    function GetPrintingWidth() {
        // these first two lines make sure we have an index number for the values being passed
        $this->SetPageOrientation($this->__apiPageOrientation);
        $this->SetPageSize($this->__apiPageSize);
        
        if ($this->__apiPageOrientation == 0) {
            $pageWidthInMillimeters = $this->__apiPageSizes[$this->__apiPageSize]['shortside'];
        } else {
            $pageWidthInMillimeters = $this->__apiPageSizes[$this->__apiPageSize]['longside'];
        }
        // needs to be in inches 25.4 mm per inch
        $pageWidth = $pageWidthInMillimeters / 25.4;
        
        // actual size of the image need (for 17x11 page actually is w=15.95, h=10.15)
        $printPdfMapImageWidth = $pageWidth * 0.92;
        
        $printingWidth = round($printPdfMapImageWidth * $this->__apiPrintPdfMapDpi);
        
        return $printingWidth;
    }
    function GetPrintingHeight() {
        // these first two lines make sure we have an index number for the values being passed
        $this->SetPageOrientation($this->__apiPageOrientation);
        $this->SetPageSize($this->__apiPageSize);
        
        if ($this->__apiPageOrientation == 0) {
            $pageHeightInMillimeters = $this->__apiPageSizes[$this->__apiPageSize]['longside'];
        } else {
            $pageHeightInMillimeters = $this->__apiPageSizes[$this->__apiPageSize]['shortside'];
        }
        // needs to be in inches 25.4 mm per inch
        $pageHeight = $pageHeightInMillimeters / 25.4;
        
        // actual size of the image need (for 17x11 page actually is w=15.95, h=10.15)
        $printPdfMapImageHeight = $pageHeight * 0.92;
        
        $printingHeight = round($printPdfMapImageHeight * $this->__apiPrintPdfMapDpi);
        
        return $printingHeight;
    }
    function CreatePDF() {
        // strip out the mapfile name
        $mapFileName = substr($this->__apiMapImage, strrpos($this->__apiMapImage, '/') + 1, -4);
        
        // create a file
        $pdfFile = pdf_new();
        
        // open the new file
        pdf_open_file($pdfFile, "");
        
        // fill out document information
        pdf_set_info($pdfFile, 'Author', $this->__apiAuthor);
        pdf_set_info($pdfFile, 'Creator', $this->__apiCreator);
        pdf_set_info($pdfFile, 'Title', $this->__apiTitle);
        pdf_set_info($pdfFile, 'Subject', $this->__apiSubject);
        pdf_set_info($pdfFile, 'Keywords', $this->__apiKeywords);
        pdf_set_info($pdfFile, 'Date', $this->__apiDate);
        
        // start a new page
        if ($this->__apiPageOrientation == 0) {  // 0=portrait
            pdf_begin_page($pdfFile, $this->__apiPageShortSide, $this->__apiPageLongSide);
        } else {
            pdf_begin_page($pdfFile, $this->__apiPageLongSide, $this->__apiPageShortSide);
        }
        
        // place map image from url
        $imageType = substr($this->__apiMapImage, -3);
        $tempImageName = 'tempimage.' . $imageType;
        
        if ($remoteImage = fopen($this->__apiMapImage, 'rb')) {
            if ($localImage = fopen($this->__apiPDFFilePath . $tempImageName, 'wb')) {	
                $buffer = '';	
                while(!feof($remoteImage)) {
                    $buffer .= fread($remoteImage, 4096);
                }
                fwrite($localImage, $buffer, strlen($buffer));
                fclose($localImage);
            } else {
                print('Error generating map image for PDF - Cannot open local ' . $this->__apiPDFFilePath . $tempImageName);
                exit;
            }
        } else {
            print('Error generating map image for PDF - Cannot open remote ' . $this->__apiMapImage);
            exit;
        }
        fclose($remoteImage);
        
        /// add the map image to the pdf file
        $mapImage = pdf_open_image_file($pdfFile, $imageType, $this->__apiPDFFilePath . $tempImageName);
        pdf_place_image($pdfFile, $mapImage, 15, 15, 0.25);
        
        // end page
        pdf_end_page($pdfFile);
        
        // close and save file
        pdf_close($pdfFile);
        
        // get the pdf from memory
        $buffer = pdf_get_buffer($pdfFile);
        $length = strlen($buffer);
        
        // spit out the pdf into the browser
        header("Content-type: application/pdf");
        header("Content-Length: $length");
        header("Content-Disposition: inline; filename=map.pdf");
        print($buffer);
        
        // delete the pdf from memory
        pdf_delete($pdfFile);
        
        exit;
    }
}
?>