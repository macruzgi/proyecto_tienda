<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
/*
*ruta de error
*/
$routes->set404Override(function() {
    echo view('errors/html/page_404'); // Muestra una vista personalizada para el error 404
});
$routes->get('/', 'Login::index');
$routes->post('/Sesion', 'Login::Validar_Usuario');
$routes->get('/Salir', 'Login::Cerrar_Sesion');
$routes->get('/Error_De_Acceso', 'Login::Error_De_Acceso');
$routes->get('/Bienvenida', 'Home::index');

//rutas para los usuarios
$routes->get('/Administrar_Usuarios', 'Usuarios::index');
$routes->get('/Vista_Asignar_Permisos/(:num)', 'Usuarios::Vista_Asignar_Permisos/$1');
$routes->post('/Asignar_Permisos', 'Usuarios::Asignar_Permisos');
$routes->get('/Vista_Agregar_Usuario', 'Usuarios::Vista_Agregar_Usuario');
$routes->post('/Agregar_Usuario', 'Usuarios::Agregar_Usuario');
$routes->get('/Vista_Editar_Usuario/(:num)', 'Usuarios::Vista_Editar_Usuario/$1');
$routes->post('/Editar_Usuario', 'Usuarios::Editar_Usuario');
$routes->post('/Bloquer_Desbloquear_Usuario', 'Usuarios::Bloquer_Desbloquear_Usuario');

/*
 *
 *rutas para backups
*/
$routes->get('/Aministrar_Backups', 'Utilidades::index');
$routes->get('/Generar_Backup', 'Utilidades::Generar_Backup');
$routes->get('/Errores_No_Existe_Registro', 'Utilidades::Errores_No_Existe_Registro');

/*
 *rutas para cotizaciones
 *
 */
$routes->get('/Administrar_Cotizaciones', 'Cotizaciones::index');
$routes->get('/Re_Imprimir_Cotizacion/(:num)', 'Cotizaciones::Re_Imprimir_Cotizacion/$1');
$routes->post('/Eliminar_Cotizacion', 'Cotizaciones::Eliminar_Cotizacion');
$routes->post('/Cargar_Cotizacion', 'Cotizaciones::Cargar_Cotizacion');
$routes->post('/Guardar_E_Imprimir_Cotizacion', 'Cotizaciones::Guardar_E_Imprimir_Cotizacion');

/*
 *rutas para los clientes
 */
$routes->get('/Administrar_Clientes', 'Clientes::index');
$routes->get('/Vista_Agregar_Cliente', 'Clientes::Vista_Agregar_Cliente');
$routes->post('/Agregar_Cliente', 'Clientes::Agregar_Cliente');
$routes->get('/Vista_Editar_Cliente/(:num)', 'Clientes::Vista_Editar_Cliente/$1');
$routes->post('/Editar_Cliente', 'Clientes::Editar_Cliente');
$routes->post('/Traer_Municipios', 'Utilidades::Traer_Municipios');
/*
 *rutas para los Proveedores
 */
$routes->get('/Administrar_Proveedores', 'Proveedores::index');
$routes->get('/Vista_Agregar_Proveedor', 'Proveedores::Vista_Agregar_Proveedor');
$routes->post('/Agregar_Proveedor', 'Proveedores::Agregar_Proveedor');
$routes->get('/Vista_Editar_Poveedor/(:num)', 'Proveedores::Vista_Editar_Poveedor/$1');
$routes->post('/Editar_Proveedor', 'Proveedores::Editar_Proveedor');

/*
 *rutas para los Productos
 *productos\ es la subcarpeta donde esta el controlador
 */
$routes->get('/productos/Administrar_Productos', 'productos\Productos::index');
$routes->get('/productos/Vista_Agregar_Productos', 'productos\Productos::Vista_Agregar_Productos');
$routes->post('/productos/Agregar_Producto', 'productos\Productos::Agregar_Producto');
$routes->get('/productos/Vista_Editar_Producto/(:num)', 'productos\Productos::Vista_Editar_Producto/$1');
$routes->post('/productos/Editar_Producto', 'productos\Productos::Editar_Producto');


/*
 *rutas para los Compras
 *Compras\ es la subcarpeta donde esta el controlador
 */
$routes->get('/Compras/Administrar_Compras', 'Compras\Compras::index');
$routes->get('/Compras/Vista_Agregar_Compras', 'Compras\Compras::Vista_Agregar_Compras');
$routes->post('/Compras/Traer_Proveedor', 'Compras\Compras::Traer_Proveedor');
//busca un producto para la compra
$routes->post('/Compras/Buscar_Producto', 'Compras\Compras::Buscar_Producto');
$routes->post('/Compras/Procesar_Compra', 'Compras\Compras::Procesar_Compra');
$routes->post('/Compras/Vista_Resultado_Busqueda_Proveedor', 'Compras\Compras::Vista_Resultado_Busqueda_Proveedor');
$routes->post('/Compras/Taer_Detalle_Compra', 'Compras\Compras::Taer_Detalle_Compra');
/*
 *rutas para los Precios
 *Precios\ es la subcarpeta donde esta el controlador
*/
$routes->get('/Precios/Administrar_Precios', 'Precios\Precios::index');
$routes->post('/Precios/Traer_Dato_Producto_Para_Precio', 'Precios\Precios::Traer_Dato_Producto_Para_Precio');
$routes->post('/Precios/Agregar_Precio', 'Precios\Precios::Agregar_Precio');

/*
 *rutas para las entradas al inventario
 *Inventario\ es la subcarpeta donde esta el controlador
*/
$routes->get('/Inventario/Administrar_Entradas_Al_Inventario', 'Inventario\Inventario::index');
$routes->get('/Inventario/Vista_Agregar_Entrada_Al_Inventario', 'Inventario\Inventario::Vista_Agregar_Entrada_Al_Inventario');
$routes->post('/Inventario/Procesar_Entrada', 'Inventario\Inventario::Procesar_Entrada');
$routes->post('/Inventario/Traer_Detalle_Entrada_Inventario', 'Inventario\Inventario::Traer_Detalle_Entrada_Inventario');

/*salidas del inventario*/
$routes->get('/Inventario_Salidas/Administrar_Salidas_Al_Inventario', 'Inventario_Salidas\Inventario_Salidas::index');
$routes->get('/Inventario_Salidas/Vista_Agregar_Salida_Al_Inventario', 'Inventario_Salidas\Inventario_Salidas::Vista_Agregar_Salida_Al_Inventario');
$routes->post('/Inventario_Salidas/Procesar_Salida', 'Inventario_Salidas\Inventario_Salidas::Procesar_Salida');
$routes->post('/Inventario_Salidas/Traer_Detalle_Salida_Inventario', 'Inventario_Salidas\Inventario_Salidas::Traer_Detalle_Salida_Inventario');

/*
 *rutas para las ventas
 *Ventas\ es la subcarpeta donde esta el controlador
*/
$routes->get('/Ventas/Administrar_Facturas', 'Ventas\Facturacion::index');
$routes->get('/Ventas/Bandeja_Facturas', 'Ventas\Facturacion::Bandeja_Facturas');
$routes->get('/Ventas/Nueva_Venta', 'Ventas\Facturacion::Nueva_Venta');
$routes->post('/Ventas/Traer_Cliente', 'Ventas\Facturacion::Traer_Cliente');
$routes->post('/Ventas/Vista_Resultado_Busqueda_Cliente', 'Ventas\Facturacion::Vista_Resultado_Busqueda_Cliente');
$routes->post('/Ventas/Traer_Cotizaciones', 'Ventas\Facturacion::Traer_Cotizaciones');
$routes->post('/Ventas/Buscar_Producto_Para_Venta', 'Ventas\Facturacion::Buscar_Producto_Para_Venta');
$routes->post('/Ventas/Agregar_Producto_Al_Carro', 'Ventas\Facturacion::Agregar_Producto_Al_Carro');
$routes->post('/Ventas/Ver_Productos_Del_Carrito', 'Ventas\Facturacion::Ver_Productos_Del_Carrito');
$routes->post('/Ventas/Eliminar_Producto_Del_Carito', 'Ventas\Facturacion::Eliminar_Producto_Del_Carito');
$routes->post('/Ventas/Actualizar_Items_Carrito', 'Ventas\Facturacion::Actualizar_Items_Carrito');
$routes->post('/Ventas/Limpiar_Carrito', 'Ventas\Facturacion::Limpiar_Carrito');
$routes->post('/Ventas/Guardar_Pre_Venta', 'Ventas\Facturacion::Guardar_Pre_Venta');
$routes->post('/Ventas/Guardar_Venta', 'Ventas\Facturacion::Guardar_Venta');
$routes->get('/Ventas/Imprimir_Factura/(:num)', 'Ventas\Facturacion::Imprimir_Factura/$1');
$routes->post('/Ventas/Modificar_Venta', 'Ventas\Facturacion::Modificar_Venta');
$routes->post('/Ventas/Eliminar_Pre_Factura', 'Ventas\Facturacion::Eliminar_Pre_Factura');
$routes->post('/Ventas/Traer_Detalle_Venta', 'Ventas\Facturacion::Traer_Detalle_Venta');
$routes->post('/Ventas/Traer_Detalle_Factura', 'Ventas\Facturacion::Traer_Detalle_Factura');

/*
 *rutas para los reportes
 *Reportes\ es la subcarpeta donde esta el controlador
*/
$routes->get('/Reportes/Utilidad', 'Reportes\Reportes::index');
$routes->post('/Reportes/Reporte_De_Utilidad', 'Reportes\Reportes::Reporte_De_Utilidad');
$routes->get('/Reportes/Ventas', 'Reportes\Reportes::Ventas');
$routes->post('/Reportes/Reporte_De_Ventas', 'Reportes\Reportes::Reporte_De_Ventas');
$routes->get('/Reportes/Productos', 'Reportes\Reportes::Productos');
$routes->post('/Reportes/Reporte_De_Productos', 'Reportes\Reportes::Reporte_De_Productos');
$routes->get('/Reportes/Kardex', 'Reportes\Reportes::Kardex');
$routes->post('/Reportes/Reporte_De_Kardex', 'Reportes\Reportes::Reporte_De_Kardex');
$routes->get('/Reportes/Precios', 'Reportes\Reportes::Precios');
$routes->post('/Reportes/Reporte_Precios', 'Reportes\Reportes::Reporte_Precios');

/*
 *rutas para los tipos de usuarios
 *Tipos_Usuarios\ es la subcarpeta donde esta el controlador
*/
$routes->get('/Tipos_Usuarios/Administrar_Tipos_Usuarios', 'Tipos_Usuarios\Tipos_Usuarios::index');
$routes->get('/Tipos_Usuarios/Vista_Agregar_Tipo_Usuario', 'Tipos_Usuarios\Tipos_Usuarios::Vista_Agregar_Tipo_Usuario');
$routes->post('/Tipos_Usuarios/Agregar_Tipo_Usuario', 'Tipos_Usuarios\Tipos_Usuarios::Agregar_Tipo_Usuario');
$routes->get('/Tipos_Usuarios/Vista_Editar_Tipo_Usuario/(:num)', 'Tipos_Usuarios\Tipos_Usuarios::Vista_Editar_Tipo_Usuario/$1');
$routes->post('/Tipos_Usuarios/Modificar_Tipo_Usuario', 'Tipos_Usuarios\Tipos_Usuarios::Modificar_Tipo_Usuario');

/*
 *rutas para los administracion general, datos de la 
 *empresa
 *Configuracion\ es la subcarpeta donde esta el controlador
*/
$routes->get('/Configuracion/Datos_Empresa', 'Configuracion\Configuracion::index');
$routes->post('/Configuracion/Actualizar_Datos_Generales', 'Configuracion\Configuracion::Actualizar_Datos_Generales');

/*
 *rutas para grficas canvas
 *Graficos\ es la subcarpeta donde esta el controlador
*/
$routes->post('/Graficos/Traer_Ventas_Semana', 'Graficos\Graficos::index');
$routes->post('/Graficos/Traer_Ventas_Mes_Por_Vendedor', 'Graficos\Graficos::Traer_Ventas_Mes_Por_Vendedor');
$routes->post('/Graficos/Traer_Top_Cinco_Productos_Mas_Vendido', 'Graficos\Graficos::Traer_Top_Cinco_Productos_Mas_Vendido');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
