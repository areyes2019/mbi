<?php echo $this->extend('panel_template') ?>
<?php echo $this->section('contenido') ?>
<div class="container">
	<div class="row">
		<div class="col-md-6">		
			<div class="card shadow mb-4 rounded-0">
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		            <h6 class="m-0 font-weight-bold text-primary">Reporte de Falla</h6>
		            <div class="dropdown no-arrow">
		                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
		                </a>
		                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" style="">
		                    <div class="dropdown-header">Dropdown Header:</div>
		                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#tecnico_asignado">Enviar</a>
		                    <a class="dropdown-item" href="#">Descargar</a>
		                    <a class="dropdown-item" href="#">Guardar como borrador</a>
		                </div>
		            </div>
			    </div>
			    <div class="card-body">
			    	<h4>Hospital General</h4>
			    	<form>
			            <div class="form-group">
			                <label for="equipo">Equipo</label>
			                <input type="text" class="form-control" id="equipo" placeholder="Ingrese el nombre del equipo" required>
			            </div>
			            <div class="form-group">
			                <label for="marca">Marca</label>
			                <input type="text" class="form-control" id="marca" placeholder="Ingrese la marca del equipo" required>
			            </div>
			            <div class="form-group">
			                <label for="modelo">Modelo</label>
			                <input type="text" class="form-control" id="modelo" placeholder="Ingrese el modelo del equipo" required>
			            </div>
			            <div class="form-group">
			                <label for="status">Estado del Equipo</label>
			                <select class="form-control" id="status" required>
			                    <option>Operativo</option>
			                    <option>En reparación</option>
			                    <option>Fuera de servicio</option>
			                    <option>No evaluado</option>
			                </select>
			            </div>
			            <div class="form-group">
			                <label for="horario">Horario de Visita</label>
			                <input type="datetime-local" class="form-control" id="horario" required>
			            </div>
			            <div class="form-group">
			                <label for="ubicacion">Ubicación del Equipo</label>
			                <input type="text" class="form-control" id="ubicacion" placeholder="Ingrese la ubicación del equipo" required>
			            </div>
			            <div class="form-group">
			                <label for="tecnico">Técnico Responsable</label>
			                <input type="text" class="form-control" id="tecnico" placeholder="Ingrese el nombre del técnico" required>
			            </div>
			            <div class="form-group">
			                <label for="observaciones">Observaciones</label>
			                <textarea class="form-control" id="observaciones" rows="4" placeholder="Ingrese observaciones adicionales"></textarea>
			            </div>
		        	</form>
			    </div>
			</div>
		</div>
	</div>
	<!-- Modal -->
    <div class="modal fade" id="tecnico_asignado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog rounded-0">
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
                        <th>Nombre</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="w-100">
                        <td>Carlos Martínez</td>
                        <td>
                            <a class="btn btn-primary btn-circle" href="<?php echo base_url('kardex_reporte'); ?>"  class="my-btn-primary p-1"><span class="bi bi-send"></span></a>
                        </td>
                    </tr>
                    <tr class="w-100">
                        <td>Andrés Salceda</td>
                        <td>
                            <a class="btn btn-primary btn-circle" href="<?php echo base_url('kardex_reporte'); ?>"  class="my-btn-primary p-1"><span class="bi bi-send"></span></a>
                        </td>
                    </tr>
                    <tr class="w-100">
                        <td>Fernando Moreno</td>
                        <td>
                            <a class="btn btn-primary btn-circle" href="<?php echo base_url('kardex_reporte'); ?>"  class="my-btn-primary p-1"><span class="bi bi-send"></span></a>
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
</div>
<script>
	$( document ).ready(function() {
    new DataTable('#modal');
    new DataTable('#example');
});
</script>
<?php echo $this->endSection()?>