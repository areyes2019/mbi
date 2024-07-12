<?php echo $this->extend('Panel/panel_template')?>
<?php echo $this->section('contenido')?>
<div class="container-fluid">
    <div class="row column_title">
        <div class="col-md-12">
            <div class="page_title">
                <h2>Artículos</h2>
            </div>
        </div>
    </div>
    <!-- row -->
    <div class="row">
        <!-- table section -->
        <div class="col-md-12">
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0">
                        <button class="btn btn-primary btn-icon-split mb-2" data-toggle="modal" data-target="#nuevo_articulo">
                            <span class="icon text-white-50">
                                <i class="bi bi-plus-circle"></i>
                            </span>
                            <span class="text">Nuevo Artículo</span>
                        </button>
                    </div>
                    <div class="modal fade" id="nuevo_articulo">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form action="<?php echo base_url('nuevo_articulo'); ?>" method="post">
                                <label for="">Nombre</label>
                                <input type="text" class="my-input w-100" name="nombre">
                                <label for="">Modelo</label>
                                <input type="text" class="my-input w-100" name="modelo">
                                <label for="">Precio Proveedor</label>
                                <input type="text" class="my-input w-100" name="precio_prov">
                                <label for="">Precio Público</label>
                                <input type="text" class="my-input w-100" name="precio_pub">
                                <button class="btn btn-primary btn-icon-split mt-2">
                                    <span class="icon text-white-50">
                                        <i class="bi bi-save"></i>
                                    </span>
                                    <span class="text">Guardar</span>
                                </button>
                            </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-icon-split" data-dismiss="modal">
                                <span class="icon text-white-50">
                                    <i class="bi bi-box-arrow-right"></i>
                                </span>
                                <span class="text">Cerrar</span>
                            </button>
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
                                    <th>Nombre</th>
                                    <th>Modelo</th>
                                    <th>Precio Proveedor</th>
                                    <th>Precio Público</th>
                                    <th>Beneficio</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($articulos as $articulo): ?>
                                <tr>
                                    <td><?= $articulo['nombre'];?></td>
                                    <td><?= $articulo['modelo'];?></td>
                                    <td>$<?= $articulo['precio_prov'];?></td>
                                    <td><strong>$<?= $articulo['precio_pub'];?></strong></td>
                                    <td>$<?= $articulo['precio_pub'] - $articulo['precio_prov'];?></td>
                                    <td>
                                        <a class="btn btn-circle btn-sm btn-primary" href="editar_articulo/<?php echo $articulo['idArticulo'] ?>" class="btn btn-sm rounded-0 my-btn-success"><span class="bi bi-pencil"></span></a>
                                        <a class="btn btn-circle btn-sm btn-danger" href="eliminar_articulo/<?php echo $articulo['idArticulo']  ?>" onclick="return confirm('¿Seguro que quieres eliminar este registro?')" class="btn btn-sm rounded-0 my-btn-danger"><span class="bi bi-trash3"></span></a>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Modelo</th>
                                    <th>Precio Proveedor</th>
                                    <th>Precio Público</th>
                                    <th>Beneficio</th>
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