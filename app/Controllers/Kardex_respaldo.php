<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ClientesModel;
use App\Models\KardexModel;
use App\Models\KardexDetalleModel;
use App\Models\HorariosModel;
use App\Models\UsuariosModel;
use App\Models\MensajeModel;
use App\Models\RefaccionesModel;
use App\Models\CotizacionesModel;
use App\Models\KardexDiagnosticoModel;
use App\Models\KardexDiagnosticoImgModel;
use App\Models\EntidadesModel;
use Dompdf\Dompdf;
class Kardex extends BaseController
{
    public function index($id,$slug)
    {
        // Conexión a la base de datos
        $db = \Config\Database::connect();

        // Consulta principal del kardex
        $builder = $db->table('mbi_kardex');
        $builder->join('mbi_clientes', 'mbi_clientes.id_cliente = mbi_kardex.id_cliente');
        $builder->where('id_kardex', $id);
        $resultado = $builder->get()->getResultArray();
        if (!$resultado) {
            return "No hay datos en la consulta resultado";
        }
        $fecha = $this->formatearFecha($resultado[0]['fecha_registro']);

        //buscamos al usuario
        $user = session('id_usuario');
        $usuario = new UsuariosModel();
        $resultado_usuario = $usuario->find($user);

        if (!$resultado_usuario){
            return "no hay usuario";
        }

        $data=[
            'slug'=>$slug,
            'id'=>$id,
            'clientes'=>$resultado,
            'fecha'=> $fecha,
            'usuario'=>$resultado_usuario
        ];

        return view('kardex',$data);
    }
    public function mostrar_reporte($id)
    {
        if (empty($id)) {
            return "no hay datos en el id";
        }

        $reporte = [];

        $reporte_query = new KardexDetalleModel();
        $reporte_query->where('id_kardex',$id);
        $reporte = $reporte_query->findAll();
        if (!$reporte){
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'No hay reporte',
                'flag'=>0
            ]);
        }
        return json_encode($reporte);
    }
    public function ver_diagnostico($id)
    {   
        if (!$id){
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'No hay id',
                'flag'=>0
            ]);
        }

        $model = new KardexDiagnosticoModel();
        $resultado = $model->find($id);

        if (!$resultado){
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'No hay resultado',
                'flag'=>0
            ]);
        }

        return json_encode($resultado);
    }
    public function mostrar_refacciones($id)
    {
        if (!$id){
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'No hay id',
                'flag'=>0
            ]);
        }

        $model = new RefaccionesModel();
        $model->where('id_diagnostico',$id);
        $resultado = $model->findAll();
        if ($resultado) {
            return json_encode($resultado);
        }else{
            return json_encode(['status'=>'error','message'=>'No hay datos que mostrar']);
        };
    }
    public function mostrar_imagenes($id)
    {
        $model = new KardexDiagnosticoImgModel();
        $model->where('id_kardex_diagnostico',$id);
        $resultado = $model->findAll();
        if (!$resultado) {
            return json_encode(['status'=>'error','message'=>'No hay datos que mostrar']);
        };
        
        return json_encode($resultado);
    }
   public function eliminar_img($id)
    {
        $img = new KardexDiagnosticoImgModel();

        // Verificar si el ID está vacío
        if (empty($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No hay id',
                'flag' => 0
            ]);
        }

        try {
            // Intentar eliminar la imagen
            $delete = $img->delete($id);

            if ($delete) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Se eliminó la imagen con éxito',
                    'flag' => 1
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'No se pudo eliminar la imagen',
                    'flag' => 0
                ]);
            }
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda ocurrir
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Ocurrió un error al intentar eliminar la imagen: ' . $e->getMessage(),
                'flag' => 0
            ]);
        }
    }
    private function formatearFecha($fechaOriginal)
    {
        $dias = [
            'Sunday' => 'domingo', 'Monday' => 'lunes', 'Tuesday' => 'martes',
            'Wednesday' => 'miércoles', 'Thursday' => 'jueves', 'Friday' => 'viernes',
            'Saturday' => 'sábado'
        ];
        $meses = [
            'January' => 'enero', 'February' => 'febrero', 'March' => 'marzo',
            'April' => 'abril', 'May' => 'mayo', 'June' => 'junio', 'July' => 'julio',
            'August' => 'agosto', 'September' => 'septiembre', 'October' => 'octubre',
            'November' => 'noviembre', 'December' => 'diciembre'
        ];

        $fecha = new \DateTime($fechaOriginal);
        $dia = $dias[$fecha->format('l')];
        $mes = $meses[$fecha->format('F')];
        return ucfirst("$dia, " . $fecha->format('d') . " de $mes de " . $fecha->format('Y'));
    }
    public function mostrar_cliente($id)
    {
    }
    public function master()
    {   
        $uri = service('uri');
        $id_kardex = $uri->getSegment(3);
        echo $id_kardex;
    }    
    public function crear_kardex()
    {
        $json = $this->request->getJSON();

        $tipo = isset($json->tipo) ? filter_var($json->tipo, FILTER_VALIDATE_INT) : null;
        $cliente = isset($json->cliente) ? filter_var($json->cliente, FILTER_VALIDATE_INT) : null;


        $tipos_validos = [
            1 => "Diagnóstico",
            2 => "Refacciones",
            3 => "Mtto.Prev",
            4 => "Garantía"
        ];

        if (!array_key_exists($tipo, $tipos_validos)) {
            return json_encode(['error' => 'Tipo no válido']);
        }

        $tipo_txt = $tipos_validos[$tipo];

        // Validar cliente en la base de datos
        $clienteModel = new ClientesModel();
        if (!$clienteModel->find($cliente)) {
            return json_encode(['error' => 'Cliente no encontrado']);
        }

        // Obtener nombre del usuario autenticado
        $usuarioModel = new UsuariosModel();
        $usuario = $usuarioModel->find(session('id_usuario'));

        if (!$usuario) {
            return json_encode(['error' => 'Usuario no encontrado']);
        }

        $nombre_completo = $usuario['nombre'] . " " . $usuario['apellidos'];

        // Generar slug seguro
        $slug = strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));

        $nuevo = new KardexModel();
        $data = [
            'slug' => $slug,
            'id_cliente' => $cliente,
            'generado_por' => session('id_usuario'),
            'generado_nombre' => $nombre_completo,
            'tipo' => $tipo,
            'tipo_txt' => $tipo_txt,
            'atendido_por' => session('id_usuario'),
        ];


        if (!$nuevo->insert($data)) {
            return json_encode(['error' => 'No se pudo insertar el reporte']);
        }
        //buscamos el kardex que se acaba de generar
        $kardex = new KardexModel();
        $id_kardex = $kardex->select('id_kardex')->where('slug',$slug)->first();
         $id = $id_kardex['id_kardex'];

        return json_encode([
            'exito' => 1,
            'slug' => $id,
            'slg'=>$slug,
        ]);
         
    }
    public function detalle_kardex()
    {
        $model = new KardexDetalleModel();
        $data = [
            'nombre' => $this->request->getvar('nombre'),
            'marca' => $this->request->getvar('marca'),
            'modelo' => $this->request->getvar('modelo'),
            'serie' => $this->request->getvar('serie'),
            'inventario' => $this->request->getvar('inventario'),
            'falla' => $this->request->getvar('falla'),
            'id_kardex' => $this->request->getvar('kardex'),
        ];

        if ($model->insert($data)) {
            echo 1;
        }   
    }
    public function agregar_diagnostico()
    {
        
        $request = $this->request->getJSON(true);
        if (empty($request) || !is_array($request)) {
            return $this->response->setJSON([
                'status'=> 'error',
                'message'=>'No hay datos en el request'
            ]);
        }

    
        $data = [
           'id_diagnostico' => intval($request['id_detalle']),  
           'diagnostico'=> $request['diagnostico'], 
           'reparacion'=> $request['reparacion'], 
           'tiempo_entrega'=> $request['tiempo_entrega'], 
           'precio_estimado'=> $request['precio_estimado'], 
           'id_kardex' => $request['kardex'], 
        ];


        $model = new KardexDiagnosticoModel();
        $insert = $model->insert($data);
        if ($insert === false) {
            return $this->response->setJSON([
                'status'=> 'error',
                'message'=>'No se pudo insertar el registro',
                'flag'=> 0
            ]);
        }else{
            return $this->response->setJSON([
                'status'=> 'success',
                'message'=>'El registro se insertó correctamente',
                'flag'=>1
            ]);
        }
        

    }
    public function actualizacion_diagnostico()
    {
        $model = new KardexDiagnosticoModel();

        $request = $this->request->getJSON();

        $diagnostico = $request->diagnostico;
        $precio = $request->precio_estimado;
        $tiempo = $request->tiempo_entrega;
        $reparacion = $request->reparacion;

        $data = [
            'diagnostico' => $diagnostico,
            'precio_estimado' => $precio,
            'reparacion' => $reparacion,
            'tiempo_entrega' => $tiempo,
        ];

        $slug = $request->slug;

        if ($model->update($slug,$data)) {
            return json_encode('1');
        }
        return json_encode($request);
    }
    public function modificar_diagnostico($id_detalle)
    {
        $slug_query = new KardexDiagnosticoModel();
        $slug_query->where('id_detalle_kardex',$id_detalle);
        $resultado = $slug_query->findAll();
        return json_encode($resultado);
    }
    public function eliminar_diagnostico($id)
    {
        // Verificar si el ID es válido y numérico
        if (!is_numeric($id) || $id <= 0) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ID de diagnóstico no válido',
                'flag'    => 0,
            ]);
        }

        // Iniciar la transacción
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Instanciar modelos
            $fotosModel       = new KardexDiagnosticoImgModel();
            $refaccionesModel = new RefaccionesModel();
            $diagnosticoModel = new KardexDiagnosticoModel();

            // Obtener fotos relacionadas
            $fotos = $fotosModel->where('id_kardex_diagnostico', $id)->asArray()->findAll();

            foreach ($fotos as $foto) {
                $rutaImagen = FCPATH . 'public/equipos/' . $foto['img']; // Ruta absoluta

                // Verificar si el archivo existe y eliminarlo
                if (is_file($rutaImagen) && file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }
            }

            // Eliminar registros de imágenes
            $fotosModel->where('id_kardex_diagnostico', $id)->delete();

            // Eliminar refacciones asociadas
            $refaccionesModel->where('id_diagnostico', $id)->delete();

            // Eliminar el diagnóstico
            if (!$diagnosticoModel->delete($id)) {
                throw new \Exception('No se pudo eliminar el diagnóstico');
            }

            // Confirmar transacción
            $db->transComplete();

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Registro eliminado correctamente',
                'flag'    => 1,
            ]);
        } catch (\Exception $e) {
            // Revertir cambios en caso de error
            $db->transRollback();

            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $e->getMessage(),
                'flag'    => 0,
            ]);
        }
    }

    public function enviar_kardex()
    {
        /*$session = session();
        return json_encode($session->get());*/

        $correo  = env('MY_GLOBAL_VAR');

        $db = \Config\Database::connect();
        
        //datos de entrada
        $kardex = $this->request->getvar('kardex');
        $destinatario_id = $this->request->getvar('destinatario');
        $hora = $this->request->getvar('hora');
        $dia = $this->request->getvar('dia');


        // Validar que se haya recibido un ID de kardex
        if (!$kardex) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ID de Kardex no recibido']);
        }

        //datos del kardex
        $kardex_model = new KardexModel();
        $resultado_kardex = $kardex_model->select('estatus')->where('id_kardex',$kardex)->first();
        $estatus = $resultado_kardex['estatus'];
        
        //tenemos la variable de sesion     
        $rol = session('id_rol');
        $enviado_por = session('id_usuario'); //esto es para el correo electronico

        //enviamos el kardex a su destino
        if ($estatus == 1 && $rol == 1) { //esta en borrador y lo tiene el vendedor
            $data = [
                'estatus' => 2, // Cambiamos el estatus a revisión
                'atendido_por' => $destinatario_id  //se lo enviamos al administrador
            ];

            if ($kardex_model->update($kardex,$data)) {
                $usuario_model = new UsuariosModel();

                //enviamos el correo al destinatario
                $destinatario = $usuario_model->select('correo')->where('id_usuario',$destinatario_id)->first(); //obtenemos el dest.
                if ($destinatario && isset($destinatario['correo'])) {
                    $cuerpo = [
                        'envia'=>$correo,
                        'recibe'=>$destinatario['correo'],
                        'kardex'=>$kardex,
                        'mensaje'=>"Tienes un kardex nuevo",
                        'asunto'=>"Tienes un kardex nuevo"
                    ];
                    $this->enviarCorreo($cuerpo);
                }
                return $this->response->setJSON(['status'=>'success', 'message'=>'Se envio el kardex a revision']);
            }else{
                return $this->response->setJSON(['status'=>'error', 'message'=>'No se pudo enviar a revision']);
            }

        }elseif($estatus == 2 && $rol == 2){ //si lo tiene el adminstrador esta en revision y se lo manda a tecnico 
            
            //buscamos el correo de quien recibe
            $usuario_model = new UsuariosModel();
            $recibe = $usuario_model->select('correo')->where('id_usuario',$destinatario_id)->first(); 

            //tenemos los datos del kardex
            $data=[
                'estatus'=> 4,
                'dia'=>$dia,
                'hora'=>$hora,
                'atendido_por' => $destinatario_id
            ];
            //aqui los datos del correo
            $cuerpo = [
                'envia'=>$correo,
                'recibe'=>$recibe['correo'],
                'kardex'=>$kardex,
                'mensaje'=>"Tienes un kardex nuevo, revisa tu panel",
                'asunto'=>"Se te esta asignando el Kardex No: ".$kardex
            ];
            if ($kardex_model->update($kardex,$data)) {
                $this->enviarCorreo($cuerpo);
                return $this->response->setJSON(['status'=>'success', 'message'=>'Se mado el kardex a diagnóstico']);
            }
        };/*elseif($estatus == 3 && $rol == 2){
            $estatus_id = 2;
            $data['estatus'] = $estatus_id;
            $data['dia'] = null;
            $data['hora'] = null;
            if ($estatus_query->update($kardex,$data)) {
                echo 1;
            }
        }elseif($estatus == 2 && $rol == 3 ){
            $estatus_id = 4;
            $data['estatus'] = $estatus_id;
            $data['dia'] = $dia;
            $data['hora'] = $hora;
            if ($estatus_query->update($kardex,$data)) {
                echo 1;
            }
        }elseif($estatus == 5 && $rol == 3 ){
            $estatus_id = 4;
            $data['estatus'] = $estatus_id;
            $data['dia'] = $dia;
            $data['hora'] = $hora;
            if ($estatus_query->update($kardex,$data)) {
                echo 1;
            }
        }*/
        
        return $this->response->setJSON(['status' => 'error', 'message' => 'No tienes permisos para esta acción']);

    }
    public function si_ingeniero($id)
    {
        $model = new UsuariosModel();
        $model->where('id_usuario',$id);
        $resultado = $model->findAll();
        if ($resultado[0]['id_rol']==3) {
            echo 1;
        }
    }
    public function eliminar_kardex($id)
    {

        //aqui tenemos todos los modelos que vamos a necesitar
        $kardex = new KardexModel();
        $diagnosticoModel = new KardexDiagnosticoModel();
        $slugModel = new KardexDetalleModel();
        $imgModel = new KardexDiagnosticoImgModel();
        
       
    }   
    public function borrar_linea($id)
    {
        if (empty($id)){
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'No hay id',
                'flag'=>0
            ]);
        }

        $model = new KardexDetalleModel();
        $delete = $model->delete($id);
        if ($delete == true){
            return $this->response->setJSON([
                'status'=>'success',
                'message'=>'Se ejecutó el borrado',
                'flag'=>1
            ]);
        }

    }
    //esta funcion lanza el kardez al modal para verlo en vista rápida
    public function ver_kardex($id)
    {

        $db = \Config\Database::connect();
        
        $builder = $db->table('mbi_kardex');
        $builder->join('mbi_clientes','mbi_clientes.id_cliente = mbi_kardex.id_cliente');
        $builder->where('id_kardex',$id);
        $resultado = $builder->get()->getResultArray();
        $id_kardex = $resultado[0]['id_kardex'];
        //buscamos los detalles del kardex

        $detalles = new KardexDetalleModel();
        $detalles->where('id_kardex', $id_kardex);
        $resultado_detalles = $detalles->findAll();


        $data=[
            'kardex'=>   $resultado,
            'detalles'=> $resultado_detalles
        ];
        return json_encode($data);
    }
    //esta funcion muestra el cardex en la barra lateral
    public function ver_kardex_lateral($id)
    {
        

        $db = \Config\Database::connect();
        
        $builder = $db->table('mbi_kardex');
        $builder->join('mbi_clientes','mbi_clientes.id_cliente = mbi_kardex.id_cliente');
        $builder->where('mbi_kardex.id_kardex',$id);
        $resultado = $builder->get()->getResultArray();

        $model = new KardexDetalleModel();
        $model->where('id_kardex',$id);
        $resultado_detalle = $model->findAll();

        $data = [
            'kardex' => $resultado,
            'kardex_detalle' => $resultado_detalle,
        ];
        return json_encode($data);
    }
    public function ver_primer_kardex()
    {
        $db = \Config\Database::connect();
        
        $builder = $db->table('mbi_kardex')
        ->join('mbi_clientes','mbi_clientes.id_cliente = mbi_kardex.id_cliente')
        ->orderBy('id_kardex','DESC')
        ->limit(1);
        $query = $builder->get();

        $detalle = new KardexDetalleModel();
        $detalle->where('id_kardex', $resultado['id_kardex']);
        $resultado_detalle = $detalle->findAll();

        $data = [
            'primer_kardex' => $query,
            'primer_detalle' => $resultado_detalle,
        ];
        return json_encode($data);

    }
    public function subir_imagen()
    {
        $imagen = $this->request->getFile('imagen');
        $id_diagnostico = $this->request->getVar('slug');
        // Validar que el archivo y el ID del diagnóstico estén presentes
        if (!$imagen || !$id_diagnostico) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Datos incompletos',
                'flag' => 0,
            ]);
        }

        // Validar la extensión del archivo
        $extension = $imagen->getClientExtension();
        $permitidos = ['png', 'jpeg', 'jpg'];
        if (!$imagen->isValid() || !in_array($extension, $permitidos)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Solo se permiten imágenes válidas (png, jpeg, jpg)',
                'flag' => 0,
            ]);
        }

        // Generar un nombre único para la imagen
        $nuevo_nombre = $imagen->getRandomName();

        // Mover la imagen al directorio deseado
        try {
            if ($imagen->move('public/equipos', $nuevo_nombre)) {
                $img = new KardexDiagnosticoImgModel();
                $data = [
                    'img' => $nuevo_nombre,
                    'id_kardex_diagnostico' => $id_diagnostico,
                ];

                // Insertar la información en la base de datos
                if ($img->insert($data)) {
                    return $this->response->setJSON([
                        'status' => 'success',
                        'message' => 'Foto subida con éxito',
                        'flag' => 1,
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Error al guardar la información en la base de datos',
                        'flag' => 0,
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Error al mover la imagen',
                    'flag' => 0,
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error inesperado: ' . $e->getMessage(),
                'flag' => 0,
            ]);
        }

        
    }
    public function kardex_accion()
    {
        
        $correo = env('MY_GLOBAL_VAR');
       
        $json = $this->request->getJSON();

        // Obtén el correo desde las variables de entorno

        // Validar que los datos necesarios estén presentes
        if (empty($json)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Datos incompletos']);
        }

        // Cargar el modelo
        $model = new KardexModel();
        $kardex = $json->kardex;
        // Buscar el registro en la base de datos
        $resultado = $model->find($kardex);

        // Verificar si el registro existe
        if (!$resultado) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Registro no encontrado']);
        }

        // Verificar el estatus actual del registro
        if ($resultado['estatus'] != 4) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Acción no permitida en el estatus actual']);
        }

        // Preparar los datos para la actualización
        $data = [
            'kardex' => $kardex,
            'accion' => $json->accion,
            'razon'  => $json->razon
        ];

        // Realizar la acción correspondiente
        if ($json->accion == 1) { // Aceptar
            $data['aceptado'] = date('Y-m-d');
            $data['estatus'] = 6;
        } elseif ($accion == 2) { // Rechazar
            $data['rechazado'] = date('Y-m-d');
            $data['estatus'] = 5;
            $data['rechazo_razon'] = $razon;

            // Enviar correo electrónico
            $message = view('email/enviar_kardex', ['mensaje' => $razon]);
            $email_service = \Config\Services::email();
            $email_service->setFrom($correo, 'Grupo MBI');
            $email_service->setTo($resultado['correo']); // Asumiendo que el correo está en el resultado
            $email_service->setSubject('Nueva orden de servicio. No responder');
            $email_service->setMessage($message);
            $email_service->setMailType('html');

            if (!$email_service->send()) {
                log_message('error', 'Error al enviar el correo: ' . $email_service->printDebugger(['headers']));
                return $this->response->setStatusCode(500)->setJSON(['error' => 'Error al enviar el correo']);
            }
        } else {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Acción no válida']);
        }

        // Actualizar el registro en la base de datos
        if ($model->update($kardex, $data)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Error al actualizar el registro']);
        }
    }
    public function regresar_vendedor()
    {
        

        //esto es lo que viene por el post
        $kardex = $this->request->getvar('id');
        $msg = $this->request->getvar('mensaje');

        //return json_encode(['kardex'=>$kardex,'asunto'=>$asunto,'mensaje'=>$msg]);

        if ($kardex && $msg) { //comprobamos si hay variables en el input
            //necesitamo saber quien lo mando
            $model = new KardexModel();
            $resultado = $model->select('generado_por')->where('id_kardex',$kardex)->first();
            //sacamos su correo
            $correo_model = new UsuariosModel();
            $recibe =  $correo_model->select('correo')->where('id_usuario',$resultado['generado_por'])->first(); 
            $envia =   $correo_model->select('correo')->where('id_usuario',session('id_usuario'))->first(); 
            
            if ($resultado) { //comprobamos si la consulta tiene resutados
                $data = [
                    'estatus'=>1,
                    'atendido_por'=>$resultado['generado_por'],
                    'rechazado'=>1,
                    'rechazo_razon'=>$msg,
                ];
                if ($model->update($kardex,$data)) { //comrobamos si se acutalizo el kardex
                    $cuerpo = [
                        'envia'=>$envia['correo'],
                        'recibe'=>$recibe['correo'],
                        'kardex'=>$kardex,
                        'mensaje'=>$msg,
                        'asunto'=>'Te han regresado el Kardex No. # '.$kardex
                    ];
                    $this->enviarCorreo($cuerpo);
                    return $this->response->setJSON(['status'=>'success','message'=>'El Kardex se devolvio correctamente']);
                }else{
                    return $this->response->setJSON(['status'=>'success','message'=>'El Kardex no se devolvió']);
                }
                
            }else{
                return $this->response->setJSON(['status'=>'success','message'=>'No hay datos de kardex']);
            }

        }else{
            return $this->response->setJSON(['status'=>'success','message'=>'No hay datos de entrada']);
        }

    }
    public function regresar_kardex()
    {
        $id = session('id_usuario');

        $kardex_query = new KardexModel();    
        //estos son los datos que vienen del formulario
        $kardex = $this->request->getvar('id');
        $razon = $this->request->getvar('razon');

        $model = new UsuariosModel();
        $model->where('id_usuario',$id);
        $resultado = $model->findAll();
        $nombre_completo = $resultado['0']['nombre']." ".$resultado[0]['apellidos'];

        //vamos a encontrar los datos del destinatario

        $kardex_query->where('id_kardex', $kardex);
        $resultado_kardex = $kardex_query->findAll();

        $data = [
            'comentarios' => $razon,
            'estatus'=>3,
            'reenviado_por'=>$id,
            'reenviado_nombre'=>$nombre_completo

        ];

        if ($kardex_query->update($kardex,$data)) {
            echo 1;
    }
     
    }
    public function actualizar_detalle($id)
    {
       if (!$id){
           return $this->response->setJSON([
               'status'=>'error',
               'message'=>'No hay id',
               'flag'=>0
           ]);
       }

       $model = new KardexDetalleModel();
       $resultado = $model->find($id);
       if ($resultado){
            return json_encode($resultado);
            return $this->response->setJSON([
               'status'=>'success',
               'message'=>'Se ejecutó la consulta',
               'flag'=>1
            ]);
       }
    }
    public function actualizar_final($id)
    {
        
        $data = $this->request->getJSON(true);
        $model = new KardexDetalleModel();
        if ($model->update($id,$data)) {
            echo 1;
        }

    }
    public function liberar_diagnostico($kardex)
    {
        $model = new KardexModel();
        $data['estatus'] = 7;
        if ($model->update($kardex,$data)) {
            echo 1;
        }
    }
    public function pdf_os($id)
    {
        $db = \Config\Database::connect();

        // Obtener el estatus del kardex
        $estatus = new KardexModel();
        $estatus->where('id_kardex', $id);
        $resultado_estatus = $estatus->findAll();

        $mensaje = new MensajeModel();
        $mensaje->where('kardex_id', $resultado_estatus[0]['slug']);
        $resultado_mensaje = $mensaje->get()->getResultArray();

        $builder = $db->table('mbi_kardex');
        $builder->join('mbi_clientes', 'mbi_clientes.id_cliente = mbi_kardex.id_cliente');
        $builder->join('usuarios', 'usuarios.id_usuario = mbi_kardex.generado_por');
        $builder->where('id_kardex', $id);
        $resultado = $builder->get()->getResultArray();

        $id_cliente = $resultado[0]['id_cliente'];

        // Obtener datos de horarios
        $hora = new HorariosModel();
        $hora->where('id_cliente', $id_cliente);
        $hora_data = $hora->findAll();

        // Obtener detalles del kardex
        $detalle_model = new KardexDetalleModel();
        $detalle_model->where('id_kardex', $id);
        $detalle = $detalle_model->findAll();

        // Obtener diagnóstico y refacciones
        $diagnostico = null;
        $refaccion = null;

        if (!empty($detalle)) {
            $valoracion = new KardexDiagnosticoModel();
            $valoracion->where('id_detalle_kardex', $detalle[0]['slug']);
            $resultado_diagnostico = $valoracion->findAll();

            if (!empty($resultado_diagnostico)) {
                $diagnostico = $resultado_diagnostico;

                // Obtener refacciones si existen
                $repuesto = new RefaccionesModel();
                $repuesto->where('id_diagnostico', $resultado_diagnostico[0]['id_detalle_kardex']);
                $resultado_repuesto = $repuesto->findAll();

                if (!empty($resultado_repuesto)) {
                    $refaccion = $resultado_repuesto;
                }
            }
        }

        // Obtener datos de usuarios que no están logeados
        $usuario = new UsuariosModel();
        $usuario->where('id_usuario !=', session('id_usuario'));
        $usuario_data = $usuario->findAll();

        // Crear el array de datos
        $data = [
            'kardex' => $resultado,
            'horario' => $hora_data,
            'detalle' => $detalle,
            'usuarios' => $usuario_data,
            'atendido_por' => $resultado_mensaje,
        ];

        // Solo agregar 'diagnostico' y 'refacciones' si existen
        if ($diagnostico) {
            $data['diagnostico'] = $diagnostico;
        }
        if ($refaccion) {
            $data['refacciones'] = $refaccion;
        }
        $doc = new Dompdf();
        $html = view('pdf/kardex.php',$data);
        $doc->loadHTML($html);
        $doc->setPaper('A4','portrait');
        $doc->render();
        $doc->stream("KDX-".$resultado_estatus[0]['id_kardex'].".pdf");
                
    }

    public function agregar_refacciones()
    {
        $refaccionModel = new RefaccionesModel();
        $db = \Config\Database::connect();
        $db->transStart(); // Iniciar transacción

        try {
            // Obtener datos enviados por Axios y asegurarse de que es un JSON válido
            $data = $this->request->getJSON(true); 

            // Validar si se enviaron los datos esperados
            if (!isset($data['id_diagnostico']) || !is_numeric($data['id_diagnostico'])) {
                throw new \Exception('ID de diagnóstico no válido');
            }
            
            if (!isset($data['refacciones']) || !is_array($data['refacciones']) || empty($data['refacciones'])) {
                throw new \Exception('No se enviaron refacciones válidas');
            }

            $id_diagnostico = intval($data['id_diagnostico']);
            $refacciones = $data['refacciones'];

            // Guardar cada refacción en la base de datos con el id_diagnostico
            foreach ($refacciones as $refaccion) {
                // Validar estructura de la refacción
                if (!isset($refaccion['nombre'], $refaccion['marca'], $refaccion['modelo'], $refaccion['costo'])) {
                    throw new \Exception('Datos de refacción incompletos');
                }

                // Sanitizar datos
                $nombre  = trim(filter_var($refaccion['nombre'], FILTER_SANITIZE_STRING));
                $marca   = trim(filter_var($refaccion['marca'], FILTER_SANITIZE_STRING));
                $modelo  = trim(filter_var($refaccion['modelo'], FILTER_SANITIZE_STRING));
                $precio  = filter_var($refaccion['costo'], FILTER_VALIDATE_FLOAT);

                if ($precio === false) {
                    throw new \Exception('El precio de la refacción no es válido');
                }

                // Insertar en la base de datos
                $refaccionModel->insert([
                    'id_diagnostico' => $id_diagnostico,
                    'refaccion'      => $nombre,
                    'marca'          => $marca,
                    'modelo'         => $modelo,
                    'precio'         => $precio
                ]);
            }

            // Confirmar la transacción
            $db->transComplete();

            return $this->response->setStatusCode(ResponseInterface::HTTP_OK)
                                  ->setJSON(['status' => 'success', 'message' => 'Refacciones guardadas correctamente']);

        } catch (\Exception $e) {
            $db->transRollback(); // Revertir cambios en caso de error

            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                                  ->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function borrar_refaccion($id)
    {
        $model = new RefaccionesModel();
        if ($model->delete($id)) {
            echo 1;
        }
    }
    public function enviar_a_cotizar()
    {
        
        $kardex = $this->request->getvar('kardex');  //Kardex relacionado

        //necesitamos el cliente
        $kardex_query = new KardexModel();
        $cliente = $kardex_query->select('id_cliente')->where('id_kardex',$kardex)->first();
        if (empty($kardex)) {
            return $this->response->setJSON([
                'status'=> 'error',
                'message'=>'No hay datos en el kardex',
                'flag'=> 0
            ]);
        }

        //encontar al vendedor que genero el reporte
        $model = new KardexModel();
        $aprobado_por = session('id_usuario'); //El administrador que genero la cotización
        $estatus = 8; // El estatus que se actualiza en la tabla kardex

        $vendedor = $model->select('generado_nombre')->where('id_kardex',$kardex)->first();
        //generar la cotizacion

        $data=[
            'estatus' => $estatus,
        ];

        //return json_encode($data);
        //actualizar el estatus del cardex
        $update = $model->update($kardex,$data);
        if ($update == false) {
            return $this->response->setJSON([
                'status'=> 'error',
                'message'=>'No se pudo actualizar el estatus del kardex',
                'flag'=> 1
            ]);
        }

        //crear la base de una cotización
        
        ##Generar un slug aleatorio
        $caracteres_permitidos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longitud = 12;
        $slug = substr(str_shuffle($caracteres_permitidos), 0, $longitud);

        //insertar
        $insert = [
            'slug'=> $slug,
            'generado_por'=> session('id_usuario'),
            'id_kardex'=>$kardex,
            'id_cliente'=>$cliente['id_cliente']
        ];
        $cot = new CotizacionesModel();
        $cotizacion = $cot->insert($insert);
        if ($cotizacion == true) {
            return $this->response->setJSON([
                'status'=> 'success',
                'message'=>'Se genero la cotización correctamente',
                'flag'=> 1,
                'slug'=>$slug
            ]);
        }else{
            return $this->response->setJSON([
                'status'=> 'error',
                'message'=>'No se pudo generar la cotización',
                'flag'=> 0
            ]);
        }



    }
    private function enviarCorreo($cuerpo)
    {

        if ($cuerpo['asunto']) {
            $asunto = $cuerpo['asunto'];
        }else{
            $asunto = "Sin asunto";
        }

        $email = \Config\Services::email();
        $msg = $cuerpo['mensaje'];
        // Configuración del correo
        $email->setFrom($cuerpo['envia'], "Grupo MBI");
        $email->setTo($cuerpo['recibe']);
        $email->setSubject($asunto);
        $mensaje = view('email/emailGeneral',['mensaje'=>$msg,'kardex'=>$cuerpo['kardex']]);
        $email->setMessage($mensaje);
        $email->setMailType('html');

        if ($email->send()) {
            log_message('info', "Correo enviado con exito");
        } else {
            log_message('error', "Error al enviar correo: " . $email->printDebugger(['headers']));
        }
    }
    
}