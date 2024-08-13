<?php echo $this->extend('panel_template') ?>
<?php echo $this->section('contenido')?>
<div class="container-fluid" id="app">
	<div class="row column_title">
        <div class="col-md-12">
            <div class="page_title">
            	<p></p>
            	<?php foreach ($usuario as $data):?>
                <h2><?php echo $data['nombre']?></h2>
                <p class="d-none" ref="usuario"><?php echo $data['id_usuario'] ?></p>
            	<?php endforeach?>
            </div>
            <label for="" class="m-0">Agregar Seccion a este usuario</label>
            <div class="d-flex justify-content-between align-items-center">
            	<div class="col-md-8 mb-2 p-0">
		            <select name="" id="" class="form-control rounded-0 shadow-none p-0">
		            		
		            	<option value="">Selecciona una opción</option>
		            	<?php foreach ($secciones as $seccion): ?>
		            	<option value="<?php echo $seccion['section_id'] ?>" v-model="section"><?php echo $seccion['section_name'] ?></option>
		            	<?php endforeach ?>
		            </select>
            	</div>
            	<div class="col-md-8 mb-2">
	            	<button @click="agregar_seccion" class="d-none d-sm-inline-block btn  btn-primary shadow-sm rounded-0"><i class="bi bi-check text-white-50"></i> Agregar Sección</button>
            	</div>
            </div>
        </div>
    </div>
    <div class="card">
    	<div class="card-body">
    		<table class="table table-bordered">
    			<tr>
    				<th>Sección</th>
    				<th>Ver</th>
    				<th>Crear</th>
    				<th>Actualizar</th>
    				<th>Eliminar</th>
    			</tr>
    			<tr v-for='data in permisos'>
    					
    				<td>
    					{{data.section_name}}
    				</td>
    				<!--  leer -->
    				<td v-if="data.leer == 1">
    					<label class="switch">
						 	<input type="checkbox" checked :ref="data.id_permiso" @change="cambiar_leer(data.id_permiso)" :value="data.leer">
						  	<span class="slider"></span>
						</label>
    				</td>
    				<td v-else>
    					<label class="switch">
						 	<input type="checkbox" :ref="data.id_permiso" @change="cambiar_leer(data.id_permiso)" :value="data.leer">
						  	<span class="slider"></span>
						</label>
    				</td>
    				<!--  leer -->

    				<!-- crear -->
    				<td v-if="data.crear == 1">
    					<label class="switch">
						 	<input type="checkbox" checked :ref="data.id_permiso" @change="cambiar_crear(data.id_permiso)" :value="data.crear">
						  	<span class="slider"></span>
						</label>
    				</td>
    				<td v-else>
    					<label class="switch">
						 	<input type="checkbox" :ref="data.id_permiso" @change="cambiar_crear(data.id_permiso)" :value="data.crear">
						  	<span class="slider"></span>
						</label>
    				</td>
    				<!-- crear -->
    				<td v-if="data.actualizar == 1">
    					<label class="switch">
						 	<input type="checkbox" checked :ref="data.id_permiso" @change="cambiar_actualizar(data.id_permiso)">
						  	<span class="slider"></span>
						</label>
    				</td>
    				<td v-else>
    					<label class="switch">
						 	<input type="checkbox" :ref="data.id_permiso" @change="cambiar_actualizar(data.id_permiso)">
						  	<span class="slider"></span>
						</label>
    				</td>
    				<td v-if="data.eliminar == 1">
    					<label class="switch">
						 	<input type="checkbox" checked :ref="data.id_permiso" @change="cambiar_eliminar(data.id_permiso)">
						  	<span class="slider"></span>
						</label>
    				</td>
    				<td v-else>
    					<label class="switch">
						 	<input type="checkbox" :ref="data.id_permiso" @change="cambiar_eliminar(data.id_permiso)">
						  	<span class="slider"></span>
						</label>
    				</td>
    				
    			</tr>
    		</table>
		</div>
    </div>
</div>
<script src="<?php echo base_url('public/js/permisos.js'); ?>"></script>
<?php echo $this->endSection()?>