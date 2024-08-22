<?php
	if (!function_exists('tiene_permiso')) {
		
		function tiene_seccion($seccion)
		{
			$id = session('id_usuario');
			
			$db = \Config\Database::connect();
			$builder = $db->table('usuarios_secciones');
			$builder->where('id_usuario',$id);
			$builder->where('id_seccion',$seccion);
			$resultado = $builder->get()->getResultArray();

			if (empty($resultado)) {
				return false;
			}else{
				return true;
			};
			
		}

	}
	if (!function_exists('es_super_admin')) {
		
		function es_super_admin()
		{
			if (session('tipo')==1) {
				return true;
			}else{
				return false;
			}
		}
	}
?>