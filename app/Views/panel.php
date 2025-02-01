<?php echo $this->extend('panel_template') ?>
<?php echo $this->section('contenido') ?>
<style>
    .dropdown-toggle::after {
      display: none; /* Oculta el caret */
    }
  </style>
<div class="container-fluid mb-5" id="app">
    <!-- Page Heading -->
    <div class="mb-4">
        <p class="d-none" ref="usuario"><?php echo session('id_usuario') ?></p>
        <h1 class="h3 mb-0 text-gray-800">Panel Principal</h1>
        <?php if (esc(tiene_permisos(session('id_usuario'),'1','2'))): ?>
        <button class="btn btn-primary rounded-0 btn-sm mt-2 btn-sm shadow-none" data-toggle="modal" data-target="#nuevo_reporte"><span class="bi bi-filetype-pdf"></span> Nuevo Reporte</button>
        <?php endif ?>
    </div>
    <div class="mobile">
        <ul class="list-group">
            <?php foreach ($kardex_admin as $mis_tareas): ?>
            <li class="list-group-item">
                <?php 
                $estatus = asignar_estatus($mis_tareas['estatus']);
                if ($estatus): ?>
                    <span class="badge <?php echo $estatus['estilo']." ".$estatus['icon']?> "> <?php echo $estatus['nombre'] ?></span> 
                <?php endif ?>
                <br>
                <?php
                $fecha_original = $mis_tareas['created_at'];
                $fecha_formateada = date("d-m-Y", strtotime($fecha_original));
                echo $fecha_formateada;
                ?>
                <p class="m-0"><strong>Hospital</strong></p>
                <?php echo $mis_tareas['hospital'] ?>
                <p class="m-0"><strong>Generado por:</strong></p>
                <?php echo $mis_tareas['generado_nombre'] ?>
                <br>
                <span v-if="<?php echo $mis_tareas['tipo'] ?> == 1" class="badge badge-pill badge-custom-yellow "><?php echo $mis_tareas['tipo_txt'] ?></span>
                <span v-else-if="<?php echo $mis_tareas['tipo'] ?> == 2" class="badge badge-pill badge-custom-orange "><?php echo $mis_tareas['tipo_txt'] ?></span>
                <span v-else-if="<?php echo $mis_tareas['tipo'] ?> == 3" class="badge badge-pill badge-custom-blue "><?php echo $mis_tareas['tipo_txt'] ?></span>
                <span v-else-if="<?php echo $mis_tareas['tipo'] ?> == 4" class="badge badge-pill badge-custom-aqua "><?php echo $mis_tareas['tipo_txt'] ?></span>
                <br>
                <?php if (esc(tiene_permisos(session('id_usuario'),'1','4'))): ?>
                <!--  Eliminar -->
                <button class="btn btn-danger btn-sm shadow-none mr-1"><span class="bi bi-trash3"></span></button>
                <?php endif ?>

                <?php if (esc(tiene_permisos(session('id_usuario'),'1','2'))|| esc(es_super_admin())): ?>    
                <!--  Editar -->
                <button class="btn btn-primary btn-sm shadow-none mr-1" @click = "editar_kardex('<?php echo $mis_tareas['slug'] ?>')"><span class="bi bi-pencil"></span></button>
                <?php endif ?>

                <?php if (esc(tiene_permisos(session('id_usuario'),'1','1'))|| esc(es_super_admin())): ?>
                <!--  Vista Rápida -->
                <button class="btn btn-success btn-sm shadow-none"@click.prevent="ver_doc('<?php echo $mis_tareas['slug'] ?>')" data-toggle="modal" data-target="#ver_doc"><span class="bi bi-eye"></span></button>
                <?php endif ?>
            </li>
            <?php endforeach ?>        
        </ul>
    </div>
    <div class="main-pc">        
        <table id="personal" class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Clientess</th>
                    <th>Elaborado por:</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Tipo</th>
                    <th>Atendido por:</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kardex_admin as $mis_tareas): ?>
                <tr>
                    <td><?php echo $mis_tareas['id_kardex'] ?></td>
                    <td><?php echo $mis_tareas['hospital'] ?></td>
                    <td><?php echo $mis_tareas['generado_nombre'] ?></td>
                    <td>
                        <?php
                        $fecha_original = $mis_tareas['created_at'];
                        $fecha_formateada = date("d-m-Y", strtotime($fecha_original));
                        echo $fecha_formateada;
                        ?>
                    </td>
                    <td>
                        <?php 
                        $estatus = asignar_estatus($mis_tareas['estatus']);
                        if ($estatus): ?>
                            <span class="badge <?php echo $estatus['estilo']." ".$estatus['icon']?> "> <?php echo $estatus['nombre'] ?></span> 
                        <?php endif ?>


                    </td>
                    <td>
                        <span v-if="<?php echo $mis_tareas['tipo'] ?> == 1" class="badge badge-pill badge-custom-yellow "><?php echo $mis_tareas['tipo_txt'] ?></span>
                        <span v-else-if="<?php echo $mis_tareas['tipo'] ?> == 2" class="badge badge-pill badge-custom-orange "><?php echo $mis_tareas['tipo_txt'] ?></span>
                        <span v-else-if="<?php echo $mis_tareas['tipo'] ?> == 3" class="badge badge-pill badge-custom-blue "><?php echo $mis_tareas['tipo_txt'] ?></span>
                        <span v-else-if="<?php echo $mis_tareas['tipo'] ?> == 4" class="badge badge-pill badge-custom-aqua "><?php echo $mis_tareas['tipo_txt'] ?></span>
                    </td>
                    <td><strong><?php echo $mis_tareas['destinatario_nombre'] ?></strong></td>
                    <td>
                        <?php if (esc(tiene_permisos(session('id_usuario'),'1','4'))): ?>
                        <!--  Eliminar -->
                        <button class="btn btn-danger btn-sm shadow-none mr-1"><span class="bi bi-trash3"></span></button>
                        <?php endif ?>

                        <?php if (esc(tiene_permisos(session('id_usuario'),'1','2'))|| esc(es_super_admin())): ?>    
                        <!--  Editar -->
                        <button class="btn btn-primary btn-sm shadow-none mr-1" @click = "editar_kardex('<?php echo $mis_tareas['slug'] ?>')"><span class="bi bi-pencil"></span></button>
                        <?php endif ?>

                        <?php if (esc(tiene_permisos(session('id_usuario'),'1','1'))|| esc(es_super_admin())): ?>
                        <!--  Vista Rápida -->
                        <button class="btn btn-success btn-sm shadow-none"@click.prevent="ver_doc('<?php echo $mis_tareas['slug'] ?>')" data-toggle="modal" data-target="#ver_doc"><span class="bi bi-eye"></span></button>
                        <?php endif ?>
                    </td>
                </tr>
                <?php endforeach ?>        
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="nuevo_reporte" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo Reporte</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="modal" class="table table-bordered w-100">
                        <thead>
                            <tr>
                                <th>Hospital</th>
                                <th>Dr Encarg.</th>
                                <th>Tipo de sol.</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                                
                            <?php foreach ($cliente as $clientes): ?>
                            <tr class="w-100">
                                <td style="width: 50%;"><?php echo $clientes['hospital'] ?></td>
                                <td style="width: 50%;"><?php echo $clientes['titular'] ?></td>
                                <td>
                                    <!--  -->
                                    <select class="form-select rounded-0" v-model="tipos_model['<?php echo $clientes['id_cliente'] ?>']" style="width: 130px;">
                                            <option v-for="tipo in tipos" :key="tipo.clave" :value="tipo.clave">
                                                {{tipo.tipo }}
                                            </option>
                                    </select>
                                </td>
                                <td>
                                    <a class="btn btn-primary btn-circle" class="my-btn-primary p-1" @click = "nuevo_kardex('<?php echo $clientes['id_cliente'] ?>')"><span class="bi bi-check"></span></a>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0 btn-sm" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ver kardes envista rapida -->
    <div class="modal fade" id="ver_doc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-0" v-for="data in kardex_data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span class="bi bi-building"></span>{{data.hospital}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><strong>Titular:</strong>{{data.titular}}</h5>
                            <p class="m-0"><strong>Encargado: </strong>{{data.responsable}}</p>
                            <p class="m-0"><strong>Teléfono: </strong>{{data.telefono}}</p>
                            <p class="m-0"><strong>Móvil: </strong>{{data.movil}}</p>
                            <br>
                            <h5><strong>Generado por:</strong> {{data.generado_nombre}}</h5>
                        </div>
                    </div>
                    <table class="table table-bordered" v-for = "detalle in detalles">
                        <tr>
                            <th>Nombre del equipo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>No de Serie</th>
                            <th>Invenario</th>
                        </tr>
                        <tr>
                            <td>{{detalle.nombre}}</td>
                            <td>{{detalle.marca}}</td>
                            <td>{{detalle.modelo}}</td>
                            <td>{{detalle.serie}}</td>
                            <td>{{detalle.inventario}}</td>
                        </tr>
                        <tr>
                           <td colspan="5">
                                <p class="m-0"><strong>Falla:</strong></p>
                                <p>{{detalle.falla}}</p>
                            </td> 
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <?php 
                        $usuario = session('id_usuario');
                        if (rol_usuario($usuario,"3")): ?>
                        <div v-if="!data.aceptado && !data.rechazado">
                            <button type="button" class="btn btn-primary rounded-0 btn-sm" @click = "aceptar_tarea(data.id_kardex,'1')"><span class="bi bi-check2"></span> Aceptar la Tarea</button>
                            <button type="button" class="btn btn-danger rounded-0 btn-sm ml-2" @click = "aceptar_tarea(data.id_kardex,'2')"><span class="bi bi-x-lg"></span> Rechazar la Tarea </button>
                        </div>
                    <?php endif ?>

                </div>
            </div>
        </div>
    </div>
    <!--  modal para rechazar o aceptar la tarea -->
    <div class="modal fade" id="rechazar_tarea" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content rounded-0 ba">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tarea {{kardex}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <span v-if="accion == 1" class="bi bi-check2" style="font-size: 50px;"></span>
                    <span v-if="accion == 2" class="bi bi-x-square-fill" style="font-size: 50px;"></span>
                    <h5 class="text-danger">{{modal_msg}}</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary rounded-0 btn-sm btn-block" data-dismiss="modal" @click = "continuar_accion(kardex,accion)">Continuar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function openCity(stageLevel) {
  var i;
  var x = document.getElementsByClassName("stage");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  document.getElementById(stageLevel).style.display = "block";  
}
$( document ).ready(function() {
    new DataTable('#modal');
    new DataTable('#general');
    new DataTable('#personal');
    new DataTable('#personal_user');
});
</script>
<script type="text/javascript" src="<?php echo base_url('public/js/panel.js'); ?>"></script>
<?php echo $this->endSection() ?>