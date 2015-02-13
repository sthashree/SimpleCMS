<?php
include_once("administrator/lib/tcpdf/config/lang/eng.php");
include_once("administrator/lib/tcpdf/tcpdf.php");
class XTCPDF extends TCPDF {
	var $xheadertext  = 'Created With TCPDF';
    var $xheadercolor = array(0,0,200);
    var $xfootertext  = 'Copyright © %d XXXXXXXXXXX. All rights reserved.';
    var $xfooterfont  = PDF_FONT_NAME_MAIN ;
    var $xfooterfontsize = 8 ; 
	
	function Header()
    {

        list($r, $b, $g) = $this->xheadercolor;
        $this->setY(10); // shouldn't be needed due to page margin, but helas, otherwise it's at the page top
        $this->SetFillColor($r, $b, $g);
        $this->SetTextColor(255 , 255, 255);
        $this->Cell(0,20, '', 0,1,'C', 1);
        $this->Text(12,22,$this->xheadertext );
    } 
	
	function Footer()
    {
        $year = date('Y');
        $footertext = sprintf($this->xfootertext, $year);
        $this->SetY(-20);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont($this->xfooterfont,'',$this->xfooterfontsize);
        $this->Cell(0,8, $footertext,'T',1,'C');
    } 
}
?>