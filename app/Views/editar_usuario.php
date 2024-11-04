
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
                    <?php if (es_super_admin()): ?>
                    <button  class="btn btn-primary rounded-0 ml-2" data-toggle="modal" data-target="#agregar_seccion">Asignar Funciones</a>
                    <button  class="btn btn-primary rounded-0 ml-2" data-toggle="modal" data-target="#agregar_datos" @click="numero_empleado('<?php echo $user['id_usuario'] ?>')">Agregar Datos</a>
                    <?php endif ?>

                    <?php if (!es_super_admin()): ?>
                   	<div class="d-flex justify-content-between">
	                    <button  class="btn btn-primary rounded-0 ml-2" data-toggle="modal" data-target="#agregar_datos_personales" @click ="modificar_perfil">Modificar mis Datos</a>
	                    <button  class="btn btn-primary rounded-0 ml-2" data-toggle="modal" data-target="#cambiar_contraseña">Cambiar Contraseña</a>
                   	</div>
                    <?php endif ?>
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
                    <p class="m-0"><strong>Numero de Empleado: </strong><?php echo $user['no_empleado'] ?></p>
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
		    					<?php if (es_super_admin()): ?>
		    						<label class="switch">
								 		<input type="checkbox"  :checked="data.solo_ver == 1" :ref="`1${data.id_us}`" @change="permisos(data.id_us,'1')" :value="data.solo_ver">
								  		<span class="slider"></span>
									</label>
		    					<?php elseif(!es_super_admin()):?>
		    						<p v-if="data.solo_ver == 1"><span class="badge badge-primary">Tiene Permiso</span></p>
		    						<p v-if="data.solo_ver == 0"><span class="badge badge-primary">No Tiene Permiso</span></p>
		    					<?php endif; ?>
		    				</td>
		    				<td>
		    					<?php if (es_super_admin()): ?>
		    					<label class="switch">
								 	<input type="checkbox"  :checked="data.puede_crear == 1" :ref="`2${data.id_us}`" @change="permisos(data.id_us,'2')" :value="data.puede_crear">
								  	<span class="slider"></span>
								</label>
		    					<?php elseif(!es_super_admin()):?>
		    						<p v-if="data.puede_crear == 1"><span class="badge badge-primary">Tiene Permiso</span></p>
		    						<p v-if="data.puede_crear == 0"><span class="badge badge-primary">No Tiene Permiso</span></p>
		    					<?php endif; ?>
		    				</td>
		    				<td>
		    					<?php if (es_super_admin()): ?>
		    					<label class="switch">
								 	<input type="checkbox"  :checked="data.puede_modificar == 1" :ref="`3${data.id_us}`" @change="permisos(data.id_us,'3')" :value="data.puede_modificar">
								  	<span class="slider"></span>
								</label>
		    					<?php elseif(!es_super_admin()):?>
		    						<p v-if="data.puede_modificar == 1"><span class="badge badge-primary">Tiene Permiso</span></p>
		    						<p v-if="data.puede_modificar == 0"><span class="badge badge-danger">No Tiene Permiso</span></p>
		    					<?php endif; ?>
		    				</td>
		    				<td>
		    					<?php if (es_super_admin()): ?>
		    					<label class="switch">
								 	<input type="checkbox"  :checked="data.puede_eliminar == 1" :ref="`4${data.id_us}`" @change="permisos(data.id_us,'4')" :value="data.puede_eliminar">
								  	<span class="slider"></span>
								</label>
		    					<?php elseif(!es_super_admin()):?>
		    						<p v-if="data.puede_eliminar == 1"><span class="badge badge-primary">Tiene Permiso</span></p>
		    						<p v-if="data.puede_eliminar == 0"><span class="badge badge-danger">No Tiene Permiso</span></p>
		    					<?php endif; ?>
		    				</td>
		    				<td>
		    					<button class="btn btn-danger btn-sm rounded-0" @click="eliminar_seccion(data.id_us)"><span class="bi bi-trash3"></span></button>
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
	<div class="modal fade" id="agregar_datos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content rounded-0">
	      <div class="modal-header">
	        	<h5 class="modal-title" id="exampleModalLabel">Agregar Numero de Empleado</h5>
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          		<span aria-hidden="true">&times;</span>
	        	</button>
	      	</div>
	      	<div class="modal-body">
	    		<div class="form-group mt-2">
					<div class="input-group">
				        <div class="input-group-prepend input-group-sm">
				          <div class="input-group-text rounded-0">
				          	<i class="bi bi-person"></i>
				          </div>
				        </div>
						<input type="text" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Numero de Empleado"  name="titular" v-model="empleado_numero">
						<button class="btn btn-primary btn-sm rounded-0" @click="agregar_numero_empleado"><span class="bi bi-check"></span></button>
				    </div>
				    <small class="text-danger">{{errores}}</small>
				</div> 
	      	</div>
	    </div>
	  </div>
	</div>
	<!--  agregar datos personales, cada usuario los modifica -->
	<div class="modal fade" id="agregar_datos_personales" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content rounded-0">
	      <div class="modal-header">
	        	<h5 class="modal-title" id="exampleModalLabel">Modificar mis datos</h5>
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          		<span aria-hidden="true">&times;</span>
	        	</button>
	      	</div>
	      	<div class="modal-body">
	    		<div class="form-group mt-2">
					<div class="input-group">
				        <div class="input-group-prepend input-group-sm">
				          <div class="input-group-text rounded-0">
				          	<i class="bi bi-person"></i>
				          </div>
				        </div>
						<input type="text" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Nombre"  v-model="perfil.nombre">
				    </div>
				</div>
				<div class="form-group mt-2">
					<div class="input-group">
				        <div class="input-group-prepend input-group-sm">
				          <div class="input-group-text rounded-0">
				          	<i class="bi bi-person"></i>
				          </div>
				        </div>
						<input type="text" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Apellidos"  name="perfil.apellidos">
				    </div>
				</div>
				<div class="form-group mt-2">
					<div class="input-group">
				        <div class="input-group-prepend input-group-sm">
				          <div class="input-group-text rounded-0">
				          	<i class="bi bi-phone"></i>
				          </div>
				        </div>
						<input type="text" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Numero de Celular"  v-model="perfil.mobil">
				    </div>
				</div>
				<div class="form-group mt-2">
					<label for="">Cambiar mi imagen</label>
					<div class="input-group">
				        <div class="input-group-prepend input-group-sm">
				          <div class="input-group-text rounded-0">
				          	<i class="bi bi-avatar"></i>
				          </div>
				        </div>
						<input type="file" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Numero de Celular"  name="titular">
				    </div>
				</div>
				<button class="btn btn-primary btn-sm rounded-0">Actualizar</button> 
	      	</div>
	    </div>
	  </div>
	</div>	
	<!--  agregar datos personales, cada usuario los modifica -->
	<div class="modal fade" id="cambiar_contraseña" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content rounded-0">
	      <div class="modal-header">
	        	<h5 class="modal-title" id="exampleModalLabel">Cambiar Contraseña</h5>
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          		<span aria-hidden="true">&times;</span>
	        	</button>
	      	</div>
	      	<div class="modal-body">
	    		<div class="form-group mt-2">
					<div class="input-group">
				        <div class="input-group-prepend input-group-sm">
				          <div class="input-group-text rounded-0">
				          	<i class="bi bi-key"></i>
				          </div>
				        </div>
						<input type="text" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Contraseña Anterior"  name="titular">
				    </div>
				</div>
				<div class="form-group mt-2">
					<div class="input-group">
				        <div class="input-group-prepend input-group-sm">
				          <div class="input-group-text rounded-0">
				          	<i class="bi bi-key"></i>
				          </div>
				        </div>
						<input type="text" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Nueva Contraseña"  name="titular">
				    </div>
				</div>
				<div class="form-group mt-2">
					<div class="input-group">
				        <div class="input-group-prepend input-group-sm">
				          <div class="input-group-text rounded-0">
				          	<i class="bi bi-key"></i>
				          </div>
				        </div>
						<input type="text" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Confirmar Contraseña"  name="titular">
				    </div>
				</div>
				<button class="btn btn-primary btn-sm rounded-0">Modificar</button> 
	      	</div>
	    </div>
	  </div>
	</div>	
</div>
<?php endforeach ?>
<script src="<?php echo base_url('public/js/editar_usuario.js'); ?>"></script>
<script src="<?php echo base_url('public/js/alert.js'); ?>"></script>
<?php echo $this->endSection()?>