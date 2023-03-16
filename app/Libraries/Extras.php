<?php

namespace App\Libraries;

class Extras 
{
	//numero a letras
	public function numAletras($num, $fem = false, $dec = true) { 
	   $matuni[2]  = "dos"; 
	   $matuni[3]  = "tres"; 
	   $matuni[4]  = "cuatro"; 
	   $matuni[5]  = "cinco"; 
	   $matuni[6]  = "seis"; 
	   $matuni[7]  = "siete"; 
	   $matuni[8]  = "ocho"; 
	   $matuni[9]  = "nueve"; 
	   $matuni[10] = "diez"; 
	   $matuni[11] = "once"; 
	   $matuni[12] = "doce"; 
	   $matuni[13] = "trece"; 
	   $matuni[14] = "catorce"; 
	   $matuni[15] = "quince"; 
	   $matuni[16] = "dieciseis"; 
	   $matuni[17] = "diecisiete"; 
	   $matuni[18] = "dieciocho"; 
	   $matuni[19] = "diecinueve"; 
	   $matuni[20] = "veinte"; 
	   $matunisub[2] = "dos"; 
	   $matunisub[3] = "tres"; 
	   $matunisub[4] = "cuatro"; 
	   $matunisub[5] = "quin"; 
	   $matunisub[6] = "seis"; 
	   $matunisub[7] = "sete"; 
	   $matunisub[8] = "ocho"; 
	   $matunisub[9] = "nove"; 
	
	   $matdec[2] = "veint"; 
	   $matdec[3] = "treinta"; 
	   $matdec[4] = "cuarenta"; 
	   $matdec[5] = "cincuenta"; 
	   $matdec[6] = "sesenta"; 
	   $matdec[7] = "setenta"; 
	   $matdec[8] = "ochenta"; 
	   $matdec[9] = "noventa"; 
	   $matsub[3]  = 'mill'; 
	   $matsub[5]  = 'bill'; 
	   $matsub[7]  = 'mill'; 
	   $matsub[9]  = 'trill'; 
	   $matsub[11] = 'mill'; 
	   $matsub[13] = 'bill'; 
	   $matsub[15] = 'mill'; 
	   $matmil[4]  = 'millones'; 
	   $matmil[6]  = 'billones'; 
	   $matmil[7]  = 'de billones'; 
	   $matmil[8]  = 'millones de billones'; 
	   $matmil[10] = 'trillones'; 
	   $matmil[11] = 'de trillones'; 
	   $matmil[12] = 'millones de trillones'; 
	   $matmil[13] = 'de trillones'; 
	   $matmil[14] = 'billones de trillones'; 
	   $matmil[15] = 'de billones de trillones'; 
	   $matmil[16] = 'millones de billones de trillones'; 
	   
	   //Zi hack
	   $float=explode('.',$num);
	   $num=$float[0];
	
	   $num = trim((string)@$num); 
	   if ($num[0] == '-') { 
		  $neg = 'menos '; 
		  $num = substr($num, 1); 
	   }else 
		  $neg = ''; 
	   while ($num[0] == '0') $num = substr($num, 1); 
	   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
	   $zeros = true; 
	   $punt = false; 
	   $ent = ''; 
	   $fra = ''; 
	   for ($c = 0; $c < strlen($num); $c++) { 
		  $n = $num[$c]; 
		  if (! (strpos(".,'''", $n) === false)) { 
			 if ($punt) break; 
			 else{ 
				$punt = true; 
				continue; 
			 } 
	
		  }elseif (! (strpos('0123456789', $n) === false)) { 
			 if ($punt) { 
				if ($n != '0') $zeros = false; 
				$fra .= $n; 
			 }else 
	
				$ent .= $n; 
		  }else 
	
			 break; 
	
	   } 
	   $ent = '     ' . $ent; 
	   if ($dec and $fra and ! $zeros) { 
		  $fin = ' coma'; 
		  for ($n = 0; $n < strlen($fra); $n++) { 
			 if (($s = $fra[$n]) == '0') 
				$fin .= ' cero'; 
			 elseif ($s == '1') 
				$fin .= $fem ? ' una' : ' un'; 
			 else 
				$fin .= ' ' . $matuni[$s]; 
		  } 
	   }else 
		  $fin = ''; 
	   if ((int)$ent === 0) return 'Cero ' . $fin; 
	   $tex = ''; 
	   $sub = 0; 
	   $mils = 0; 
	   $neutro = false; 
	   while ( ($num = substr($ent, -3)) != '   ') { 
		  $ent = substr($ent, 0, -3); 
		  if (++$sub < 3 and $fem) { 
			 $matuni[1] = 'una'; 
			 $subcent = 'as'; 
		  }else{ 
			 $matuni[1] = $neutro ? 'un' : 'uno'; 
			 $subcent = 'os'; 
		  } 
		  $t = ''; 
		  $n2 = substr($num, 1); 
		  if ($n2 == '00') { 
		  }elseif ($n2 < 21) 
			 $t = ' ' . $matuni[(int)$n2]; 
		  elseif ($n2 < 30) { 
			 $n3 = $num[2]; 
			 if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
			 $n2 = $num[1]; 
			 $t = ' ' . $matdec[$n2] . $t; 
		  }else{ 
			 $n3 = $num[2]; 
			 if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
			 $n2 = $num[1]; 
			 $t = ' ' . $matdec[$n2] . $t; 
		  } 
		  $n = $num[0]; 
		  if ($n == 1) { 
			 $t = ' ciento' . $t; 
		  }elseif ($n == 5){ 
			 $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
		  }elseif ($n != 0){ 
			 $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
		  } 
		  if ($sub == 1) { 
		  }elseif (! isset($matsub[$sub])) { 
			 if ($num == 1) { 
				$t = ' mil'; 
			 }elseif ($num > 1){ 
				$t .= ' mil'; 
			 } 
		  }elseif ($num == 1) { 
			 $t .= ' ' . $matsub[$sub] . '?n'; 
		  }elseif ($num > 1){ 
			 $t .= ' ' . $matsub[$sub] . 'ones'; 
		  }   
		  if ($num == '000') $mils ++; 
		  elseif ($mils != 0) { 
			 if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
			 $mils = 0; 
		  } 
		  $neutro = true; 
		  $tex = $t . $tex; 
	   } 
	   $tex = $neg . substr($tex, 1) . $fin; 
	   //Zi hack --> return ucfirst($tex);
	   $end_num=ucfirst($tex).' '.$float[1].'/100';
	   return $end_num; 
	}  
	//ok
	public function Convertir_Mes_en_Nombre_Espaniol($mes){
		switch($mes)
		{   
			case 1:
			$monthNameSpanish = "enero";
			break;

			case 2:
			$monthNameSpanish = "febrero";
			break;

			case 3:
			$monthNameSpanish = "marzo";
			break;

			case 4:
			$monthNameSpanish = "abril";
			break;

			case 5:
			$monthNameSpanish = "mayo";
			break;

			case 6:
			$monthNameSpanish = "junio";
			break;
			case 7:
			$monthNameSpanish = "julio";
			break;

			case 8:
			$monthNameSpanish = "agosto";
			break;

			case 9:
			$monthNameSpanish = "septiembre";
			break;
			
			case 10:
			$monthNameSpanish = "octubre";
			break;
			
			case 11:
			$monthNameSpanish = "noviembre";
			break;
			
			case 12:
			$monthNameSpanish = "diciembre";
			break;
		}
		return $monthNameSpanish;
	}
	 public function Format_Bytes($size, $precision = 2){
		$base = log($size) / log(1024);
		$suffixes = array('B', 'KB', 'MB', 'GB', 'TB');
		return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
	}
}
class Numero_A_Letras{
	public function unidad($numuero){
	switch ($numuero)
	{
		case 9:
		{
			$numu = "nueve";
			break;
		}
		case 8:
		{
			$numu = "ocho";
			break;
		}
		case 7:
		{
			$numu = "siete";
			break;
		}
		case 6:
		{
			$numu = "seis";
			break;
		}
		case 5:
		{
			$numu = "cinco";
			break;
		}
		case 4:
		{
			$numu = "cuatro";
			break;
		}
		case 3:
		{
			$numu = "tres";
			break;
		}
		case 2:
		{
			$numu = "dos";
			break;
		}
		case 1:
		{
			$numu = "uno";
			break;
		}
		case 0:
		{
			$numu = "cero";
			break;
		}
	}
	return $numu;
}
 
	public function decena($numdero){
 
		if ($numdero >= 90 && $numdero <= 99)
		{
			$numd = "noventa ";
			if ($numdero > 90)
				$numd = $numd."y ".($this->unidad($numdero - 90));
		}
		else if ($numdero >= 80 && $numdero <= 89)
		{
			$numd = "ochenta ";
			if ($numdero > 80)
				$numd = $numd."y ".($this->unidad($numdero - 80));
		}
		else if ($numdero >= 70 && $numdero <= 79)
		{
			$numd = "setenta ";
			if ($numdero > 70)
				$numd = $numd."y ".($this->unidad($numdero - 70));
		}
		else if ($numdero >= 60 && $numdero <= 69)
		{
			$numd = "sesenta ";
			if ($numdero > 60)
				$numd = $numd."y ".($this->unidad($numdero - 60));
		}
		else if ($numdero >= 50 && $numdero <= 59)
		{
			$numd = "cincuenta ";
			if ($numdero > 50)
				$numd = $numd."y ".($this->unidad($numdero - 50));
		}
		else if ($numdero >= 40 && $numdero <= 49)
		{
			$numd = "cuarenta ";
			if ($numdero > 40)
				$numd = $numd."y ".($this->unidad($numdero - 40));
		}
		else if ($numdero >= 30 && $numdero <= 39)
		{
			$numd = "treinta ";
			if ($numdero > 30)
				$numd = $numd."y ".($this->unidad($numdero - 30));
		}
		else if ($numdero >= 20 && $numdero <= 29)
		{
			if ($numdero == 20)
				$numd = "veinte ";
			else
				$numd = "veinti".($this->unidad($numdero - 20));
		}
		else if ($numdero >= 10 && $numdero <= 19)
		{
			switch ($numdero){
			case 10:
			{
				$numd = "diez ";
				break;
			}
			case 11:
			{
				$numd = "once ";
				break;
			}
			case 12:
			{
				$numd = "doce ";
				break;
			}
			case 13:
			{
				$numd = "trece ";
				break;
			}
			case 14:
			{
				$numd = "catorce ";
				break;
			}
			case 15:
			{
				$numd = "quince ";
				break;
			}
			case 16:
			{
				$numd = "dieciseis ";
				break;
			}
			case 17:
			{
				$numd = "diecisiete ";
				break;
			}
			case 18:
			{
				$numd = "dieciocho ";
				break;
			}
			case 19:
			{
				$numd = "diecinueve ";
				break;
			}
			}
		}
		else
			$numd = $this->unidad($numdero);
	return $numd;
}
 
	public 	function centena($numc){
		if ($numc >= 100)
		{
			if ($numc >= 900 && $numc <= 999)
			{
				$numce = "novecientos ";
				if ($numc > 900)
					$numce = $numce.($this->decena($numc - 900));
			}
			else if ($numc >= 800 && $numc <= 899)
			{
				$numce = "ochocientos ";
				if ($numc > 800)
					$numce = $numce.($this->decena($numc - 800));
			}
			else if ($numc >= 700 && $numc <= 799)
			{
				$numce = "setecientos ";
				if ($numc > 700)
					$numce = $numce.($this->decena($numc - 700));
			}
			else if ($numc >= 600 && $numc <= 699)
			{
				$numce = "seiscientos ";
				if ($numc > 600)
					$numce = $numce.($this->decena($numc - 600));
			}
			else if ($numc >= 500 && $numc <= 599)
			{
				$numce = "quinientos ";
				if ($numc > 500)
					$numce = $numce.($this->decena($numc - 500));
			}
			else if ($numc >= 400 && $numc <= 499)
			{
				$numce = "cuatrocientos ";
				if ($numc > 400)
					$numce = $numce.($this->decena($numc - 400));
			}
			else if ($numc >= 300 && $numc <= 399)
			{
				$numce = "trescientos ";
				if ($numc > 300)
					$numce = $numce.($this->decena($numc - 300));
			}
			else if ($numc >= 200 && $numc <= 299)
			{
				$numce = "doscientos ";
				if ($numc > 200)
					$numce = $numce.($this->decena($numc - 200));
			}
			else if ($numc >= 100 && $numc <= 199)
			{
				if ($numc == 100)
					$numce = "cien ";
				else
					$numce = "ciento ".($this->decena($numc - 100));
			}
		}
		else
			$numce = $this->decena($numc);
 
		return $numce;
}
 
	public 	function miles($nummero){
		if ($nummero >= 1000 && $nummero < 2000){
			$numm = "mil ".($this->centena($nummero%1000));
		}
		if ($nummero >= 2000 && $nummero <10000){
			$numm = $this->unidad(Floor($nummero/1000))." mil ".($this->centena($nummero%1000));
		}
		if ($nummero < 1000)
			$numm = $this->centena($nummero);
 
		return $numm;
	}
 
	public 	function decmiles($numdmero){
		if ($numdmero == 10000)
			$numde = "diez mil";
		if ($numdmero > 10000 && $numdmero <20000){
			$numde = $this->decena(Floor($numdmero/1000))."mil ".($this->$this->centena($numdmero%1000));
		}
		if ($numdmero >= 20000 && $numdmero <100000){
			$numde = $this->decena(Floor($numdmero/1000))." mil ".($this->$this->miles($numdmero%1000));
		}
		if ($numdmero < 10000)
			$numde = $this->miles($numdmero);
 
		return $numde;
	}
 
	public 	function cienmiles($numcmero){
		if ($numcmero == 100000)
			$num_letracm = "cien mil";
		if ($numcmero >= 100000 && $numcmero <1000000){
			$num_letracm = centena(Floor($numcmero/1000))." mil ".(centena($numcmero%1000));
		}
		if ($numcmero < 100000)
			$num_letracm = $this->decmiles($numcmero);
		return $num_letracm;
	}
 
	public 	function millon($nummiero){
		if ($nummiero >= 1000000 && $nummiero <2000000){
			$num_letramm = "un millon ".($this->cienmiles($nummiero%1000000));
		}
		if ($nummiero >= 2000000 && $nummiero <10000000){
			$num_letramm = unidad(Floor($nummiero/1000000))." millones ".($this->cienmiles($nummiero%1000000));
		}
		if ($nummiero < 1000000)
			$num_letramm = $this->cienmiles($nummiero);
 
		return $num_letramm;
	}
 
	public 	function decmillon($numerodm){
		if ($numerodm == 10000000)
			$num_letradmm = "diez millones";
		if ($numerodm > 10000000 && $numerodm <20000000){
			$num_letradmm = decena(Floor($numerodm/1000000))."millones ".($this->cienmiles($numerodm%1000000));
		}
		if ($numerodm >= 20000000 && $numerodm <100000000){
			$num_letradmm = decena(Floor($numerodm/1000000))." millones ".($this->millon($numerodm%1000000));
		}
		if ($numerodm < 10000000)
			$num_letradmm = $this->millon($numerodm);
 
		return $num_letradmm;
	}
 
	public 	function cienmillon($numcmeros){
		if ($numcmeros == 100000000)
			$num_letracms = "cien millones";
		if ($numcmeros >= 100000000 && $numcmeros <1000000000){
			$num_letracms = centena(Floor($numcmeros/1000000))." millones ".($this->millon($numcmeros%1000000));
		}
		if ($numcmeros < 100000000)
			$num_letracms = $this->decmillon($numcmeros);
		return $num_letracms;
	}
 
	public 	function milmillon($nummierod){
		if ($nummierod >= 1000000000 && $nummierod <2000000000){
			$num_letrammd = "mil ".($this->cienmillon($nummierod%1000000000));
		}
		if ($nummierod >= 2000000000 && $nummierod <10000000000){
			$num_letrammd = unidad(Floor($nummierod/1000000000))." mil ".($this->cienmillon($nummierod%1000000000));
		}
		if ($nummierod < 1000000000)
			$num_letrammd = $this->cienmillon($nummierod);
 
		return $num_letrammd;
	}
 
 
	public function convertir($numero){
		     $num = str_replace(",","",$numero);
		     $num = number_format($num,2,'.','');
		     $cents = substr($num,strlen($num)-2,strlen($num)-1);
		     $num = (int)$num;
 
		     $numf = $this->milmillon($num);
 
		return ucfirst($numf)." ".$cents."/100";
}
 

}
