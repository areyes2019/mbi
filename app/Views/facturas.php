<?php echo $this->extend('panel_template')?>
<?php echo $this->section('contenido')?>
<div class="container-fluid" id="app">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Cortizaciones</h1>
    </div>
	<div class="my-card mt-3">
		<table id="factura" class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Receptor</th>
                    <th>Fecha</th>
                    <th>Estatus</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($factura as $facturas): ?>
                <tr>
                    <td><?php echo $facturas['id_folio'] ?></td>
                    <td><?php echo $facturas['hospital'] ?></td>
                    <td><?php echo date('d-m-Y', strtotime($facturas['created_at'])); ?></td>

                    <td>
                        <?php 
                        $estatus = asignar_estatus($facturas['estatus']);
                        if ($estatus): ?>
                            <span class="badge <?php echo $estatus['estilo']." ".$estatus['icon']?> "> <?php echo $estatus['nombre'] ?></span> 
                        <?php endif ?>        
                    </td>
                    <td class="d-flex justify-content-end">
                        <div class="btn-group dropleft">
                            <button class="btn btn-outline-dark btn-sm rounded-0" data-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu rounded-0">
                                <a href="" class="dropdown-item"  onclick="return confirm('¿Estas seguro de querer eliminar esta cotización?');">Cancelar</a>
                                <a href="" class="dropdown-item" @click.prevent = "enviar_factura()">Enviar por correo</a>
                                <a href="" class="dropdown-item">Vista previa</a>
                                <a href="<?php echo base_url('descargar/'.$facturas['id_folio']);?>" class="dropdown-item">Descargar PDF</a>
                                <a href="" class="dropdown-item">Descargar ZIP</a>
                            </div>
                        </div> 
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Contacto</th>
                    <th>Fecha</th>
                    <th>Estatus</th>
                </tr>
            </tfoot>
        </table>
	</div>
</div>

<div id="app"></div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog rounded-0">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Cliente</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="modal" class="table table-bordered w-100">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <tr class="w-100">
                    <td>Hospital Santa Helena</td>
                    <td>
                        <a class="btn btn-primary btn-circle" href="<?php echo base_url('kardex'); ?>"  class="my-btn-primary p-1"><span class="bi bi-check"></span></a>
                    </td>
                </tr>
                <tr class="w-100">
                    <td>Hospital Santa Helena</td>
                    <td>
                        <a class="btn btn-primary btn-circle" href=""  class="my-btn-primary p-1"><span class="bi bi-check"></span></a>
                    </td>
                </tr>
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo base_url('public/js/facturas.js'); ?>"></script>
<script>
    $( document ).ready(function() {
        new DataTable('#factura');
    });
</script>
<?php echo $this->endSection(); ?>