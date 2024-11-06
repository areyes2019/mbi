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
use Dompdf\Dompdf;
class Kardex extends BaseController
{
    public function master($slug)
    {
        //aqui mandamos los datos generales del kardes como nombre del clietne y quien genero etc.
        $db = \Config\Database::connect();
        $builder = $db->table('mbi_kardex');
        $builder->join('mbi_clientes','mbi_clientes.id_cliente = mbi_kardex.id_cliente');
        $builder->where('slug',$slug);
        $resultado = $builder->get()->getResultArray();

        //aqui mandamos el nombre del asignado a este reporte
        $mensaje = new MensajeModel();
        $mensaje->where('kardex_id',$slug);
        $resultado_mensaje = $mensaje->findAll();

        //aqui vamos a poner los detalles del kardex como fallas etc

        $reporte = new KardexDetalleModel();
        $reporte->where('id_kardex',$resultado[0]['id_kardex']);
        $resultado_reporte = $reporte->findAll();

        //aqui mostramos el diagnóstico
        if ($resultado_reporte) {
            $diagnostico = new KardexDiagnosticoModel();
            $diagnostico->where('id_detalle_kardex',$resultado_reporte[0]['slug']);
            $resultado_diagnostico = $diagnostico->findAll();
            if ($resultado_diagnostico) {
                $imagenes = new KardexDiagnosticoImgModel();
                $imagenes->where('id_kardex_diagnostico',$resultado_diagnostico[0]['id_detalle_kardex']);
                $resultado_img = $imagenes->findAll();
            }else{
                $resultado_img = null;
            }

        }else{
            $resultado_diagnostico = null;
            $resultado_img = null;
        }



        if ($resultado_diagnostico) {
            $refacciones = new RefaccionesModel();
            $refacciones->where('id_diagnostico', $resultado_diagnostico[0]['id_detalle_kardex']);
            $resultado_refacciones = $refacciones->findAll();

            //sumamos todos las refacciones
            $sumaPrecios = 0;
            foreach ($resultado_refacciones as $producto) {
                $sumaPrecios += $producto['precio'];
            }        
            $display = false;
        }else{
            $resultado_refacciones = null;
            $sumaPrecios = 0;
            $display = true;
        }

        //datos de horarios
        $hora = new HorariosModel();
        $hora->where('id_cliente', $resultado[0]['id_cliente']);
        $hora_data = $hora->findAll();

        $data = [
            'kardex'=>$resultado,
            'mensaje'=>$resultado_mensaje,
            'reporte'=>$resultado_reporte,
            'diagnostico'=>$resultado_diagnostico,
            'refacciones'=>$resultado_refacciones,
            'total'=> number_format($sumaPrecios,2),
            'display'=>$display,
            'horario' => $hora_data,
            'imagenes'=>$resultado_img
        ];
        return json_encode($data);
    }
    public function index($slug)
    {
        
        $kardex = new KardexModel();
        $kardex->where('slug',$slug);
        $resultado = $kardex->findAll();

        
        //datos de usuarios que no estan logeados 
        $usuario = new UsuariosModel();
        $usuario->where('id_usuario !=',session('id_usuario'));
        if ($resultado[0]['estatus']==1) {
            $usuario->where('id_rol',2);
        }elseif ($resultado[0]['estatus']==2) {
            $usuario->where('id_rol',3);
        }elseif($resultado[0]['estatus']==3){
            $usuario->where('id_rol',2);
        }elseif ($resultado[0]['estatus']==5) {
            $usuario->where('id_rol',3);
        }
        $usuario_data = $usuario->findAll();
        
        $data = [
            'id'=> $slug,
            'kardex'=>$resultado,
            'usuarios' => $usuario_data,
        ];

        //return json_encode($resultado);
        return view('kardex',$data);


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
        
        $request = $this->request->getJSON(true);
        $id = $request['id_detalle'];
        
        $kardex = new KardexDetalleModel();
        $kardex->where('id_detalle',$id);
        $resultado = $kardex->findAll();
        
        $data = [
           'id_detalle_kardex' => $resultado[0]['slug'], 
           'diagnostico'=> $request['diagnostico'], 
           'reparacion'=> $request['reparacion'], 
           'tiempo_entrega'=> $request['tiempo_entrega'], 
           'precio_estimado'=> $request['precio_estimado'], 
        ];

        //return json_encode($data);

        $model = new KardexDiagnosticoModel(); 
        $model->insert($data);
        echo 1;

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
    public function eliminar_diagnostico($data)
    {
                
        //borrar las fotos del servidor si las hay

        $fotos = new KardexDiagnosticoImgModel();
        $fotos->where('id_kardex_diagnostico',$data);
        $resultado_fotos = $fotos->findAll();


        foreach ($resultado_fotos as $foto) {
            // Ruta de la imagen en el servidor
            $ruta_imagen = realpath('public/equipos/' . $foto['img']);

            //return json_encode($ruta_imagen);
            // Verifica si el archivo existe antes de intentar eliminarlo
            if (file_exists($ruta_imagen)) {
                unlink($ruta_imagen); // Elimina la imagen del servidor
            }
        }
        
        // Luego puedes borrar los registros en la base de datos si es necesario
        $fotos->where('id_kardex_diagnostico', $data)->delete();

        //borrar las refacciones si las hay
        $refacciones = new RefaccionesModel();
        $refacciones->where('id_diagnostico',$data);
        $resultado_refaccion = $refacciones->findAll();
        $refacciones->where('id_diagnostico',$data)->delete();
        
        //borrar el dianostico

        $model = new KardexDiagnosticoModel();
        if ($model->delete($data)) {
            return json_encode('1');
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
        $correo  = env('MY_GLOBAL_VAR');

        $db = \Config\Database::connect();
        
        //datos de entrada
        $slug = $this->request->getvar('slug');
        $kardex = $this->request->getvar('kardex');
        $destinatario_id = $this->request->getvar('destinatario');
        $asunto = $this->request->getvar('asunto');
        $dia = $this->request->getvar('dia');
        $hora = $this->request->getvar('hora');

        $data = [
            'slug'=>$slug,
            'kardex'=>$kardex,
            'asunto'=>$asunto,
            'destinatario_id'=>$destinatario_id,
            'dia'=>$dia,
            'hora'=>$hora,
        ];
        

        //encontrar al remitente
        $id_remitente = session('id_usuario');
        $remitente = $db->table('usuarios');
        $remitente->where('id_usuario',$id_remitente);
        $resultado_remitente = $remitente->get()->getRow();
        $nombre_completo_remitente = $resultado_remitente->nombre." ".$resultado_remitente->apellidos;

        //encontrar al destinatario
        $destinatario = $db->table('usuarios');
        $destinatario->where('id_usuario',$destinatario_id);
        $resultado_destinatario = $destinatario->get()->getRow(); 
        $nombre_completo_destinatario = $resultado_destinatario->nombre." ".$resultado_destinatario->apellidos;
        $correo_destinatario = $resultado_destinatario->correo;

        
        //encontrar el msg
        $mensaje_model = new MensajeModel();
        $mensaje_model->where('kardex_id', $slug);
        $resultado_mensaje = $mensaje_model->findAll();
        $id_mensaje = $resultado_mensaje[0]['id_mensaje'];



        $mensaje = [
            'asunto'=> $asunto,
            'remitente_id'=> $id_remitente,
            'remitente_nombre'=> $nombre_completo_remitente,
            'destinatario_id'=> $destinatario_id,
            'destinatario_nombre'=>$nombre_completo_destinatario, 
        ];

        if ($mensaje_model->update($id_mensaje,$mensaje)) {
            echo 1;

            //enviamos el correo
            $message = view('email/enviar_kardex',['mensaje' => $asunto]);

            $email_service = \Config\Services::email();
            $email_service->setFrom($correo,'Grupo MBI');
            $email_service->setTo($correo_destinatario);
            $email_service->setSubject('Nueva orden de servicio. No responder');
            $email_service->setMessage($message);
            $email_service->setMailType('html');
            $email_service->send();


        }

        //una vez actualizado el msg buscamos nuevamente los datos para el estatus

        $mensaje_model->where('id_mensaje',$id_mensaje);
        $resultado_mensaje = $mensaje_model->findAll();


        $enviado_por = $resultado_mensaje[0]['remitente_id'];
        $recibido_por = $resultado_mensaje[0]['destinatario_id'];

        $estatus_usuario = new UsuariosModel();
        $estatus_usuario->where('id_usuario',$recibido_por);
        $estatus_usuario_query = $estatus_usuario->findAll();
        $rol = $estatus_usuario_query[0]['id_rol']; //<-
        

        //datos del kardex 

        $estatus_query = new KardexModel();
        $estatus_query->where('id_kardex',$kardex);
        $estatus_resultado = $estatus_query->findAll();
        $estatus = $estatus_resultado[0]['estatus'];
        
        //return json_encode($estatus);

        //return json_encode($estatus);

        if ($estatus == 1 && $rol = 2) {
            $estatus_id = 2;
            $data['estatus'] = $estatus_id;
            $data['dia'] = null;
            $data['hora'] = null;
            if ($estatus_query->update($kardex,$data)) {
                echo 1;
            }

        }elseif($estatus == 2 && $rol == 1){
            $estatus_id = 3;
            $data['estatus'] = $estatus_id;
            $data['dia'] = null;
            $data['hora'] = null;
            if ($estatus_query->update($kardex,$data)) {
                echo 1;
            }
        }elseif($estatus == 3 && $rol == 2){
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
        }
        

        /*elseif ($estatus == 4 $estatus_resultado[0]['rechazado']==1){
            $estatus = 5;
        }elseif($estatus && $resultado_query[0]['aceptado']==1){
            $estatus = 6;
        }elseif ($resultado_query[0]['id_rol']==3 && $resultado_query[0]['terminado']==1 ) {
            $estatus = 7;
        }elseif ($resultado_query[0]['estatus'] == 7) {
            $estatus = 8;
        }*/   


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
    public function borrar_linea($id)
    {
        $model = new KardexDetalleModel();
        $model->where('id_kardex',$id);
        $resultado = $model->findAll();
        $id_detalle = $resultado[0]['id_detalle']; 
        if ($model->delete($id_detalle)) {
            echo 1;
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
        $id = session('id_usuario');

        $kardex_query = new KardexModel();    
        //estos son los datos que vienen del formulario
        $kardex = $this->request->getvar('kardex');
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
        //vamos a ver el estatus del kardex

        $estatus = new KardexModel();
        $estatus->where('id_kardex',$id);
        $resultado_estatus = $estatus->findAll();


        $mensaje = new MensajeModel();
        $mensaje->where('kardex_id',$resultado_estatus[0]['slug']);
        $resultado_mensaje = $mensaje->get()->getResultArray();
    
        $builder = $db->table('mbi_kardex');
        $builder->join('mbi_clientes',',mbi_clientes.id_cliente = mbi_kardex.id_cliente');
        $builder->join('usuarios',',usuarios.id_usuario = mbi_kardex.generado_por');
        $builder->where('id_kardex',$id);
        $resultado = $builder->get()->getResultArray();
        
        $id_cliente = $resultado[0]['id_cliente'];

        //datos de horarios
        $hora = new HorariosModel();
        $hora->where('id_cliente', $id_cliente);
        $hora_data = $hora->findAll();


        $detalle_model = new KardexDetalleModel();
        $detalle_model->where('id_kardex',$id);
        $detalle = $detalle_model->findAll();

        //diagnostico
        $diagnostico = new KardexDiagnosticoModel();
        $diagnostico->where('id_detalle_kardex',$detalle[0]['slug']);
        $resultado_diagnostico = $diagnostico->findAll();
        
        //refacciones

        $refacciones = new RefaccionesModel();
        $refacciones->where('id_diagnostico',$resultado_diagnostico[0]['id_detalle_kardex']);
        $resultado_refacciones = $refacciones->findAll();

        //datos de usuarios que no estan logeados 
        $usuario = new UsuariosModel();
        $usuario->where('id_usuario !=',session('id_usuario'));
        $usuario_data = $usuario->findAll(); 



        $data = [
            'kardex' => $resultado,
            'horario' => $hora_data,
            'detalle' => $detalle,
            'usuarios' => $usuario_data,
            'atendido_por'=>$resultado_mensaje,
            'diagnostico'=>$resultado_diagnostico,
            'refacciones'=>$resultado_refacciones
        ];

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
        // Obtener datos enviados por Axios
        $data = $this->request->getJSON(true); // Decodifica JSON
        $id_diagnostico = $data['id_diagnostico']; // Obtenemos el id_diagnostico
        $refacciones = $data['refacciones'];


        // Validar si se enviaron refacciones
        if (!isset($refacciones) || empty($refacciones)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                                  ->setJSON(['message' => 'No se enviaron datos']);
        }

        $data = [
            'id'=>$id_diagnostico,
            'datos'=>$refacciones
        ];

        //return json_encode($data);

        // Guardar cada refacción en la base de datos con el id_diagnostico
        foreach ($refacciones as $refaccion) {
            $refaccionModel->insert([
                'id_diagnostico' => $id_diagnostico,   // Se añade el id_diagnostico
                'refaccion' => $refaccion['nombre'],
                'marca'  => $refaccion['marca'],
                'modelo' => $refaccion['modelo'],
                'precio'  => $refaccion['costo']
            ]);
        }
        echo 1;

    }
    public function borrar_refaccion($id)
    {
        $model = new RefaccionesModel();
        if ($model->delete($id)) {
            echo 1;
        }
    }
    
}
