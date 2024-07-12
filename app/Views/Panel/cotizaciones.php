<?php echo $this->extend('Panel/panel_template')?>
<?php echo $this->section('contenido')?>
<div class="container mt-3">
	<div class="my-card d-flex justify-content-between">
		<h2>Flujo de Trabajo</h2>
        <!-- Button trigger modal -->
       
	</div>
	<div class="my-card mt-3">
		<table id="example" class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Numero WhatsApp</th>
                    <th>Fecha</th>
                    <th>Estatus</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cotizaciones as $data): ?>
                <tr>
                    <td><?php echo $data['nombre'] ?></td>
                    <td><?php echo $data['telefono'] ?></td>
                    <td><?php echo $data['fecha'] ?></td>
                    <td>Enviada</td>
                    <td>
                        <a class="btn btn-primary btn-circle btn-sm" href="<?php echo base_url('pagina_cotizador/'.$data['slug']); ?>" class="btn btn-sm rounded-0 my-btn-success"><span class="bi bi-pencil"></span></a>
                        <a class="btn btn-danger btn-circle btn-sm" href="<?php echo base_url('eliminar_cotizacion/'.$data['idQt']); ?>" class="btn btn-sm rounded-0 my-btn-danger" onclick="return confirm('Esta eliminación no se puede revertir, ¿Deseas continuar?');"><span class="bi bi-trash3"></span></a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Nombre</th>
                    <th>Numero WhatsApp</th>
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
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                <?php foreach ($clientes as $cliente): ?>
                <tr class="w-100">
                    <td><?php echo $cliente['nombre'] ?></td>
                    <td>
                        <a class="btn btn-primary btn-circle" href="/nueva_cotizacion/<?php echo $cliente['idCliente']?>"  class="my-btn-primary p-1"><span class="bi bi-check"></span></a>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="my-btn-danger p-2" data-bs-dismiss="modal">Cerrar</button>
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