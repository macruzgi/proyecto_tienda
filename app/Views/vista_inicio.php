<?php 

if(session("id_tipo_usuario") != 1){
?>
<div class="x_panel">
<div class="alert alert-info alert-dismissible " role="alert">
   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
   </button>
   <h3>
   Buen d&iacute;a <strong><?php echo  session("nombre");?></strong></h3>
</div>
</div>
<?php 
	return;
}
?>
<div class="row">
			<div class="col-md-6 col-sm-6 ">
				<div class="x_panel">
                  <div class="x_title">
                    <h2>Ventas de la semana<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Settings 1</a>
                            <a class="dropdown-item" href="#">Settings 2</a>
                          </div>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content"><iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px; height: 0px; margin: 0px; position: absolute; inset: 0px;"></iframe>
                    <canvas id="venta_semana" width="488" height="244" style="width: 488px; height: 244px;"></canvas>
                  </div>
                </div>
			</div>
			<div class="col-md-6 col-sm-6 ">
				<div class="x_panel">
                  <div class="x_title">
                    <h2>Ventas del mes por usuario<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Settings 1</a>
                            <a class="dropdown-item" href="#">Settings 2</a>
                          </div>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content"><iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px; height: 0px; margin: 0px; position: absolute; inset: 0px;"></iframe>
                    <canvas id="bar_graph" width="488" height="244" style="width: 488px; height: 244px;"></canvas>
                  </div>
                </div>
			</div>

</div>
<div class="row">
<div class="col-md-6 col-sm-6  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Top 5 de los productos m&aacute;s vendidos <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Settings 1</a>
                            <a class="dropdown-item" href="#">Settings 2</a>
                          </div>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content"><iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px; height: 0px; margin: 0px; position: absolute; inset: 0px;"></iframe>
                    <canvas id="grafica_pastel" width="488" height="244" style="width: 488px; height: 244px;"></canvas>
                  </div>
                </div>
              </div>
</div>
				