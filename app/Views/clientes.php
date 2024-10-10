<?php echo $this->extend('panel_template')?>
<?php echo $this->section('contenido')?>
<div class="container-fluid" id="app">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('inicio'); ?>">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Clientes</li>
      </ol>
    </nav>
    <div class="row column_title">
        <div class="col-md-12">
            <div class="page_title">
                <h2>Clientes</h2>
                
            </div>
        </div>
    </div>
    <!-- row -->
    <div class="row mt-4">
        <!-- table section -->
        <div class="col-md-12">
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0 mb-2">
                        <?php if (tiene_permisos($usuario,$seccion,'2') || es_super_admin() ): ?>
                        <a href="<?php echo base_url('agregar_cliente'); ?>" class="btn btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="bi bi-plus-circle"></i>
                            </span>
                            <span class="text">Nuevo Cliente</span>
                        </a>
                        <?php endif ?>
                    </div>
                    <div class="modal fade" id="nuevo_cliente">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form action="<?php echo base_url('nuevo_cliente');?>" method="post">
                                <label for="">Nombre</label>
                                <input type="text" class="my-input w-100" name="nombre">
                                <label for="">Numero WhatsApp</label>
                                <input type="text" class="my-input w-100" name="telefono">
                                <button class="btn btn-primary btn-icon-split mt-2">
                                    <span class="icon text-white-50">
                                        <i class="bi bi-save"></i>
                                    </span>
                                    <span class="text">Guardar</span>
                                </button>
                            </form>
                          </div>
                          <div class="modal-footer">
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="table_section padding_infor_info">
                    <div class="table-responsive-sm">
                        <table id="example" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Titular</th>
                                    <th>Encargado</th>
                                    <th>Correo</th>
                                    <th>Teléfono</th>
                                    <th>Móvil</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($clientes as $cliente): ?>
                                <tr>
                                    <td><a href="" data-toggle="modal" data-target="#ver_cliente" @click="mostrar_cliente_modal('<?php echo $cliente['id_cliente'] ?>')"><?php echo $cliente['hospital'] ?></a></td>
                                    <td><?php echo $cliente['titular'] ?></td>
                                    <td><?php echo $cliente['responsable'] ?></td>
                                    <?php if ($cliente['correo'] == null):?>
                                    <td>No registrado</td>
                                    <?php else:?>
                                    <td><?php echo $cliente['correo'] ?></td>
                                    <td><?php echo $cliente['telefono'] ?></td>
                                    <td><?php echo $cliente['movil'] ?></td>
                                    <?php endif; ?>
                                    <td class="text-center">
                                        <div class="dropdown" id="menu" data-toggle="tooltip" title="Opciones de edición">
                                          <a href="#" type="button" data-toggle="dropdown" aria-expanded="false">
                                            <span class="bi bi-three-dots-vertical"></span>
                                          </a>
                                          <div class="dropdown-menu rounded-0">
                                            <?php if (tiene_permisos($usuario,$seccion,'3') || es_super_admin()): ?>
                                            <a class="dropdown-item" href="/editar_cliente/<?php echo $cliente['id_cliente']; ?>">Editar Cliente</a>
                                            <?php endif ?>
                                            <?php if (tiene_permisos($usuario,$seccion,'4')|| es_super_admin()):?>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="if(confirm('¿Estás seguro de que deseas eliminar este cliente?')) { window.location.href='/eliminar_cliente/<?php echo $cliente['id_cliente'] ?>'; }">
                                                Eliminar Cliente
                                            <?php endif ?>
                                            </a>
                                          </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Doctor o Encargado</th>
                                    <th>Responsable</th>
                                    <th>Correo</th>
                                    <th>Teléfono</th>
                                    <th>Móvil</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--  Modal ver cliente  -->
        <div class="modal fade" id="ver_cliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title">Horarios de Atención</h5>
                        <p class="d-none" ref="cliente_modal">{{id_cliente}}</p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-3" id="contentToConvert" ref="contentToConvert">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="card rounded-0">
                                      <div class="card-body" v-for = "data in editar">
                                          <h4>{{data.titular}}</h4>
                                          <h5><strong>Responsable:</strong> {{data.responsable}}</h5>
                                          <p class="m-0"><strong>Telefono</strong>{{data.telefono}}<span class="text-secondary">Ext:</span> {{data.extencion}}</p>
                                          <p class="m-0"><strong>Móvil</strong> {{data.movil}}</p>
                                          <p class="m-0"><strong>Correo:</strong> {{data.correo}}</p>
                                          <p class="m-0"><strong>Dirección:</strong> {{data.direccion}}</p>
                                          <p class="m-0"><strong>Ubicación:</strong> {{data.ubicacion}}</p>
                                          <p class="m-0"><strong>Facultad:</strong> {{data.facultad}}</p>
                                          <p class="m-0"><strong>Laboratorio:</strong> {{data.laboratorio}}</p>
                                          <p class="m-0"><strong>Pizo:</strong> {{data.piso}}</p>
                                          <p class="d-none" ref="cliente">{{data.id_cliente}}</p>
                                      </div>
                                  </div>  
                            </div>
                            <div class="col-md-5">
                                <div class="card rounded-0">
                                    <div class="card-header bg-primary rounded-0">
                                        <h5 class="card-title text-white">Horarios de Atención</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <tr>
                                                <th>Dia</th>
                                                <th>De:</th>
                                                <th>A:</th>
                                            </tr>
                                            <tr v-for="hora in horarios">
                                                <td><small>{{hora.dia}}</small></td>
                                                <td><small>{{formatTo12Hour(hora.hora_inicio)}}</small></td>
                                                <td><small>{{formatTo12Hour(hora.hora_fin)}}</small></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn"><span class="bi bi-camera" @click = "convertAndCopy"></span></button>
                    </div>
                </div>
            </div>
        </div>
        <!--  Modal agregar horario -->

    </div>
</div>
<script>
$( document ).ready(function() {
    new DataTable('#example');
    $('#menu').tooltip();
    $('#agregar_datos_fiscales').on('shown.bs.modal', function () {
        $('#estados').select2({
          allowClear: true,
          placeholder: 'Selecciona un estado',
          dropdownParent: $('#agregar_datos_fiscales')
        });
        $('#regimen-fiscal').select2({
          allowClear: true,
          placeholder: 'Selecciona el régimen fiscal',
          dropdownParent: $('#agregar_datos_fiscales')
        });
    });
});
</script>
<script type="text/javascript" src="<?php echo base_url('public/js/form_horarios.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/js/clientes.js'); ?>"></script>
<?php echo $this->endSection()?>
