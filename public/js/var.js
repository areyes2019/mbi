var url = '/agregar_diagnostico';
			var url2 = '/actualizacion_diagnostico';

			if (clase == 1) {
				axios.post(url,{
					'diagnostico': this.diagnostico,
					'reparacion': this.reparacion,
					'tiempo_entrega':this.tiempo_estimado,
					'precio_estimado':this.precio_estimado,		
					'id_detalle': this.id_detalle,
					'clase':clase
				}).then((response)=>{
					$('#diagnostico').modal('hide');
					this.vaciar_campos_diagnostico();
					this.mostrar_general();
					$.notify("Diagnóstico agregado");
				})
			}else if(clase == 2){
				axios.post(url2,{
					'diagnostico': this.diagnostico,
					'reparacion': this.reparacion,
					'tiempo_entrega':this.tiempo_estimado,
					'precio_estimado':this.precio_estimado,		
					'slug': this.id_slug,
				}).then((response)=>{
					if (response.data == 1) {
						$('#diagnostico').modal('hide');
						this.mostrar_general();
						this.vaciar_campos_diagnostico();
						$.notify("Diagnóstico actualizado",'info');
					}
				})
			}
		},
		
		
		 return json_encode($data);    
        //borrar las fotos del servidor si las hay

        /*$fotos = new KardexDiagnosticoImgModel();
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
        }*/



            <?php if (isset($diagnostico['flag']) && $diagnostico['flag']==0): ?>
            <div class="alert alert-primary rounded-0" role="alert">
                ¡Esta orden de servicio aun no esta diagnosticada!
            </div>
            <?php else: ?>
            <div class="card">
                <?php if ($proceso == 6):?>
                <div class="card-header">
                    <button class="btn btn-primary btn-sm rounded-0 mr-1">Agregar Imagen</button>
                    <button class="btn btn-primary btn-sm rounded-0 mr-1">Editar</button>
                    <button class="btn btn-danger btn-sm rounded-0 mr-1" @click = "borrar_diagnostico(<?= $diagnostico['id_diagnostico'] ?>)">Eliminar</button>
                    <button class="btn btn-secondary btn-sm rounded-0">Refacciones</button>
                </div>
                <?php endif ?>
                <div class="card-body">
                    <p class="m-0"><strong>Diagnóstico:</strong></p>
                    <p><?php echo $diagnostico['diagnostico'] ?></p>
                    <p class="m-0"><strong>Reparación sugerida:</strong></p>
                    <p><?php echo $diagnostico['reparacion'] ?></p>
                    <p class="m-0"><strong>Tiempo de entrega:</strong></p>
                    <p><?php echo $diagnostico['tiempo_entrega'] ?></p>
                    <p class="m-0"><strong>Precio estimado:</strong></p>
                    <p><?php echo $diagnostico['precio_estimado'] ?></p>
                </div>
            </div>
            <?php endif ?>
            
            <h5>Refacciones necesarias</h5>

            <?php if (isset($diagnostico['refacciones']) && isset($diagnostico['refacciones']['flag']) && $diagnostico['refacciones']['flag'] == 0): ?>

            <p></p>
            <?php else: ?>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Refacción</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Precio</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($diagnostico['refacciones'] as $refaccion): ?>
                    <tr>
                        <td><?php echo $refaccion['refaccion'] ?></td>
                        <td><?php echo $refaccion['marca'] ?></td>
                        <td><?php echo $refaccion['modelo'] ?></td>
                        <td>$<?php echo $refaccion['precio'] ?></td>
                        <td><button class="btn btn-danger btn-sm rounded-0">Eliminar</button></td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <div class="d-flex flex-nowrap overflow-auto">
                <!-- Miniaturas -->
                <?php foreach ($diagnostico['imagenes'] as $mini): ?>
                <img src="/equipos/<?php echo $mini['img'] ?>" class="thumbnail" data-toggle="modal" data-target="#imageModal" data-src="https://via.placeholder.com/600">
                <?php endforeach ?>
            </div>
            <?php endif ?>

  <!--  Modal para ver la miniatura -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?php if (isset($diagnostico['refacciones']) && isset($diagnostico['refacciones']['flag']) && $diagnostico['refacciones']['flag'] == 0): ?>
                    <p></p>
                    <?php else: ?>
                        <?php foreach ($diagnostico['imagenes'] as $img): ?>
                        <img src="/equipos/<?= $img['img'] ?>" class="modal-img" id="modalImage">
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>