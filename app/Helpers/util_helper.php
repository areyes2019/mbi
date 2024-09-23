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
	if (!function_exists('tiene_pemisos')) {
		function tiene_permisos($usuario, $seccion, $permiso)
		{
			$db = \Config\Database::connect();
			$builder = $db->table('usuarios_secciones');
			$builder->where('id_usuario',$usuario);
			$builder->where('id_seccion',$seccion);
			$resultado = $builder->get()->getResultArray();
			
			//return json_encode($resultado);
			
			if ($resultado) {
				switch ($permiso) {
	                case '1':
	                    return $resultado[0]['solo_ver'];
	                case '2':
	                    return $resultado[0]['puede_crear'];
	                case '3':
	                    return $resultado[0]['puede_modificar'];
	                case '4':
	                    return $resultado[0]['puede_eliminar'];
	                default:
	                    return false;
            	}
            	return false;
			}
		}
	}
	if (!function_exists('tiene_estatus')) {
		function tiene_estatus($usuario,$kardex){
			$db = \Config\Database::connect();
			$builder = $db->table('usuarios');
			$builder->where('id_usuario', $usuario);
			$resultado_usuario = $builder->get()->getResultArray();
			$usuario = $resultado_usuario[0]['id_rol'];

			$kardex = $db->table('mbi_kardex');
			$kardex->where('id_kardex',$kardex);
			$kardex_resultado = $kardex->get()->getResultArray();
			$kdx = $kardex_resultado[0]['estatus'];

			if ($usuario == 1 && $kdx == 1) {
				return true;
			}
		}
	}
	if (!function_exists('asignar_estatus')) {
		function asignar_estatus($estatus){
			
			$db = \Config\Database::connect();
			$builder = $db->table('mbi_proceso');
			$builder->where('id_proceso',$estatus);
			$resultado = $builder->get()->getRow();
			
			if ($resultado) {
				return [
					'nombre' => $resultado->nombre,
					'estilo' => $resultado->estilo,
				];
			}else{
				return null;

			}
		}
	}
	if (!function_exists('asignar_tipo')) {
		
		function asignar_tipo($kardex){
			
		}
	}

?>