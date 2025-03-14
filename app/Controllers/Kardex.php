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
use App\Models\InboxModel;
use App\Models\KardexDiagnosticoModel;
use App\Models\KardexDiagnosticoImgModel;
use App\Models\EntidadesModel;
use Dompdf\Dompdf;
use CodeIgniter\I18n\Time;
class Kardex extends BaseController
{
    public function index($slug) //este nos muestra el kardex 
    {
        $db = \Config\Database::connect(); //servicio de conexion
        $usuarios = new UsuariosModel();
        $reportes = new KardexDetalleModel();
        $diagnostico = new KardexDiagnosticoModel();
        $refacciones = new RefaccionesModel();
        $imagen = new KardexDiagnosticoImgModel();
        $entidades = new EntidadesModel();
        $errores = [];  //declaramos errores vacios para que no se detenga;
        
        //confirmamos que venga algo en el slug
        if (empty($slug)){
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'No hay id',
                'flag'=>0
            ]);
        }
        // Consulta principal del kardex
        $builder = $db->table('mbi_kardex');
        $builder->select('mbi_kardex.*, mbi_clientes.hospital, mbi_clientes.titular, mbi_clientes.responsable, mbi_clientes.telefono, mbi_clientes.movil,mbi_clientes.facultad,mbi_clientes.laboratorio');
        $builder->join('mbi_clientes', 'mbi_clientes.id_cliente = mbi_kardex.id_cliente');
        $builder->where('mbi_kardex.slug', $slug); // Asegúrate de que 'slug' pertenece a 'mbi_kardex'
        $resultado = $builder->get()->getResultArray();
        //confirmamos que venga algo en resultado
        if (!$resultado){
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'No hay kardex',
                'flag'=>0
            ]);
        }
        //sacamos entidades
        $entidad = $entidades->findAll();
        if (empty($entidad)){
            $entidad=[
                'status'=>'error',
                'message'=>'No hay entidades',
                'flag'=>0
            ];
        }

        //sacamos usuarios
        $users = $usuarios->findAll();
        if (empty($users)){
            $users=[
                'status'=>'error',
                'message'=>'No hay reporte aun',
                'flag'=>0
            ];
        }
        
        //sacamos detalles
        $reporte_data = $reportes->where('id_kardex',$resultado[0]['id_kardex'])->findAll();
        //confirmamos que haya detalles
        if (empty($reporte_data)){
            $reporte_data=[
                'status'=>'error',
                'message'=>'No hay reporte aun',
                'flag'=>0,
            ];
            $errores['reporte']=0;
            $diagnostico_datos = [
                'status'=> 'error',
                'message'=> 'No hay diagnostico',
                'flag'=> 0
            ];
        }
        ##
        $diagnostico_datos = $diagnostico->find($reporte_data[0]['id_detalle'] ?? null);
        if (empty($diagnostico_datos)) {
            $diagnostico_datos = [
                'status'=>'error',
                'message'=> 'No hay diagnostico',
                'flag'=> 0,
            ];
            $errores['diagnostico'] = 0; 
            $errores['refacciones'] = 0;
            $errores['imagenes'] = 0;
        } else {
            $refacciones_data = $refacciones->where('id_diagnostico', $diagnostico_datos['id_diagnostico'] ?? null)->findAll();
            $diagnostico_datos['refacciones'] = $refacciones_data ?: [];

            if (empty($refacciones_data)) {
                $errores['refacciones'] = 0;
            }

            $imagen_data = $imagen->where('id_kardex_diagnostico', $diagnostico_datos['id_diagnostico'] ?? null)->findAll();
            $diagnostico_datos['imagenes'] = $imagen_data ?: [];

            if (empty($imagen_data)) {
                $errores['imagenes'] = 0;
            }
        }

        ##
        $proceso =  $resultado[0]['estatus'];
        $rol = $usuarios->find(session('id_usuario'));
        if (empty($rol)){
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'Usuario',
                'flag'=>0
            ]);
        }        
    
        $fecha = $this->formatearFecha($resultado[0]['created_at']); //mostramos al fecha formateada
        $data = [
            'kardex'=> $resultado,
            'entidades'=>$entidad,
            'reporte'=>$reporte_data,
            'fecha'=> $fecha,
            'diagnostico'=>$diagnostico_datos,
            'errores'=>$errores,
            'id'=>$resultado[0]['id_kardex'],
            'usuarios'=>$users,
            'proceso'=>$proceso,
            'rol'=>$rol['id_rol']
        ];
            
        return view('kardex',$data);

        //return json_encode($data);




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
    public function crear_kardex()
    {
        
        $tipo = $this->request->getvar('tipo');
        $cliente = $this->request->getvar('cliente');

        $tipo_txt = "";

        if ($tipo == 1) {
            $tipo_txt = "Diagnóstico";
        }elseif($tipo == 2){
            $tipo_txt = "Refaciones";
        }elseif($tipo == 3){
            $tipo_txt = "Mtto.Prev";
        }elseif ($tipo == 4) {
            $tipo_txt = "Garantía";
        }
        
        

        //vamos a obtener el nombre del remitente
        $nombre = new UsuariosModel();
        $nombre->where('id_usuario',session('id_usuario'));
        $resultado_nombre = $nombre->findAll();
        $nombre_completo = $resultado_nombre[0]['nombre']." ".$resultado_nombre[0]['apellidos'];


        $caracteres_permitidos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longitud = 5;
        //vamos a abrir un reporte con numero de cliente y slug
        $nuevo = new KardexModel();
        $slug = substr(str_shuffle($caracteres_permitidos), 0, $longitud);
        $data=[
            'slug'=> $slug,
            'id_cliente'=> $cliente,
            'generado_por'=>session('id_usuario'),
            'generado_nombre'=>$nombre_completo,
            'tipo'=>$tipo,
            'tipo_txt'=>$tipo_txt,
            'atendido_por'=>session('id_usuario')
        ];

        $mensaje = [
            'asunto'=> 'Borrador',
            'remitente_id'=> session('id_usuario'),
            'remitente_nombre'=> $nombre_completo,
            'destinatario_id'=> session('id_usuario'),
            'destinatario_nombre'=>$nombre_completo, 
            'kardex_id'=> $slug
        ];

        $mensaje_model = new MensajeModel();
        if ($nuevo->insert($data) && $mensaje_model->insert($mensaje)) {
            $dato = [
                'exito'=> 1,
                'slug' => $slug
            ];
            return json_encode($dato);
        };
    }
    public function detalle_kardex()
    {
        $caracteres_permitidos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longitud = 19;
        //vamos a abrir un reporte con numero de cliente y slug
        $slug = substr(str_shuffle($caracteres_permitidos), 0, $longitud);

        $model = new KardexDetalleModel();
        $data = [
            'slug' => $slug,
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
        
        //resibilos que viene por el request
        $request = $this->request->getJSON(true);
        //juntamos los datos
        $data = [
           'id_diagnostico' => $request['id_diagnostico'], 
           'diagnostico'=> $request['diagnostico'], 
           'reparacion'=> $request['reparacion'], 
           'tiempo_entrega'=> $request['tiempo_entrega'], 
           'precio_estimado'=> $request['precio_estimado'], 
        ];

        //return json_encode($data);

        $model = new KardexDiagnosticoModel(); 
        $insert =  $model->insert($data);
        if ($insert == true){
            return $this->response->setJSON([
                'status'=>'success',
                'message'=>'Se registro correctamente',
                'flag'=>1
            ]);
        }

    }
    public function actualizacion_diagnostico()
    {
        $model = new KardexDiagnosticoModel(); // tenemos el modelo

        $request = $this->request->getJSON(); //tenemos el request

        $id = $request->id_diagnostico;

        $data = [
            'diagnostico' => $request->diagnostico,
            'precio_estimado' => $request->precio_estimado,
            'reparacion' => $request->reparacion,
            'tiempo_entrega' => $request->tiempo_entrega,
        ];

        $update = $model->update($id,$data);
        if ($update){
            return $this->response->setJSON([
                'status'=>'success',
                'message'=>'Se actulizó correctamente',
                'flag'=> 1
            ]);
        }
    }
    public function modificar_diagnostico($id) //id_diagnostico
    {

        $slug_query = new KardexDiagnosticoModel();
        //comprobamos si llega el id
        if (empty($id)) {
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'No hay datos en la función',
                'flag'=>0
            ]);
        }
        //si llega efectuamos la consulta
        $slug_query->where('id_diagnostico',$id);
        //compraobamos que la consulta tenga datos
        if (empty($slug_query)){
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'No hay id',
                'flag'=>0
            ]);
        }
        $resultado = $slug_query->findAll();
        return json_encode($resultado);
    }
    public function eliminar_diagnostico($data)
    {
        $db = \Config\Database::connect();

        $fotosModel = new KardexDiagnosticoImgModel();
        $refaccionesModel = new RefaccionesModel();
        $diagnosticoModel = new KardexDiagnosticoModel();

        //confirmamos que el data venga listo
        if (empty($data)) {
            return json_encode(['error' => 'El ID del diagnóstico no puede estar vacío.']);
        }
        try {
            $db->transStart(); // Iniciar transacción

            // Eliminar fotos
            $fotos = $fotosModel->where('id_kardex_diagnostico', $data)->findAll();
            foreach ($fotos as $foto) {
                $ruta_imagen = realpath('public/equipos/' . $foto['img']);
                if ($ruta_imagen && file_exists($ruta_imagen)) {
                    unlink($ruta_imagen);
                } else {
                    log_message('warning', 'El archivo no existe: ' . $foto['img']);
                }
            }

            //Eliminamos fotos
            $fotosEliminadas = $fotosModel->where('id_kardex_diagnostico', $data)->delete();
            //Eliminar refacciones si las hay
            $refaccionesEliminadas = $refaccionesModel->where('id_diagnostico', $data)->delete();

            //Eliminar diagnostico
            $diagnosticoEliminado = $diagnosticoModel->delete($data);

            if (!$fotosEliminadas || !$refaccionesEliminadas || !$diagnosticoEliminado) {
                throw new Exception("No se pudieron eliminar todos los registros.");
            }


            $db->transCommit(); // Confirmar transacción
            return json_encode(['success' => true, 'message' => 'Diagnóstico y datos relacionados eliminados correctamente.']);
        } catch (Exception $e) {
            $db->transRollback(); // Revertir transacción en caso de error
            return json_encode(['error' => $e->getMessage()]);
        }
    }
    public function mostrar_kardex($id) //muestra los detalles del Kardex
    {
        $db = \Config\Database::connect();
        $builder = $db->table('mbi_kardex_detalle');
        $builder->join('mbi_kardex_diagnostico', 'mbi_kardex_diagnostico.id_detalle_kardex = mbi_kardex_detalle.slug','left');
        $builder->where('mbi_kardex_detalle.id_kardex', $id);
        $resultado = $builder->get()->getResultArray();
        if ($resultado) {
            return json_encode($resultado);
        }else{
            return json_encode(0);
        }
    }
    public function enviar_kardex()
    {

        $kardex_data = new KardexModel();
        $usuario = new UsuariosModel();
        //en este punto solo cambiamos el estatus y el atendido por, luego se manda el correo

        //datos de entrada
        $correo_mbi  = env('MY_GLOBAL_VAR'); //correo global
        $db = \Config\Database::connect(); //nos conectamos
        
        //datos de entrada
        $kardex = $this->request->getvar('kardex');
        $destinatario_id = $this->request->getvar('destinatario');
        $dia = $this->request->getvar('dia');
        $hora = $this->request->getvar('hora');

        if (empty($dia)&&empty($hora)) {
            $dia = null;
            $hora = null;
        }

        $data = [
            'kardex'=>$kardex,
            'destinatario_id'=>$destinatario_id,
            'dia'=>$dia,
            'hora'=>$hora,
        ];


        //vamos a traer el correo del destinatario
        $correo = $usuario->select('correo')->where('id_usuario',$destinatario_id)->findAll();
        if (!$correo){
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'No hay correo',
                'flag'=>0
            ]);
        }

        $mail = $correo[0]['correo'];
        //vamos a traer los datos del status del kardex
        $estatus = $kardex_data->select('estatus')->where('id_kardex',$kardex)->findAll();

        if (!$estatus){
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'No hay Kardex',
                'flag'=>0
            ]);
        }
        $stage = $estatus[0]['estatus']; //ya tenemos el estatuso para la logica

        if ($stage == 1 || $stage == 3) {
            // cambiamos a dos y enviamos a un adminstrador
            $data = [
                'estatus'=> 2,
                'atendido_por'=>$destinatario_id,
                'dia'=>$dia,
                'hora'=>$hora,
            ];
        }elseif ($stage == 2) {
            // cambiamos a cuatro y enviamos a un tecnico
            $data = [
                'estatus'=> 4,
                'atendido_por'=>$destinatario_id,
                'dia'=>$dia,
                'hora'=>$hora,
            ];
        }elseif ($stage == 5) {
            // cambiamos a cuatro y enviamos a un tecnico
            $data = [
                'estatus'=> 4,
                'atendido_por'=>$destinatario_id,
                'dia'=>$dia,
                'hora'=>$hora,
            ];
        }

        $update = $kardex_data->update($kardex,$data); 
        if ($update == true){
            // Enviar el correo electrónico
            $email = \Config\Services::email();
            $email->setTo($mail);
            $email->setFrom($correo_mbi, 'Tu Nombre');
            $email->setSubject('Nueva Orden de Servicio');

            // Cargar la vista y pasar los datos
            $email->setMessage(view('email/emailGeneral', [
                'kardex' => $kardex,
                'mensaje'=>"Tienes una nueva orden de servicio para tu atanción"
            ]));
            if ($email->send()) {
                return $this->response->setJSON([
                    'status'=>'error',
                    'message'=>'Correo enviado',
                    'flag'=>1
                ]);
            }else{

            }
        }else{
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'No se pudo enviar',
                'flag'=>0
            ]);
        }

        //aqui enviamos el correo

        #necesitamos un destinatario*/

    }
    public function si_ingeniero()
    {   
        //traemos los modelos
        $cliente_query = new KardexModel();
        $horarios = new HorariosModel();
        $model = new UsuariosModel();

        $usuario = $this->request->getvar('usuario'); 
        $id = $this->request->getvar('id'); 
        //sacamos al cliente
        $resultado_cliente = $cliente_query->select('id_cliente')->where('id_kardex',$id)->findAll();
        if (!$resultado_cliente){
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'No hay consulta',
                'flag'=>0
            ]);
        }

        $cliente = $resultado_cliente[0]['id_cliente'];

        $model->where('id_usuario',$usuario);
        $resultado = $model->findAll();
        if ($resultado[0]['id_rol'] ==3 ) {
            //sacamos los horarios 
            $horarios->where('id_cliente',$cliente);
            $resultado_horarios = $horarios->findAll();
            return json_encode([
              'datos'=> $resultado_horarios,
              'flag'=>1
            ]);
        }else{
            return json_encode([
                'status'=>'error',
                'message'=>'No hay horarios',
                'flag'=>0,
            ]);
        }
    }
    public function eliminar_kardex($id)
    {
        //encontramos el msg que corresponde

        $mensaje = new MensajeModel();
        $mensaje->where('kardex_id',$id);
        $resultado = $mensaje->findAll();
        
        //return json_encode($resultado);

        if ($resultado) {
            $mensaje->delete($resultado[0]['id_mensaje']);
        }

        $model = new KardexModel();
        if ($model->delete($id)) {
            echo 1;
        }       
    }   
    public function borrar_linea($id) //borra el detalle del reporte
    {
        $model = new KardexDetalleModel();
        $delete = $model->delete($id);

        if ($delete == true){
            return $this->response->setJSON([
                'status'=>'success',
                'message'=>'Se eliminó el detalle',
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
        $slug = $this->request->getvar('slug');

        $data=[
            "imagen"=>$imagen->getClientExtension(),
            "slug"=>$slug
        ];
        //return json_encode($data);
        $extencion = $imagen->getClientExtension();
        $permitidos =['png','jpeg','jpg'];
        if (!$imagen->isValid() || !in_array($extencion, $permitidos)) {
            return "Solo se permiten imagenes validas";
        }
        $nuevo_nombre = $imagen->getRandomName();
        
        if ($imagen->move('public/equipos',$nuevo_nombre)) {
            $img = new KardexDiagnosticoImgModel();
            $data= [
                'img'=> $nuevo_nombre,
                'id_kardex_diagnostico'=> $slug,
            ];
            if ($img->insert($data)) {
                return json_encode('1');
            }

        }
    }
    public function rechazar_tarea()
    {
        $kardex = new KardexModel();
        //recibimos los datos
        $id_kardex = $this->request->getvar('kardex');
        $razon  = $this->request->getvar('razon');
        $data = [
            'rechazado'=>1,
            'rechazo_razon'=>$razon,
            'estatus'=>5,
        ];

        $rechazo = new KardexModel();
        $update = $rechazo->update($id_kardex,$data);
        if ($update == true) {
            return $this->response->setJSON([
                'status'=>'success',
                'message'=>'Se rechazo el kardex',
                'flag'=>1
            ]);
        }
        return $this->response->setJSON([
            'status'=>'error',
            'message'=>'No se ejecuto la accion',
            'flag'=>0
        ]);

    }
    public function aceptar_tarea($id)
    {
        $kardex = new KardexModel();
        $fechaActual = Time::now('America/Mexico_City', 'en_US');
        $fecha = $fechaActual->toDateString(); // 2025-02-28
        $data = [
            'aceptado'=> $fecha,
            'estatus'=>6,
        ];

        $update = $kardex->update($id,$data);
        if ($update == true){
            return $this->response->setJSON([
                'status'=>'success',
                'message'=>'Se acepto el reporte',
                'flag'=>1
            ]);
        }


    }
    public function kardex_accion()
    {
        $correo = env('MY_GLOBAL_VAR');


        $kardex = $this->request->getvar('kardex');
        $accion = $this->request->getvar('accion');
        $razon  = $this->request->getvar('razon');
        
        $data = [
            'kardex'=> $kardex,
            'accion'=> $accion,
        ];

        
        $model = new KardexModel();
        $model->where('id_kardex', $kardex);
        $resultado = $model->findAll();

        //vamos a econtrar al destinatario

        $mensaje = new MensajeModel();
        $mensaje->where('kardex_id',$resultado[0]['slug']);
        $resultado_mensaje = $mensaje->findAll();
        $texto = $resultado_mensaje[0]['asunto'];
        $id_remitente = $resultado_mensaje[0]['remitente_id'];

        $remitente = new UsuariosModel();
        $remitente->where('id_usuario',$id_remitente);
        $resultado_remitente = $remitente->findAll();

        //return json_encode($resultado);

        if ($accion == 1 ) { //aceptar
            if ($resultado[0]['estatus'] == 4) {
                $hoy  = date('Y:m:d');
                $data['aceptado'] = $hoy;
                $data['estatus'] = 6;
                if ($model->update($kardex,$data)) {
                    echo 1;
                }
            }
        }elseif($accion == 2){ //rechazar
            if ($resultado[0]['estatus'] == 4) {
                $hoy  = date('Y:m:d');
                $data['rechazado'] = $hoy;
                $data['estatus'] = 5;
                $data['rechazo_razon'] = $razon;
                if ($model->update($kardex,$data)) {
                    //enviamos el correo
                    $message = view('email/enviar_kardex',['mensaje' => $texto]);
                    $email_service = \Config\Services::email();
                    $email_service->setFrom($correo,'Grupo MBI');
                    $email_service->setTo($resultado_remitente[0]['correo']);
                    $email_service->setSubject('Nueva orden de servicio. No responder');
                    $email_service->setMessage($message);
                    $email_service->setMailType('html');
                    $email_service->send();
                    echo 1;
                }
            }
        }


    }
    public function regresar_kardex()
    {
        $correo = env('MY_GLOBAL_VAR');
        $id = session('id_usuario');
        $email = \Config\Services::email();
        $kardex_query = new KardexModel();    
        $model = new UsuariosModel();

        //estos son los datos que vienen del formulario
        $kardex = $this->request->getvar('kardex');
        $razon = $this->request->getvar('razon');

        //buscamos el mail del destinatario y su id
        $usuario = $kardex_query->select('generado_por')->where('id_kardex',$kardex)->findAll();
        if (!$usuario){
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'No existe el usuario',
                'flag'=>0
            ]);
        }

        //buscamos el correo
        $correo = $model->select('correo')->where('id_usuario',$usuario[0]['generado_por'])->findAll();
        if (!$correo){
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'No existe el correo',
                'flag'=>0
            ]);
        }
        //reunimos los datos
        $data = [
            'estatus'=>3,
            'atendido_por'=>$usuario[0]['generado_por'],
        ];

        $mail = $correo[0]['correo'];
        $update = $kardex_query->update($kardex,$data);
        if ($update == true) {
            $email->setTo($mail);
            $email->setFrom($correo[0]['correo'], 'MBI');
            $email->setSubject('Kardex Regresado');

            // Cargar la vista y pasar los datos
            $email->setMessage(view('email/emailGeneral', [
                'kardex' => $kardex,
                'mensaje' => $razon,
            ]));
        }

        if ($email->send()) {
            return json_encode([
                'status'=>'success',
                'message'=>'correo enviado',
                'flag'=>1,
            ]);
        }

        
    }
    public function actualizar_detalle($id)
    {
       $model = new KardexDetalleModel();
       $model->where('id_detalle',$id);
       $resultado = $model->findAll();
       return json_encode($resultado);
    }
    public function actualizar_final($id)
    {
        
        $data = $this->request->getJSON(true);
        $model = new KardexDetalleModel();
        if ($model->update($id,$data)) {
            echo 1;
        }

    }
    public function ver_galeria($id)
    {
        $model = new KardexDiagnosticoImgModel();
        $model->where('id_kardex_diagnostico', $id);
        $resultado = $model->findAll();
        return json_encode($resultado);
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
        
        $hora_inicio =  date("h:i A", strtotime($hora_data[0]['hora_inicio']));
        $hora_final =   date("h:i A", strtotime($hora_data[0]['hora_fin']));
        // Obtener detalles del kardex
        $detalle_model = new KardexDetalleModel();
        $detalle_model->where('id_kardex', $id);
        $detalle = $detalle_model->findAll();

        // Obtener diagnóstico y refacciones
        $diagnostico = null;
        $refaccion = null;

        if (!empty($detalle)) {
            $valoracion = new KardexDiagnosticoModel();
            $valoracion->where('id_diagnostico', $detalle[0]['id_detalle']);
            $resultado_diagnostico = $valoracion->findAll();

            if (!empty($resultado_diagnostico)) {
                $diagnostico = $resultado_diagnostico;

                // Obtener refacciones si existen
                $repuesto = new RefaccionesModel();
                $repuesto->where('id_diagnostico', $resultado_diagnostico[0]['id_diagnostico']);
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
            'atendido_por' => $resultado[0]['nombre']." ".$resultado[0]['apellidos'],
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
        // Obtener datos enviados por Axios
        $data = $this->request->getJSON(true); // Decodifica JSON
        $id_diagnostico = $data['id_diagnostico']; // Obtenemos el id_diagnostico
        $refacciones = $data['refacciones'];

        // Validar si se enviaron refacciones
        if (!isset($refacciones) || empty($refacciones)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                                  ->setJSON(['message' => 'No se enviaron datos']);
        }

        //return json_encode($data);
        $db->transStart();
        try {
            // Guardar cada refacción en la base de datos con el id_diagnostico
            foreach ($refacciones as $refaccion) {
                $insertResult = $refaccionModel->insert([
                    'id_diagnostico' => $id_diagnostico,   // Se añade el id_diagnostico
                    'refaccion' => $refaccion['nombre'],
                    'marca'  => $refaccion['marca'],
                    'modelo' => $refaccion['modelo'],
                    'precio'  => $refaccion['costo']
                ]);

            }
            $db->transComplete();
            if ($db->transStatus() === false) {
                throw new Exception("Hubo un errro al guardar los datos");
            }
            return json_encode([
                'flag'=>1
            ]);
            
        } catch (Exception $e) {
            // Si hubo un error, deshacer la transacción (rollback)
            $db->transRollback();
            echo "Error: " . $e->getMessage();
        }
        

    }
    public function borrar_refaccion($id)
    {
        $model = new RefaccionesModel();
        if (empty($id)){
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'No hay id',
                'flag'=>0
            ]);
        }
        $delete = $model->delete($id); 
        if ($delete == true) {
            return json_encode([
                'flag'=>1
            ]);
        }
    }
    public function enviar_a_cotizar()
    {
        $model = new KardexModel();

        $costo = $this->request->getvar('costo');
        $kardex = $this->request->getvar('kardex');
        $estatus = 8;

        $data=[
            'estatus' => $estatus,
            'costo_total' => $costo,
        ];

        //return json_encode($data);
        if ($model->update($kardex,$data)) {
            echo 1;
        }


    }
    
}
