 <?php 
//se trae desde un view cell creada en App\Cell\EmpresaInfo.php 
$Datos_Empresa= json_decode(view_cell('\App\Cell\EmpresaInfo::Datos_Empresa') , true);//el valor true es para que el json se convierta en array
			  //print_r($Datos_Empresa);
?>
<div class="profile_pic">
                <img src="<?php echo base_url();?>/images/<?php echo $Datos_Empresa[4]["valor_configuracion"];?>" alt="<?php echo $Datos_Empresa[0]["valor_configuracion"];?>" class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Bienvenido,</span>
                <h2><?php echo  session("nombre");?></h2>
              </div>
			 