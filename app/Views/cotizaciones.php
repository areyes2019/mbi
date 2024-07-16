<?php echo $this->extend('panel_template')?>
<?php echo $this->section('contenido')?>
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <button data-toggle="modal" data-target="#exampleModal" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Genera Reporte</button>
    </div>
	<div class="my-card mt-3">
		<table id="example" class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Contacto</th>
                    <th>Fecha</th>
                    <th>Estatus</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Hospital Santa Maria</td>
                    <td>Elena Santos</td>
                    <td>12/12/2024</td>
                    <td>SD</td>
                    <td>
                        <a class="btn btn-primary btn-circle btn-sm" href="" class="btn btn-sm rounded-0 my-btn-success"><span class="bi bi-pencil"></span></a>
                        <a class="btn btn-danger btn-circle btn-sm" href="" class="btn btn-sm rounded-0 my-btn-danger" onclick="return confirm('Esta eliminación no se puede revertir, ¿Deseas continuar?');"><span class="bi bi-trash3"></span></a>
                    </td>
                </tr>
                <tr>
                    <td>Hospital San José</td>
                    <td>Pedro Baltrierrez</td>
                    <td>12/12/2024</td>
                    <td>SD</td>
                    <td>
                        <a class="btn btn-primary btn-circle btn-sm" href="" class="btn btn-sm rounded-0 my-btn-success"><span class="bi bi-pencil"></span></a>
                        <a class="btn btn-danger btn-circle btn-sm" href="" class="btn btn-sm rounded-0 my-btn-danger" onclick="return confirm('Esta eliminación no se puede revertir, ¿Deseas continuar?');"><span class="bi bi-trash3"></span></a>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>Nombre</th>
                    <th>Contacto</th>
                    <th>Fecha</th>
                    <th>Estatus</th>
                    <th>Acción</th>
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
<script>
    $( document ).ready(function() {
        new DataTable('#modal');
        new DataTable('#example');
    });
</script>
<script type="" src="<?php echo base_url('public/js/cotizaciones.js'); ?>"></script>
<?php echo $this->endSection(); ?>