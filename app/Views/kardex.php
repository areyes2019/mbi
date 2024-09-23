<?php echo $this->extend('panel_template') ?>
<?php echo $this->section('contenido') ?>
<div class="container-fluid" id="app">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <?php foreach ($kardex as $data):?>
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-start">
            <button  class="btn btn-primary btn-sm rounded-0 mr-2" data-toggle = "modal" data-target="#enviar_cardex"><span class="bi bi-gear"></span> Turnar</button>
            <button  class="btn btn-primary btn-sm rounded-0" data-toggle="modal" data-target="#equipos"><i class="bi bi-plus-circle"></i> Agregar Equipos</button>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-12">
                    <h5><strong>No. </strong><span ref="kardex"><?php echo $data['id_kardex'] ?></span></h5>
                    <h5><?php echo $data['hospital'] ?></h5>
                    <p class="m-0"><strong>Titular: </strong><?php echo $data['titular'] ?></p>
                    <p class="m-0"><strong>Responsable: </strong><?php echo $data['responsable'] ?></p>
                    <p class="m-0"><strong>Teléfono: </strong><?php echo $data['telefono'] ?></p>
                    <p class="m-0"><strong>Móvil: </strong><?php echo $data['movil'] ?></p>
                    <br>
                    <h6><strong>Generado por: </strong><?php echo $data['generado_nombre'] ?></h6>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12" v-if="<?php echo $hay_detalle ?> == 0">
                    <div class="alert alert-primary" role="alert">
                        No se han agregado equipos a este kardex
                    </div>
                </div>
                <div class="col-12" v-else>
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Equipo</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>No.Serie</th>
                                <th>No. Inventario</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody v-for="kdx in lista">
                            <tr>
                                <td>{{kdx.nombre}}</td>
                                <td>{{kdx.marca}}</td>
                                <td>{{kdx.modelo}}</td>
                                <td>{{kdx.serie}}</td>
                                <td>{{kdx.inventario}}</td>
                                <td>
                                    <button  class="btn btn-primary btn-sm rounded-0"><span class="bi bi-trash3" @click = "borrar_linea(kdx.id_kardex)"></span></button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5"><strong>Descripción del problema: </strong>{{kdx.falla}}</td>
                            </tr>
                        </tbody>                    
                    </table>
                </div>
            </div>
        </div>
        <?php endforeach ?>
    </div>
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
                <div class="form-group mt-2">
                    <div class="input-group">
                        <div class="input-group-prepend input-group-sm">
                          <div class="input-group-text rounded-0">
                            <i class="bi bi-person"></i>
                          </div>
                        </div>
                        <select v-model="usuario" class="form-control rounded-0 shadow-none">
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
                        <input class="form-control rounded-0 shadow-none" placeholder="Asunto..." v-model="asunto">
                    </div>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary rounded-0 shadow-none btn-sm" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary rounded-0 shadow-none btn-sm" @click="enviar"><span class="bi bi-plus-circle"></span> Agregar</button>
          </div>
        </div>
      </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url('public/js/alert.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/js/kardex.js');?>"></script>
<?php echo $this->endSection() ?>