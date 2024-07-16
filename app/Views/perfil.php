<?php echo $this->extend('panel_template') ?>
<?php echo $this->section('contenido') ?>
<div class="row">
	<?php foreach ($usuario as $data): ?>
	<div class="col-12 col-md-4">
		<div class="card card-body rounded-0">
			<div class="imagen_cuadrada">
				<img src="<?php echo base_url('public/img/inge.jpg'); ?>" class="rounded-circle align-content-center">
			</div>
			<h4 class="text-center mt-4"><?php echo $data['nombre'] ?></h4>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-body">
				<h5>Nombre completo</h5>
				<h6 class="m-0"><?php echo $data['nombre'] ?></h6>
				<hr>
				<h5>Correo Electrónico</h5>
				<h6 class="m-0"><?php echo $data['correo'] ?></h6>
				<hr>
				<h5>Telefono Móvil</h5>
				<h6 class="m-0">No Definido</h6>
				<hr>
				<a href="#" class="btn btn-primary btn-icon-split btn-sm mr-2">
	                <span class="icon text-white-50">
	                    <i class="bi bi-person"></i>
	                </span>
	                <span class="text">Editar Perfil</span>
	            </a>
	            <a href="#" class="btn btn-primary btn-icon-split btn-sm mr-2">
	                <span class="icon text-white-50">
	                    <i class="bi bi-key"></i>
	                </span>
	                <span class="text">Asignar Permisos</span>
	            </a>
	            
			</div>
		</div>
	</div>
	<?php endforeach ?>
</div>
<?php echo $this->endSection() ?>