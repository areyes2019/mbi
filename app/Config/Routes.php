<?php

use CodeIgniter\Router\RouteCollection;
/**
 * @var RouteCollection $routes
 */
$routes->group('',['filter' => 'NoLoggin'],static function($routes){
	$routes->get('/', 'Login::index');
	$routes->get('recuperar', 'Login::recuperar');
	$routes->get('crear_cuenta', 'Login::crear');
	$routes->post('nueva_cuenta', 'Login::insertar');
	$routes->post('entrar', 'Login::validar_entrada');
});


$routes->group('',['filter' => 'AuthFilter'],static function($routes){
	
	$routes->get('/salir', 'Login::salir');	
	
	//usuarios
	$routes->group('',['filter'=> 'mifiltro'],static function($routes){
	});
	$routes->get('/usuarios', 'Usuarios::index');	
	$routes->get('/nuevo_usuario', 'Usuarios::nuevo');	
	$routes->get('editar_usuario/(:num)', 'Usuarios::editar/$1');	
	$routes->get('ver_usuario/(:num)', 'Usuarios::ver/$1');	
	$routes->post('actualizar_usuario', 'Usuarios::actualizar');	
	$routes->get('eliminar_usuario', 'Usuarios::eliminar');	
	$routes->get('permisos/(:num)', 'Usuarios::permisos/$1');
	$routes->get('/ver_permisos/(:num)', 'Usuarios::ver_permisos/$1');
	$routes->post('/actualizar_permiso', 'Usuarios::actualizar_permiso');	
	$routes->get('/inicio', 'Admin::index');	
	$routes->post('/agregar_rol_usuario', 'Usuarios::agregar_rol_usuario');	
	$routes->get('/ver_roles_asignados/(:num)', 'Usuarios::ver_roles_asignados/$1');	
	
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
	$routes->post('agregar_permiso', 'Roles::agregar_permiso');
	$routes->get('mostrar_permiso_seccion/(:num)', 'Roles::mostrar_permiso_seccion/$1');
	$routes->get('borrar_permiso/(:num)', 'Roles::borrar_permiso/$1');
	$routes->get('eliminar_seccion_rol/(:num)', 'Roles::eliminar_seccion_rol/$1');
	$routes->get('quitar_rol_usuario/(:num)', 'Roles::quitar_rol_usuario/$1');

	
	//kardex
	$routes->get('kardex','Kardex::index');


	$routes->get('/inicio', 'Admin::index');	
	/*Clientes*/
	$routes->get('clientes', 'Clientes::index');
	$routes->get('agregar_cliente', 'Clientes::agregar');
	$routes->post('nuevo_cliente', 'Clientes::nuevo');
	$routes->get('editar_cliente/(:num)', 'Clientes::editar/$1');
	$routes->post('actualizar_cliente', 'Clientes::actualizar');
	$routes->get('eliminar_cliente/(:num)', 'Clientes::eliminar/$1');
	
	/*Proveedores*/
	$routes->get('proveedores', 'admin\Proveedores::index');
	$routes->post('nuevo_proveedor', 'admin\Proveedores::nuevo');
	$routes->get('editar_proveedor/(:num)', 'admin\Proveedores::editar/$1');
	$routes->post('actualizar_proveedor', 'admin\Proveedores::actualizar');
	$routes->get('eliminar_proveedor/(:num)', 'admin\Proveedores::eliminar/$1');
	$routes->get('mostrar_familias/(:num)', 'admin\Proveedores::mostrar_familias/$1');
	$routes->post('agregar_familia', 'admin\Proveedores::agregar_familia');

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
	$routes->get('nueva_cotizacion/(:num)', 'Cotizaciones::nueva/$1');
	$routes->get('pagina_cotizador/(:any)', 'Cotizaciones::pagina/$1');
	$routes->get('editar_cotizacion/(:num)', 'Cotizaciones::editar/$1');
	$routes->get('actualizar_cotizacion/(:num)', 'Cotizaciones::actualizar/$1');
	$routes->get('eliminar_cotizacion/(:num)', 'Cotizaciones::eliminar/$1');
	$routes->post('agregar_articulo', 'Cotizaciones::agregar');
	$routes->post('agregar_articulo_ind', 'Cotizaciones::agregar_ind');
	$routes->get('mostrar_detalles/(:num)', 'Cotizaciones::mostrar_detalles/$1');
	$routes->get('borrar_linea/(:num)', 'Cotizaciones::borrar_linea/$1');
	$routes->get('descargar_cotizacion/(:num)', 'Cotizaciones::cotizacion_pdf/$1');
	$routes->get('enviar', 'Cotizaciones::enviar');
	$routes->get('enviar_pdf/(:num)', 'Cotizaciones::enviar_pdf/$1');
	$routes->post('pago', 'Cotizaciones::pago');
	$routes->post('modificar_cantidad', 'Cotizaciones::modificar_cantidad');
	$routes->post('marcar_entregado', 'Cotizaciones::entregado');

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
	$routes->get('nueva_cotizacion', 'admin\Cotizaciones::nueva');
});


