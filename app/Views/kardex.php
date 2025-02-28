<?php echo $this->extend('panel_template') ?>
<?php echo $this->section('contenido') ?>
<div id="app" v-cloak>
    <?php foreach ($clientes as $cliente): ?>
    <nav class="navbar navbar-expand-lg custom-navbar">
        <div class="container-fluid">
            <!-- Breadcrumb personalizado a la izquierda -->
            <div class="breadcrumb-container">
                <a href="<?php echo base_url('/inicio'); ?>" class="breadcrumb-item">Inicio</a>
                <span class="breadcrumb-item active">Kardex <span ref="kardex"><?= $cliente['id_kardex']?></span></span>
            </div>

            <!-- Botones alineados a la derecha -->
            <div class="ml-auto">
                <button class="btn btn-primary btn-sm rounded-0 shadow-none">Turnar</button>
                <button class="btn btn-primary btn-sm rounded-0 shadow-none">Liberar Kardex</button>
                <button class="btn btn-primary btn-sm rounded-0 shadow-none">Regresar</button>
                <button class="btn btn-primary btn-sm rounded-0 shadow-none" data-toggle="modal" data-target="#equipos">Agregar Equipos</button>
                <button class="btn btn-primary btn-sm rounded-0 shadow-none">Aceptar</button>
                <button class="btn btn-primary btn-sm rounded-0 shadow-none">Rechazar</button>
                <button class="btn btn-primary btn-sm rounded-0 shadow-none">Cotizar</button>
            </div>
        </div>
    </nav>

    <div class="row mt-4">
        <div class="col-md-6">
            <h5>Reporte de servicio No: <span class="text-secondary">56</span></h5>
            <h5>Tipo de reporte
                <?php if ($cliente['tipo']==1): ?>
                    <span class="badge badge-danger"><?= $cliente['tipo_txt'] ?></span>
                <?php endif ?>
                <?php if ($cliente['tipo']==2): ?>
                    <span class="badge badge-primary"><?= $cliente['tipo_txt'] ?></span>
                <?php endif ?>
                <?php if ($cliente['tipo']==3): ?>
                    <span class="badge badge-success"><?= $cliente['tipo_txt'] ?></span>
                <?php endif ?>
                <?php if ($cliente['tipo']==4): ?>
                    <span class="badge badge-danger"><?= $cliente['tipo_txt'] ?></span>
                <?php endif ?>
            </h5>
            <p class="m-0"><strong>Hospital: </strong><?= $cliente['hospital'] ?></p>
            <p class="m-0"><strong>Facultad: </strong><?= $cliente['facultad'] ?></p>
            <p class="m-0"><strong>Responsable: </strong><?= $cliente['responsable'] ?></p>
            <p class="m-0"><strong>Telefono: </strong><?=  $cliente['telefono']?></p>
            <p class="m-0"><strong>Celuar: </strong><?=  $cliente['movil']?></p>
            <p class="mt-3"><strong>Generado por: </strong><?= $cliente['generado_nombre']?></p>
            <p class="m-0"><strong>Fecha: </strong><?= $fecha?></p>
        </div>
    </div>
    <?php endforeach ?>
    <div class="row mt-4 mb-5">
        <div class="col-md-6" v-for="isue in reporte" :key="isue.id_detalle">
            <p><strong>Reporte de Falla</strong></p>
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary btn-sm rounded-0 mr-1"data-toggle="modal" data-target="#equipos_actualizar" @click = "actualizar(isue.id_detalle)"><span class="bi bi-pencil"></span></button>
                    <button  class="btn btn-danger btn-sm rounded-0"><span class="bi bi-trash3" @click = "borrar_linea(isue.id_detalle)"></span></button>
                </div>
                <div class="card-body">
                    <p class="m-0"><strong>Equipo: </strong>{{isue.nombre}}</p>
                    <p class="m-0"><strong>Marca: </strong>{{isue.marca}}</p>
                    <p class="m-0"><strong>Modelo: </strong>{{isue.modelo}}</p>
                    <p class="m-0"><strong>Falla reportada</strong></p>
                    <p>{{isue.falla}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <p><strong>Diagnóstico técnico</strong></p>
            <div class="card">
                <div class="card-header">
                    <button  class="btn btn-primary btn-sm rounded-0 mr-1" data-toggle="modal" data-target="#agregar_imagen" @click="guardar_imgen_diangostico(diagnostico.id_diagnostico)"><i class="bi bi-camera"></i></button>
                    <!--  modificar diagnostico -->
                    <button  class="btn btn-primary btn-sm rounded-0 mr-1" data-toggle = "modal" data-target = "#diagnostico" @click = "modal_diagnostico(diagnostico.id_diagnostico,2)"><i class="bi bi-pencil"></i></button>
                    <!--  eliminar -->
                    <button   class="btn btn-danger btn-sm rounded-0 mr-1" @click = "borrar_diagnostico(diagnostico.id_diagnostico)"><span class="bi bi-trash3"></span></button>
                    <button  class="btn btn-secondary btn-sm rounded-0" data-toggle="modal" data-target="#agregar_refacciones" @click = "abrir_modal_refacciones(diagnostico.id_diagnostico)"><span class="bi bi-tools"></span> Refacciones</button>
                </div>
                <div class="card-body">
                    <div>
                    <p class="m-0"><strong>Diangóstico técnico</strong></p>
                    <p>{{diagnostico.diagnostico}}</p>
                    <p class="m-0"><strong>Reparacion sugerida</strong></p>
                    <p>{{diagnostico.reparacion}}</p>
                    <p class="mb-0"><strong>Costo sugerido: </strong>${{diagnostico.precio_estimado}}</p>
                    <p class="mb-0"><strong>Tiempo de entrega: </strong>{{diagnostico.tiempo_entrega}}</p>
                    </div>
                    <p class="mt-5">Refacciones {{errores.refaccion}}</p>
                    <hr>
                    <div v-if="errores.refaccion === 1" class="alert alert-danger" role="alert">
                      No se han agregado refacciones.
                    </div>
                    <table class="table mt-4" v-else>
                        <tr>
                            <th>Refacciones</th>
                            <th>Costo</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>Lorem ipsum, dolor.</td>
                            <td>$500.00</td>
                            <td>
                                <button class="btn btn-danger btn-sm rounded-0"><span class="bi bi-trash3"></span></button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1"></td>
                            <td>Costo refacciones</td>
                            <td>$25300</td>
                        </tr>
                        <tr>
                            <td colspan="1"></td>
                            <td>Costo Total</td>
                            <td>$25300</td>
                        </tr>
                    </table>
                    <div class="row gallery" v-if="imagenes.length > 0">
                        <!-- Miniatura 1 -->
                        <div class="col-md-3 col-sm-6" v-for="imagen in imagenes" :key="imagen.id_img">
                            <img  src="" class="img-thumbnail" data-toggle="modal" data-target="#imageModal"  @click="mandar_img_modal(imagen.img)">
                            <!-- Icono de eliminar (solo el bote de basura) -->
                            <button class="btn btn-sm text-white gallery-delete" @click.stop="eliminarImagen(imagen.id_img)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>

                    </div>
                    <div v-else class="alert alert-danger" role="alert">
                        No se han agregado imágenes.
                    </div>
                    <!-- Modal para mostrar la imagen en grande -->
                    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="modal-body">
                                    <img src="" id="modalImage" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--  actualizar reportes -->
<div class="modal fade" id="equipos_actualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content rounded-0">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-gear-wide-connected"></i> Actualizar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group mt-2">
                <label for="">Nombre del equipo</label>
                <div class="input-group">
                    <div class="input-group-prepend input-group-sm">
                      <div class="input-group-text rounded-0">
                        <i class="bi bi-gear"></i>
                      </div>
                    </div>
                    <input type="text" class="form-control rounded-0 form-control-sm shadow-none"  v-model="actualizar_linea.nombre">
                </div>
            </div>
            <div class="form-group mt-2">
                <label for="">Marca</label>
                <div class="input-group">
                    <div class="input-group-prepend input-group-sm">
                      <div class="input-group-text rounded-0">
                        <i class="bi bi-tags"></i>
                      </div>
                    </div>
                    <input type="text" class="form-control rounded-0 form-control-sm shadow-none"   v-model="actualizar_linea.marca">
                    <small class="text-danger">{{errores.marca}}</small>
                </div>
            </div>
            <div class="form-group mt-2">
              <label for="">Modelo</label>
                <div class="input-group">
                    <div class="input-group-prepend input-group-sm">
                      <div class="input-group-text rounded-0">
                        <i class="bi bi-tags"></i>
                      </div>
                    </div>
                    <input type="text" class="form-control rounded-0 form-control-sm shadow-none"   v-model="actualizar_linea.modelo">
                    <small class="text-danger">{{errores.modelo}}</small>
                </div>
            </div>
            <div class="form-group mt-2">
                <label for="">Número de serie</label>
                <div class="input-group">
                    <div class="input-group-prepend input-group-sm">
                      <div class="input-group-text rounded-0">
                        <i class="bi bi-upc"></i>
                      </div>
                    </div>
                    <input type="text" class="form-control rounded-0 form-control-sm shadow-none"   v-model="actualizar_linea.serie">
                    <small class="text-danger">{{errores.serie}}</small>
                </div>
            </div>
            <div class="form-group mt-2">
                <label for="">Inventario</label>
                <div class="input-group">
                    <div class="input-group-prepend input-group-sm">
                      <div class="input-group-text rounded-0">
                        <i class="bi bi-box"></i>
                      </div>
                    </div>
                    <input type="text" class="form-control rounded-0 form-control-sm shadow-none"   v-model="actualizar_linea.inventario">
                    <small class="text-danger">{{errores.invetario}}</small>
                </div>
            </div>
            <div class="form-group mt-2">
                <label for="">Falla</label>
                <div class="input-group">
                    <div class="input-group-prepend input-group-sm">
                      <div class="input-group-text rounded-0">
                        <i class="bi bi-bandaid"></i>
                      </div>
                    </div>
                    <textarea class="form-control rounded-0 shadow-none"  v-model="actualizar_linea.falla"></textarea>
                    <small class="text-danger">{{errores.falla}}</small>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-0 shadow-none btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary rounded-0 shadow-none btn-sm" @click="actualizar_detalle(actualizar_linea.id_detalle)"><i class="bi bi-arrow-clockwise"></i> Actualizar</button>
      </div>
    </div>
  </div>
</div>
<!--  Agregar equipos -->
<div class="modal fade" id="equipos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content rounded-0">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-gear-wide-connected"></i> Agregar equipos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group mt-2">
                <div class="input-group">
                    <div class="input-group-prepend input-group-sm">
                      <div class="input-group-text rounded-0">
                        <i class="bi bi-gear"></i>
                      </div>
                    </div>
                    <input type="text" class="form-control rounded-0 form-control-sm shadow-none"   @input="limpiar_error($event,'nombre')" placeholder="Nombre del equipo*" v-model="formulario.nombre">
                    <small class="text-danger">{{errores.nombre}}</small>
                </div>
            </div>
            <div class="form-group mt-2">
                <div class="input-group">
                    <div class="input-group-prepend input-group-sm">
                      <div class="input-group-text rounded-0">
                        <i class="bi bi-tags"></i>
                      </div>
                    </div>
                    <input type="text" class="form-control rounded-0 form-control-sm shadow-none"   @input="limpiar_error($event,'marca')" placeholder="Marca *" v-model="formulario.marca">
                    <small class="text-danger">{{errores.marca}}</small>
                </div>
            </div>
            <div class="form-group mt-2">
                <div class="input-group">
                    <div class="input-group-prepend input-group-sm">
                      <div class="input-group-text rounded-0">
                        <i class="bi bi-tags"></i>
                      </div>
                    </div>
                    <input type="text" class="form-control rounded-0 form-control-sm shadow-none"   @input="limpiar_error($event,'modelo')" placeholder="Modelo*" v-model="formulario.modelo">
                    <small class="text-danger">{{errores.modelo}}</small>
                </div>
            </div>
            <div class="form-group mt-2">
                <div class="input-group">
                    <div class="input-group-prepend input-group-sm">
                      <div class="input-group-text rounded-0">
                        <i class="bi bi-upc"></i>
                      </div>
                    </div>
                    <input type="text" class="form-control rounded-0 form-control-sm shadow-none"   @input="limpiar_error($event,'serie')" placeholder="Numero de serie*" v-model="formulario.serie">
                    <small class="text-danger">{{errores.serie}}</small>
                </div>
            </div>
            <div class="form-group mt-2">
                <div class="input-group">
                    <div class="input-group-prepend input-group-sm">
                      <div class="input-group-text rounded-0">
                        <i class="bi bi-box"></i>
                      </div>
                    </div>
                    <input type="text" class="form-control rounded-0 form-control-sm shadow-none"   @input="limpiar_error($event,'invetario')" placeholder="Inventario *" v-model="formulario.inventario">
                    <small class="text-danger">{{errores.invetario}}</small>
                </div>
            </div>
            <div class="form-group mt-2">
                <div class="input-group">
                    <div class="input-group-prepend input-group-sm">
                      <div class="input-group-text rounded-0">
                        <i class="bi bi-bandaid"></i>
                      </div>
                    </div>
                    <textarea placeholder="Describa brevemente la falla" class="form-control rounded-0 shadow-none" name="" id="" @input="limpiar_error($event,'falla')" v-model="formulario.falla"></textarea>
                    <small class="text-danger">{{errores.falla}}</small>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-0 shadow-none btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary rounded-0 shadow-none btn-sm" @click="insertar"><span class="bi bi-plus-circle"></span> Agregar</button>
      </div>
    </div>
  </div>
</div>
<!--  Agregar Imagenes -->
<div class="modal fade" id="agregar_imagen">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar imagenes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="file" class="form-label">Seleccionar Imagen</label>
                    <input type="file" class="form-control" id="file" @change="archivo" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm rounded-0" data-dismiss="modal">Close</button>
                <button type="button" :class="['btn', 'btn-primary', 'btn-sm', 'rounded-0', archivo_permitido]" @click = "subir_imagen">Guardar</button>
            </div>
        </div>
    </div>
</div>
</div> <!-- termina el app -->
<script type="text/javascript" src="<?php echo base_url('public/js/alert.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/js/kardex.js');?>"></script>
<?php echo $this->endSection() ?>
