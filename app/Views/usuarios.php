<?php echo $this->extend('panel_template') ?>
<?php echo $this->section('contenido') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Usuarios</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#exampleModal">Agregar Usuario</a>
</div>
<div class="card card-body rounded-0">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th>Nombre</th>
				<th>Mobil</th>
				<th>Función</th>
				<th></th>
			</tr>
		</thead>
		<?php foreach ($usuarios as $data): ?>
		<tr>
			<td><?php echo $data['id_usuario'] ?></td>
			<td><?php echo $data['nombre'] ?> <?php echo $data['apellidos'] ?></td>
			<td><span class="bi bi-envelope"></span> <?php echo $data['correo'] ?></td>
			<td>Ventas</td>
			<td>
				<a href="<?php echo base_url('editar_usuario/'.$data['id_usuario'])?>" class="btn btn-primary btn-circle btn-sm" data-toggle = "tooltip" data-placement="top" title="Editar"><span class="bi bi-pencil"></span></a>
			</td>
		</tr>
		<?php endforeach ?>
		<tbody>
			
		</tbody>	
	</table>
</div>
<script>
	$(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
<?php echo $this->endSection() ?>