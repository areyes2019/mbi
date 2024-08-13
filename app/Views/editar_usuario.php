<?php echo $this->extend('panel_template') ?>
<?php echo $this->section('contenido') ?>
<?php foreach ($usuario as $user): ?>
<div class="container-fluid mt-5" id="app">
	<nav aria-label="breadcrumb">
  		<ol class="breadcrumb">
    		<li class="breadcrumb-item"><a href="<?php echo base_url('inicio'); ?>">Inicio</a></li>
    		<li class="breadcrumb-item"><a href="<?php echo base_url('usuarios'); ?>">Usuarios</a></li>
    		<li class="breadcrumb-item active" aria-current="page"><?php echo $user['nombre'].' '.$user['apellidos'] ?></li>
  		</ol>
	</nav>
	<div class="row">
        <div class="col-md-4">
            <div class="card rounded-0">
                <img src="<?php echo $user['avatar'] ?>" class="card-img-top rounded-circle mx-auto mt-3" alt="Foto de Perfil" style="width: 200px; height: 200px;">
                <div class="card-body text-center">
                    <h4 class="card-title"><?php echo $user['nombre'] ?></h4>
                    <p class="card-text"><?php echo $user['correo'] ?></p>
                    <p class="d-none" ref="usuario"><?php echo $user['id_usuario'] ?></p>
                    <button  class="btn btn-primary rounded-0" data-toggle="modal" data-target="#agregar_roles">Asignar Roles</a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card rounded-0">
                <div class="card-header bg-primary rounded-0 text-white">
                    <h4>Información Personal</h4>
                </div>
                <div class="card-body">
                    <p><strong>Nombre Completo: </strong><?php echo $user['nombre'].' '.$user['apellidos']?></p>
                    <p><strong>Email: </strong> <?php echo $user['correo'] ?></p>
                    <p><strong>Teléfono: </strong><?php echo $user['mobil'] ?></p>
                    <hr>
                    <div class="col-md-4">
	                    <h5>Roles asgsinados:</h5>
	                    <ul class="list-group">
	                    	<li class="list-group-item d-flex justify-content-between align-items-center" v-for="data in roles_asignados">
	                    		<p class="m-0">{{data.role_name}}</p>
	                    		<button class="btn btn-danger btn-sm rounded-0 shadow-none" @click='eliminar_rol(data.id_ur)'><span class="bi bi-x"></span></button>
	                    	</li>
	                    </ul>
                    </div>
                </div>
                <div class="card-footer bg-white">
                	<button class="btn btn-sm rounded-0 btn-primary">Ver Tareas</button>
                	<button class="btn btn-sm rounded-0 btn-primary">Ver Pendientes</button>
                </div>
            </div>
        </div>
	</div>
	<div class="modal fade" id="agregar_roles" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content rounded-0 modal-sm">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Asignar Rol</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <p class="m-0 text-danger">{{alert}}</p>
		      	<label for="">Nombre del Rol</label>
		      	<div class="d-flex justify-content-between">
			    	<select class="form-select rounded-0 shadow-none" v-model="rol">
			    		<option value="">Sleccione una opción</option>
			    		<option v-for="rol in roles" :value="rol.role_id">{{rol.role_name}}</option>
			    	</select>
			    	<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm rounded-0" @click.prevent="agregar_rol"><i class="bi bi-check"></i></a>
		      	</div>
		      </div>
		    </div>
		  </div>
		</div>	
</div>
<?php endforeach ?>
<script src="<?php echo base_url('public/js/editar_usuario.js'); ?>"></script>
<?php echo $this->endSection()?>