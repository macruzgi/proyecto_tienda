<div class="x_panel">
                  <div class="x_title">
                    <h2>Datos de la empresa</small></h2>
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
                  <div class="x_content">
                      <div class="row">
                          <div class="col-sm-12">
						  <form id="frm_actulaizar_datos_empresa">
								<div id="overlay">
								  <!--overlay para cuando se está procesando el formulario y mustra un alerta de espere..-->
								  <div class="spinner"></div>
								  <div class="message">
								  <div class="spinner-border text-primary" role="status">
									  <span class="sr-only">Loading...</span>
									</div>
								  Espere por favor...</div>
								</div>
								<div class="alert alert-danger alert-dismissible" role="alert" style="display:none;" id="mensaje">
											<!--
											Aqui se veran los mensajes de error-->
								</div>
								<div class="col-md-3 col-sm-3  profile_left">
									  <div class="profile_img">
										<div id="crop-avatar">
										  <!-- Current avatar -->
										  <img class="img-responsive avatar-view" src="<?php echo base_url();?>/images/<?php echo $Traer_Datos_Empresa[4]->valor_configuracion;?>" alt="<?php echo $Traer_Datos_Empresa[0]->valor_configuracion;?>" title="<?php echo $Traer_Datos_Empresa[0]->valor_configuracion;?>" style="width: 106%;">
										</div>
									  </div>
									  <h3><?php echo $Traer_Datos_Empresa[0]->valor_configuracion;?></h3>

									  <ul class="list-unstyled user_data">
										<li><i class="fa fa-map-marker user-profile-icon"></i> <?php echo $Traer_Datos_Empresa[1]->valor_configuracion;?>
										</li>

										<li>
										  <i class="fa fa-briefcase user-profile-icon"></i> <?php echo $Traer_Datos_Empresa[2]->valor_configuracion;?>
										</li>

										
									  </ul>
												<button type="submit" id="btn_Guardar_tipo" class="btn btn-success">Actualizar datos</button>
								</div>	
								
								<div class="col-md-9 col-sm-9 ">
									<div role="tabpanel" class="tab-pane active " id="tab_content1" aria-labelledby="home-tab">

										<!-- start recent activity -->
										<ul class="messages">
										  <li>
											<i class="fa fa-check"></i>
											
											<div class="message_wrapper">
											  <h4>* Nombre de la empresa:</h4>

											  <br>
											  <p class="url">
												
												<input type="text" id="nombre_empresa" class="form-control" name="nombre_empresa" value="<?php echo $Traer_Datos_Empresa[0]->valor_configuracion;?>">
											  </p>
											</div>
										  </li>
										  
										  <li>
											<i class="fa fa-check"></i>
											
											<div class="message_wrapper">
											  <h4>* Direci&oacute;n:</h4>

											  <br>
											  <p class="url">
												
												<input type="text" id="direccion_empresa" class="form-control" name="direccion_empresa" value="<?php echo $Traer_Datos_Empresa[1]->valor_configuracion;?>">
											  </p>
											</div>
										  </li>
										  <li>
											<i class="fa fa-check"></i>
											
											<div class="message_wrapper">
											  <h4>Tel&eacute;fono:</h4>

											  <br>
											  <p class="url">
												
												<input type="text" id="telefono_empresa" class="form-control" name="telefono_empresa" value="<?php echo $Traer_Datos_Empresa[2]->valor_configuracion;?>" data-inputmask="'mask': '9999-9999'">
											  </p>
											</div>
										  </li>
										  <li>
											<i class="fa fa-check"></i>
											
											<div class="message_wrapper">
											  <h4>* Moneda:</h4>

											  <br>
											  <p class="url">
												
												<input type="text" id="moneda_empresa" class="form-control" name="moneda_empresa" value="<?php echo $Traer_Datos_Empresa[3]->valor_configuracion;?>">
											  </p>
											</div>
										  </li>
										  <li>
											<i class="fa fa-check"></i>
											
											<div class="message_wrapper">
											  <h4>Logo:</h4>

											  <br>
											  <p class="url">
												
												<input class="form-control" type="file" id="archivo" name="archivo">
											  </p>
											  <input type="hidden" id="nombre_logo"  name="nombre_logo" value="<?php echo $Traer_Datos_Empresa[4]->valor_configuracion;?>">
											</div>
										  </li>
										  
										  

										</ul>
										<!-- end recent activity -->

									  </div>
									  
								</div>
							</form>
                           </div>
              </div>
            </div>
                </div>