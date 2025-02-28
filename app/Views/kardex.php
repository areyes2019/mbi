<?php echo $this->extend('panel_template') ?>
<?php echo $this->section('contenido') ?>
<div id="app">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="/inicio">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kardex <?php echo $id ?></li>
        </ol>
    </nav>

    <!-- Card principal -->
    <div class="card rounded-0">
        <div class="card-header">
            <!--  esto lo ve el vendedor en la etapa 1 y el administrador en la etapa 2 -->
            <?php if (($proceso == 1 && $rol== 1)||($proceso==2 && $rol== 2)): ?>
            <button class="btn btn-primary btn-sm rounded-0 mr-1" data-toggle = "modal" data-target="#enviar_cardex">Turnar</button>
            <?php endif ?>
            
            <?php if ($proceso == 6 && $rol==3): ?>
            <button class="btn btn-primary btn-sm rounded-0 mr-2">Liberar Kardex</button>
            <?php endif ?>
            
            <?php if ($proceso==1 && $rol == 1): ?>
            <button class="btn btn-primary btn-sm rounded-0 mr-1" data-toggle = "modal" data-target="#equipos">Agregar Equipos</button>
            <?php endif ?>

            <?php if ($proceso == 4 && $rol==3): ?>
            <button class="btn btn-success btn-sm rounded-0 shadow-none mr-1">Aceptar</button>
            <button class="btn btn-danger btn-sm rounded-0 shadow-none mr-1" data-toggle = "modal" data-target="#rechazar_tarea">Rechazar</button>
            <?php endif ?>

            <?php if ($proceso == 7 && $rol==2): ?>
            <button class="btn btn-warning btn-sm rounded-0 text-dark mr-1" data-toggle = "modal" data-target="#entidad">Enviar a cotización</button>
            <?php endif ?>
            <a href="/pdf_os/123" class="btn btn-primary btn-sm rounded-0 mr-2" data-toggle = "modal" data-target="#enviar_cardex">Descargar PDF</a>
        </div>
        <div class="card-body">
            <?php foreach ($kardex as $k):?>
            <div class="row">
                <div class="col-md-12">
                    <?php if ($k['tipo']==1): ?>
                    <h4><span class="badge badge-primary"><?= $k['tipo_txt'] ?></span></h4>
                    <?php endif ?>

                    <?php if ($k['tipo']==2): ?>
                    <h4><span class="badge badge-secondary"><?= $k['tipo_txt'] ?></span></h4>
                    <?php endif ?>
                    <?php if ($k['tipo']==3): ?>
                    <h4><span class="badge badge-success"><?= $k['tipo_txt'] ?></span></h4>
                    <?php endif ?>
                    
                    <?php if ($k['tipo']==4): ?>
                    <h4><span class="badge badge-warning text-dark"><?= $k['tipo_txt'] ?></span></h4>
                    <?php endif ?>
                </div>
                <div class="col-md-12">
                    <h5 class="m-0 text-primary">Orden de Trabajo<strong ref="kardex_id"> <?php echo $id ?></strong></h5>
                    <h6>Fecha: <strong><?php echo $fecha ?> </strong></h6>
                </div>
                <div class="col-md-4">
                    <h5 class="m-0">Hospital General</h5>
                    <p class="m-0">Ubicación: Edificio A</p>
                    <p class="m-0"><strong>Facultad:</strong> <?= $k['facultad']?></p>
                    <p class="m-0"><strong>Laboratorio:</strong><?= $k['laboratorio'] ?></p>
                    <p class="m-0"><strong>Contacto:</strong><?= $k['responsable'] ?></p>
                    <p class="m-0"><strong>Teléfono:</strong><?= $k['movil'] ?></p>
                    <p class="m-0"><strong>Generado por:</strong> <?php echo $k['generado_nombre'] ?></p>
                    <h4><span class="text-danger">Costo total $1000</span></h4>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </div>
    <!-- Reporte de falla -->
    <div class="row mt-4 mb-5">
        <div class="col-md-6">
        <p><strong>Reporte</strong></p>
        
        <?php if (isset($reporte['flag']) && $reporte['flag']==0): ?>
        <div class="alert alert-primary rounded-0" role="alert">
            Esta orden de servicio aun no tiene detalles.
        </div>
        <?php else:?>
        <?php foreach ($reporte as $isue): ?>
        <div class="card">
            <div class="card-header">
                <button 
                    class="btn btn-primary btn-sm rounded-0 mr-1" 
                    data-toggle="modal" 
                    data-target="#equipos_actualizar"
                    @click = "actualizar(<?= $isue['id_detalle']?>)"
                    >Editar</button>
                <button class="btn btn-danger btn-sm rounded-0" @click = "borrar_linea(<?= $isue['id_detalle'] ?>)">Eliminar</button>
            </div>
            <div class="card-body">
                <p class="m-0"><strong>Nombre del equipo:</strong> <?php echo $isue['nombre'] ?></p>
                <p class="m-0"><strong>Marca:</strong> <?php echo $isue['marca'] ?></p>
                <p class="m-0"><strong>Modelo:</strong> <?php echo $isue['modelo'] ?></p>
                <p class="m-0"><strong>Inventario:</strong> <?php echo $isue['inventario'] ?></p>
                <p class="m-0"><strong>Falla:</strong> <?php echo $isue['falla'] ?></p>
            </div>
        </div>
        <?php endforeach ?>
        
        <?php endif ?>
        </div>
        <div class="col-md-6">
            <p><strong>Diagnóstico</strong></p>
            
            <?php if ($diagnostico['flag']==0): ?>
            <div class="alert alert-primary rounded-0" role="alert">
                ¡Esta orden de servicio aun no esta diagnosticada!
            </div>
            <?php else: ?>
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary btn-sm rounded-0 mr-1">Agregar Imagen</button>
                    <button class="btn btn-primary btn-sm rounded-0 mr-1">Editar</button>
                    <button class="btn btn-danger btn-sm rounded-0 mr-1">Eliminar</button>
                    <button class="btn btn-secondary btn-sm rounded-0">Refacciones</button>
                </div>
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
            <?php if ($diagnostico['flag']==0): ?>
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
        </div>
    </div>
    <!--  Modal para ver la miniatura -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?php if ($diagnostico['flag']==0): ?>
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
    <!--  Modal definir entidad -->
    <div class="modal fade" id="entidad" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="miModalLabel">Ingrese el Costo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
                <label for="">Entidad</label>
                <select name="" id="" class="form-control rounded-0 shadow-none" v-model="entidad">
                    <option value="" selected disabled>Seleccione una entidad</option>
                    <?php foreach ($entidades as $entidad): ?>
                    <option value="<?php echo $entidad['id_entidad'] ?>"><?php echo $entidad['razon_social'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-sm rounded-0" @click="cotizar(<?php echo $id ?>)">Cotizar</button>
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
                <p class="d-none" ref="id_detalle">{{id_detalle}}</p>
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
            <button type="button" class="btn btn-primary rounded-0 shadow-none btn-sm" @click="actualizar_detalle(id_detalle)"><i class="bi bi-arrow-clockwise"></i> Actualizar</button>
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
<script type="text/javascript" src="<?php echo base_url('public/js/alert.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/js/kardex.js');?>"></script>
<?php echo $this->endSection() ?>

