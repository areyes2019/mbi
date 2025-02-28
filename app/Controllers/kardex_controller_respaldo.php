//aqui mandamos los datos generales del kardes como nombre del clietne y quien genero etc.
        $db = \Config\Database::connect();
        $builder = $db->table('mbi_kardex');
        $builder->join('mbi_clientes','mbi_clientes.id_cliente = mbi_kardex.id_cliente');
        $builder->where('slug',$slug);
        $resultado = $builder->get()->getResultArray();

        //aqui vamos a poner los detalles del kardex como fallas etc
        $reporte = new KardexDetalleModel();
        $reporte->where('id_kardex',$resultado[0]['id_kardex']);
        $resultado_reporte = $reporte->findAll();
        $costo_reparacion = 0; // Inicializar como 0 para evitar errores si no hay diagnóstico
        $costo_refacciones = 0; // Inicializar para evitar errores si no hay refacciones
        $sumaPrecios = 0;      // Inicializar para evitar errores si no hay refacciones
        $resultado_img = null;
        $resultado_diagnostico = null;
        $resultado_refacciones = null;
        $display = true; // Valor por defecto

        //aqui mostramos el diagnóstico
        if ($resultado_reporte) {
            $diagnostico = new KardexDiagnosticoModel();
            $diagnostico->where('id_detalle_kardex',$resultado_reporte[0]['slug']);
            $resultado_diagnostico = $diagnostico->findAll();
            if ($resultado_diagnostico) {
                $costo_reparacion = $resultado_diagnostico[0]['precio_estimado'];
            }

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
                $sumaPrecios += floatval($producto['precio']);
            }        
            $display = false;
        }else{
            $resultado_refacciones = null;
            $sumaPrecios = 0;
            $display = true;
        }
        $costo_total = $costo_reparacion + $sumaPrecios;
        //datos de horarios
        $hora = new HorariosModel();
        $hora->where('id_cliente', $resultado[0]['id_cliente']);
        $hora_data = $hora->findAll();

        $data = [
            'kardex'=>$resultado,
            'reporte'=>$resultado_reporte,
            'diagnostico'=>$resultado_diagnostico,
            'costo_total'=>$costo_total,
            'refacciones'=>$resultado_refacciones,
            'total'=> number_format($sumaPrecios,2),
            'display'=>$display,
            'horario' => $hora_data,
            'imagenes'=>$resultado_img,
            'user'=>$resultado[0]['generado_por'],
            'kardex_id'=>$resultado[0]['id_kardex']
        ];
        return json_encode($data);