<?php echo $this->extend('panel_template')?>
<?php echo $this->section('contenido')?>
<div id="app">
	<div class="container-fluid">
		<div class="row column_title">
	        <div class="col-md-12">
	        	<?php foreach ($nombre as $key_nom): ?>
	            <div class="page_title">
	                <h2>Rol <?php echo $key_nom['role_name'] ?></h2>
	                <p class="d-none" ref="rol"><?php echo $key_nom['role_id'] ?></p>
	            </div>
	        	<?php endforeach ?>
	        </div>
    	</div>
    	<label for="">Agregar Seccion al Rol</label>
    	<p class="m-0 text-danger">{{alert_top}}</p>
    	<div class="row">
    		<div class="col-md-6 d-flex justify-content-between">
		    	<select class="form-select rounded-0 shadow-none" v-model="seccion_id_agregar">
		    		<option value="">Selecione una opcion</option>
		    		<option :value="sec.section_id" v-for = "sec in secciones">{{sec.section_name}}</option>	
		    	</select>
    			<button class="btn btn-primary btn-sm rounded-0" @click="add_seccion"><span class="bi bi-check"></span></button>
    		</div>
    	</div>
    	<div class="row mt-4">
	    	<div class="col-md-6">
	    		<div class="card card-body rounded-0 p-4">
		    		<table class="table">
		    			<tr>
		    				<th>Secciones</th>
		    				<th></th>
		    			</tr>
		    			<?php foreach ($lista as $nombre):?>
			    			<tr>
			    				<td><?php echo $nombre['section_name'] ?></td>
			    				<td class="d-flex justify-content-end">
			    					<button class="btn btn-primary btn-sm rounded-0" @click="abir_permisos(
			    						<?php echo $nombre['id_roles_secciones']?>,
			    						'<?php echo $nombre['section_name'];?>' 
			    					)"><span class="bi bi-pencil"></span></button>
			    					<button class="btn btn-sm btn-danger rounded-0" @click="eliminar_seccion_rol('<?php echo $nombre['id_roles_secciones']?>')" ><span class="bi bi-trash3"></span></button>
			    				</td>
			    			</tr>
		    			<?php endforeach ?>
		    		</table>
		    	</div>
		    </div>
	    </div>
	    <div class="modal fade" id="agregar_permisos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content rounded-0 modal-sm">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">{{nombre_seccion}}</h5>
		        <p class="d-none" ref="seccion">{{seccion_id}}</p>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      	<p :class="['text-danger',display]">{{alert}}</p>
		      	<label for="">Agregar permiso</label>
		      	<div class="d-flex justify-content-between">
			    	<select v-model="permiso" class="form-select rounded-0 shadow-none">
			    		<option value="">Sleccione una opción</option>
			    		<option :value="permi.permission_id" v-for="permi in permisos">{{permi.permission_name}}</option>
			    	</select>
			    	<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm rounded-0" @click.prevent="agregar_permiso"><i class="bi bi-check"></i></a>
		      	</div>
		    	<ul class="list-group mt-2 rounded-0">
		    		<li class="list-group-item" v-for="lista in permisos_rol">
		    			<div class="d-flex justify-content-between">
		    				<p class="m-0">{{lista.permission_name}}</p>
		    				<button class="btn btn-danger btn-circle btn-sm" @click="borrar_permiso(lista.id_permiso_seccion)"><span class="bi bi-x"></span></button>
		    			</div>
		    		</li>
		    	</ul>
		      </div>
		      <div class="modal-footer">
		        
		      </div>
		    </div>
		  </div>
		</div>		
	</div>
</div>
<script src="<?php echo base_url('public/js/permisos.js'); ?>"></script>
<?php echo $this->endSection() ?>
