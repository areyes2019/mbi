
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
                    <h4 class="card-title m-0"><?php echo $user['nombre'] ?></h4>
                    <h4 class="card-title m-0"><?php echo $funcion ?></h4>
                    <p class="card-text"><?php echo $user['correo'] ?></p>
                    <p class="d-none" ref="usuario"><?php echo $user['id_usuario'] ?></p>
                    <button  class="btn btn-primary rounded-0 ml-2" data-toggle="modal" data-target="#agregar_seccion">Asignar Funciones</a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card rounded-0">
                <div class="card-header bg-primary rounded-0 text-white">
                    <h4>Información Personal</h4>
                </div>
                <div class="card-body">
                    <p class="m-0"><strong>Nombre Completo: </strong><?php echo $user['nombre'].' '.$user['apellidos']?></p>
                    <p class="m-0"><strong>Email: </strong> <?php echo $user['correo'] ?></p>
                    <p class="m-0"><strong>Teléfono: </strong><?php echo $user['mobil'] ?></p>
                    <p class="m-0"><strong>Función: </strong><?php echo $funcion ?></p>
                    <hr>
                    <h5>Secciones asignadas:</h5>
                	<table class="table table-bordered">
		    			<tr>
		    				<th>Sección</th>
		    				<th>Ver</th>
		    				<th>Crear</th>
		    				<th>Actualizar</th>
		    				<th>Eliminar</th>
		    				<th></th>
		    			</tr>
		    			<tr v-for="data in secciones_asignados">
		    				<td>
		    					{{data.section_name}}
		    				</td>
		    				<td>
		    					<label class="switch">
								 	<input type="checkbox"  :checked="data.solo_ver == 1" :ref="`1${data.id_us}`" @change="permisos(data.id_us,'1')" :value="data.solo_ver">
								  	<span class="slider"></span>
								</label>
		    				</td>
		    				<td>
		    					<label class="switch">
								 	<input type="checkbox"  :checked="data.puede_crear == 1" :ref="`2${data.id_us}`" @change="permisos(data.id_us,'2')" :value="data.puede_crear">
								  	<span class="slider"></span>
								</label>
		    				</td>
		    				<td>
		    					<label class="switch">
								 	<input type="checkbox"  :checked="data.puede_modificar == 1" :ref="`3${data.id_us}`" @change="permisos(data.id_us,'3')" :value="data.puede_modificar">
								  	<span class="slider"></span>
								</label>
		    				</td>
		    				<td>
		    					<label class="switch">
								 	<input type="checkbox"  :checked="data.puede_eliminar == 1" :ref="`4${data.id_us}`" @change="permisos(data.id_us,'4')" :value="data.puede_eliminar">
								  	<span class="slider"></span>
								</label>
		    				</td>		    				
		    			</tr>
    				</table>
                </div>
            </div>
        </div>
	</div>
	<div class="modal fade" id="agregar_seccion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content rounded-0 modal-sm">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Asignar Permisos</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <p class="m-0 text-danger">{{alert}}</p>
		      	<label for="" class="mb-0">Asignar Sección</label>
		      	<div class="d-flex justify-content-between">
			    	<select class="form-select rounded-0 shadow-none" v-model="seccion">
			    		<option value="">Seleccione una opción</option>
			    		<option v-for="seccion in secciones" :value="seccion.section_id">{{seccion.section_name}}</option>
			    	</select>
			    	<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm rounded-0" @click.prevent="agregar_seccion"><i class="bi bi-check"></i></a>
		      	</div>
		      	<label class="mt-2 mb-0">Asignar Función</label>
		      	<div class="d-flex justify-content-between">
			    	<select class="form-select rounded-0 shadow-none" v-model="funcion">
			    		<option value="" selected>Seleccione una opción</option>
			    		<option v-for="funcion in funciones" :value="funcion.role_id">{{funcion.role_name}}</option>
			    	</select>
			    	<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm rounded-0" @click.prevent="asignar_funcion"><i class="bi bi-check"></i></a>
		      	</div>
		      </div>
		    </div>
		  </div>
		</div>	
</div>
<?php endforeach ?>
<script src="<?php echo base_url('public/js/editar_usuario.js'); ?>"></script>
<?php echo $this->endSection()?>