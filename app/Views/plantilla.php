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

    <title><?php echo $Datos_Empresa[0]["valor_configuracion"];?></title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url();?>/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url();?>/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo base_url();?>../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="<?php echo base_url();?>/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?php echo base_url();?>/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url();?>/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url();?>/build/css/custom.min.css" rel="stylesheet">
	 <!-- Datatables -->
    
    <link href="<?php echo base_url();?>/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
	<!-- bootstrap-datetimepicker -->
    <link href="<?php echo base_url();?>/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
	
	 <!-- Css macruz-gi -->
     <link href="<?php echo base_url();?>/vendors/macruzgi/estilos_personalizados.css" rel="stylesheet">
	 <!--alertify-->
		<link rel="stylesheet" href="<?php echo base_url(); ?>/vendors/alertify/css/alertify.css"/>
		<link rel="stylesheet" href="<?php echo base_url(); ?>/vendors/alertify/css/alertify.min.css"/>
		<link rel="stylesheet" href="<?php echo base_url(); ?>/vendors/alertify/css/alertify.min.css"/>
		<link rel="stylesheet" href="<?php echo base_url(); ?>/vendors/alertify/css/themes/default.css"/>
	<script>
		var baseUrl = "<?php echo base_url(); ?>";
	</script>
  </head>

  <!--class= nav-md es para mostrar el menu normal
  class=nav-sm es para ocultar el menu normal y mostrar solo una barra lateral y los iconos-->
  <body class="nav-md"> 
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo base_url();?>/Bienvenida" class="site_title"><i class="fa fa-wrench"></i> <span><?php echo $Datos_Empresa[0]["valor_configuracion"];?></span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <!--pefil menu lateral izquierdo-->
				<?php echo view("includes/perfil_menu_lateral_izquierdo");?>
			  <!--fin perfil menu lateral izquierdo-->
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <!--menu izquierdo-->
				<?php echo view("includes/menu_lateral_izquierdo");?>
			  <!--fin menu lateral izquierdo-->
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
               <a> <span class="glyphicon" aria-hidden="true"></span></a>
			  <a> <span class="glyphicon" aria-hidden="true"></span></a>
			  <a> <span class="glyphicon" aria-hidden="true"></span></a>        
              <a data-toggle="tooltip" data-placement="top" title="Salir" href="<?php echo base_url();?>/Salir">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
			 
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
         <!--top navitation-->
			<?php echo view("includes/top_navigation");?>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
			<div class="">
				 <!--contenido, aqui se mostraran todas las vistas, con esto se evita estar haciendo un include de archivos css/js, todo se mostrara en este apartado-->
				 <?php 
				 /*
				 *$contenido es la variable tipo array que tomara el valor que se le asigne en los controladores y mostrara el el valor de esa variable
				 *
				 */
				 echo view($contenido);?>
			</div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix">Developer 2023-<?php echo date("Y");?> <a href="https://macruzgi.com/" target="_blank">MaCruz-Gi</a> E-mail:giancarlos1029@hotmail.com</div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url();?>/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url();?>/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url();?>/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url();?>/vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="<?php echo base_url();?>/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="<?php echo base_url();?>/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?php echo base_url();?>/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url();?>/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="<?php echo base_url();?>/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="<?php echo base_url();?>/vendors/Flot/jquery.flot.js"></script>
    <script src="<?php echo base_url();?>/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="<?php echo base_url();?>/vendors/Flot/jquery.flot.time.js"></script>
    <script src="<?php echo base_url();?>/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="<?php echo base_url();?>/vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="<?php echo base_url();?>/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="<?php echo base_url();?>/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="<?php echo base_url();?>/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="<?php echo base_url();?>/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="<?php echo base_url();?>/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="<?php echo base_url();?>/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="<?php echo base_url();?>/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo base_url();?>/vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url();?>/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

	<!-- Datatables -->
	
    <script src="<?php echo base_url();?>/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url();?>/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?php echo base_url();?>/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url();?>/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url();?>/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?php echo base_url();?>/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?php echo base_url();?>/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url();?>/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="<?php echo base_url();?>/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
	<script src="<?php echo base_url();?>/vendors/jszip/dist/jszip.min.js"></script>
    <script src="<?php echo base_url();?>/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?php echo base_url();?>/vendors/pdfmake/build/vfs_fonts.js"></script>
	<script src="<?php echo base_url();?>/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  
    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url();?>/build/js/custom.min.js"></script>
	<!-- jquery Validator-->
	<script src="<?php echo base_url();?>/vendors/jquery/dist/jquery.validate.min.js"></script>
	<!-- jquery.inputmask -->
    <script src="<?php echo base_url();?>/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
	
	<!-- bootstrap-datetimepicker -->    
    <script src="<?php echo base_url();?>/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	
	<!--js macruz-gi-->
	<script src="<?php echo base_url();?>/vendors/macruzgi/js/usuarios.js"></script>
	<script src="<?php echo base_url();?>/vendors/macruzgi/js/cotizaciones.js"></script>
	<script src="<?php echo base_url();?>/vendors/macruzgi/js/clientes.js"></script>
	<script src="<?php echo base_url();?>/vendors/macruzgi/js/proveedores.js"></script>
	<script src="<?php echo base_url();?>/vendors/macruzgi/js/productos.js"></script>
	<script src="<?php echo base_url();?>/vendors/macruzgi/js/compras.js"></script>
	<script src="<?php echo base_url();?>/vendors/macruzgi/js/precios.js"></script>
	<script src="<?php echo base_url();?>/vendors/macruzgi/js/inventario.js"></script>
	<script src="<?php echo base_url();?>/vendors/macruzgi/js/inventario_salidas.js"></script>
	<script src="<?php echo base_url();?>/vendors/macruzgi/js/ventas.js"></script>
	<script src="<?php echo base_url();?>/vendors/macruzgi/js/reportes.js"></script>
	<script src="<?php echo base_url();?>/vendors/macruzgi/js/configuraciones_grales.js"></script>
	<script src="<?php echo base_url();?>/vendors/macruzgi/js/canvas.js"></script>
	
	<!--alertify-->
	<script src="<?php echo base_url(); ?>/vendors/alertify/alertify.js"></script>
	<script src="<?php echo base_url(); ?>/vendors/alertify/alertify.min.js"></script>
	
<script>
//para que cargue la funciond e mostrar productos en el carro al entrar a la vista
 Mostar_Productos_En_El_Carrito();
</script>
  </body>
</html>
