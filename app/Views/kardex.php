<?php echo $this->extend('panel_template') ?>
<?php echo $this->section('contenido') ?>
<style>
    .table-custom-padding th, .table-custom-padding td {
        padding: 0.2rem; /* Ajusta este valor según la cantidad de padding que desees */
    }
</style>
<div class="container mb-5" id="app">
    <?php foreach ($kardex as $data):?>
    <div class="row">
        <div class="col-md-4">
            <div class="card rounded-0">
                <div class="card-header">
                    <?php if (esc(permisos($data['estatus'], 'turnar'))): ?>
                    <button  class="btn btn-primary btn-sm rounded-0 mr-1" data-toggle = "modal" data-target="#enviar_cardex"><span class="bi bi-gear"></span> Turnar</button>
                    <?php endif ?>
                    
                    <?php if (esc(permisos($data['estatus'],'equipos'))): ?>
                    <button  class="btn btn-primary btn-sm rounded-0 mr-1" data-toggle="modal" data-target="#equipos"><i class="bi bi-plus-circle"></i> Agregar Equipos</button>
                    <?php endif ?>

                    <?php if (esc(permisos($data['estatus'],'aceptar_tarea'))):?>
                    <button class="btn btn-success btn-sm rounded-0 shadow-none mr-1" @click="aceptar_tarea(<?php echo $data['id_kardex'] ?>)"><span class="bi bi-check2"></span> Acetpar</button>
                    <button class="btn btn-danger btn-sm rounded-0 shadow-none" @click="rechazar_tarea_modal(<?php echo $data['id_kardex'] ?>)"><span class="bi bi-x-lg"></span> Rechazar</button>
                    <?php endif ?>
                </div>
                <div class="card-body">
                    <?php 
                    $estatus = asignar_estatus($data['estatus']);
                    if ($estatus): ?>
                        <span class="badge <?php echo $estatus['estilo']." ".$estatus['icon']?> "> <?php echo $estatus['nombre'] ?></span> 
                    <?php endif ?>
                    <p class="d-none" ref = "kardex"><?php echo $data['slug']?></p>
                    <h6 class="m-0"><strong>No. </strong><span ref="kardex_id"><?php echo $data['id_kardex'] ?></span></h6>
                    <h5 class="mt-3 mb-0"><?php echo $data['hospital'] ?></h5>
                    <p class="mt-2 mb-0"><strong><?php echo $data['titular'] ?></strong></p>
                    <p class="m-0">Titular</p>
                    
                    <p class="mt-2 mb-0"><strong><?php echo $data['responsable'] ?></strong></p>
                    <p>Responsable</p>
                    
                    <p class="m-0"><strong><?php echo $data['telefono'] ?></strong></p>
                    <p>Teléfono</p>
                    <p class="m-0"><strong><?php echo $data['movil'] ?></strong></p>
                    <p class="m-0">Móvil</p>
                    
                    <br>
                    <h6><strong>Generado por: </strong><?php echo $data['generado_nombre'] ?></h6>
                </div>
            </div>
            <div class="card mt-2 rounded-0">
                <div class="card-body">
                    <p class="m-0"><strong>Programado para el</strong></p>
                    <p class="m-0">25 de Marzo de 2025. 05:00 p.m.</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card rounded-0">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <a href="">Descargar pdf</a>
                    </div>
                    <div>
                        <button class="btn btn-warning btn-sm rounded-0 shadow-none" @click="terminar_tarea()"><span class="bi bi-check2"></span> Marcar terminado</button>
                        <?php if (esc(permisos($data['estatus'],'terminado'))): ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div v-for="kdx in lista">
            <div class="card rounded-0 mt-2">
                <div class="card-body rounded-0">
                    <div class="col-12" v-if="<?php echo $hay_detalle ?> == 0">
                        <div class="alert alert-primary" role="alert">
                            No se han agregado equipos a este kardex
                        </div>
                    </div>
                    <h5>Reporte generado por el vendedor</h5>
                    <table class="table table-custom-padding">
                        <tr>
                            <th>Equipo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>No. Serie</th>
                            <th>Inventario</th>
                        </tr>
                        <tr>
                            <td>{{kdx.nombre}}</td>
                            <td>{{kdx.marca}}</td>
                            <td>{{kdx.modelo}}</td>
                            <td>{{kdx.serie}}</td>
                            <td>{{kdx.inventario}}</td>
                        </tr>
                        <tr>
                            <th style="border-bottom: none;">Falla reportada</th>
                            <td colspan="4" style="border-bottom: none;">{{kdx.falla}}</td>
                        </tr>
                        <tr>
                            <td colspan="5" style="border-bottom:none;">
                                <?php if (esc(permisos($data['estatus'],'editar_eliminiar'))): ?>
                                <button class="btn btn-primary btn-sm rounded-0 mr-1"data-toggle="modal" data-target="#equipos_actualizar" @click = "actualizar(kdx.id_detalle)"><span class="bi bi-pencil"></span></button>
                                <button  class="btn btn-danger btn-sm rounded-0"><span class="bi bi-trash3" @click = "borrar_linea(kdx.id_kardex)"></span></button>
                                <?php endif ?>
                                
                                <!--  Generar diagostico -->
                                <?php if (esc(permisos($data['estatus'],'imagen_diagnostico'))): ?>
                                <button class="btn btn-primary btn-sm rounded-0" v-if="!kdx.id_detalle_kardex" data-toggle = "modal" data-target = "#diagnostico" @click = "modal_diagnostico(kdx.id_detalle,1)"><i class="bi bi-tools"></i></button>
                                <?php endif ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card rounded-0 mt-2">
                <div class="card-header">
                    <?php if (esc(permisos($data['estatus'],'imagen_diagnostico'))): ?>
                    <!--  imagenes de diagnostico  -->
                    <button  v-if="kdx.id_detalle_kardex"class="btn btn-primary btn-sm rounded-0 mr-1" data-toggle="modal" data-target="#agregar_imagen" @click="guardar_imgen_diangostico(kdx.id_detalle_kardex)"><i class="bi bi-camera"></i></button>
                    <!--  modificar diagnostico -->
                    <button v-if="kdx.id_detalle_kardex" class="btn btn-primary btn-sm rounded-0 mr-1" data-toggle = "modal" data-target = "#diagnostico" @click = "modal_diagnostico(kdx.id_detalle_kardex,2)"><i class="bi bi-pencil"></i></button>
                    <!--  eliminar -->
                    <button  v-if="kdx.id_detalle_kardex"class="btn btn-danger btn-sm rounded-0" @click = "borrar_diagnostico(kdx.id_detalle_kardex)"><span class="bi bi-trash3"></span></button>
                    <?php endif ?>
                </div>
                <div class="card-body rounded-0">
                    <h5>Diagnóstico Técnico</h5>
                    <p class="m-0">{{kdx.diagnostico}}</p>
                    <table class="table table-custom-padding">
                        <tr>
                            <th>Refacciones</th>
                            <td>{{kdx.refacciones}}</td>
                        </tr>
                        <tr>
                            <th>Tiempo estimado</th>
                            <td>{{kdx.tiempo_entrega}}</td>
                        </tr>
                        <tr>
                            <th>Precio aproximado</th>
                            <td>${{kdx.precio_estimado}}</td>
                        </tr>
                    </table>
                    <a href="" data-toggle="modal" data-target="#galeria" @click.prevent="ver_galeria(kdx.id_detalle_kardex)">Ver imágenes</a>
                </div>
            </div>
            <hr>
            </div>
        </div>    
    </div><!--  fin del row -->
    <?php endforeach ?>
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
                        <small class="text-danger">{{errores.nombre}}</small>
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

    <!-- Agregar diagnostico -->
    <div class="modal fade" id="diagnostico" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-tools"></i> {{modal_text}}</h5>
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
                        <input type="text" class="form-control rounded-0 form-control-sm shadow-none"   @input="limpiar_error($event,'nombre')" placeholder="Describe el diagnóstico" v-model="diagnostico">
                    </div>
                </div>
                <div class="form-group mt-2">
                    <div class="input-group">
                        <div class="input-group-prepend input-group-sm">
                          <div class="input-group-text rounded-0">
                            <i class="bi bi-gear-fill"></i>
                          </div>
                        </div>
                        <input type="text" class="form-control rounded-0 form-control-sm shadow-none"   @input="limpiar_error($event,'marca')" placeholder="Refacciones *" v-model="refacciones">
                    </div>
                </div>
                <div class="form-group mt-2">
                    <div class="input-group">
                        <div class="input-group-prepend input-group-sm">
                          <div class="input-group-text rounded-0">
                            <i class="bi bi-calendar-date"></i>
                          </div>
                        </div>
                        <input type="text" class="form-control rounded-0 form-control-sm shadow-none"   @input="limpiar_error($event,'marca')" placeholder="Tiempo estimado *" v-model="tiempo_estimado">
                    </div>
                </div>
                <div class="form-group mt-2">
                    <div class="input-group">
                        <div class="input-group-prepend input-group-sm">
                          <div class="input-group-text rounded-0">
                            <i class="bi bi-cash-coin"></i>
                          </div>
                        </div>
                        <input type="text" class="form-control rounded-0 form-control-sm shadow-none"   @input="limpiar_error($event,'marca')" placeholder="Precio estimado *" v-model="precio_estimado">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-0 shadow-none btn-sm" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary rounded-0 shadow-none btn-sm" @click="generar_diagnostico(clase)"><span class="bi bi-plus-circle"></span> Agregar</button>
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
    <!--  Galeria de imagenes -->
    <div class="modal fade" id="galeria" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <div class="modal-header bg-dark rounded-0">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close btn-dark" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" v-for = "data_img in imagenes">
                <div class="gallery-container">
                    <div class="main-image">
                    </div>
                    <div class="thumbnails">
                        <img class="thumbnail" :src="'/public/equipos/' + data_img.img" alt="Miniatura 1" width="180">
                    </div>
                </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Understood</button>
          </div>
        </div>
      </div>
    </div>
    <!--  Enviar Kardex -->
    <div class="modal fade" id="enviar_cardex" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span class="bi bi-send"></span> Enviar Kardex</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div v-if="<?php echo $hay_detalle ?> == 0">
                    <h4 class="text-danger text-center">Aun no has agregado ningun equipo</h4>
                </div>
                <div v-else>
                    <div class="form-group mt-2">
                        <div class="input-group">
                            <div class="input-group-prepend input-group-sm">
                              <div class="input-group-text rounded-0">
                                <i class="bi bi-person"></i>
                              </div>
                            </div>
                            <select v-model="usuario" class="form-control rounded-0 shadow-none" @change = "si_ingeniero(usuario)">
                                <option value="defecto" disabled>Selecciona...</option>
                                <?php foreach ($usuarios as $usuario): ?>
                                <option value="<?php echo $usuario['id_usuario']; ?>"><?php echo $usuario['nombre']." ".$usuario['apellidos'] ?></option>    
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <div class="input-group">
                            <div class="input-group-prepend input-group-sm">
                              <div class="input-group-text rounded-0">
                                <i class="bi bi-card-text"></i>
                              </div>
                            </div>
                            <input class="form-control rounded-0 shadow-none" v-model="asunto">
                        </div>
                    </div>
                    <div v-if="ingeniero == 1">
                    <label for="">Horario del cliente</label>
                    <table class="table table-bordered">
                        <tr>
                            <td>Dia</td>
                            <td>De:</td>
                            <td>A:</td>
                        </tr>
                        <?php foreach ($horario as $tiempo): ?>
                        <tr>
                            <td><?php echo $tiempo['dia'] ?></td>
                            <td><?php echo $tiempo['hora_inicio'] ?></td>
                            <td><?php echo $tiempo['hora_fin'] ?></td>
                        </tr>
                        <?php endforeach ?>
                    </table>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-2">
                                <label for="">Selecciona el día</label>
                                <div class="input-group">
                                    <div class="input-group-prepend input-group-sm">
                                      <div class="input-group-text rounded-0">
                                        <i class="bi bi-card-text"></i>
                                      </div>
                                    </div>
                                    <input type="date" class="form-control rounded-0 shadow-none" v-model="dia">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-2">
                                <label for="">Selecciona la hora</label>
                                <div class="input-group">
                                    <div class="input-group-prepend input-group-sm">
                                      <div class="input-group-text rounded-0">
                                        <i class="bi bi-card-text"></i>
                                      </div>
                                    </div>
                                    <input type="time" class="form-control rounded-0 shadow-none" v-model="hora">
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>                    
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary rounded-0 shadow-none btn-sm" data-dismiss="modal">Cerrar</button>
            <button v-if="<?php echo $hay_detalle ?> > 0" type="button" class="btn btn-primary rounded-0 shadow-none btn-sm" @click="enviar"><span class="bi bi-plus-circle"></span> Enviar</button>
          </div>
        </div>
      </div>
    </div>

    <!--  Regresar Kardex -->
    <div class="modal fade" id="regresar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span class="bi bi-send"></span> Enviar Kardex</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Vas a devolver este Kardex, ¿Deseas continuar?</h5>
                <div class="form-group mt-2">
                    <div class="input-group">
                        <div class="input-group-prepend input-group-sm">
                          <div class="input-group-text rounded-0">
                            <i class="bi bi-card-text"></i>
                          </div>
                        </div>
                        <input class="form-control rounded-0 shadow-none" placeholder="Razon..." v-model="razon">
                    </div>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary rounded-0 shadow-none btn-sm" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary rounded-0 shadow-none btn-sm" @click="regresar"><span class="bi bi-plus-circle"></span> Continuar</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="rechazar_tarea" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content rounded-0 ba">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tarea {{kardex}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 class="text-danger text-center">¿Estas seguro de rechazar esta tarea?</h5>
                    <div class="form-group mt-2">
                    <label for="" class="text-left">Escribe la razón</label>
                    <div class="input-group">
                        <div class="input-group-prepend input-group-sm">
                          <div class="input-group-text rounded-0">
                            <i class="bi bi-card-text"></i>
                          </div>
                        </div>
                        <input class="form-control rounded-0 shadow-none" placeholder="Razon..." v-model="razon">
                    </div>
                </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary rounded-0 btn-sm btn-block" data-dismiss="modal" @click = "rechazar_tarea">Continuar</button>
                </div>
            </div>
        </div>
    </div>
</div> <!--  fin del container -->
<script type="text/javascript" src="<?php echo base_url('public/js/alert.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/js/kardex.js');?>"></script>
<?php echo $this->endSection() ?>