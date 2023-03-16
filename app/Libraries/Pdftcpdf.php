<?php namespace App\Libraries;
//la libreria as sido registrada en app/Confg/Autoload.php para que sea posible el use TCPPDF
use TCPDF;


class Pdftcpdf extends TCPDF
{
	public $usuario="";//variable publica rque recibe el usurio desde las vista o controladores
	public $tituloReporte=""; //variable publica rque recibe el numero de herramiente desde las vista o controladores
	public $nombre_empresa ="";//variable publica que recibe el nombre de la empresa
	public $direccion = "";//variable publica que recibe la direccion de la empresa
	public $telefono ="";//variable publica que recibe el telefono de la empresa
	public $logo_empresa = ""; //variable  publica que recibe el nombre de la imagen
	public $moneda = ""; //variable  publica que recibe el la leyenda de la moneda expresada en "" 
    function __construct()
    {
        parent::__construct();
    }
    
      //Page header
    public function Header() {
         //$this->SetFont('courier', 'B', 10);
        // Title
		$this->Cell(25,5,'',0,1,'C');
		$this->Cell(25,5,'',0,1,'C'); //C es para center
		$this->SetFont('', 'B', 10);
		$this->SetX(40);//moverse en x
		$this->Cell(25,5,$this->nombre_empresa,0,1);
		$this->SetX(40);//moverse en x
		$this->Cell(25,5,$this->tituloReporte,0,1);
		$this->SetY(20);//moverse en Y
		$this->SetFont('', 'I', 8);
		$this->Cell(25,5,$this->moneda,0,1);
		
		//$image_file2 = K_PATH_IMAGES.'logosv.gif';
		$this->Image("./images/".$this->logo_empresa, 10, 8, 28, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		
			
       
        $this->SetCreator(PDF_CREATOR);
		$this->SetAuthor('MaCruz-Gi');
		$this->SetTitle('Reporte');
		$this->SetSubject('Reporte');
		
       
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
		date_default_timezone_set('America/El_Salvador');
		$this->SetY(-15);//moverse en y
		//$this->Cell(0, 5, date("d/m/Y H:i:s"), 0,1);
		$this->SetFont('', 'I', 8);
		$this->Cell(0, 5, $this->direccion, 0,1);		
		$this->Cell(0, 5, 'Generado por: '.$this->usuario.' '.date("d/m/Y H:i:s"), 0,1); 
		$this->SetY(-15);//moverse en y
		$this->Cell(0, 5, 'Pág. '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0,1, 'R');//R es a la derecha
		$this->SetY(-15);//moverse en y
		//imprimo un hr
		$this->writeHTML("<hr>", true, false, false, false, '');
		//$this->Cell(25,5,$this->getAliasNumPage(),0,1);
		
    }  
    
}


?>