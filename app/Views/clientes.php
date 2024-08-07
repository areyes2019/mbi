<?php echo $this->extend('panel_template')?>
<?php echo $this->section('contenido')?>
<div class="container-fluid">
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
                        <a href="<?php echo base_url('agregar_cliente'); ?>" class="btn btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-flag"></i>
                            </span>
                            <span class="text">Nuevo Cliente</span>
                            
                        </a>
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
                                    <th>Empresa</th>
                                    <th>Contacto</th>
                                    <th>Correo</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($clientes as $cliente): ?>
                                <tr>
                                    <td><?php echo $cliente['empresa'] ?></td>
                                    <td><?php echo $cliente['contacto'] ?></td>
                                    <?php if ($cliente['correo'] == null):?>
                                    <td>No registrado</td>
                                    <?php else:?>
                                    <td><?php echo $cliente['correo'] ?></td>
                                    <?php endif; ?>
                                    <td>
                                        <a class="btn btn-primary btn-circle btn-sm" href="editar_cliente/<?php echo $cliente['id_cliente'] ?>"><span class="bi bi-pencil"></span></a>
                                        <a class="btn btn-danger btn-circle btn-sm" href="eliminar_cliente/<?php echo $cliente['id_cliente']  ?>" onclick="return confirm('¿Seguro que quieres eliminar este registro?')"><span class="bi bi-trash3"></span></a>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Numero WhatsApp</th>
                                    <th>Correo</th>
                                    <th>Acción</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $( document ).ready(function() {
        new DataTable('#example');
    });
    </script>
</div>
<?php echo $this->endSection()?>
