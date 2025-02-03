<?php

use CodeIgniter\Router\RouteCollection;
/**
 * @var RouteCollection $routes
 */
$routes->get('base', 'Migraciones::index');	
$routes->get('migrar', 'Migraciones::up');	
$routes->get('regresar', 'Migraciones::down');
$routes->post('batch', 'Migraciones::batch');

$routes->group('',['filter' => 'NoLoggin'],static function($routes){
	$routes->get('/', 'Login::index');
	$routes->get('recuperar', 'Login::recuperar');
	$routes->get('crear_cuenta', 'Login::crear');
	$routes->post('nueva_cuenta', 'Login::insertar');
	$routes->post('entrar', 'Login::validar_entrada');

	$routes->get('password/request', 'PasswordResetController::requestForm');
	$routes->post('password/email', 'PasswordResetController::sendResetLink');
	$routes->get('password/reset/(:any)', 'PasswordResetController::showResetForm/$1');
	$routes->post('password/reset', 'PasswordResetController::resetPassword');
});


$routes->group('',['filter' => 'AuthFilter'],static function($routes){
	


	$routes->get('/salir', 'Login::salir');	
	//usuarios

	//config
	$routes->get('entidades', 'Entidades::index');
	$routes->get('entidades/create', 'Entidades::create');
	$routes->post('entidades/store', 'Entidades::store');
	$routes->get('entidades/show/(:num)', 'Entidades::show/$1');
	$routes->get('entidades/edit/(:num)', 'Entidades::edit/$1');
	$routes->post('entidades/update/(:num)', 'Entidades::update/$1');
	$routes->get('entidades/delete/(:num)', 'Entidades::delete/$1');



	$routes->get('/inicio', 'Admin::index');	
	$routes->get('/usuarios', 'Usuarios::index');	
	$routes->post('/nuevo_usuario', 'Usuarios::nuevo');	
	$routes->get('editar_usuario/(:num)', 'Usuarios::editar/$1');	
	$routes->get('ver_usuario/(:num)', 'Usuarios::ver/$1');	
	$routes->post('actualizar_usuario', 'Usuarios::actualizar');	
	$routes->get('eliminar_usuario/(:num)', 'Usuarios::eliminar/$1');	
	$routes->get('permisos/(:num)', 'Usuarios::permisos/$1');
	$routes->get('/ver_permisos/(:num)', 'Usuarios::ver_permisos/$1');
	$routes->post('/actualizar_permiso', 'Usuarios::actualizar_permiso');	
	$routes->post('/agregar_seccion_usuario', 'Usuarios::agregar_seccion_usuario');	
	$routes->get('/ver_secciones_asignadas/(:num)', 'Usuarios::ver_secciones_asignadas/$1');	
	$routes->get('perfil', 'Usuarios::modificar_perfil');	
	$routes->post('/agregar_numero_empleado', 'Usuarios::agregar_numero_empleado');	
	
	//roles y permisos
	$routes->get('roles', 'Roles::index');
	$routes->get('ver_roles', 'Roles::mostrar');
	$routes->post('agregar_rol', 'Roles::agregar');
	$routes->get('ver_secciones', 'Roles::ver_secciones');
	$routes->get('ver_permisos', 'Roles::ver_permisos');
	$routes->get('eliminar_rol/(:num)', 'Roles::eliminar_rol/$1');
	$routes->get('editar_rol/(:num)', 'Roles::editar_rol/$1');
	$routes->post('add_seccion', 'Roles::add_seccion');
	$routes->get('secciones_de_rol/(:num)', 'Roles::rol_seccion/$1');
	$routes->post('asignar_funcion', 'Roles::asignar_funcion');
	$routes->get('mostrar_permiso_seccion/(:num)', 'Roles::mostrar_permiso_seccion/$1');
	$routes->get('borrar_permiso/(:num)', 'Roles::borrar_permiso/$1');
	$routes->get('eliminar_seccion_rol/(:num)', 'Roles::eliminar_seccion_rol/$1');
	$routes->get('quitar_seccion_usuario/(:num)', 'Roles::quitar_seccion_usuario/$1');
	$routes->post('actualizar_permiso_seccion', 'Roles::editar_permiso');

	
	/*Clientes*/
	$routes->get('clientes', 'Clientes::index');
	$routes->get('agregar_cliente', 'Clientes::agregar');
	$routes->post('nuevo_cliente', 'Clientes::nuevo');
	$routes->get('editar_cliente/(:num)', 'Clientes::editar/$1');
	$routes->get('mostrar_cliente/(:num)', 'Clientes::mostrar_cliente/$1');
	$routes->post('actualizar_cliente', 'Clientes::actualizar');
	$routes->get('eliminar_cliente/(:num)', 'Clientes::eliminar/$1');
	$routes->post('agregar_horario/(:num)', 'Clientes::agregar_horario/$1');
	$routes->post('agregar_datos_fiscales', 'Clientes::agregar_datos_fiscales');
	$routes->get('mostrar_datos_fiscales/(:num)', 'Clientes::mostrar_datos_fiscales/$1');
	$routes->post('actualizar_datos_fiscales', 'Clientes::actualizar_datos_fiscales');
	$routes->post('agregar_horario', 'Clientes::agregar_horario');
	$routes->get('ver_horarios/(:num)', 'Clientes::ver_horarios/$1');
	$routes->get('eliminar_horario/(:num)', 'Clientes::eliminar_horario/$1');
	$routes->post('actualizar_hora', 'Clientes::actualizar_hora');
	$routes->post('agregar_equipo', 'Clientes::agregar_equipo');
	
	//kardex
	$routes->get('kardex/(:any)','Kardex::index/$1');
	$routes->get('kardex_general/(:any)','Kardex::master/$1');
	$routes->get('kardex_reporte','Kardex::kardex_repo');
	$routes->post('crear_kardex','Kardex::crear_kardex');
	$routes->post('detalle_kardex','Kardex::detalle_kardex');
	$routes->get('mostrar_kardex/(:num)','Kardex::mostrar_kardex/$1');
	$routes->get('ver_mis_tareas/(:num)','Kardex::ver_mis_tareas/$1');
	$routes->post('enviar_kardex','Kardex::enviar_kardex');
	$routes->get('borrar_linea/(:num)','Kardex::borrar_linea/$1');
	$routes->get('ver_kardex/(:num)','Kardex::ver_kardex/$1');
	$routes->get('ver_primer_kardex','Kardex::ver_kardex_lateral');
	$routes->post('kardex_accion','Kardex::kardex_accion');
	$routes->post('regresar_kardex','Kardex::regresar_kardex');
	$routes->get('actualizar_detalle/(:num)','Kardex::actualizar_detalle/$1');
	$routes->post('actualizar_final/(:num)','Kardex::actualizar_final/$1');
	$routes->get('eliminar_kardex/(:num)','Kardex::eliminar_kardex/$1');
	$routes->get('si_ingeniero/(:num)','Kardex::si_ingeniero/$1');
	$routes->post('agregar_diagnostico','Kardex::agregar_diagnostico');
	$routes->post('subir_imagen','Kardex::subir_imagen');
	$routes->get('modificar_diagnostico/(:any)','Kardex::modificar_diagnostico/$1');
	$routes->post('actualizacion_diagnostico','Kardex::actualizacion_diagnostico');
	$routes->get('eliminar_diagnostico/(:any)','Kardex::eliminar_diagnostico/$1');
	$routes->get('ver_galeria/(:any)','Kardex::ver_galeria/$1');
	$routes->get('liberar_diagnostico/(:num)','Kardex::liberar_diagnostico/$1');
	$routes->get('pdf_os/(:num)','Kardex::pdf_os/$1');
	$routes->post('/agregar_refacciones','Kardex::agregar_refacciones');
	$routes->post('/enviar_a_cotizar','Kardex::enviar_a_cotizar');
	$routes->get('borrar_refaccion/(:num)','Kardex::borrar_refaccion/$1');
	
	
	/*Proveedores*/
	$routes->get('proveedores', 'admin\Proveedores::index');
	$routes->post('nuevo_proveedor', 'admin\Proveedores::nuevo');
	$routes->get('editar_proveedor/(:num)', 'admin\Proveedores::editar/$1');
	$routes->post('actualizar_proveedor', 'admin\Proveedores::actualizar');
	$routes->get('eliminar_proveedor/(:num)', 'admin\Proveedores::eliminar/$1');
	$routes->get('mostrar_familias/(:num)', 'admin\Proveedores::mostrar_familias/$1');
	$routes->post('agregar_familia', 'admin\Proveedores::agregar_familia');

	/*mi tablero*/
	$routes->get('mi_tablero', 'Inbox::index');
	$routes->post('nuevo_proveedor', 'Inbox::nuevo');
	$routes->get('editar_proveedor/(:num)', 'Inbox::editar/$1');
	$routes->post('actualizar_proveedor', 'Inbox::actualizar');
	$routes->get('eliminar_proveedor/(:num)', 'Inbox::eliminar/$1');
	$routes->get('mostrar_familias/(:num)', 'Inbox::mostrar_familias/$1');
	$routes->post('agregar_familia', 'Inbox::agregar_familia');
	$routes->get('mostrar_bandeja', 'Inbox::mostrar_bandeja');
	$routes->get('vista_previa/(:num)','Inbox::vista_previa/$1');
	$routes->get('primer_kardex','Inbox::primer_kardex');

	/*Articulos*/
	$routes->get('articulos', 'admin\Articulos::index');
	$routes->get('mostrar_articulos', 'admin\Articulos::mostrar');
	$routes->get('mostrar_articulos_compras/(:num)', 'admin\Articulos::mostrar_compras/$1');
	$routes->post('nuevo_articulo', 'admin\Articulos::nuevo');
	$routes->get('editar_articulo/(:num)', 'admin\Articulos::editar/$1');
	$routes->post('actualizar_articulo', 'admin\Articulos::actualizar');
	$routes->get('eliminar_articulo/(:num)', 'admin\Articulos::eliminar/$1');

	/*Panel*/
	$routes->get('cotizaciones', 'Cotizaciones::index');
	$routes->post('nueva_cotizacion', 'Cotizaciones::nueva');
	$routes->get('cotizacion_independiente/(:num)', 'Cotizaciones::independiente/$1');
	$routes->get('clonar/(:any)', 'Cotizaciones::clonar/$1');
	$routes->get('pagina_cotizador/(:any)/(:any)', 'Cotizaciones::pagina/$1');
	$routes->get('pagina_cotizador_independiente', 'Cotizaciones::independiente/$1');
	$routes->get('editar_cotizacion/(:num)', 'Cotizaciones::editar/$1');
	$routes->get('actualizar_cotizacion/(:num)', 'Cotizaciones::actualizar/$1');
	$routes->get('eliminar_cotizacion/(:num)', 'Cotizaciones::eliminar/$1');
	$routes->post('agregar_articulo', 'Cotizaciones::agregar');
	$routes->post('agregar_articulo_ind/(:any)', 'Cotizaciones::agregar_ind/$1');
	$routes->get('mostrar_detalles/(:any)', 'Cotizaciones::mostrar_detalles/$1');
	$routes->get('borrar_linea_detalle/(:num)', 'Cotizaciones::borrar_linea_detalle/$1');
	$routes->get('descargar_cotizacion/(:num)', 'Cotizaciones::cotizacion_pdf/$1');
	$routes->get('enviar', 'Cotizaciones::enviar');
	$routes->get('enviar_pdf/(:num)', 'Cotizaciones::enviar_pdf/$1');
	$routes->post('pago', 'Cotizaciones::pago');
	$routes->post('modificar_cantidad', 'Cotizaciones::modificar_cantidad');
	$routes->post('marcar_entregado', 'Cotizaciones::entregado');
	$routes->post('agregar_condiciones', 'Cotizaciones::condiciones');
	$routes->post('/cambiar_moneda', 'Cotizaciones::cambiar_moneda');
	$routes->get('/ver_diagnostico_kardex/(:num)', 'Cotizaciones::ver_diagnostico_kardex/$1');
	$routes->post('/aceptar_rechazar', 'Cotizaciones::accion');
	$routes->get('/mostrar_entidades', 'Cotizaciones::mostrar_entidades');
	$routes->post('/agregar_inner', 'Cotizaciones::agregar_inner');
	$routes->get('/ver_microdados/(:num)', 'Cotizaciones::ver_microdados/$1');
	$routes->get('/eliminar_micro/(:num)', 'Cotizaciones::eliminar_micro/$1');


	/*Compras*/
	$routes->get('compras', 'admin\Compras::index');
	$routes->get('mostrar_compras', 'admin\Compras::mostrar');
	$routes->get('pedido/(:num)', 'admin\Compras::pedido/$1');
	$routes->get('nueva_compra/(:num)', 'admin\Compras::nueva/$1');
	$routes->get('pagina_orden/(:any)', 'admin\Compras::pagina/$1');
	$routes->get('editar_compra/(:num)', 'admin\Compras::editar/$1');
	$routes->get('actualizar_compra/(:num)', 'admin\Compras::actualizar/$1');
	$routes->get('eliminar_compra/(:num)', 'admin\Compras::eliminar/$1');
	$routes->post('agregar_articulo_compras', 'admin\Compras::agregar');
	$routes->get('mostrar_detalles_compras/(:num)', 'admin\Compras::mostrar_detalles/$1');
	$routes->get('borrar_linea_compras/(:num)', 'admin\Compras::borrar_linea/$1');
	$routes->get('descargar_orden/(:num)', 'admin\Compras::cotizacion_pdf/$1');
	$routes->get('enviar_orden', 'admin\Compras::enviar');
	$routes->get('enviar_pdf_orden/(:num)', 'admin\Compras::enviar_pdf/$1');
	$routes->post('pago_compras', 'admin\Compras::pago');
	$routes->post('compra_recibida', 'admin\Compras::recibida');
	$routes->post('modificar_cantidad_compras', 'admin\Compras::modificar_cantidad');

	/*Cuentas*/
	$routes->get('contabilidad', 'admin\Contabiidad::index');
	$routes->get('nueva_cuenta/(:num)', 'admin\Contabiidad::nuevo/$1');
	$routes->get('editar_cuenta/(:num)', 'admin\Contabiidad::editar/$1');
	$routes->post('actualizar_cuenta', 'admin\Contabiidad::actualizar');
	$routes->get('eliminar_cuenta/(:num)', 'admin\Contabiidad::eliminar/$1');
	
	/*Pedidos*/
	$routes->get('pedidos', 'admin\Pedidos::index');
	$routes->get('nuevo_pedido/(:num)', 'admin\Pedidos::nueva/$1');
	$routes->get('pagina_pedido/(:any)', 'admin\Pedidos::pagina/$1');
	$routes->get('editar_pedido/(:num)', 'admin\Pedidos::editar/$1');
	$routes->get('actualizar_pedido/(:num)', 'admin\Pedidos::actualizar/$1');
	$routes->get('eliminar_pedido/(:num)', 'admin\Pedidos::eliminar/$1');
	$routes->post('agregar_articulo_pedido', 'admin\Pedidos::agregar');
	$routes->get('mostrar_detalles_pedido/(:num)', 'admin\Pedidos::mostrar_detalles/$1');
	$routes->get('borrar_linea_pedido/(:num)', 'admin\Pedidos::borrar_linea/$1');
	$routes->get('descargar_pedido/(:num)', 'admin\Pedidos::cotizacion_pdf/$1');
	$routes->get('enviar_pedido', 'admin\Pedidos::enviar');
	$routes->get('enviar_pdf_pedido/(:num)', 'admin\Pedidos::enviar_pdf/$1');
	$routes->post('pago_pedido', 'admin\Pedidos::pago');

	/*Existencias*/
	$routes->get('existencias', 'admin\Existencias::index');
	$routes->get('nueva_existencia/(:num)', 'admin\Existencias::nuevo/$1');
	$routes->get('editar_existencia/(:num)', 'admin\Existencias::editar/$1');
	$routes->post('actualizar_existencia', 'admin\Existencias::actualizar');
	$routes->get('eliminar_existencia/(:num)', 'admin\Existencias::eliminar/$1');

	$routes->get('nueva_venta', 'admin\Ventas::nueva');
	$routes->get('cotizaciones', 'admin\Cotizaciones::index');
	$routes->get('editar_cotizacion', 'admin\Cotizaciones::editar');
	//$routes->get('nueva_cotizacion', 'admin\Cotizaciones::nueva');

	//facturacion
	$routes->post('/facturar/', 'Facturacion::index');
	$routes->get('/facturas/', 'Facturacion::lista');
	$routes->post('/descargar_factura/', 'Facturacion::descargar');
	$routes->get('/descargar/(:num)', 'Facturacion::descargar/$1');


});


