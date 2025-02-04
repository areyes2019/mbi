<?php echo $this->extend('panel_template') ?>
<?php echo $this->section('contenido') ?>
<?php foreach ($kardex as $data): ?>    
<div id="app">
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo base_url('/inicio'); ?>">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kardex <?php echo $data['id_kardex'] ?></li>
        </ol>
    </nav>
    <div class="card rounded-0">
        <div class="card-header">
            <?php if (esc(permisos($data['estatus'],'imagen_diagnostico'))): ?>
            <button class="btn btn-primary btn-sm rounded-0 mr-2" @click="liberar('<?php echo $data['id_kardex'] ?>')">Liberar Kardex</button>
            <?php endif; ?>

            <?php if (esc(permisos($data['estatus'], 'turnar'))): ?>
            <button  class="btn btn-primary btn-sm rounded-0 mr-1" data-toggle = "modal" data-target="#enviar_cardex"><span class="bi bi-gear"></span> Turnar</button>
            <?php endif ?>

            <?php if (esc(permisos($data['estatus'],'equipos'))): ?>
            <button  class="btn btn-primary btn-sm rounded-0 mr-1" data-toggle="modal" data-target="#equipos"><i class="bi bi-plus-circle"></i> Agregar Equipos</button>
            <?php endif; ?>
            <?php if (esc(permisos($data['estatus'],'aceptar_tarea'))):?>
            <button class="btn btn-success btn-sm rounded-0 shadow-none mr-1" @click="aceptar_tarea(<?php echo $data['id_kardex'] ?>)"><span class="bi bi-check2"></span> Acetpar</button>
            <button class="btn btn-danger btn-sm rounded-0 shadow-none mr-1" @click="rechazar_tarea_modal(<?php echo $data['id_kardex'] ?>)"><span class="bi bi-x-lg"></span> Rechazar</button>
            <?php endif ?>
            <?php if (esc(permisos($data['estatus'],'cotizacion'))):?>
            <button class="btn btn-warning btn-sm rounded-0 text-dark mr-1" data-toggle="modal" data-target="#entidad"><span class="bi bi-send"></span> Enviar a cotización</button>
            <?php endif ?>
            <?php if (esc(permisos($data['estatus'],'cotizar'))): ?>
            <button class="btn btn-warning btn-sm rounded-0 text-dark mr-1" data-toggle="modal" data-target="#entidad"><span class="bi bi-send"></span> Cotizar</button> 
            <?php endif ?>
            <a  v-if="Array.isArray(datos.reporte) && datos.reporte.length > 0" href="<?php echo base_url('pdf_os')."/".$data['id_kardex']; ?>" class="btn btn-primary btn-sm rounded-0 mr-2"><span class="bi bi-filetype-pdf"></span> Descargar pdf</a>
            <p class="d-none">Clave: <span ref="kardex_id"><?php echo $id ?></span></p>
            <p class="d-none" ref="id_kardex"><?php echo $data['id_kardex']?></p>
        </div>
        <div class="card-body" v-for="(kardex, index) in datos.kardex" :key="index">
            <div class="row">
                <div class="col-md-12">
                    <h4><span class="badge badge-primary">{{kardex.tipo_txt}}</span></h4>
                </div>
                <div class="col-md-12">
                    <h5 class="m-0 text-primary"><strong>Orden de Trabajo {{kardex.id_kardex}}</strong></h5>
                </div>
                <div class="col-md-4">
                    <h5 class="m-0">{{kardex.hospital}}</h5>
                    <p class="m-0">{{kardex.ubicacion}}</p>
                    <p class="m-0"><strong>Facultad:</strong> {{kardex.facultad}}</p>
                    <p class="m-0"><strong>Laboratorio:</strong> {{kardex.laboratorio}}</p>
                    <p class="m-0"><strong>Contacto:</strong> {{kardex.responsable}}</p>
                    <p class="m-0"><strong>Teléfono:</strong> {{kardex.telefono}}</p>
                </div>
                <div class="col-md-4">
                    <p class="m-0"><strong>Generado por:</strong></p>
                    <p class="m-0">{{kardex.generado_nombre}}</p>
                    <p class="m-0"><strong>Aceptado por:</strong></p>
                    <p class="m-0" v-for = "nombre in datos.mensaje">{{nombre.destinatario_nombre}}</p>
                    <p class="m-0"><strong>Cita el {{ formatearFecha(kardex.dia) }}</strong></p>
                    <p class="m-0"><strong>Hora: </strong>{{ formatearHora(kardex.hora) }}</p>
                </div>
                <h4><span class="text-danger">Costo total ${{datos.costo_total}}</span></h4>
            </div>
        </div>
    </div>
    <div v-for = "reporte in datos.reporte">
        <div class="card mt-4 rounded-0 mb-4">
            <div class="card-header">
                <!--  Generar diagostico -->
                <?php if (esc(permisos($data['estatus'],'imagen_diagnostico'))): ?>
                <button v-if="datos.display" class="btn btn-primary btn-sm rounded-0 mt-2"  data-toggle = "modal" data-target = "#diagnostico" @click = "modal_diagnostico(reporte.id_detalle,1)"><i class="bi bi-pen"></i> Agregar Diagnostico</button>
                <?php endif ?>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <p><strong>Reporte</strong></p>
                        <div class="card rounded-0">
                            <div class="card-body">
                                <p class="m-0"><strong>Nombre del equipo:</strong></p>
                                <p class="m-0">{{reporte.nombre}}</p>
                                <p class="m-0"><strong>Marca:</strong></p>
                                <p class="m-0">{{reporte.marca}}</p>
                                <p class="m-0"><strong>Modelo:</strong></p>
                                <p class="m-0">{{reporte.modelo}}</p>
                                <p class="m-0"><strong>Inventario:</strong></p>
                                <p class="m-0">{{reporte.inventario}}</p>
                                <p class="m-0"><strong>Falla:</strong></p>
                                <p class="m-0">{{reporte.falla}}</p>
                                <?php if (esc(permisos($data['estatus'],'editar_eliminiar'))): ?>
                                <button class="btn btn-primary btn-sm rounded-0 mr-1 mt-2"data-toggle="modal" data-target="#equipos_actualizar" @click = "actualizar(reporte.id_detalle)"><span class="bi bi-pencil"></span></button>
                                <button  class="btn btn-danger btn-sm rounded-0 mt-2"><span class="bi bi-trash3" @click = "borrar_linea(reporte.id_kardex)"></span></button>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div v-if="datos.diagnostico && datos.diagnostico.length">
                            <p><strong>Diagnóstico</strong></p>
                            <div class="card rounded-0" v-for = "diagnostico in datos.diagnostico">
                                <div class="card-header">
                                    <?php if (esc(permisos($data['estatus'],'imagen_diagnostico'))): ?>
                                    <!--  imagenes de diagnostico  -->
                                    <button  class="btn btn-primary btn-sm rounded-0 mr-1" data-toggle="modal" data-target="#agregar_imagen" @click="guardar_imgen_diangostico(diagnostico.id_detalle_kardex)"><i class="bi bi-camera"></i></button>
                                    <!--  modificar diagnostico -->
                                    <button  class="btn btn-primary btn-sm rounded-0 mr-1" data-toggle = "modal" data-target = "#diagnostico" @click = "modal_diagnostico(diagnostico.id_detalle_kardex,2)"><i class="bi bi-pencil"></i></button>
                                    <!--  eliminar -->
                                    <button   class="btn btn-danger btn-sm rounded-0 mr-1" @click = "borrar_diagnostico(diagnostico.id_detalle_kardex)"><span class="bi bi-trash3"></span></button>
                                    <button  class="btn btn-secondary btn-sm rounded-0" data-toggle="modal" data-target="#agregar_refacciones" @click = "abrir_modal_refacciones(diagnostico.id_detalle_kardex)"><span class="bi bi-tools"></span> Refacciones</button>
                                    <?php endif ?>
                                </div>
                                <div class="card-body">
                                    <p class="m-0"><strong>Diagnóstico:</strong></p>
                                    <p class="m-0">{{diagnostico.diagnostico}}</p>
                                    <p class="m-0"><strong>Reparación sugerida:</strong></p>
                                    <p class="m-0">{{diagnostico.reparacion}}</p>
                                    <p class="m-0"><strong>Tiempo de entrega:</strong></p>
                                    <p class="m-0">{{diagnostico.tiempo_entrega}}</p>
                                    <p class="m-0"><strong>Precio sugerido:</strong></p>
                                    <p class="m-0">${{diagnostico.precio_estimado}}</p>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <p><strong>Diagnóstico</strong></p>
                            <div class="alert alert-danger"><strong>Aun no hay diagnóstico</strong></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div v-if="datos.diagnostico && datos.diagnostico.length">
                            <p><strong>Refacciones</strong></p>
                            <div class="card rounded-0" v-for = "diagnostico in datos.diagnostico">
                                <div class="card-body">
                                    <table class="table">
                                        <tr>
                                            <th>Refacción</th>
                                            <th>Marca</th>
                                            <th>Modelo</th>
                                            <th>Precio</th>
                                            <th></th>
                                        </tr>
                                        <tr v-for = "refacciones in datos.refacciones">
                                            <td>{{refacciones.refaccion}}</td>
                                            <td>{{refacciones.marca}}</td>
                                            <td>{{refacciones.modelo}}</td>
                                            <td>${{refacciones.precio}}</td>
                                            <?php if (esc(permisos($data['estatus'],'imagen_diagnostico'))): ?>
                                            <td><button class="btn btn-danger btn-sm rounded-0" @click = "borrar_refaccion(refacciones.id_refaccion)"><span class=" bi bi-x-lg"></span></button></td>
                                            <?php endif ?>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-right"><strong>Total</strong></td>
                                            <td>${{datos.total}}</td>
                                        </tr>
                                    </table>
                                    <div class="d-flex flex-wrap">
                                        <div v-for = "data_img in datos.imagenes" class="p-2 position-relative">
                                            <img  class="foto d-flex mr-1" :src="'/public/equipos/' + data_img.img" alt="Miniatura 1" @click = "mostrarImagenGrande(data_img.img)">
                                            <?php if (esc(permisos($data['estatus'],'imagen_diagnostico'))): ?>                                                
                                            <button class="btn-close position-absolute top-0 end-0" aria-label="Close" @click="eliminarImagen(data_img)"></button>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                    <!-- Modal para mostrar imagen en grande -->
                                    <div v-if="imagenGrande" class="my-modal" @click="cerrarImagenGrande">
                                      <img :src="'/public/equipos/' + imagenGrande" alt="Imagen en grande" class="imagen-grande">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <p><strong>Refacciones</strong></p>
                            <div class="alert alert-danger"><strong>No se han agregado refacciones</strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  Modal agregar precio por el administrador -->
    <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="miModalLabel">Ingrese el Costo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="row row-cols-lg-auto g-3 align-items-center">
              <div class="col-12">
                <label class="visually-hidden" for="inlineFormInputGroupUsername">Costo</label>
                <div class="input-group">
                  <div class="input-group-text">$</div>
                  <input type="number" class="form-control" id="inlineFormInputGroupUsername" placeholder="Costo" v-model = "precio_admin">
                </div>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-primary" @click.prevent="a_cotizacion(datos.user,datos.kardex_id)">Enviar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--  Modal definir entidad -->
    <div class="modal fade" id="entidad" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="miModalLabel">Escoge la entidad</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
                <label for="">Selecciona una entidad...</label>
                <select name="" id=""  class="form-control rounded-0 shadow-none" v-model="entidad">
                    <?php foreach ($entidades as $entidad): ?>
                    <option value="<?php echo $entidad['id_entidad'] ?>"><?php echo $entidad['razon_social'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-sm rounded-0" @click="cotizar(<?php echo $data['id_kardex'] ?>)">Cotizar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Agregar diagnostico -->
    <div class="modal fade" id="diagnostico" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Diagnóstico</h5>
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
                    <label for="">Escribe la reparación sugerida</label>
                    <div class="input-group">
                        <div class="input-group-prepend input-group-sm">
                          <div class="input-group-text rounded-0">
                            <i class="bi bi-gear"></i>
                          </div>
                        </div>
                        <textarea name="" id="" class="form-control rounded-0 form-control-sm shadow-none" v-model="reparacion" ></textarea>
                    </div>
                </div>
                <div class="form-group mt-2">
                    <div class="input-group">
                        <div class="input-group-prepend input-group-sm">
                          <div class="input-group-text rounded-0">
                            <i class="bi bi-coin"></i>
                          </div>
                        </div>
                        <input type="text" class="form-control rounded-0 form-control-sm shadow-none"   @input="limpiar_error($event,'marca')" placeholder="Costo estimado de mano de obra *" v-model="precio_estimado">
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
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-0 shadow-none btn-sm" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary rounded-0 shadow-none btn-sm" @click="generar_diagnostico(clase)"><span class="bi bi-plus-circle"></span> Agregar</button>
            </div>
        </div>
      </div>
    </div>
    <!--  Agregar refacciones -->
    <div class="modal fade" id="agregar_refacciones">
        <div class="modal-dialog modal-xl">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar refacciones</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <button type="button" class="btn btn-primary btn-sm rounded-0 mb-3" @click="agregarFila"><span class="bi bi-plus-circle"></span></button>
                    <form @submit.prevent="submitForm">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="d-none"></th>
                                    <th>Nombre de la pieza</th>
                                    <th>Costo</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(refaccion, index) in refacciones" :key="index">
                                    <td class="d-none"><input type="text" v-model = "id_diagnostico"></td>
                                    <td width="40%"><input class="form-control form-control-sm rounded-0 shadow-none" type="text" v-model="refaccion.nombre" placeholder="Refacción"></td>
                                    <td><input class="form-control form-control-sm rounded-0 shadow-none" type="number" v-model="refaccion.costo" placeholder="Costo" step="0.01"></td>
                                    <td><input class="form-control form-control-sm rounded-0 shadow-none" type="text" v-model="refaccion.marca" placeholder="Marca"></td>
                                    <td><input class="form-control form-control-sm rounded-0 shadow-none" type="text" v-model="refaccion.modelo" placeholder="Modelo"></td>
                                    <td class="d-flex justify-content-end"><button type="button" class="btn btn-danger btn-sm rounded-0" @click="eliminarFila(index)"><span class="bi bi-x-lg"></span></button></td>
                                </tr>
                            </tbody>
                        </table>
                        <br><br>
                        <button type="submit" class="btn btn-primary btn-sm rounded-0">Guardar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm rounded-0" data-dismiss="modal">Close</button>
                    <button type="button" :class="['btn', 'btn-primary', 'btn-sm', 'rounded-0', archivo_permitido]" @click = "subir_imagen">Guardar</button>
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
                <div v-if="!datos.reporte || datos.reporte.length === 0">
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
                        <tr v-for = "horario in datos.horario">
                            <td>{{horario.dia}}</td>
                            <td>{{horario.hora_inicio}}</td>
                            <td>{{horario.hora_fin}}</td>
                        </tr>
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
            <button  type="button" v-if="Array.isArray(datos.reporte) && datos.reporte.length > 0" class="btn btn-primary rounded-0 shadow-none btn-sm" @click="enviar"><span class="bi bi-plus-circle"></span> Enviar</button>
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
    <!--  modal rechazar tarea -->
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
</div>
<?php endforeach ?>
<script type="text/javascript" src="<?php echo base_url('public/js/alert.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/js/kardex.js');?>"></script>
<?php echo $this->endSection() ?>
