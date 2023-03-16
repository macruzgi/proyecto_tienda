<div class="menu_section">
                <h3>Men&uacute; General</h3>
                <ul class="nav side-menu">
                  <li><a href="<?php echo base_url();?>/Bienvenida"><i class="fa fa-home"></i> Inicio </a>
              
                  </li>
				   <?php 
						if(session("Taer_Opciones_Del_Menu")){
							
						
						//variable bandera
						$bandera_Modulo =0;
						//recorro las opciones del menu
						foreach(session("Taer_Opciones_Del_Menu") as $Opciones_Menu_Encontradas):
						//si la bander $bandera_Modulo es diferente a id_modulo entonces que imprima el menun principal
						if($bandera_Modulo != $Opciones_Menu_Encontradas->id_modulo){
				   ?>
                  <li><a><i class="fa <?php echo $Opciones_Menu_Encontradas->fa_menu;?>"></i> <?php echo $Opciones_Menu_Encontradas->nombre_modulo; ?><span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
						<?php
							$bandera_Modulo = $Opciones_Menu_Encontradas->id_modulo;
							//en este foreacha se recorren las sub opciones del menu
							foreach(session("Taer_Opciones_Del_Menu") as $Sub_Opciones_Menu):
							$bandera_Modulo_Opcion = $Sub_Opciones_Menu->id_modulo;
							//con esta validacion se valida que si la opcion es igual o pertenece al las subociones, entonces que imprima los sub-menus
							if($bandera_Modulo_Opcion == $Sub_Opciones_Menu->id_modulo and $bandera_Modulo == $bandera_Modulo_Opcion){
								$bandera_Modulo_Opcion = $Sub_Opciones_Menu->id_modulo;
						?>
                      <li><a href="<?php echo base_url().$Sub_Opciones_Menu->link;?>"><?php echo $Sub_Opciones_Menu->nombre_opcion; ?></a></li>
					  <?php 
							}
							else{
								$bandera_Modulo_Opcion = $Sub_Opciones_Menu->id_modulo;
							}
							endforeach;
							
						
						?>
                    </ul>
                  </li>
				  <?php
						$bandera_Modulo = $Opciones_Menu_Encontradas->id_modulo;
						}
					endforeach;
						}
					?>
                 
                  <li><a href="<?php echo base_url();?>/Salir"><i class="fa fa-sign-out"></i> Salir </a>
              
                  </li>
                </ul>
              </div>