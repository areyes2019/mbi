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
					'icon' => $resultado->icon,
				];
			}else{
				return null;

			}
		}
	}
	if (!function_exists('rol_usuario')) {
		
		function rol_usuario($usuario, $rol){
			$db = \Config\Database::connect();
			$builder = $db->table('usuarios');
			$builder->where('id_usuario',$usuario);
			$resultado = $builder->get()->getRow();
			$id = $resultado->id_rol;

			if ($id == $rol) {
				return true;
			}
		}
	}
	if (!function_exists('estatus_permiso')) {
		function estatus_permiso($estatus,$kardex){
			//buscamos el kardex 
			$db = \Config\Database::connect();
			$builder = $db->table('mbi_kardex');
			$builder->where('id_kardex',$kardex);
			$resultado = $builder->get()->getRow();
			$permiso = $resultado->estatus;

			if ($permiso == $estatus) {
				return true;
			}

		}
	}
	if (!function_exists('permisos')) {
		function permisos($estatus, $boton){

			$db = \Config\Database::connect();
			$builder = $db->table('usuarios');
			$builder->where('id_usuario',session('id_usuario'));
			$resultado = $builder->get()->getRow();

			$rol = $resultado->id_rol;

			switch ($boton) {
                case 'turnar':
	                if ($estatus == 1 && $rol== 1) {
	                	return true;
	                }elseif ($estatus == 2 && $rol == 2) {
	                	return true;
	                }elseif ($estatus == 3 && $rol == 1) {
	                	return true;
	                }elseif ($estatus == 5 && $rol == 2) {
	                	return true;
	                }
	               break;
                case 'equipos':
                	if ($estatus == 1 && $rol== 1) {
	                	return true;
	                }elseif ($estatus == 3 && $rol == 1) {
	                	return true;
	                }
	               	break;
                case 'aceptar_tarea':
                    if ($estatus == 4 && $rol== 3) {
	                	return true;
	                }elseif ($estatus == 5 && $rol == 3) {
	                	return false;
	                }
	               break;
	            case 'editar_eliminiar':
                    if ($estatus == 1 && $rol== 1) {
	                	return true;
	                }elseif($estatus == 3 && $rol == 1) {
	                	return true;
	                }
	               break;
	            case 'panel_eliminar':
                    if ($estatus == 1 && $rol==1) {
                    	return true;
                    }elseif ($estatus == 3 && $rol == 1) {
                    	return true;
                    }
	               break;
	            case 'ver_kardex':
                    if ($rol==3) {
                    	return true;
                    }
	               break;
	            case 'panel_editar':
                    if ($rol!=3) {
                    	return true;
                    }
	               break;
	            case 'imagen_diagnostico':
                    if ($estatus == 6 && $rol == 3) {
                    	return true;
                    }
	               break;
                default:
                    return false;
        	}

		}
	}
	if (!function_exists('buscar_horario')) {
		function buscar_horario($horario){
			$db = \Config\Database::connect();
			$builder = $db->table('mbi_horarios_atencion');
			$builder->where('id_horario',$horario);
			$resultado = $builder->get()->getRow();
			$hora_inicio = date("g:i A",strtotime($resultado->hora_inicio));
			$hora_fin = date("g:i A",strtotime($resultado->hora_fin));
			$horario_definido = $resultado->dia." "."De:"." ".$hora_inicio." "."A:".$hora_fin;

			return json_encode($horario_definido);
		}
	}
	
?>