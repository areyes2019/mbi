<?php echo $this->extend('panel_template') ?>
<?php echo $this->section('contenido') ?>
<div class="container-fluid" id="app">
  	<nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          	<li class="breadcrumb-item"><a href="<?php echo base_url('/inicio'); ?>">Inicio</a></li>
          	<li class="breadcrumb-item active" aria-current="page">Usuarios</li>
        </ol>
  	</nav>
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
	    <h1 class="h3 mb-0 text-gray-800">Usuarios</h1>
	    <div>
		    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-2" data-toggle="modal" data-target="#agregar_usuario">Agregar Usuario</a>
		    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#agregar_rol">Agregar Rol</a>
	    </div>
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
				<td><?php echo $data['role_name'] ?></td>
				<td>
					<a href="<?php echo base_url('editar_usuario/'.$data['id_usuario'])?>" class="btn btn-primary btn-circle btn-sm" data-toggle = "tooltip" data-placement="top" title="Editar"><span class="bi bi-pencil"></span></a>
				</td>
			</tr>
			<?php endforeach ?>
			<tbody>
				
			</tbody>	
		</table>
	</div>
	
	<!--  Modal agregar usuario -->
	<div class="modal fade" id="agregar_usuario" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content rounded-0">
	      	<div class="modal-header">
	        	<h5 class="modal-title" id="staticBackdropLabel"><span class="bi bi-person"></span> Agegar Usuario</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
	      	</div>
	    	<div class="modal-body">
	    		<!--  nombre del usuario-->
		    	<div class="form-group">
					<div class="input-group mb-2">
				        <div class="input-group-prepend input-group-sm">
				          <div class="input-group-text rounded-0">
				          	<i class="bi bi-person"></i>
				          </div>
				        </div>
						<input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'nombre')" placeholder="Nombre" v-model="form.nombre" name="nombre">
		    		</div>
					<small class="text-danger">{{errores.nombre}}</small>
				</div>
				<!--  apellidos del usuario-->
		    	<div class="form-group">
					<div class="input-group mb-2">
				        <div class="input-group-prepend input-group-sm">
				          <div class="input-group-text rounded-0">
				          	<i class="bi bi-person"></i>
				          </div>
				        </div>
						<input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'apellidos')" placeholder="Apellidos" v-model="form.apellidos" name="nombre">
		    		</div>
					<small class="text-danger">{{errores.apellidos}}</small>
				</div>
				<!--  correo del usuario-->
		    	<div class="form-group">
					<div class="input-group mb-2">
				        <div class="input-group-prepend input-group-sm">
				          <div class="input-group-text rounded-0">
				          	<i class="bi bi-envelope"></i>
				          </div>
				        </div>
						<input type="text"  class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'correo')" placeholder="Correo" v-model="form.correo" name="correo">
		    		</div>
					<small class="text-danger">{{errores.correo}}</small>
				</div>
				<!--  contraseña del usuario-->
		    	<div class="form-group">
					<div class="input-group mb-2">
				        <div class="input-group-prepend input-group-sm">
				          <div class="input-group-text rounded-0">
				          	<i class="bi bi-key"></i>
				          </div>
				        </div>
						<input type="password"  class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'pass01')" placeholder="Escribe la contraseña" v-model="form.password" name="password">
		    		</div>
				</div>
				<!--  confirmar contraseña del usuario-->
		    	<div class="form-group">
					<div class="input-group mb-2">
				        <div class="input-group-prepend input-group-sm">
				          <div class="input-group-text rounded-0">
				          	<i class="bi bi-key"></i>
				          </div>
				        </div>
						<input type="password"  class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'pass02')" placeholder="Confirma la contraseña" v-model="form.password_confirm" name="password">
		    		</div>
					<small class="text-danger">{{errores.pass}}</small>
				</div> 
	      	</div>
	      	<div class="modal-footer">
	        	<button type="button" class="btn btn-secondary rounded-0 btn-sm" data-dismiss="modal" @click = "limpiar_form">Cancelar</button>
	        	<button type="button" class="btn btn-primary btn-sm rounded-0" @click = "insertar">Guardar</button>
	      	</div>
	    </div>
	  </div>
	</div>
	<!-- modal agregar rol -->
	<div class="modal fade" id="agregar_rol" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content rounded-0 modal-sm">
	      	<div class="modal-header">
	        	<h5 class="modal-title" id="staticBackdropLabel"><span class="bi bi bi-person-circle"></span> Agregar Rol</h5>
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          		<span aria-hidden="true">&times;</span>
	        	</button>
	      	</div>
	      	<div class="modal-body">
	      		<!--  nuevo rol-->
		    	<div class="form-group">
					<div class="input-group mb-2">
				        <div class="input-group-prepend input-group-sm">
				          <div class="input-group-text rounded-0">
				          	<i class="bi bi-person"></i>
				          </div>
				        </div>
						<input type="text"  class="form-control rounded-0 form-control-sm shadow-none" placeholder="Escriba el nombre del rol" v-model="rol" >
						<button class="btn btn-primary btn-sm rounded-0" @click = "agregar_rol"><span class="bi bi-check"></span></button>
						<table class="table">
							<tr>
								<th>Nombre</th>
							</tr>
							<tr v-for="rol in roles">
								<td class="d-flex justify-content-between">
									{{rol.role_name}}
									<button class="btn btn-danger btn-sm rounded-0" @click = "eliminar_rol(rol.role_id)"><span class="bi bi-x-lg"></span></button>
								</td>
							</tr>
						</table>
		    		</div>
				</div> 
	      	</div>
	      	<div class="modal-footer">
	        	<button type="button" class="btn btn-secondary btn-sm rounded-0" data-dismiss="modal">Cancelar</button>
	      </div>
	    </div>
	  </div>
	</div>
</div>
<script src="<?php echo base_url('public/js/usuarios.js'); ?>"></script>
<script src="<?php echo base_url('public/js/alert.js'); ?>"></script>
<script>
	$(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
<?php echo $this->endSection() ?>