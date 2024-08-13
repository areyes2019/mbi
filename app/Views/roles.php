<?php echo $this->extend('panel_template') ?>
<?php echo $this->section('contenido') ?>
<div class="container-fluid" id="app">
	<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800 mb-4">Roles y Permisos</h1>
	</div>
	<label for="" class="mr-4">Agregar Rol</label>
	<div class="d-flex align-items-center mb-4">
    	<input type="text" name="rol" class="rounded-0 mr-2" v-model="nombre">
    	<button class="btn btn-primary btn-sm" @click="agregar_rol"><span class="bi bi-check"></span></button>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="card card-body rounded-0">
				<ul class="list-group rounded-0">
				  	<li class="list-group-item active">Roles</li>
				  	<li class="list-group-item" v-for="data in roles">
				  		<div class=" d-flex justify-content-between align-items-center">
					  		<p class="m-0">{{data.role_name}}</p>
						  	<div class="col-md-2 d-flex justify-content-start">
						  		<button class="btn btn-danger btn-sm mr-2" @click="eliminar(data.role_id)"><span class="bi bi-trash3"></span></button>
						  		<a :href="'secciones_de_rol/'+data.role_id" class="btn btn-primary btn-sm"><span class="bi bi-eyeglasses"></span></a>
						  	</div>
				  		</div>
				  	</li>
				</ul>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url('public/js/roles.js'); ?>"></script>
<?php echo $this->endSection() ?>
