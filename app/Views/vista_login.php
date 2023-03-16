<?php 
//se trae desde un view cell creada en App\Cell\EmpresaInfo.php que trae la informacion de la empresa
$Datos_Empresa= json_decode(view_cell('\App\Cell\EmpresaInfo::Datos_Empresa') , true);//el valor true es para que el json se convierta en array
			  //print_r($Datos_Empresa);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?php echo base_url();?>/images/favicon.ico" type="image/ico" />
    <title><?php echo $Datos_Empresa[0]["valor_configuracion"];?> </title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url();?>/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url();?>/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo base_url();?>/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url();?>/vendors/macruzgi/estilos_personalizados.css" rel="stylesheet">
	
	<!-- Estilos personalizados -->
    <link href="<?php echo base_url();?>/build/css/custom.min.css" rel="stylesheet">
	
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
			<div id="overlay">
							  <!--overlay para cuando se está procesando el formulario y mustra un alerta de espere..-->
							  <div class="spinner"></div>
							  <div class="message">
							  <div class="spinner-border text-primary" role="status">
								  <span class="sr-only">Loading...</span>
								</div>
							  Espere por favor...</div>
			</div>
            <form id="frm_Inicio_de_Sesion">
              <h1>Inicio de sesi&oacute;n</h1>
			  <div class="alert alert-danger alert-dismissible" role="alert" style="display:none;" id="mensaje">
                    <!--
                    Aqui se veran los mensajes de error-->
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Usuario" required="" id="usuario" name="usuario" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Contrase&ntilde;a" required="" id="clave" name ="clave" />
              </div>
              <div>
				<button class="btn btn-primary" id="btnEntrar">Entrar</button>
                <!--a class="btn btn-default submit" href="index.html">Log in</a-->
                <!--a class="reset_pass" href="#">Lost your password?</a-->
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                
                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-wrench"></i> <?php echo $Datos_Empresa[0]["valor_configuracion"];?></h1>
                  <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 4 template. Privacy and Terms</p>
				  <p>Developer  <a href="http://macruzgi.atwebpages.com" target="_blank">MaCruz-Gi</a>E-mail:giancarlos1029@hotmail.com 2023-<?php echo date("Y");?></p>
                </div>
              </div>
            </form>
          </section>
        </div>

       </div>
    </div>
	<script src="<?php echo base_url();?>/vendors/jquery/dist/jquery.min.js"></script>
	<script src="<?php echo base_url();?>/vendors/jquery/dist/jquery.validate.min.js"></script>
	<script>
		$("#frm_Inicio_de_Sesion").validate({
			rules:{
				clave:{required:true},
				usuario:{required:true}
			},
			messages:{
				clave:{required:"Valor requerido"},
				usuario:{required:"Valor requerido"}
			},
			submitHandler: function (formulario){
				//una vez de clic desabilito el boton
				//$("#btnEntrar").prop("disabled", true);
				$.ajax({
					type:"POST",
					url:"<?php echo base_url();?>/Sesion",
					data:$("#frm_Inicio_de_Sesion").serialize(),
					dataType:"json",//espero un json como respuesta
					beforeSend: function() {
						//muestro el loadin espsere..
						$("#overlay").show();
					},
					success:function(datos_esperados){
						$("#mensaje").empty();//quito cualquier mensaje previamente mostrado
						$("#mensaje").removeClass();//remuevo la clase css
						$("#mensaje").addClass(datos_esperados.clase_css);//clase css será la respuesta enviada por el controlador
						$("#mensaje").append(datos_esperados.mensaje);//mensaje que será la respuesta enviada por el controlador
						$("#mensaje").show();//muestro el mensaje
						if(datos_esperados.respuesta ==1){
							//respuesta será la respuesta enviada por el controlador
							//si la respuesta es 1 como sussces que nos rediriga a la pagina de inicio
							window.location.replace("<?php echo base_url();?>/Bienvenida");
						}
						
					},
					complete: function() {
						// Oculta el overlay después de completar la petición
						$("#overlay").hide();
					  }
				});
			}
		});
	</script>
  </body>
</html>